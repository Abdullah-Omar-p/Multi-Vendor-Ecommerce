<?php

namespace App\Policies;

use App\Models\Offer;
use App\Models\User;

class OfferPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin']) || $user->can('view-offers');
    }

    public function show(User $user, Offer $offer): bool
    {
        return $user->id === $offer->user_id
            || $user->hasAnyRole(['super-admin', 'admin'])
            || $user->can('view-offers');
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'vendor']) || $user->can('create-offers');
    }

    public function update(User $user, Offer $offer): bool
    {
        return $user->id === $offer->user_id
            || $user->hasAnyRole(['super-admin', 'admin'])
            || $user->can('update-offers');
    }

    public function delete(User $user, Offer $offer): bool
    {
        return $user->id === $offer->user_id
            || $user->hasAnyRole(['super-admin', 'admin'])
            || $user->can('delete-offers');
    }

    public function restore(User $user, Offer $offer): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

    public function forceDelete(User $user, Offer $offer): bool
    {
        return $user->hasAnyRole(['super-admin']);
    }
}
