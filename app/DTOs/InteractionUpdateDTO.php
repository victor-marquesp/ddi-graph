<?php

namespace App\DTOs;

use App\Enums\Severity;

readonly class InteractionUpdateDTO {

    private function __construct(
        public Severity $severity,
        public ?string $description
    ) {}

    public static function fromArray(array $data) : self {

        return new self(
            severity: Severity::from($data['severity']),
            description: $data['description'] ?? null
        );

    }

}