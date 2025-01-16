<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the user can view any orders.
     */
    public function viewAny(User $user): bool
    {
        // Allow all users to view orders or restrict based on permissions/roles
        return true;
//        return $user->hasAnyRole(['super-admin', 'admin']) || $user->can('view-orders');
    }

    /**
     * Determine whether the user can view a specific order.
     */
    public function show(User $user, Order $order): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create an order.
     */
    public function create(User $user): bool
    {
        // Allow users with specific roles or permissions to create orders
        return $user->hasAnyRole(['super-admin', 'vendor']) || $user->can('create-orders');
    }

    /**
     * Determine whether the user can update an order.
     */
    public function update(User $user, Order $order): bool
    {
        // Allow updating if the user owns the order or has specific roles/permissions
        return $user->id === $order->user_id
            || $user->hasAnyRole(['super-admin', 'admin'])
            || $user->can('update-orders');
    }

    /**
     * Determine whether the user can delete an order.
     */
    public function delete(User $user, Order $order): bool
    {
        // Allow deleting if the user owns the order or has specific roles/permissions
        return $user->id === $order->user_id
            || $user->hasAnyRole(['super-admin', 'admin'])
            || $user->can('delete-orders');
    }
}
