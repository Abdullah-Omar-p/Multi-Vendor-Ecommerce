<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    public function definition(): array
    {
        $store_id = Store::all('id')->random();

        return [
            'price' => fake()->numberBetween(10, 300),
            'name' => fake()->name(),
            'about' => fake()->text,
            'custom' => fake()->randomElement([0, 1]),
            'status' => fake()->randomElement(['active', 'inactive']),
            'no_pieces' => fake()->numberBetween(1, 10),
            'store_id' => $store_id,
        ];
    }
}
