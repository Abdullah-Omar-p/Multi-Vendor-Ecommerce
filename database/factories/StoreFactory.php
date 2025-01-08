<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'phone' => fake()->PhoneNumber(),
            'about_store' => fake()->paragraph(),
            'link_website' => fake()->url(),
            'services' => fake()->paragraph(),
            'location' => fake()->address(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
