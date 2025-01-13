<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function create(User $user): bool
    {
        return $user->hasAnyRole('super-admin') || $user->can('create-categories');
    }

    public function update(User $user, Category $category): bool
    {
        return $user->hasAnyRole('super-admin') ||
            $user->id === $category->user_id ||
            $user->can('update-categories');
    }

    public function show(User $user, Category $category): bool
    {
        return $user->hasAnyRole('super-admin') ||
            $user->can('view-categories') ||
            $user->id === $category->user_id;
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->hasAnyRole('super-admin') ||
            $user->id === $category->user_id ||
            $user->can('delete-categories');
    }
}
