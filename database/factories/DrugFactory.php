<?php

namespace Database\Factories;

use App\Models\Classification;
use App\Models\Drug;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Drug>
 */
class DrugFactory extends Factory {

    /**
     * @return array<string, mixed>
     */
    public function definition() : array {

        return [
            'name' => fake()->name(),
            'description' => fake()->optional()->text(),
            'classification_id' => Classification::factory()->create()->id
        ];
    }
}
