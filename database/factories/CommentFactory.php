<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{

    public function definition(): array
    {
        $user_id = User::all()->random()->id;
        $product_id = Product::all()->random()->id;
        return [
            'content' => fake()->paragraph(),
            'parent_id' => null,
            'user_id' => $user_id,
            'rate' => fake()->randomFloat(2, 10, 100),
            'product_id' => $product_id,
        ];
    }
}
