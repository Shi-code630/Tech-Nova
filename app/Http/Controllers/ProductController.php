<?php

namespace App\Http\Controllers;

use App\Helpers\RewardHelper;
use App\Models\Product;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with([
                'category',
                'brand',
                'variants' => fn ($q) => $q->where('status', true)->orderBy('id'),
                'reviews' => fn ($q) => $q->where('status', true)->with('user')->latest(),
            ])
            ->withCount([
                'reviews as reviews_count' => fn ($q) => $q->where('status', true),
            ])
            ->withAvg([
                'reviews as average_rating' => fn ($q) => $q->where('status', true),
            ], 'rating')
            ->firstOrFail();

        $soldCount = (int) $product->orderItems()->sum('quantity');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->latest()
            ->limit(8)
            ->get();

        $coinsEarnable = RewardHelper::calculateEarnedCoins(
            ($product->discount_price && $product->discount_price < $product->price)
                ? $product->discount_price
                : $product->price
        );

        $ratingBreakdown = collect([5, 4, 3, 2, 1])->mapWithKeys(
            fn ($star) => [$star => $product->reviews->where('rating', $star)->count()]
        );

        $isWishlisted = auth()->check()
            ? auth()->user()->wishlists()->where('product_id', $product->id)->exists()
            : false;

        return view('frontend.product.show', compact(
            'product',
            'relatedProducts',
            'soldCount',
            'coinsEarnable',
            'ratingBreakdown',
            'isWishlisted'
        ));
    }
}