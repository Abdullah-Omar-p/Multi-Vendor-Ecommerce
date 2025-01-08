<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferUserFactory extends Factory
{
    public function definition(): array
    {
        $offerId = Offer::all()->random()->id;
        $userId = User::all()->random()->id;
        return [
            'offer_id' => $offerId,
            'user_id' => $userId,
        ];

    }
}
