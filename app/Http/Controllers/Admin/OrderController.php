<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderStatusUpdated;
use App\Models\Order;
use App\Models\OrderTracking;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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


        $order->order_status = $newStatus;


        if ($newStatus === 'shipped') {
            $order->shipped_at = now();
        } elseif ($newStatus === 'delivered') {
            $order->delivered_at = now();
        }

        $order->save();


        OrderTracking::create([
            'order_id' => $order->id,
            'status' => $newStatus,
            'location' => $order->current_location ?? 'Status updated',
            'note' => 'Status updated by admin to ' . ucfirst($newStatus),
            'tracked_at' => now(),
        ]);

       
        event(new OrderStatusUpdated($order, $oldStatus, $newStatus));

        return back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Show order tracking page
     */
    public function track(Order $order)
    {
        $order->load(['items.product', 'trackings', 'address', 'user']);

        return view('orders.track', compact('order'));
    }
}
