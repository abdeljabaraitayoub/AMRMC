<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medics>
 */
class MedicsFactory extends Factory
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
            'type' => $this->faker->word,
            'dosage_form' => $this->faker->randomElement(['tablet', 'capsule', 'liquid']),
            'manufacturer' => $this->faker->company,
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'description' => $this->faker->optional()->text,
            'image' => $this->faker->imageUrl(),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
