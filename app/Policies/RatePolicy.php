<?php

namespace App\Policies;

use App\Models\Rate;
use App\Models\User;

class RatePolicy
{
    public function create(User $user): bool
    {
        return $user->hasAnyRole('super-admin') || $user->can('create-rates');
    }

    public function update(User $user, Rate $rate): bool
    {
        return $user->hasAnyRole('super-admin') ||
            $user->id === $rate->user_id ||
            $user->can('update-rates');
    }

    public function delete(User $user, Rate $rate): bool
    {
        return $user->hasAnyRole('super-admin') ||
            $user->id === $rate->user_id ||
            $user->can('delete-rates');
    }
}
