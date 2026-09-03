<?php

namespace App\Http\Controllers;

use App\DTOs\DrugDTO;
use App\Http\Requests\Drug\StoreDrugRequest;
use App\Http\Requests\Drug\UpdateDrugRequest;
use App\Models\Classification;
use App\Models\Drug;
use App\Services\DrugService;

class DrugController extends Controller{
    
    public function __construct(
        private DrugService $drugService
    ) {}

    public function index() {
        $drugs = Drug::all();

        return view('drugs.index', compact('drugs'));
    }

    public function create() {
        $classifications = Classification::all();
        
        return view('drugs.create', compact('classifications'));
    }

    public function store(StoreDrugRequest $request) {

        $dto = DrugDTO::fromArray(
            $request->validated()
        );

        $this->drugService->create($dto);

        return redirect()->route('drugs.index')->with('success', 'Drug created');
    }

    public function show(Drug $drug) {
        return view('drugs.show', compact('drug'));
    }

    public function edit(Drug $drug) {
        $classifications = Classification::all();
        
        return view('drugs.create', compact('drug', 'classifications'));
    }

    public function update(UpdateDrugRequest $request, Drug $drug) {
        
        $dto = DrugDTO::fromArray(
            $request->validated()
        );

        $this->drugService->update(
            dto: $dto,
            drug: $drug
        );

        return redirect()->route('drugs.show', $drug)->with('success', 'Drug updated');
    }

    public function destroy(Drug $drug) {

        $this->drugService->delete($drug);
     
        return redirect()->route('drugs.index')->with('success', 'Drug deleted');
    }
}
