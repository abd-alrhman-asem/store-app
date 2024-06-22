<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the user can update the order.
     *
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function update(User $user, Order $order): bool
    {
        // Only allow the user who created the order to update it
        return $user->id === $order->user_id;
    }

    /**
     * Determine whether the user can delete the order.
     *
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function delete(User $user, Order $order): bool
    {
        // Only allow the user who created the order to delete it
        return $user->id === $order->user_id;
    }
}
