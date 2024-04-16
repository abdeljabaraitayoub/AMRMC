<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Association::factory(10)->create();
        \App\Models\AssociationAgent::factory(10)->create();
        \App\Models\Medics::factory(10)->create();
        \App\Models\Disease::factory(10)->create();
        \App\Models\Patient::factory(10)->create();
        \App\Models\Event::factory(3)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
