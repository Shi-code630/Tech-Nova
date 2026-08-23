<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Orders
        $totalOrders = $user->orders()->count();

        $inProgress = $user->orders()
            ->whereIn('order_status', [
                'pending',
                'processing',
                'shipped',
            ])
            ->count();

        // Wishlist
        $wishlistCount = $user->wishlists()->count();

        // Total spent
        $totalSpent = $user->orders()
            ->where('order_status', 'delivered')
            ->sum('grand_total');

        // Recent orders
        $recentOrders = $user->orders()
            ->latest()
            ->take(5)
            ->get();

        // Saved addresses
        $addresses = $user->addresses()
            ->latest()
            ->take(3)
            ->get();

        // Cart
        $cartCount = $user->carts()->sum('quantity');

        return view('user.dashboard', compact(
            'user',
            'totalOrders',
            'inProgress',
            'wishlistCount',
            'totalSpent',
            'recentOrders',
            'addresses',
            'cartCount'
        ));
    }
}
