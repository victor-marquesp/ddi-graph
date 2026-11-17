<?php

namespace App\Http\Controllers;

use App\Graph\GraphBuilder;
use App\Graph\GraphMetrics;
use App\Http\Requests\Graph\SelectedGraphRequest;
use App\Models\Drug;
use App\Models\Interaction;

class MetricsController extends Controller {
    
    public function __construct(
        private GraphBuilder $builder,
        private GraphMetrics $graphMetrics
    ) {}

    public function all() {

        $drugs = Drug::all();
        $interactions = Interaction::all();
        $graph = $this->builder->build($drugs->all(), $interactions->all());

        $result = $this->graphMetrics->calculate($graph);
        
        return view('graph.dashboard', compact('result', 'graph'));
    }

    public function selected(SelectedGraphRequest $request) {

        $ids = $request->validated('drug_ids');
        $drugs = Drug::findMany($ids)->all();
        $interactions = Interaction::whereIn('drugA_id', $ids)->whereIn('drugB_id', $ids)->get()->all();
        $graph = $this->builder->build($drugs, $interactions);

        $result = $this->graphMetrics->calculate($graph);

        return view('graph.dashboard', compact('result', 'graph'));
    }

}
