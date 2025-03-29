<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function create(User $user): bool
    {
        return $user->hasAnyRole('super-admin') || $user->can('create-products');
    }

    public function update(User $user, Product $product): bool
    {
        return $user->hasAnyRole('super-admin') ||
            $user->id === $product->user_id ||
            $user->can('update-products');
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->hasAnyRole('super-admin') ||
            $user->id === $product->user_id ||
            $user->can('delete-products');
    }
}
