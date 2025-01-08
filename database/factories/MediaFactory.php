<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    public function definition(): array
    {
        $product = Product::all()->random()->id;
        $store = Store::all()->random()->id;
        $offer = Offer::all()->random()->id;
        $user = User::all()->random()->id;

        $mediaAbleId = fake()->randomElement([$store,$offer,$user,$product]);
        if ($mediaAbleId == $product){
            $mediaAbleType = Product::class;
        }elseif ($mediaAbleId == $store){
            $mediaAbleType = Store::class;
        }
        elseif ($mediaAbleId == $offer){
            $mediaAbleType = Offer::class;
        }else{
            $mediaAbleType = User::class;
        }

        return [
            'filename' => fake()->imageUrl(),
            'mediaable_id' => $mediaAbleId,
            'mediaable_type' => $mediaAbleType,
            'type' => fake()->randomElement(['video','voice','image']),
        ];
    }
}
