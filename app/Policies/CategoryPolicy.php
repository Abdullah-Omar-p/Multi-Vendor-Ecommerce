<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Determine whether the user can create a category.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole('super-admin') || $user->can('create-categories');
    }

    /**
     * Determine whether the user can update the category.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->hasAnyRole('super-admin') ||
            $user->id === $category->user_id ||
            $user->can('update-categories');
    }

    /**
     * Determine whether the user can view the category.
     */
    public function show(User $user, Category $category): bool
    {
        return $user->hasAnyRole('super-admin') ||
            $user->can('view-categories') ||
            $user->id === $category->user_id;
    }

    /**
     * Determine whether the user can delete the category.
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->hasAnyRole('super-admin') ||
            $user->id === $category->user_id ||
            $user->can('delete-categories');
    }
}
