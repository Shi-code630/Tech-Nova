<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderStatusUpdated;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $oldStatus = $order->order_status;
        $newStatus = $request->status;

        // Update order status
        $order->order_status = $newStatus;

        // Update timestamps for specific statuses
        if ($newStatus === 'shipped') {
            $order->shipped_at = now();
        } elseif ($newStatus === 'delivered') {
            $order->delivered_at = now();
        }

        $order->save();

        
        event(new OrderStatusUpdated($order, $oldStatus, $newStatus));

        return back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Show order tracking page
     */
    public function track(Order $order)
    {
        return view('orders.track', compact('order'));
    }
}
