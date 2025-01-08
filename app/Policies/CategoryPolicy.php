<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class CategoryPolicy
{
    public function create(User $user, Category $course = null)
    {
        switch (true) {
            case $user->hasAnyRole('super-admin'):
                return true;
            default :
                return false;
        }
    }

    public function update(User $user, Category $course = null)
    {
        switch (true) {
            case $user->hasAnyRole('super-admin'):
                return true;
            default :
                return false;
        }
    }

    public function show(User $user, Category $category = null)
    {
//        return $user->hasAnyRole('super-admin');
        return true;
    }

    public function delete(User $user, Category $post = null)
    {
        switch (true) {
            case $user->hasAnyRole('super-admin'):
                return true;
            default :
                return false;
        }
    }
}
