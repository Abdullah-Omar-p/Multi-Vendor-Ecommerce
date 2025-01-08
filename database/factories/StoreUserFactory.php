<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreUserFactory extends Factory
{

    public function definition(): array
    {
        $user_id = User::all()->random()->id;
        $store_id = Store::all()->random()->id;
        return [
            'user_id' => $user_id,
            'store_id' => $store_id,
        ];
    }
}
