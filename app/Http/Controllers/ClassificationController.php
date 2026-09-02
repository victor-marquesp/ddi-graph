<?php

namespace App\Http\Controllers;

use App\DTOs\ClassificationDTO;
use App\Http\Requests\Classification\StoreClassificationRequest;
use App\Http\Requests\Classification\UpdateClassificationRequest;
use App\Models\Classification;
use App\Services\ClassificationService;

class ClassificationController extends Controller {

    public function __construct(
        private ClassificationService $classificationService
    ) {}
    
    public function index() {

        $classifications = Classification::all();

        return view('classifications.index', compact('classifications'));
    }

    public function create() {
        return view('classifications.create');
    }

    public function store(StoreClassificationRequest $request) {
        
        $dto = ClassificationDTO::fromArray(
            $request->validated()
        );

        $this->classificationService->create($dto);

        return redirect()->route('classifications.index')->with('success', 'Classification Created');
    }

    public function show(Classification $classification) {
        return view('classifications.show', compact('classification'));
    }

    public function edit(Classification $classification) {
        return view('classifications.edit', compact('classification'));
    }

    public function update(UpdateClassificationRequest $request, Classification $classification) {
        
        $dto = ClassificationDTO::fromArray(
            $request->validated()
        );

        $this->classificationService->update(
            dto: $dto,
            classification: $classification
        );

        return redirect()->route('classifications.show', $classification)->with('success', 'Classification Updated');
    }

    public function destroy(Classification $classification) {
        
        $this->classificationService->delete($classification);

        return redirect()->route('classifications.index')->with('success', 'Classification Deleted');
    }
}
