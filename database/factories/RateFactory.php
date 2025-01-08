<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RateFactory extends Factory
{
    public function definition(): array
    {
        $user_id = User::all()->random()->id;
        $product_id = Product::all()->random()->id;
        $commentId = Comment::all()->random()->id;
        return [
            'user_id' => $user_id,
            'comment_id' => $commentId,
            'rate' => fake()->randomFloat(2, 10, 100),
            'product_id' => $product_id,
        ];

    }
}
