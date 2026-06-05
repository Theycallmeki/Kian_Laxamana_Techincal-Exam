<?php

namespace Database\Factories;

use App\Models\Factory;
use Illuminate\Database\Eloquent\Factories\Factory as EloquentFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Factory>
 */
class FactoryFactory extends EloquentFactory
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
