<?php

namespace App\Policies;

use App\Models\Order;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OrderPolicy
{
    /**
     * Generic view - works for both User and Admin
     */
    public function view(Authenticatable $user, Order $order): bool
    {
        // ✅ Admin check
        if ($user instanceof \App\Models\Admin) {
            return true;
        }

        // ✅ User check
        if ($user instanceof \App\Models\User) {
            return $user->id === $order->user_id;
        }

        return false;
    }

    public function update(Authenticatable $user, Order $order): bool
    {
        if ($user instanceof \App\Models\Admin) {
            return true;
        }

        return false;
    }

    public function delete(Authenticatable $user, Order $order): bool
    {
        if ($user instanceof \App\Models\Admin) {
            return true;
        }

        return false;
    }

    public function cancel(Authenticatable $user, Order $order): bool
    {
        if ($user instanceof \App\Models\User) {
            return $user->id === $order->user_id &&
                   in_array($order->order_status, ['pending', 'processing']);
        }

        return false;
    }
}
