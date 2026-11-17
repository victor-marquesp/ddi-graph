<?php

namespace App\Graph;

class GraphMetrics {

    public function calculate(Graph $graph) : GraphMetricsResult {

        return new GraphMetricsResult(
            nodeCount: $graph->nodeCount(),
            edgeCount: $graph->edgeCount(),
            averageDegree: $this->averageDegree($graph),
            density: $this->density($graph),
            connectedComponents: $this->connectedComponents($graph),
            maximumDegree: $this->maximumDegree($graph),
            averageEdgeSeverity: $this->averageEdgeSeverity($graph),
            severeInteractions: $this->severeInteractions($graph)
        );

    }

    private function averageDegree(Graph $graph) : float {

        $n = $graph->nodeCount();
        $m = $graph->edgeCount();

        if($n === 0) {
            return 0.0;
        }

        return (2 * $m) / $n;

    }

    private function density(Graph $graph) : float {

        $n = $graph->nodeCount();
        $m = $graph->edgeCount();

        if($n < 2) {
            return 0.0;
        }

        return (2 * $m) / ($n * ($n - 1));

    }

    private function connectedComponents(Graph $graph) : int {

        $visited = [];
        $components = 0;

        foreach($graph->nodes as $id => $node) {

            if(isset($visited[$id])) {
                continue;
            }

            $components++;

            $stack = [$id];
            $visited[$id] = true;

            while(!empty($stack)) {

                $currentId = array_pop($stack);

                foreach($graph->neighbors($currentId) as $neighbor) {

                    $neighborId = $neighbor->id;

                    if(!isset($visited[$neighborId])) {

                        $visited[$neighborId] = true;
                        $stack[] = $neighborId;

                    }

                }

            }

        }

        return $components;

    }

    /** @return array{degree: int|null, nodeIds: int[]} */
    private function maximumDegree(Graph $graph) : array {

        $maxDegree = null;
        $nodeIds = [];

        foreach($graph->nodes as $id => $node) {

            $degree = $graph->degree($id);

            if($maxDegree === null || $degree > $maxDegree) {

                $maxDegree = $degree;
                $nodeIds = [$id];

            } elseif($degree === $maxDegree) {

                $nodeIds[] = $id;

            }

        }

        return [
            'degree' => $maxDegree,
            'nodeIds' => $nodeIds
        ];

    }

    private function averageEdgeSeverity(Graph $graph) : ?float {

        $m = $graph->edgeCount();

        if($m === 0) {
            return null;
        }

        $totalWeight = 0;

        foreach($graph->edges as $edge) {
            $totalWeight += $edge->severity->weight();
        }

        return $totalWeight / $m;

    }

    private function severeInteractions(Graph $graph) : int {

        $count = 0;

        foreach($graph->edges as $edge) {

            if($edge->severity->isSevere()) {
                $count++;
            }

        }

        return $count;

    }

}