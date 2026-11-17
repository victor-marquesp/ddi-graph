<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;

class SelectionController extends Controller {

    public function index(Request $request) {

        $drugs = Drug::orderBy('name')->get();

        $ids = $request->query('drug_ids', []);

        $ids = is_array($ids)
            ? array_filter($ids, 'is_scalar')
            : [];

        $selected = $drugs->pluck('id')
            ->intersect($ids)
            ->values()
            ->all();

        $mode = $request->query('mode', 'graph');

        if (!in_array($mode, ['table', 'graph', 'metrics'], true)) {
            $mode = 'graph';
        }

        return view('graph.selection', compact(
            'drugs',
            'selected',
            'mode'
        ));

    }

}