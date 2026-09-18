<?php

use App\Models\Drug;
use App\Models\Interaction;

use App\Graph\GraphBuilder;
use App\Graph\Graph;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {

    $this->drugs = Drug::factory(10)->create();
    $this->interactions = Interaction::factory(20)->create();

    $this->graphBuilder = new GraphBuilder();

});

it('builds the graph with valid data', function() {

    $graph = $this->graphBuilder->build($this->drugs, $this->interactions);

    expect($graph)->toBeInstanceOf(Graph::class);

    foreach($this->drugs as $drug) {

        $node = $graph->getNode($drug->id);

        expect($node->id)->toBe($drug->id);
        expect($node->classification)->toBe($drug->classification);
        expect($node->properties['name'])->toBe($drug->name);
        expect($node->properties['description'])->toBe($drug->description);

    }

    foreach($this->interactions as $interaction) {

        $edge = $graph->getEdge($interaction->id);

        expect($edge->id)->toBe($interaction->id);
        expect($edge->nodeA->id)->toBe($interaction->drugA_id);
        expect($edge->nodeB->id)->toBe($interaction->drugB_id);
        expect($edge->severity)->toBe($interaction->severity);
        expect($edge->properties['description'])->toBe($interaction->description);

    }

});

it('builds an empty graph', function () {

    $graph = $this->graphBuilder->build([], []);

    expect($graph)->toBeInstanceOf(Graph::class);

    expect($graph->nodes)->toBe([]);
    expect($graph->edges)->toBe([]);

});
