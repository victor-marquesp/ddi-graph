<?php

namespace App\Services;

use App\DTOs\InteractionDTO;
use App\DTOs\InteractionUpdateDTO;
use App\Exceptions\DuplicatedInteractionException;
use App\Exceptions\SelfInteractionException;
use App\Models\Interaction;

class InteractionService {

    public function create(InteractionDTO $dto) : Interaction {

        if($dto->drugA_id === $dto->drugB_id) {
            throw new SelfInteractionException('A Drug cannot interact with itself');
        }

        if($dto->drugA_id  > $dto->drugB_id) {
            $temp = $dto->drugA_id;
            $dto->drugA_id = $dto->drugB_id;
            $dto->drugB_id = $temp;
        }

        $isDuplicated = Interaction::where('drugA_id', $dto->drugA_id)
            ->where('drugB_id', $dto->drugB_id)
            ->exists();

        if($isDuplicated) {
            throw new DuplicatedInteractionException('This interaction already exists');
        }

        $interaction = Interaction::create([
            'drugA_id' => $dto->drugA_id,
            'drugB_id' => $dto->drugB_id,
            'severity' => $dto->severity,
            'description' => $dto->description
        ]);

        return $interaction;
    }

    public function update(InteractionUpdateDTO $dto, Interaction $interaction) : Interaction {

        $interaction->update([
            'severity' => $dto->severity,
            'description' => $dto->description
        ]);

        $interaction->refresh();

        return $interaction;
    }

    public function delete(Interaction $interaction) {

        Interaction::where('drugA_id', $interaction->drugA_id)
            ->where('drugB_id', $interaction->drugB_id)
            ->delete();

    } 

}
