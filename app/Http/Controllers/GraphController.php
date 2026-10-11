<?php

namespace App\Http\Controllers;

use App\Graph\GraphBuilder;
use App\Http\Requests\Graph\SelectedGraphRequest;
use App\Models\Drug;
use App\Models\Interaction;
use Illuminate\Http\Request;

class GraphController extends Controller {
    
    public function __construct(
        private GraphBuilder $builder
    ) {}

    public function all() {

        $drugs = Drug::all();
        $interactions = Interaction::all();
        $graph = $this->builder->build($drugs->all(), $interactions->all());

        
        return view('graph.index', compact('graph'));
    }

    public function selected(SelectedGraphRequest $request) {

        $ids = $request->validated('drug_ids');

        $drugs = Drug::findMany($ids)->all();

        $interactions = Interaction::whereIn('drugA_id', $ids)->whereIn('drugB_id', $ids)->get()->all();
        
        $graph = $this->builder->build($drugs, $interactions);

        return view('graph.index', compact('graph'));
    }

}
