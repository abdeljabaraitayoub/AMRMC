<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'User_id' => $this->faker->numberBetween(1, 10),
            'title' => $this->faker->word,
            'description' => $this->faker->text,
            'date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'endDate' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}
