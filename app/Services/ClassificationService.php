<?php

namespace App\Services;

use App\Models\Classification;
use App\DTOs\ClassificationDTO;

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
        $classification->delete();
    }

}