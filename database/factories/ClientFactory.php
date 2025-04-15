<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->company(),
            'btw_number'=>fake()->randomElement(['748.909.383','715.794.870','1.015.821.216']),
            'add_btw' => fake()->boolean(),
            'address'=>fake()->address(),
        ];
    }
}