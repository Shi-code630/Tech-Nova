<?php

namespace App\Http\Controllers;

use App\Helpers\RewardHelper;
use App\Models\Review;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // ==================== ORDERS ====================
        $totalOrders = $user->orders()->count();

        $inProgress = $user->orders()
            ->whereIn('order_status', [
                'pending',
                'processing',
                'shipped',
            ])
            ->count();

        $orderCounts = [
            'total'      => $totalOrders,
            'pending'    => $user->orders()->where('order_status', 'pending')->count(),
            'processing' => $user->orders()->where('order_status', 'processing')->count(),
            'shipped'    => $user->orders()->where('order_status', 'shipped')->count(),
            'delivered'  => $user->orders()->where('order_status', 'delivered')->count(),
            'cancelled'  => $user->orders()->where('order_status', 'cancelled')->count(),
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

        // ==================== COINS ====================
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
public function settings()
{
    return view('user.settings');
}
    /**
     * Full HTML page for the user's coins / rewards.
     */
    public function coins(Request $request)
    {
        $user = $request->user();

        // Coin summary (RewardHelper बाट)
        $coinSummary = RewardHelper::getUserCoinsSummary($user);

        // Total orders (view मा $totalOrders प्रयोग भएको छ)
        $totalOrders = $user->orders()->count();

        // Transactions — PAGINATED (view ले ->total() र ->links() चाहन्छ)
        $transactions = \App\Models\RewardTransaction::with('order')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('user.coins.index', compact(
            'user',
            'coinSummary',
            'totalOrders',
            'transactions'
        ));
    }

    /**
     * JSON endpoint for live coin updates (AJAX).
     */
    public function liveCoins(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'coinSummary'        => RewardHelper::getUserCoinsSummary($user),
            'recentTransactions' => RewardHelper::getRecentTransactions($user, 5),
        ]);
    }

    public function reviews()
    {
        $reviews = Review::with(['product', 'user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.reviews.index', compact('reviews'));
    }
}
