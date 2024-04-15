<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disease>
 */
class DiseaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'symptoms' => $this->faker->text,
            'causes' => $this->faker->text,
            'treatment' => $this->faker->text,
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),

        ];
    }
}
