<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $user_id = User::all()->random()->id;
        $offerId = Offer::all('id')->random();
        $product = Product::inRandomOrder()->first();
        $productDiscount = $product->discount;
        $productPrice    = $product->price;
        $productActualPrice = $productPrice - ($productDiscount/100) * $productPrice;
        $product_id = $product->id;
        $storeId = $product->store_id;

        $start_date = '-1 year';
        $end_date = 'now';

        $trans_date = fake()->dateTimeBetween($start_date, $end_date);

        return [
            'price' => $productActualPrice,
            'user_id' => $user_id,
            'store_id' => $storeId,
            'status' => 'active' or 'inactive',
//            'product_id' => $product_id,
//            'offer_id' => $offerId,
            'location' => fake()->address(),
            'trans_date' => $trans_date->format('Y-m-d H:i:s'),

        ];
    }
}
