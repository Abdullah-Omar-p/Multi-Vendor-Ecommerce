<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductFactory extends Factory
{

    public function definition()
    {
        $user_id = Order::all()->random()->id;
        $product_id = Product::all()->random()->id;
        return [
            'order_id' => $user_id,
            'product_id' => $product_id,
        ];
    }
}
