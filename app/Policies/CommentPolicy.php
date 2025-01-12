<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole('super-admin') || $user->can('view-comments');
    }

    public function view(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id ||
            $user->hasAnyRole('super-admin') ||
            $user->can('view-comments');
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole('super-admin') || $user->can('create-comments');
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id ||
            $user->hasAnyRole('super-admin') ||
            $user->can('update-comments');
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id ||
            $user->hasAnyRole('super-admin') ||
            $user->can('delete-comments');
    }

    public function restore(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id ||
            $user->hasAnyRole('super-admin') ||
            $user->can('restore-comments');
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id ||
            $user->hasAnyRole('super-admin') ||
            $user->can('force-delete-comments');
    }
}
