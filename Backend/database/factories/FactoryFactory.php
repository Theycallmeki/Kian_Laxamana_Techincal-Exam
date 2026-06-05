<?php

namespace Database\Factories;

use App\Models\Factory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Factory>
 */
class AppFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'factory_name' => fake()->company(),
            'location' => fake()->address(),
            'email' => fake()->companyEmail(),
            'website' => fake()->url(),
        ];
    }
}
