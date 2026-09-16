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

    /**
     * Find an active product by its slug.
     */
    private function findActiveProduct(string $slug): Product
    {
        return Product::query()
            ->where('slug', $slug)
            ->where('status', 'active')
            ->with('category')
            ->firstOrFail();
    }

    /**
     * Get related products from the same category.
     */
    private function getRelatedProducts(Product $product): Collection
    {
        return Product::query()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->limit(self::RELATED_LIMIT)
            ->get();
    }

    /**
     * Track the current product in the session and return the other
     * recently viewed products (excluding the current one).
     */
    private function getRecentlyViewedProducts(Product $product): Collection
    {
        $ids = $this->pushToRecentlyViewed($product->id);

        // Remove current product from the list we display
        $ids = array_values(array_diff($ids, [$product->id]));

        if (empty($ids)) {
            return collect();
        }

        return Product::query()
            ->whereIn('id', $ids)
            ->where('status', 'active')
            ->get()
            ->sortBy(fn (Product $item) => array_search($item->id, $ids))
            ->values();
    }

    /**
     * Add a product ID to the top of the recently viewed list,
     * keeping only the latest N entries. Returns the updated list.
     */
    private function pushToRecentlyViewed(int $productId): array
    {
        $ids = session()->get(self::SESSION_KEY, []);

        // Remove duplicates and prepend the current product
        $ids = array_values(array_diff($ids, [$productId]));
        array_unshift($ids, $productId);

        // Keep only the latest N
        $ids = array_slice($ids, 0, self::RECENTLY_VIEWED_LIMIT);

        session()->put(self::SESSION_KEY, $ids);

        return $ids;
    }
}
