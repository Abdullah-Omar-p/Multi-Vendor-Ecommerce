<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class CartProductFactory extends Factory
{
    public function definition(): array
    {
        $cartId = Cart::all()->random()->id;
        $productId = Product::all()->random()->id;
        return [
            'cart_id' => $cartId,
            'product_id' => $productId,
        ];
    }
}
