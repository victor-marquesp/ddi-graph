<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drug;

class SelectionController extends Controller {

    public function index() {
        $drugs = Drug::all();

        return view('graph.selection', compact('drugs'));
    }

}
