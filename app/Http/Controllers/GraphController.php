<?php

namespace App\Http\Controllers;

use App\Graph\CytoscapeSerializer;
use App\Graph\GraphBuilder;
use App\Http\Requests\Graph\SelectedGraphRequest;
use App\Models\Drug;
use App\Models\Interaction;

class GraphController extends Controller {
    
    public function __construct(
        private GraphBuilder $builder,
        private CytoscapeSerializer $serializer
    ) {}

    public function all() {

        $drugs = Drug::with('classification')->get();
        $interactions = Interaction::all();

        $graph = $this->builder->build($drugs->all(), $interactions->all());

        $elements = $this->serializer->serialize($graph);
        
        return view('graph.index', compact('graph', 'elements'));
    }

    public function selected(SelectedGraphRequest $request) {

        $ids = $request->validated('drug_ids');

        $drugs = Drug::with('classification')->findMany($ids)->all();
        $interactions = Interaction::whereIn('drugA_id', $ids)->whereIn('drugB_id', $ids)->get()->all();
        
        $graph = $this->builder->build($drugs, $interactions);
        
        $elements = $this->serializer->serialize($graph);

        return view('graph.index', compact('graph', 'elements', 'ids'));
    }

}
