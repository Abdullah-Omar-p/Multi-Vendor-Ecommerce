<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        // $parent_id = Category::all()->random()->id;

        $parent_id = 1;      // when you make artisan migrate this should be cancelled

        return [
            'name' => fake()->name(),
            'parent_id' => $parent_id,
        ];
    }
}
