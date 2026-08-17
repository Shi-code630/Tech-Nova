<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    /**
     * Display all orders for the logged-in customer.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = Order::query()
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('user.orders.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Display a single order for the logged-in customer.
     */
    public function show(Request $request, $order)
    {
        $user = $request->user();

        $order = Order::query()
            ->where('id', $order)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $items = $order->items()
            ->with(['product', 'variant'])
            ->get();

        $address = null;

        if ($order->address_id) {
            $address = $user->addresses()
                ->where('id', $order->address_id)
                ->first();
        }

        return view('user.orders.view', [
            'order' => $order,
            'items' => $items,
            'address' => $address,
        ]);
    }
}
