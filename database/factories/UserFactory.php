<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'date_of_birth' => fake()->date(),
            'phone' => fake()->unique()->phoneNumber(),
            'country' => fake()->country(),
            'city' => fake()->city(),
            'address' => fake()->address(),
            // 'role' => fake()->randomElement(['admin', 'doctor', 'patient', 'association_agent', 'pharmacist', 'lab_technician', 'analyst']),
            // 'role' => fake()->randomElement(['admin']),
            'role' => 'patient',
            'password' => static::$password ??= Hash::make('password'),
            'image' => fake()->imageUrl(),
            'created_at' => fake()->dateTimeBetween('-4 month', '+8 month'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model's role should be admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin()
    {
        return $this->state([
            'role' => 'admin',
        ]);
    }

    /**
     * Indicate that the model's role should be patient.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function patient()
    {
        return $this->state([
            'role' => 'patient',
        ]);
    }
    /**
     * Indicate that the model's role should be agent.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function agent()
    {
        return $this->state([
            'role' => 'association_agent',
        ]);
    }
}
