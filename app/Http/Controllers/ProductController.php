<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    private const RELATED_LIMIT = 8;
    private const RECENTLY_VIEWED_LIMIT = 5;
    private const SESSION_KEY = 'recently_viewed';

    public function show(string $slug)
    {
        $product = $this->findActiveProduct($slug);

        return view('frontend.product.show', [
            'product'                => $product,
            'relatedProducts'        => $this->getRelatedProducts($product),
            'recentlyViewedProducts' => $this->getRecentlyViewedProducts($product),
        ]);
    }

    private function findActiveProduct(string $slug): Product
    {
        return Product::query()
            ->where('slug', $slug)
            ->where('status', 'active')
            ->with([
                'category',
                'brand',
                'variants',
                'reviews' => function ($q) {
                    $q->where('status', true)
                        ->with('user:id,name')
                        ->latest();
                },
            ])
            ->withReviewStats()
            ->firstOrFail();
    }

    private function getRelatedProducts(Product $product): Collection
    {
        return Product::query()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->with('brand')
            ->withReviewStats()
            ->limit(self::RELATED_LIMIT)
            ->get();
    }

    private function getRecentlyViewedProducts(Product $product): Collection
    {
        $ids = $this->pushToRecentlyViewed($product->id);
        $ids = array_values(array_diff($ids, [$product->id]));

        if (empty($ids)) {
            return collect();
        }

        return Product::query()
            ->whereIn('id', $ids)
            ->where('status', 'active')
            ->withReviewStats()
            ->get()
            ->sortBy(fn (Product $item) => array_search($item->id, $ids))
            ->values();
    }

    private function pushToRecentlyViewed(int $productId): array
    {
        $ids = session()->get(self::SESSION_KEY, []);
        $ids = array_values(array_diff($ids, [$productId]));
        array_unshift($ids, $productId);
        $ids = array_slice($ids, 0, self::RECENTLY_VIEWED_LIMIT);
        session()->put(self::SESSION_KEY, $ids);

        return $ids;
    }
}
