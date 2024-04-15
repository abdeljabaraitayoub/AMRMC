<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => \App\Models\User::factory(),
            'medical_record_number' => $this->faker->unique()->numerify('MRN-########'),
            'medical_history' => $this->faker->text,
            'association_id' => $this->faker->optional()->numberBetween(1, 10),
            'disease_id' => $this->faker->optional()->numberBetween(1, 10),
        ];
    }
}
