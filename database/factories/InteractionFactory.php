<?php

namespace Database\Factories;

use App\Enums\Severity;
use App\Models\Drug;
use App\Models\Interaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Interaction>
 */
class InteractionFactory extends Factory {

    /**
     * @return array<string, mixed>
     */
    public function definition() : array {

        return [
            'drugA_id' => Drug::factory()->create(),
            'drugB_id' => Drug::factory()->create(),
            'severity' => fake()->randomElement(Severity::class),
            'description' => fake()->optional()->text()
        ];

    }
}
