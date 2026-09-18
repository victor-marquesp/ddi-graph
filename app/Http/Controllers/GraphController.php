<?php

namespace App\Http\Controllers;

use App\Graph\GraphBuilder;
use App\Models\Drug;
use App\Models\Interaction;
use Illuminate\Http\Request;

class GraphController extends Controller {
    
    public function __construct(
        private GraphBuilder $builder
    ) {}

    public function index() {

        $drugs = Drug::all();
        $interactions = Interaction::all();

        $graph = $this->builder->build($drugs->all(), $interactions->all());
        
        return view('graph.index', compact('graph'));
    }

}
