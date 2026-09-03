<?php

namespace App\DTOs;

readonly class DrugDTO {

    private function __construct(
        public string $name,
        public ?string $description,
        public int $classification_id
    ) {}

    public static function fromArray(array $data) : self {

        return new self(
            name: $data['name'],
            description: $data['description'] ?? null,
            classification_id: $data['classification_id']
        );

    }
}
