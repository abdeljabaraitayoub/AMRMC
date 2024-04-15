<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Association>
 */
class AssociationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'address' => $this->faker->optional()->address,
            'city' => $this->faker->city,
            'country' => 'Morocco', // default value
            'website' => $this->faker->optional()->url,
            'description' => $this->faker->optional()->text,
            'objectives' => $this->faker->optional()->text,
            'activities' => $this->faker->optional()->text,
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
