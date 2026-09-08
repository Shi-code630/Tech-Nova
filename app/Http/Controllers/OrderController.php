<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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

        $order->load(['items.product', 'trackings', 'address', 'user']);

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

        $order->load(['items.product']);

       return view('User.orders.review', compact('order'));
    }

    /**
     * Submit order review
     */
    public function submitReview(Request $request, Order $order)
{
    if (!Auth::check() || $order->user_id != Auth::id()) {
        abort(403, 'Unauthorized');
    }

    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string|max:1000',
    ]);

    // Check that this product actually belongs to this order
    $productExists = $order->items()
        ->where('product_id', $validated['product_id'])
        ->exists();

    if (!$productExists) {
        abort(403, 'This product does not belong to this order.');
    }

    Review::create([
        'product_id' => $validated['product_id'],
        'user_id' => Auth::id(),
        'rating' => $validated['rating'],
        'review' => $validated['review'] ?? null,
        'status' => true,
    ]);

    return redirect()
        ->route('orders.track', $order)
        ->with('success', 'Thank you for your review!');
}
    /**
     * ✅ Cancel Order (Customer)
     */
    public function cancel(Request $request, Order $order)
    {
        // 1. Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // 2. Get authenticated user
        $user = Auth::user();

        // 3. Check if user exists
        if (!$user) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        // 4. Check if order has user_id
        if ($order->user_id === null) {
            abort(404, 'Order not found.');
        }

        // 5. Check if order belongs to this user
        if ($order->user_id !== $user->id) {
            abort(403, 'You are not authorized to cancel this order.');
        }

        // 6. Check if order can be cancelled
        if (!in_array($order->order_status, ['pending', 'processing'])) {
            return back()->with('error', 'This order cannot be cancelled.');
        }

        // 7. Update status
        $order->update([
            'order_status' => 'cancelled',
        ]);

        // 8. Add tracking record
        OrderTracking::create([
            'order_id' => $order->id,
            'status' => 'cancelled',
            'location' => $order->current_location ?? 'Order cancelled',
            'note' => 'Order cancelled by customer',
            'tracked_at' => now(),
        ]);

        return redirect()->route('orders.track', $order)
            ->with('success', 'Order cancelled successfully!');
    }
}
