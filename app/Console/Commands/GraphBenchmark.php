<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Graph\Graph;
use App\Graph\GraphBuilder;
use App\Graph\GraphMetrics;

use App\Models\Drug;
use App\Models\Interaction;


class GraphBenchmark extends Command {

    protected $signature = 'graph:benchmark
        {--limit=0}
        {--iterations=100}';

    protected $description = 'Evaluate graph representation';

    public function handle() : int {

        $limit = (int) $this->option('limit');
        $iterations = (int) $this->option('iterations');

        if($limit < 0 || $iterations < 1) {
            return self::FAILURE;
        }

        $ids = $this->selectDrugIds($limit);

        if(empty($ids)) {
            $this->error('No drugs found.');

            return self::FAILURE;
        }

        $start = hrtime(true);

        $drugs = Drug::with('classification')
            ->whereIn('id', $ids)
            ->get()
            ->all();

        $interactions = Interaction::query()
            ->whereIn('drugA_id', $ids)
            ->whereIn('drugB_id', $ids)
            ->get()
            ->all();

        $retrievalTime = $this->elapsed($start);

        gc_collect_cycles();

        $initialMemory = memory_get_usage();

        memory_reset_peak_usage();

        $start = hrtime(true);

        $graph = (new GraphBuilder())->build(
            $drugs,
            $interactions
        );

        $buildTime = $this->elapsed($start);

        $graphMemory = memory_get_usage() - $initialMemory;

        $peakMemory = memory_get_peak_usage() - $initialMemory;

        $start = hrtime(true);

        $metrics = (new GraphMetrics())->calculate($graph);

        $totalPeakMemory = memory_get_peak_usage();

        $metricsTime = $this->elapsed($start);

        $results = [
            'dataset' => [
                'drugs' => count($drugs),
                'interactions' => count($interactions)
            ],

            'integrity' => $this->validateGraph(
                $graph,
                $drugs,
                $interactions
            ),

            'performance' => [
                'retrieval_ms' => $retrievalTime,
                'build_ms' => $buildTime,
                'metrics_ms' => $metricsTime,
                'graph_memory_mb' => $graphMemory / 1024 ** 2,
                'peak_build_memory_mb' => $peakMemory / 1024 ** 2,
                'total_peak_memory_mib' => $totalPeakMemory / 1024 ** 2
            ],

            'comparison' => $this->compareOperations(
                $graph,
                $ids,
                $iterations
            ),

            'metrics' => $metrics
        ];

        $this->line(json_encode(
            $results,
            JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR
        ));

        return self::SUCCESS;

    }

    private function selectDrugIds(int $limit) : array {

        $ids = Drug::query()
            ->orderBy('id')
            ->pluck('id')
            ->all();

        usort($ids, function ($a, $b) {

            return strcmp(
                hash('sha256', "42:{$a}"),
                hash('sha256', "42:{$b}")
            );

        });

        if($limit === 0) {
            return $ids;
        }

        return array_slice($ids, 0, $limit);

    }

    private function validateGraph(
        Graph $graph,
        array $drugs,
        array $interactions
    ) : array {

        $validNodes = 0;
        $validEdges = 0;

        foreach($drugs as $drug) {

            $node = $graph->nodes[$drug->id] ?? null;

            if(
                $node !== null &&
                $node->classification->id === $drug->classification_id &&
                $node->properties === $drug->toNodeProperties()
            ) {
                $validNodes++;
            }

        }

        foreach($interactions as $interaction) {

            $edge = $graph->hasEdge(
                $interaction->drugA_id,
                $interaction->drugB_id
            );

            if(
                $edge !== null &&
                $edge->severity === $interaction->severity &&
                $edge->properties === $interaction->toEdgeProperties()
            ) {
                $validEdges++;
            }

        }

        return [
            'expected_nodes' => count($drugs),
            'actual_nodes' => $graph->nodeCount(),
            'valid_nodes' => $validNodes,

            'expected_edges' => count($interactions),
            'actual_edges' => $graph->edgeCount(),
            'valid_edges' => $validEdges,

            'passed' =>
                $validNodes === count($drugs) &&
                $validEdges === count($interactions) &&
                $graph->nodeCount() === count($drugs) &&
                $graph->edgeCount() === count($interactions)
        ];

    }

    private function elapsed(int $start) : float {

        return (hrtime(true) - $start) / 1_000_000;

    }

    private function benchmark(
        callable $operation,
        int $iterations
    ) : float {

        // Warm-up
        $operation();

        $start = hrtime(true);

        for($i = 0; $i < $iterations; $i++) {
            $operation();
        }

        return $this->elapsed($start) / $iterations;

    }

    private function compareOperations(
        Graph $graph,
        array $ids,
        int $iterations
    ) : array {

        $firstKey = array_key_first($graph->edges);

        if($firstKey === null) {
            return [];
        }

        $edge = $graph->getEdge($firstKey);

        $a = $edge->nodeA->id;
        $b = $edge->nodeB->id;

        $incidentQuery = fn() => Interaction::query()
            ->whereIn('drugA_id', $ids)
            ->whereIn('drugB_id', $ids)
            ->where(function ($query) use ($a) {
                $query->where('drugA_id', $a)
                    ->orWhere('drugB_id', $a);
            });

        $operations = [

            'has_edge' => [
                'sql' => fn() => Interaction::query()
                    ->where('drugA_id', min($a, $b))
                    ->where('drugB_id', max($a, $b))
                    ->exists(),

                'graph' => fn() =>
                    $graph->hasEdge($a, $b) !== null
            ],

            'neighbors' => [
                'sql' => fn() => $incidentQuery()
                    ->selectRaw(
                        'CASE WHEN "drugA_id" = ?
                        THEN "drugB_id"
                        ELSE "drugA_id" END AS neighbor_id',
                        [$a]
                    )
                    ->toBase()
                    ->pluck('neighbor_id')
                    ->all(),

                'graph' => fn() => array_map(
                    fn($node) => $node->id,
                    $graph->neighbors($a)
                )
            ],

            'degree' => [
                'sql' => fn() => $incidentQuery()->count(),

                'graph' => fn() => $graph->degree($a)
            ]

        ];

        $results = [];

        foreach($operations as $name => $operation) {

            $expected = $operation['sql']();
            $actual = $operation['graph']();

            if(is_array($expected) && is_array($actual)) {
                sort($expected);
                sort($actual);
            }

            $results[$name] = [
                'equivalent' => $expected === $actual,

                'sql_ms' => $this->benchmark(
                    $operation['sql'],
                    $iterations
                ),

                'graph_ms' => $this->benchmark(
                    $operation['graph'],
                    $iterations
                )
            ];

        }

        return $results;

    }



}