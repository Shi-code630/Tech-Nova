<?php

namespace App\Http\Controllers;

use App\Helpers\RewardHelper;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();


        $totalOrders = $user->orders()->count();

        $inProgress = $user->orders()
            ->whereIn('order_status', [
                'pending',
                'processing',
                'shipped',
            ])
            ->count();


        $orderCounts = [
            'total' => $totalOrders,
            'pending' => $user->orders()->where('order_status', 'pending')->count(),
            'processing' => $user->orders()->where('order_status', 'processing')->count(),
            'shipped' => $user->orders()->where('order_status', 'shipped')->count(),
            'delivered' => $user->orders()->where('order_status', 'delivered')->count(),
            'cancelled' => $user->orders()->where('order_status', 'cancelled')->count(),
        ];

        // ==================== WISHLIST ====================
        $wishlistCount = $user->wishlists()->count();

        // ==================== TOTAL SPENT ====================
        $totalSpent = $user->orders()
            ->where('order_status', 'delivered')
            ->sum('grand_total');

        // ==================== RECENT ORDERS ====================
        $recentOrders = $user->orders()
            ->latest()
            ->take(5)
            ->get();

        // ==================== ADDRESSES ====================
        $addresses = $user->addresses()
            ->latest()
            ->take(3)
            ->get();

        // ==================== CART ====================
        $cartCount = $user->carts()->sum('quantity');
        $coinSummary = RewardHelper::getUserCoinsSummary($user);
        $recentTransactions = RewardHelper::getRecentTransactions($user, 5);

        return view('user.dashboard', compact(
            'user',
            'totalOrders',
            'inProgress',
            'orderCounts',
            'wishlistCount',
            'totalSpent',
            'recentOrders',
            'addresses',
            'cartCount',
            'coinSummary',
            'recentTransactions'
        ));
    }


    public function liveCoins(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'coinSummary' => RewardHelper::getUserCoinsSummary($user),
            'recentTransactions' => RewardHelper::getRecentTransactions($user, 5),
        ]);
    }
}
