<?php

namespace App\Services;

use App\DTOs\DrugDTO;
use App\Models\Drug;

class DrugService {

    public function create(DrugDTO $dto) : Drug {

        $drug = Drug::create([
            'name' => $dto->name,
            'description' => $dto->description,
            'classification_id' => $dto->classification_id
        ]);

        return $drug;
    }

    public function update(DrugDTO $dto, Drug $drug) : Drug {

        $drug->update([
            'name' => $dto->name,
            'description' => $dto->description,
            'classification_id' => $dto->classification_id
        ]);

        $drug->refresh();

        return $drug;
    }

    public function delete(Drug $drug) : void {
        $drug->delete();
    }

}