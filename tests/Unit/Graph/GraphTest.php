<?php

use App\Enums\Severity;

use App\Exceptions\InvalidNodeException;
use App\Exceptions\InvalidEdgeException;
use App\Exceptions\NonExistentNodeException;
use App\Exceptions\NonExistentEdgeException;

use App\Graph\AdjacencyList;
use App\Graph\Edge;
use App\Graph\Graph;
use App\Graph\Node;

use App\Models\Classification;

beforeEach(function () {

    $this->classification = Classification::factory()->create();

});

it('add nodes', function () {

    $nodeA = new Node(
        id: 1, 
        classification: $this->classification, 
        labels: [':node'],
        properties: [
            'name' => 'aspirin',
            'description' => 'reliefs pain and fever'
        ]
    );

    $nodeB = new Node(2, $this->classification);
    $graph = new Graph(new AdjacencyList());

    $graph->addNode($nodeA);
    $graph->addNode($nodeB);

    expect($graph->getNode(1))->toEqual($nodeA);
    expect($graph->getNode(2))->toEqual($nodeB);

});


it('does not add duplicate nodes', function () {

    $nodeA = new Node(1, $this->classification);
    $nodeB = new Node(1, $this->classification);
    $graph = new Graph(new AdjacencyList());

    $graph->addNode($nodeA);

    expect(fn() => $graph->addNode($nodeB))->toThrow(InvalidNodeException::class);

});

it('add edges', function () {

    $nodeA = new Node(1, $this->classification);
    $nodeB = new Node(2, $this->classification);
    $nodeC = new Node(3, $this->classification);
    $nodeD = new Node(4, $this->classification);

    $edgeA = new Edge(
        id: 1, 
        nodeA: $nodeA, 
        nodeB: $nodeB, 
        severity: Severity::MINOR, 
        properties: [
            'description' => ''
        ]
    );

    $edgeB = new Edge(2, $nodeC, $nodeD, Severity::MAJOR);
    $graph = new Graph(new AdjacencyList());

    $graph->addNode($nodeA);
    $graph->addNode($nodeB);
    $graph->addNode($nodeC);
    $graph->addNode($nodeD);

    $graph->addEdge($edgeA);
    $graph->addEdge($edgeB);

    expect($graph->getEdge(1))->toEqual($edgeA);
    expect($graph->getEdge(2))->toEqual($edgeB);

});

it('does not add edges with duplicate IDs', function () {

    $nodeA = new Node(1, $this->classification);
    $nodeB = new Node(2, $this->classification);
    $nodeC = new Node(3, $this->classification);

    $invalidEdge = new Edge(1, $nodeA, $nodeC, Severity::MAJOR);

    $graph = new Graph(new AdjacencyList());
    $graph->addNode($nodeA);
    $graph->addNode($nodeB);
    $graph->addNode($nodeC);

    expect(fn() => $graph->addEdge($invalidEdge))->toThrow(InvalidEdgeException::class);

});

it('does not add edges with non-existent nodes', function () {

    $nodeA = new Node(1, $this->classification);
    $nodeB = new Node(2, $this->classification);

    $invalidEdge = new Edge(1, $nodeA, $nodeB, Severity::MAJOR);

    $graph = new Graph(new AdjacencyList());

    expect(fn() => $graph->addEdge($invalidEdge))->toThrow(InvalidEdgeException::class);

});

it('does not add duplicate edges', function () {

    $nodeA = new Node(1, $this->classification);
    $nodeB = new Node(2, $this->classification);
    $validEdge = new Edge(1, $nodeA, $nodeB);
    $duplicatedEdge = new Edge(2, $nodeA, $nodeB);

    $graph = new Graph(new AdjacencyList());

    $graph->addNode($nodeA);
    $graph->addNode($nodeB);

    $graph->addEdge($validEdge);

    expect(fn() => $graph->addEdge($duplicatedEdge))->toThrow(InvalidEdgeException::class);

});

it('does not add self-loops', function () {

    $nodeA = new Node(1, $this->classification);
    $selfEdge = new Edge(1, $nodeA, $nodeA);

    $graph = new Graph(new AdjacencyList());
    $graph->addNode($nodeA);

    expect(fn() => $graph->addEdge($selfEdge))->toThrow(InvalidEdgeException::class);

});

test('utilities methods works', function () {

    $nodeA = new Node(1, $this->classification);
    $nodeB = new Node(2, $this->classification);
    $nodeC = new Node(3, $this->classification);
    $nodeD = new Node(4, $this->classification);
    $nodeE = new Node(5, $this->classification);

    $edgeAB = new Edge(1, $nodeA, $nodeB, Severity::MINOR);
    $edgeBC = new Edge(2, $nodeB, $nodeC, Severity::MODERATE);
    $edgeAC = new Edge(3, $nodeA, $nodeC, Severity::MAJOR);
    $edgeCD = new Edge(4, $nodeC, $nodeD, Severity::CONTRAINDICATED);

    $graph = new Graph(new AdjacencyList());

    $graph->addNode($nodeA);
    $graph->addNode($nodeB);
    $graph->addNode($nodeC);
    $graph->addNode($nodeD);
    $graph->addNode($nodeE);

    $graph->addEdge($edgeAB);
    $graph->addEdge($edgeBC);
    $graph->addEdge($edgeAC);
    $graph->addEdge($edgeCD);

    expect($graph->nodeCount())->toBe(5);
    expect($graph->edgeCount())->toBe(4);

    expect($graph->hasEdge(1, 2))->toBe($edgeAB);
    expect($graph->hasEdge(1, 5))->toBe(false);

    expect(
        $graph->neighbors(1)
    )->toBe([$nodeB, $nodeC]);
    expect($graph->neighbors(5))->toBe([]);

    expect(
        $graph->incidentEdges(1)
    )->toBe([$edgeAB, $edgeAC]);
    expect($graph->incidentEdges(5))->toBe([]);

    expect($graph->degree(1))->toBe(2);
    expect($graph->degree(5))->toBe(0);

});

test('utilities methods works on empty graph', function () {

    $graph = new Graph(new AdjacencyList());

    expect($graph->nodeCount())->toBe(0);
    expect($graph->edgeCount())->toBe(0);

    expect(fn() => $graph->getNode(1))->toThrow(NonExistentNodeException::class);
    expect(fn() => $graph->getEdge(1))->toThrow(NonExistentEdgeException::class);

    expect(fn() => $graph->hasEdge(1, 2))->toThrow(NonExistentNodeException::class);
    expect(fn() => $graph->neighbors(1))->toThrow(NonExistentNodeException::class);
    expect(fn() => $graph->incidentEdges(1))->toThrow(NonExistentNodeException::class);
    expect(fn() => $graph->degree(1))->toThrow(NonExistentNodeException::class);

});

test('graph is undirected', function () {

    $nodeA = new Node(1, $this->classification);
    $nodeB = new Node(2, $this->classification);

    $edgeAB = new Edge(1, $nodeA, $nodeB, Severity::MODERATE);

    $graph = new Graph(new AdjacencyList());
    $graph->addNode($nodeA);
    $graph->addNode($nodeB);
    $graph->addEdge($edgeAB);

    expect($graph->hasEdge(1, 2))->toBe($edgeAB);
    expect($graph->hasEdge(2, 1))->toBe($edgeAB);

});
