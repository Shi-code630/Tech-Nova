<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Products per page.
     */
    private const PER_PAGE = 20;

    /**
     * Show category products
     */
    public function show($slug, Request $request)
    {
        // =========================================================
        // 1. Fetch Category with children and parent
        // =========================================================
        $category = Category::with([
            'children',
            'parent',
        ])
        ->where('slug', $slug)
        ->firstOrFail();


        // =========================================================
        // 2. Get all category IDs (self + descendants)
        // =========================================================
        $categoryIds = $this->getAllCategoryIds($category);


        // =========================================================
        // 3. Breadcrumb Ancestors
        // =========================================================
        $ancestors = collect();

        $parent = $category->parent;

        while ($parent) {

            $ancestors->prepend($parent);

            $parent = $parent->parent;
        }


        // =========================================================
        // 4. Base Product Query
        // =========================================================
        $productsQuery = Product::whereIn(
            'category_id',
            $categoryIds
        )
        ->where('status', true)
        ->with([
            'brand',
            'category',
        ]);


        // =========================================================
        // 5. Child Category Filter
        // =========================================================
        if ($request->filled('child')) {

            $child = Category::where(
                'slug',
                $request->child
            )
            ->whereIn(
                'id',
                $categoryIds
            )
            ->first();

            if ($child) {

                $childCategoryIds = $this->getAllCategoryIds($child);

                $productsQuery->whereIn(
                    'category_id',
                    $childCategoryIds
                );
            }
        }


        // =========================================================
        // 6. Brand Filter
        // =========================================================
        if ($brandSlug = $request->query('brand')) {

            $brand = Brand::where('slug', $brandSlug)->first();

            if ($brand) {

                $productsQuery->where('brand_id', $brand->id);
            }
        }


        // =========================================================
        // 7. Minimum Price Filter
        // =========================================================
        if ($request->filled('min_price')) {

            $productsQuery->where(
                'price',
                '>=',
                (float) $request->min_price
            );
        }


        // =========================================================
        // 8. Maximum Price Filter
        // =========================================================
        if ($request->filled('max_price')) {

            $productsQuery->where(
                'price',
                '<=',
                (float) $request->max_price
            );
        }


        // =========================================================
        // 9. Products  (PAGINATED — 20 per page)
        //
        //   latest() → newest products always land on page 1
        //   paginate(20) → 20 cards per page
        //   withQueryString() → brand / child / price filters
        //                       are preserved across pages
        // =========================================================
        $products = $productsQuery
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();


        // =========================================================
        // 10. Brands for Sidebar
        // =========================================================
        $brands = Brand::whereHas(
            'products',
            function ($query) use ($categoryIds) {

                $query
                    ->whereIn('category_id', $categoryIds)
                    ->where('status', true);
            }
        )
        ->withCount([
            'products' => function ($query) use ($categoryIds) {

                $query
                    ->whereIn('category_id', $categoryIds)
                    ->where('status', true);
            }
        ])
        ->orderBy('name')
        ->get();


        // =========================================================
        // 11. Wishlist product IDs (for the heart icon state)
        // =========================================================
$wishlistProductIds = Auth::check()
    ? Auth::user()
        ->wishlist()
        ->pluck('product_id')
        ->toArray()
    : [];
        // NOTE: adjust ->wishlist() to your actual relation name
        //       (e.g. ->wishlists(), ->wishlistItems(), etc.).


        // =========================================================
        // 12. Today's Deals Main Page
        // =========================================================
        if (
            $category->slug === 'todays-deals' ||
            $category->slug === 'today-deals'
        ) {

            return view(
                'frontend.today-deals.show',
                compact(
                    'category',
                    'products',
                    'brands',
                    'ancestors',
                    'wishlistProductIds'
                )
            );
        }


        // =========================================================
        // 13. Limited Time Offer (top-level)
        // =========================================================
        if ($category->slug === 'limited-time-offer') {

            return view(
                'frontend.today-deals.limited-time',
                compact(
                    'category',
                    'products',
                    'brands',
                    'ancestors',
                    'wishlistProductIds'
                )
            );
        }


        // =========================================================
        // 14. Today's Deals Child Categories
        // =========================================================
        if ($category->parent_id) {

            $parent = Category::find($category->parent_id);

            if (
                $parent &&
                (
                    $parent->slug === 'todays-deals' ||
                    $parent->slug === 'today-deals'
                )
            ) {

                // Limited Time Offer
                if ($category->slug === 'limited-time-offer') {

                    return view(
                        'frontend.today-deals.limited-time',
                        compact(
                            'category',
                            'products',
                            'brands',
                            'ancestors',
                            'wishlistProductIds'
                        )
                    );
                }

                // Other Today's Deals children
                return view(
                    'frontend.today-deals.festive',
                    compact(
                        'category',
                        'products',
                        'brands',
                        'ancestors',
                        'wishlistProductIds'
                    )
                );
            }
        }


        // =========================================================
        // 15. Normal Category Page
        // =========================================================
        return view(
            'frontend.category.show',
            compact(
                'category',
                'products',
                'brands',
                'ancestors',
                'wishlistProductIds'
            )
        );
    }


    /**
     * Today's Deals
     */
    public function todayDeals(Request $request)
    {
        // =========================================================
        // 1. Today's Deals Parent Category
        // =========================================================
        $category = Category::with([
            'children',
            'parent',
        ])
        ->whereIn('slug', [
            'todays-deals',
            'today-deals',
        ])
        ->where('status', true)
        ->firstOrFail();


        // =========================================================
        // 2. Category IDs
        // =========================================================
        $categoryIds = $this->getAllCategoryIds($category);


        // =========================================================
        // 3. Breadcrumb Ancestors
        // =========================================================
        $ancestors = collect();

        $parent = $category->parent;

        while ($parent) {

            $ancestors->prepend($parent);

            $parent = $parent->parent;
        }


        // =========================================================
        // 4. Products Query
        // =========================================================
        $productsQuery = Product::whereIn(
            'category_id',
            $categoryIds
        )
        ->where('status', true)
        ->with([
            'brand',
            'category',
        ]);


        // =========================================================
        // 5. Brand Filter
        // =========================================================
        if ($brandSlug = $request->query('brand')) {

            $brand = Brand::where('slug', $brandSlug)->first();

            if ($brand) {

                $productsQuery->where('brand_id', $brand->id);
            }
        }


        // =========================================================
        // 6. Minimum Price
        // =========================================================
        if ($request->filled('min_price')) {

            $productsQuery->where(
                'price',
                '>=',
                (float) $request->min_price
            );
        }


        // =========================================================
        // 7. Maximum Price
        // =========================================================
        if ($request->filled('max_price')) {

            $productsQuery->where(
                'price',
                '<=',
                (float) $request->max_price
            );
        }


        // =========================================================
        // 8. Products  (PAGINATED)
        // =========================================================
        $products = $productsQuery
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();


        // =========================================================
        // 9. Brands
        // =========================================================
        $brands = Brand::whereHas(
            'products',
            function ($query) use ($categoryIds) {

                $query
                    ->whereIn('category_id', $categoryIds)
                    ->where('status', true);
            }
        )
        ->withCount([
            'products' => function ($query) use ($categoryIds) {

                $query
                    ->whereIn('category_id', $categoryIds)
                    ->where('status', true);
            }
        ])
        ->orderBy('name')
        ->get();


        // =========================================================
        // 10. Wishlist product IDs
        // =========================================================

$wishlistProductIds = Auth::check()
    ? Auth::user()
        ->wishlist()
        ->pluck('product_id')
        ->toArray()
    : [];

        // =========================================================
        // 11. Return Today's Deals
        // =========================================================
        return view(
            'frontend.today-deals.show',
            compact(
                'category',
                'products',
                'brands',
                'ancestors',
                'wishlistProductIds'
            )
        );
    }


    /**
     * Recursively get all category IDs
     * (self + children + grandchildren...)
     */
    private function getAllCategoryIds($category)
    {
        $ids = collect([$category->id]);

        foreach ($category->children as $child) {

            $ids = $ids->merge(
                $this->getAllCategoryIds($child)
            );
        }

        return $ids
            ->unique()
            ->values()
            ->toArray();
    }
}
