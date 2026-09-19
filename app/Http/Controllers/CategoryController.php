<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    private const PER_PAGE = 20;

    /*
    |--------------------------------------------------------------------------
    | Normal Category
    |--------------------------------------------------------------------------
    */
    public function show($slug, Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Load Category
        |--------------------------------------------------------------------------
        */
        $category = Category::with([
            'children' => function ($query) {
                $query->where('status', true)
                    ->orderBy('name');
            },
            'parent',
        ])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Limited Time category ko separate page par bhejo
        |--------------------------------------------------------------------------
        */
        if ($category->slug === 'limited-time-offer') {
            return redirect()->route('limited-time');
        }

        /*
        |--------------------------------------------------------------------------
        | Get all category IDs
        |--------------------------------------------------------------------------
        */
        $categoryIds = $this->getAllCategoryIds($category);

        /*
        |--------------------------------------------------------------------------
        | Today Deals Parent
        |--------------------------------------------------------------------------
        */
        $todayDealsParent = Category::whereIn('slug', [
            'todays-deals',
            'today-deals',
        ])
            ->where('status', true)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Normal Today Deals se Limited Time products remove
        |--------------------------------------------------------------------------
        */
        if (
            $todayDealsParent &&
            in_array($category->slug, [
                'todays-deals',
                'today-deals',
            ])
        ) {
            $limitedTimeCategory = Category::where(
                'slug',
                'limited-time-offer'
            )
                ->where('status', true)
                ->first();

            if ($limitedTimeCategory) {
                $limitedTimeIds = $this->getAllCategoryIds(
                    $limitedTimeCategory
                );

                $categoryIds = array_values(
                    array_diff($categoryIds, $limitedTimeIds)
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Breadcrumb
        |--------------------------------------------------------------------------
        */
        $breadcrumbs = [];

        $current = $category;

        while ($current) {
            array_unshift($breadcrumbs, $current);

            if ($current->parent_id) {
                $current = Category::find($current->parent_id);
            } else {
                $current = null;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Product Query
        |--------------------------------------------------------------------------
        */
        $query = Product::whereIn('category_id', $categoryIds)
            ->where('status', 'active')
            ->with([
                'brand',
                'category',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Child Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('child')) {
            $childCategory = Category::where('slug', $request->child)
                ->where('status', true)
                ->first();

            if ($childCategory) {
                $childIds = $this->getAllCategoryIds($childCategory);

                $query->whereIn('category_id', $childIds);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Brand Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('brand')) {
            $query->whereIn(
                'brand_id',
                (array) $request->brand
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Minimum Price
        |--------------------------------------------------------------------------
        */
        if ($request->filled('min_price')) {
            $query->where(
                'price',
                '>=',
                $request->min_price
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Maximum Price
        |--------------------------------------------------------------------------
        */
        if ($request->filled('max_price')) {
            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */
        $products = $query
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Brands
        |--------------------------------------------------------------------------
        */
        $brands = Brand::where('status', true)
            ->whereHas('products', function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds)
                    ->where('status', 'active');
            })
            ->withCount([
                'products' => function ($q) use ($categoryIds) {
                    $q->whereIn('category_id', $categoryIds)
                        ->where('status', 'active');
                },
            ])
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Wishlist
        |--------------------------------------------------------------------------
        */
        $wishlistProductIds = [];

        if (Auth::check()) {
            $wishlistProductIds = Auth::user()
                ->wishlists()
                ->pluck('product_id')
                ->toArray();
        }

        /*
        |--------------------------------------------------------------------------
        | Today Deals View
        |--------------------------------------------------------------------------
        */
        if (
            in_array($category->slug, [
                'todays-deals',
                'today-deals',
            ])
        ) {
            return view(
                'frontend.today-deals.show',
                compact(
                    'category',
                    'products',
                    'brands',
                    'breadcrumbs',
                    'wishlistProductIds'
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Festive Deals
        |--------------------------------------------------------------------------
        */
        if (
            $todayDealsParent &&
            $category->parent_id === $todayDealsParent->id
        ) {
            return view(
                'frontend.today-deals.festive',
                compact(
                    'category',
                    'products',
                    'brands',
                    'breadcrumbs',
                    'wishlistProductIds'
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Normal Category
        |--------------------------------------------------------------------------
        */
        return view(
            'frontend.category.show',
            compact(
                'category',
                'products',
                'brands',
                'breadcrumbs',
                'wishlistProductIds'
            )
        );
    }


    /*
|--------------------------------------------------------------------------
| Today Deals
|--------------------------------------------------------------------------
*/
public function todayDeals(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | Find Today Deals Parent
    |--------------------------------------------------------------------------
    */
    $category = Category::with([
        'children' => function ($query) {
            $query->where('status', true)
                ->orderBy('name');
        },
    ])
        ->whereIn('slug', [
            'todays-deals',
            'today-deals',
        ])
        ->where('status', true)
        ->firstOrFail();

    /*
    |--------------------------------------------------------------------------
    | Limited Time Category
    |--------------------------------------------------------------------------
    | Limited Time Offer ko Today's Deals se exclude karna hai.
    |--------------------------------------------------------------------------
    */
    $limitedTimeCategory = Category::where(
        'slug',
        'limited-time-offer'
    )
        ->where('status', true)
        ->first();

    $limitedTimeIds = [];

    if ($limitedTimeCategory) {
        $limitedTimeIds = $this->getAllCategoryIds(
            $limitedTimeCategory
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Child Categories + Products
    |--------------------------------------------------------------------------
    */
    $childCategories = $category->children;

    foreach ($childCategories as $child) {

        /*
        |----------------------------------------------------------------------
        | Get child + descendants IDs
        |----------------------------------------------------------------------
        */
        $childIds = $this->getAllCategoryIds($child);

        /*
        |----------------------------------------------------------------------
        | Remove Limited Time products
        |----------------------------------------------------------------------
        */
        $childIds = array_values(
            array_diff($childIds, $limitedTimeIds)
        );

        /*
        |----------------------------------------------------------------------
        | Products
        |----------------------------------------------------------------------
        */
        $child->today_deals_products = Product::whereIn(
            'category_id',
            $childIds
        )
            ->where('status', 'active')
            ->with([
                'brand',
                'category',
            ])
            ->latest()
            ->take(5)
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Wishlist
    |--------------------------------------------------------------------------
    */
    $wishlistProductIds = [];

    if (Auth::check()) {
        $wishlistProductIds = Auth::user()
            ->wishlists()
            ->pluck('product_id')
            ->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | Breadcrumb
    |--------------------------------------------------------------------------
    */
    $breadcrumbs = [$category];

    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */
    return view(
        'frontend.today-deals.show',
        compact(
            'category',
            'childCategories',
            'breadcrumbs',
            'wishlistProductIds'
        )
    );
}


    /*
    |--------------------------------------------------------------------------
    | Limited Time Offer
    |--------------------------------------------------------------------------
    */
    public function limitedTime(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Limited Time Category
        |--------------------------------------------------------------------------
        */
        $category = Category::with([
            'children' => function ($query) {
                $query->where('status', true)
                    ->orderBy('name');
            },
        ])
            ->where('slug', 'limited-time-offer')
            ->where('status', true)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Category IDs
        |--------------------------------------------------------------------------
        */
        $categoryIds = $this->getAllCategoryIds($category);

        /*
        |--------------------------------------------------------------------------
        | TODAY START / TOMORROW START
        |--------------------------------------------------------------------------
        */
        $todayStart = now()->startOfDay();

        $tomorrowStart = now()
            ->copy()
            ->addDay()
            ->startOfDay();

        /*
        |--------------------------------------------------------------------------
        | Limited Time Products
        |--------------------------------------------------------------------------
        |
        | Active hona zaroori hai.
        |
        | Aur last activation aaj ka hona zaroori hai.
        |
        */
        $query = Product::whereIn('category_id', $categoryIds)
            ->where('status', 'active')
            ->where(
                'limited_time_activated_at',
                '>=',
                $todayStart
            )
            ->where(
                'limited_time_activated_at',
                '<',
                $tomorrowStart
            )
            ->with([
                'brand',
                'category',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Child Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('child')) {
            $childCategory = Category::where('slug', $request->child)
                ->where('status', true)
                ->first();

            if ($childCategory) {
                $childIds = $this->getAllCategoryIds(
                    $childCategory
                );

                $query->whereIn('category_id', $childIds);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Brand Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('brand')) {
            $query->whereIn(
                'brand_id',
                (array) $request->brand
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Price Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('min_price')) {
            $query->where(
                'price',
                '>=',
                $request->min_price
            );
        }

        if ($request->filled('max_price')) {
            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */
        $products = $query
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Brands
        |--------------------------------------------------------------------------
        */
        $brands = Brand::where('status', true)
            ->whereHas('products', function ($q) use (
                $categoryIds,
                $todayStart,
                $tomorrowStart
            ) {
                $q->whereIn('category_id', $categoryIds)
                    ->where('status', 'active')
                    ->where(
                        'limited_time_activated_at',
                        '>=',
                        $todayStart
                    )
                    ->where(
                        'limited_time_activated_at',
                        '<',
                        $tomorrowStart
                    );
            })
            ->withCount([
                'products' => function ($q) use (
                    $categoryIds,
                    $todayStart,
                    $tomorrowStart
                ) {
                    $q->whereIn('category_id', $categoryIds)
                        ->where('status', 'active')
                        ->where(
                            'limited_time_activated_at',
                            '>=',
                            $todayStart
                        )
                        ->where(
                            'limited_time_activated_at',
                            '<',
                            $tomorrowStart
                        );
                },
            ])
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Breadcrumb
        |--------------------------------------------------------------------------
        */
        $breadcrumbs = [];

        $current = $category;

        while ($current) {
            array_unshift($breadcrumbs, $current);

            if ($current->parent_id) {
                $current = Category::find(
                    $current->parent_id
                );
            } else {
                $current = null;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Wishlist
        |--------------------------------------------------------------------------
        */
        $wishlistProductIds = [];

        if (Auth::check()) {
            $wishlistProductIds = Auth::user()
                ->wishlists()
                ->pluck('product_id')
                ->toArray();
        }

        /*
        |--------------------------------------------------------------------------
        | Limited Time View
        |--------------------------------------------------------------------------
        */
        return view(
            'frontend.limited-time-offer.limited-time',
            compact(
                'category',
                'products',
                'brands',
                'breadcrumbs',
                'wishlistProductIds'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Get All Category IDs
    |--------------------------------------------------------------------------
    */
    private function getAllCategoryIds(
        Category $category
    ): array {
        $ids = [$category->id];

        $children = Category::where(
            'parent_id',
            $category->id
        )
            ->where('status', true)
            ->get();

        foreach ($children as $child) {
            $ids = array_merge(
                $ids,
                $this->getAllCategoryIds($child)
            );
        }

        return $ids;
    }
}
