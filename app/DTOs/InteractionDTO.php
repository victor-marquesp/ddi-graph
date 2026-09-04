<?php

namespace App\DTOs;

use App\Enums\Severity;

class InteractionDTO {

    private function __construct(
        public int $drugA_id,
        public int $drugB_id,
        public readonly Severity $severity,
        public readonly ?string $description
    ) {}

    public static function fromArray(array $data) : self {

        return new self(
            drugA_id: $data['drugA_id'],
            drugB_id: $data['drugB_id'],
            severity: Severity::from($data['severity']),
            description: $data['description'] ?? null
        );

    }

}