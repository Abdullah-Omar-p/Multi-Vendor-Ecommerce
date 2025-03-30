<?php

namespace App\Policies;

use App\Models\Store;
use App\Models\User;

class StorePolicy
{
    public function create(User $user): bool
    {
        return $user->hasAnyRole('super-admin') || $user->can('create-stores');
    }

    public function update(User $user, Store $store): bool
    {
        return $user->hasAnyRole('super-admin') ||
            $user->id === $store->added_by ||
            $user->can('update-stores');
    }

    public function delete(User $user, Store $store): bool
    {
        return $user->hasAnyRole('super-admin') ||
            $user->id === $store->added_by ||
            $user->can('delete-stores');
    }
}
