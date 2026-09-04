<?php

namespace App\Http\Controllers;

use App\DTOs\InteractionDTO;
use App\DTOs\InteractionUpdateDTO;
use App\Exceptions\DuplicatedInteractionException;
use App\Exceptions\SelfInteractionException;
use App\Http\Requests\Interaction\StoreInteractionRequest;
use App\Http\Requests\Interaction\UpdateInteractionRequest;
use App\Models\Drug;
use App\Models\Interaction;
use App\Services\InteractionService;

class InteractionController extends Controller {

    public function __construct(
        private InteractionService $interactionService
    ) {}
    
    public function index() {
        $interactions = Interaction::all();

        return view('interactions.index', compact('interactions'));
    }

    public function create() {
        $drugs = Drug::all();

        return view('interactions.create', compact('drugs'));
    }

    public function store(StoreInteractionRequest $request) {

        $dto = InteractionDTO::fromArray(
            $request->validated()
        );
        
        try {
            $this->interactionService->create($dto);
        } catch (SelfInteractionException | DuplicatedInteractionException $e) {
            return redirect()->route('interactions.index')->with('error', $e->getMessage());
        } 

        return redirect()->route('interactions.index')->with('success', 'Interaction created');
    }

    public function show(Drug $drugA, Drug $drugB) {
        $interaction = Interaction::where('drugA_id', $drugA->id)
            ->where('drugB_id', $drugB->id)
            ->firstOrFail();

        return view('interactions.show', compact('interaction'));   
    }

    public function edit(Drug $drugA, Drug $drugB) {

        $interaction = Interaction::where('drugA_id', $drugA->id)
            ->where('drugB_id', $drugB->id)
            ->firstOrFail();

        return view('interactions.edit', compact('interaction'));
    }

    public function update(UpdateInteractionRequest $request, Drug $drugA, Drug $drugB) {
        
        $interaction = Interaction::where('drugA_id', $drugA->id)
            ->where('drugB_id', $drugB->id)
            ->firstOrFail();

        $dto = InteractionUpdateDTO::fromArray(
            $request->validated()
        );

        $this->interactionService->update(
            dto: $dto,
            interaction: $interaction
        );

        return redirect()->route('interactions.index')->with('success', 'Interaction updated');
    }

    public function destroy(Drug $drugA, Drug $drugB) {
    
        $interaction = Interaction::where('drugA_id', $drugA->id)
            ->where('drugB_id', $drugB->id)
            ->firstOrFail();

        $this->interactionService->delete($interaction);

        return redirect()->route('interactions.index')->with('success', 'Interaction deleted');
    }
}
