<?php

namespace App\Graph;

use App\Models\Classification;

class Node {

    public private(set) int $id;

    public private(set) Classification $classification;

    /** @var string[] */
    public private(set) array $labels = [];

    /** @var array<string, mixed> */
    public private(set) array $properties = [];

    /** @param ?string[] $labels @param ?array<string, mixed> $properties */
    public function __construct(int $id, Classification $classification, ?array $labels = null, ?array $properties = null) {

        $this->id = $id;
        $this->classification = $classification;

        if($labels !== null) {
            $this->labels = $labels;
        }

        if($properties !== null) {
            $this->properties = $properties;
        }

    }

}
