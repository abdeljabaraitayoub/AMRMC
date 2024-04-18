<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssociationAgent>
 */
class AssociationAgentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => \App\Models\User::factory()->agent(),
            // 'association_id' => $this->faker->numberBetween(1, 10),
            'association_id' => 1,
            'position' => $this->faker->randomElement(['president', 'member']),
            'bio' => $this->faker->text,
        ];
    }
}
