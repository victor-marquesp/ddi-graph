<?php

use App\Enums\Severity;
use App\Graph\Graph;
use App\Graph\Node;
use App\Graph\Edge;
use App\Graph\CytoscapeSerializer;
use App\Models\Classification;

use App\Graph\AdjacencyList;

beforeEach(function () {

    $this->graph = new Graph(new AdjacencyList());

    $this->serializer = new CytoscapeSerializer();

});

test('serializes an empty graph', function () {

    expect($this->serializer->serialize($this->graph))
        ->toBe([
            'nodes' => [],
            'edges' => []
        ]);

});

test('serializes nodes and edges', function () {

    $classification = new Classification([
        'name' => 'Classification A'
    ]);

    $classification->id = 1;

    $nodeA = new Node(
        id: 1,
        classification: $classification,
        labels: ['drug'],
        properties: ['name' => 'Drug A']
    );

    $nodeB = new Node(
        id: 2,
        classification: $classification,
        labels: ['drug'],
        properties: ['name' => 'Drug B']
    );

    $this->graph->addNode($nodeA);
    $this->graph->addNode($nodeB);

    $this->graph->addEdge(new Edge(
        id: 1,
        nodeA: $nodeA,
        nodeB: $nodeB,
        severity: Severity::from('major'),
        properties: ['description' => 'Interaction description']
    ));

    $result = $this->serializer->serialize($this->graph);

    expect($result['nodes'])->toHaveCount(2);
    expect($result['edges'])->toHaveCount(1);

    expect($result['nodes'][0]['data'])
        ->toMatchArray([
            'id' => 'n1',
            'drugId' => 1,
            'name' => 'Drug A',
            'classification' => 'Classification A',
            'degree' => 1
        ]);

    expect($result['edges'][0]['data'])
        ->toMatchArray([
            'id' => 'e1',
            'source' => 'n1',
            'target' => 'n2',
            'severity' => 'major',
            'description' => 'Interaction description'
        ]);

});
