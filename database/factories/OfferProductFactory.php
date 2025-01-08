<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferProductFactory extends Factory
{
    public function definition(): array
    {
        $offerId = Offer::all()->random()->id;
        $productId = Product::all()->random()->id;
        $storeId = Store::all()->random()->id;
        return [
            'offer_id' => $offerId,
            'product_id' => $productId,
            'store_id' => $storeId,
        ];

    }
}
