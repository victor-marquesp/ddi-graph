<?php

use App\Enums\Severity;
use App\Models\Classification;
use App\Graph\AdjacencyList;
use App\Graph\Edge;
use App\Graph\Graph;
use App\Graph\Node;
use App\Graph\GraphMetrics;
use App\Graph\GraphMetricsResult;

// Helper function
function createTestGraph(int $nodeCount, array $edges = []): Graph {

    $graph = new Graph(new AdjacencyList());

    $classification = new Classification([
        'name' => 'Test Classification'
    ]);

    $nodes = [];

    for ($id = 1; $id <= $nodeCount; $id++) {

        $nodes[$id] = new Node(
            id: $id,
            classification: $classification
        );

        $graph->addNode($nodes[$id]);
    }

    foreach ($edges as $index => $edge) {

        [$nodeA, $nodeB, $severity] = $edge;

        $graph->addEdge(new Edge(
            id: $index + 1,
            nodeA: $nodes[$nodeA],
            nodeB: $nodes[$nodeB],
            severity: $severity
        ));
    }

    return $graph;
}

describe('default cases', function() {

    // Reference Graph
    beforeEach(function () {

        $classificationX = new Classification(['name' => 'Classification X']);
        $classificationY = new Classification(['name' => 'Classification Y']);
        $classificationZ = new Classification(['name' => 'Classification Z']);

        $nodeA = new Node(
            id: 1,
            classification: $classificationX
        ); 

        $nodeB = new Node(
            id: 2,
            classification: $classificationX
        );

        $nodeC = new Node(
            id: 3,
            classification: $classificationY
        );

        $nodeD = new Node(
            id: 4,
            classification: $classificationY
        );

        $nodeE = new Node(
            id: 5,
            classification: $classificationZ
        );

        $edgeAB = new Edge(
            id: 1,
            nodeA: $nodeA,
            nodeB: $nodeB,
            severity: Severity::MODERATE
        );
        $edgeAC = new Edge(
            id: 2,
            nodeA: $nodeA,
            nodeB: $nodeC,
            severity: Severity::MINOR
        );
        $edgeBC = new Edge(
            id: 3,
            nodeA: $nodeB,
            nodeB: $nodeC,
            severity: Severity::MAJOR
        );
        $edgeBD = new Edge(
            id: 4,
            nodeA: $nodeB,
            nodeB: $nodeD,
            severity: Severity::CONTRAINDICATED
        );
        $edgeBE = new Edge(
            id: 6,
            nodeA: $nodeB,
            nodeB: $nodeE,
            severity: Severity::MAJOR
        );
        $edgeCD = new Edge(
            id: 5,
            nodeA: $nodeC,
            nodeB: $nodeD,
            severity: Severity::CONTRAINDICATED
        );
        $edgeDE = new Edge(
            id: 7,
            nodeA: $nodeD,
            nodeB: $nodeE,
            severity: Severity::MODERATE
        );

        $this->graph = new Graph(new AdjacencyList());

        $this->graph->addNode($nodeA);
        $this->graph->addNode($nodeB);
        $this->graph->addNode($nodeC);
        $this->graph->addNode($nodeD);
        $this->graph->addNode($nodeE);

        $this->graph->addEdge($edgeAB);
        $this->graph->addEdge($edgeAC);
        $this->graph->addEdge($edgeBC);
        $this->graph->addEdge($edgeBD);
        $this->graph->addEdge($edgeBE);
        $this->graph->addEdge($edgeCD);
        $this->graph->addEdge($edgeDE);

    });

    it('returns a GraphMetricsResult', function () {

        $graphMetrics = new GraphMetrics();

        $result = $graphMetrics->calculate($this->graph);

        $this->assertInstanceOf(GraphMetricsResult::class, $result);
    });

    // Network metrics

    it('calculates number of nodes', function () {

        $graphMetrics = new GraphMetrics();

        $result = $graphMetrics->calculate($this->graph);

        $this->assertSame(5, $result->nodeCount);

    });

    it('calculates number of edges', function () {

        $graphMetrics = new GraphMetrics();

        $result = $graphMetrics->calculate($this->graph);

        $this->assertSame(7, $result->edgeCount);

    });

    it('calculates average degree', function () {

        $graphMetrics = new GraphMetrics();

        $result = $graphMetrics->calculate($this->graph);

        $this->assertEqualsWithDelta(2.8, $result->averageDegree, 0.000001);

    });

    it('calculates graph density', function () {

        $graphMetrics = new GraphMetrics();

        $result = $graphMetrics->calculate($this->graph);

        $this->assertEqualsWithDelta(0.7, $result->density, 0.000001);

    });

    it('calculates connected components', function () {

        $graphMetrics = new GraphMetrics();

        $result = $graphMetrics->calculate($this->graph);

        $this->assertSame(1, $result->connectedComponents);

    });

    it('identifies maximum degree', function () {

        $graphMetrics = new GraphMetrics();

        $result = $graphMetrics->calculate($this->graph);

        $this->assertEquals(
            [
                'degree' => 4,
                'nodeIds' => [2] 
            ], 
            $result->maximumDegree
        );

    });

    it('calculates average edge severity', function () {

        $result = (new GraphMetrics())->calculate($this->graph);

        $this->assertEqualsWithDelta(19 / 7, $result->averageEdgeSeverity, 0.000001);

    });

    it('counts severe interactions', function () {

        $graphMetrics = new GraphMetrics();

        $result = $graphMetrics->calculate($this->graph);

        $this->assertSame(4, $result->severeInteractions);

    });

});

describe('specific cases', function () {

    it('calculates metrics for an empty graph', function () {

        $emptyGraph = new Graph(new AdjacencyList());

        $result = (new GraphMetrics())->calculate($emptyGraph);

        $this->assertInstanceOf(GraphMetricsResult::class, $result);

        $this->assertSame(0, $result->nodeCount);
        $this->assertSame(0, $result->edgeCount);

        $this->assertSame(0.0, $result->averageDegree);
        $this->assertSame(0.0, $result->density);

        $this->assertSame(0, $result->connectedComponents);

        $this->assertSame([
            'degree' => null,
            'nodeIds' => []
        ], $result->maximumDegree);

        $this->assertNull($result->averageEdgeSeverity);
        $this->assertSame(0, $result->severeInteractions);

    });

    it('handles isolated nodes', function () {

        $graph = createTestGraph(4, [
            [1, 2, Severity::MINOR],
            [2, 3, Severity::MINOR],
            [1, 3, Severity::MINOR]
        ]);

        $result = (new GraphMetrics())->calculate($graph);

        $this->assertSame(4, $result->nodeCount);
        $this->assertSame(2, $result->connectedComponents);

        $this->assertEqualsWithDelta(1.5, $result->averageDegree, 0.000001);
        $this->assertEqualsWithDelta(0.5, $result->density, 0.000001);

    });

    it('handles disconnected graphs', function () {

        $graph = createTestGraph(5, [
            [1, 2, Severity::MINOR],
            [2, 3, Severity::MINOR],
            [4, 5, Severity::MINOR]
        ]);

        $result = (new GraphMetrics())->calculate($graph);

        $this->assertSame(2, $result->connectedComponents);

    });

    it('handles graphs without edges', function () {

        $graph = createTestGraph(3);

        $result = (new GraphMetrics())->calculate($graph);

        $this->assertSame(3, $result->nodeCount);
        $this->assertSame(0, $result->edgeCount);
        $this->assertSame(3, $result->connectedComponents);

        $this->assertSame(0.0, $result->averageDegree);
        $this->assertSame(0.0, $result->density);

        $this->assertSame(0, $result->maximumDegree['degree']);

        $this->assertEqualsCanonicalizing(
            [1, 2, 3],
            $result->maximumDegree['nodeIds']
        );

        $this->assertNull($result->averageEdgeSeverity);
        $this->assertSame(0, $result->severeInteractions);

    });

    it('handles graphs with a single node', function () {

        $graph = createTestGraph(1);

        $result = (new GraphMetrics())->calculate($graph);

        $this->assertSame(1, $result->nodeCount);
        $this->assertSame(0, $result->edgeCount);
        $this->assertSame(1, $result->connectedComponents);

        $this->assertSame(0.0, $result->averageDegree);
        $this->assertSame(0.0, $result->density);

        $this->assertSame([
            'degree' => 0,
            'nodeIds' => [1]
        ], $result->maximumDegree);

        $this->assertNull($result->averageEdgeSeverity);
        $this->assertSame(0, $result->severeInteractions);

    });

    it('handles ties in maximum degree', function () {

        $graph = createTestGraph(4, [
            [1, 2, Severity::MINOR],
            [2, 3, Severity::MINOR],
            [3, 4, Severity::MINOR]
        ]);

        $result = (new GraphMetrics())->calculate($graph);

        $this->assertSame(2, $result->maximumDegree['degree']);

        $this->assertEqualsCanonicalizing(
            [2, 3],
            $result->maximumDegree['nodeIds']
        );

    });

    it('handles severity threshold boundaries', function () {

        $graph = createTestGraph(5, [
            [1, 2, Severity::MINOR],
            [2, 3, Severity::MODERATE],
            [3, 4, Severity::MAJOR],
            [4, 5, Severity::CONTRAINDICATED]
        ]);

        $result = (new GraphMetrics())->calculate($graph);

        $this->assertSame(2, $result->severeInteractions);

        $this->assertEqualsWithDelta(
            2.5,
            $result->averageEdgeSeverity,
            0.000001
        );

    });

    it('handles complete graphs', function () {

        $graph = createTestGraph(4, [
            [1, 2, Severity::MINOR],
            [1, 3, Severity::MINOR],
            [1, 4, Severity::MINOR],
            [2, 3, Severity::MINOR],
            [2, 4, Severity::MINOR],
            [3, 4, Severity::MINOR]
        ]);

        $result = (new GraphMetrics())->calculate($graph);

        $this->assertSame(4, $result->nodeCount);
        $this->assertSame(6, $result->edgeCount);

        $this->assertSame(1.0, $result->density);
        $this->assertSame(3.0, $result->averageDegree);

        $this->assertSame(1, $result->connectedComponents);

        $this->assertSame(3, $result->maximumDegree['degree']);

        $this->assertEqualsCanonicalizing(
            [1, 2, 3, 4],
            $result->maximumDegree['nodeIds']
        );

    });

});
