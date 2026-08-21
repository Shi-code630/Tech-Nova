<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Show order tracking page
     */
    public function track(Order $order)
    {
        if (!Auth::check() || $order->user_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('orders.track', compact('order'));
    }

    /**
     * Show order review page
     */
    public function review(Order $order)
    {
        if (!Auth::check() || $order->user_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('orders.review', compact('order'));
    }
}
