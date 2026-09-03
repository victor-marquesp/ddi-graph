<?php

namespace App\Services;

use App\Models\Classification;
use App\DTOs\ClassificationDTO;
use App\Exceptions\ThisClassificationHasDrugsException;

class ClassificationService {

    public function create(ClassificationDTO $dto) : Classification {

        $classification = Classification::create([
            'name' => $dto->name,
            'description' => $dto->description
        ]);

        return $classification;
    }

    public function update(ClassificationDTO $dto, Classification $classification) : Classification {

        $classification->update([
            'name' => $dto->name,
            'description' => $dto->description
        ]);

        $classification->refresh();

        return $classification;
    }

    public function delete(Classification $classification) : void {

        if($classification->drugs()->exists()) {
            throw new ThisClassificationHasDrugsException('This classification has drugs associated');
        }

        $classification->delete();
    }

}