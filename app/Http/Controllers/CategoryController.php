<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    private const PER_PAGE = 20;

    /**
     * ✅ Category IDs cache
     */
    private array $categoryIdsCache = [];

    public function show($slug, Request $request)
    {
        $category = Category::with([
            'children' => fn($query) => $query->where('status', true)->orderBy('name'),
            'parent',
        ])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        if ($category->slug === 'limited-time-offer') {
            return redirect()->route('limited-time');
        }

        $categoryIds = $this->getAllCategoryIds($category);
        $childCategories = $category->children;

        // ✅ Limited Time IDs - एकै पटक load
        $limitedTimeCategory = Category::where('slug', 'limited-time-offer')
            ->where('status', true)
            ->first();

        $limitedTimeIds = $limitedTimeCategory
            ? $this->getAllCategoryIds($limitedTimeCategory)
            : [];

        // ✅ Today's Deals - Limited Time हटाउनुहोस्
        if (in_array($category->slug, ['todays-deals', 'today-deals'])) {
            $categoryIds = array_values(array_diff($categoryIds, $limitedTimeIds));
        }

        // Breadcrumb
        $breadcrumbs = [];
        $current = $category;

        while ($current) {
            array_unshift($breadcrumbs, $current);
            $current = $current->parent_id ? Category::find($current->parent_id) : null;
        }

        // Product Query
        $query = Product::whereIn('category_id', $categoryIds)
            ->where('status', 'active')
            ->with(['brand', 'category'])
            ->withReviewStats();

        // Filters
        if ($request->filled('child')) {
            $childCategory = Category::where('slug', $request->child)
                ->where('status', true)
                ->first();

            if ($childCategory) {
                $query->whereIn('category_id', $this->getAllCategoryIds($childCategory));
            }
        }

        if ($request->filled('brand')) {
            $query->whereIn('brand_id', (array) $request->brand);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->latest()->paginate(self::PER_PAGE)->withQueryString();

        // Brands
        $brands = Brand::where('status', true)
            ->whereHas('products', function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds)->where('status', 'active');
            })
            ->withCount([
                'products' => function ($q) use ($categoryIds) {
                    $q->whereIn('category_id', $categoryIds)->where('status', 'active');
                },
            ])
            ->orderBy('name')
            ->get();

        // ✅ Wishlist - Type hint सहित
        $wishlistProductIds = $this->getWishlistProductIds();

        // Today's Deals Page
        if (in_array($category->slug, ['todays-deals', 'today-deals'])) {
            foreach ($childCategories as $child) {
                $childIds = array_values(array_diff(
                    $this->getAllCategoryIds($child),
                    $limitedTimeIds
                ));

                $child->today_deals_products = Product::whereIn('category_id', $childIds)
                    ->where('status', 'active')
                    ->with(['brand', 'category'])
                    ->withReviewStats()
                    ->latest()
                    ->take(5)
                    ->get();
            }

            return view('frontend.today-deals.show', compact(
                'category',
                'products',
                'brands',
                'breadcrumbs',
                'wishlistProductIds',
                'childCategories'
            ));
        }

        // Normal Category View
        return view('frontend.category.show', compact(
            'category',
            'products',
            'brands',
            'breadcrumbs',
            'wishlistProductIds',
            'childCategories'
        ));
    }

    public function todayDeals(Request $request)
    {
        $category = Category::with([
            'children' => fn($query) => $query->where('status', true)->orderBy('name'),
        ])
            ->whereIn('slug', ['todays-deals', 'today-deals'])
            ->where('status', true)
            ->firstOrFail();

        // ✅ Limited Time IDs - एकै पटक
        $limitedTimeCategory = Category::where('slug', 'limited-time-offer')
            ->where('status', true)
            ->first();

        $limitedTimeIds = $limitedTimeCategory
            ? $this->getAllCategoryIds($limitedTimeCategory)
            : [];

        $childCategories = $category->children;

        foreach ($childCategories as $child) {
            $childIds = array_values(array_diff(
                $this->getAllCategoryIds($child),
                $limitedTimeIds
            ));

            $child->today_deals_products = Product::whereIn('category_id', $childIds)
                ->where('status', 'active')
                ->with(['brand', 'category'])
                ->withReviewStats()
                ->latest()
                ->take(5)
                ->get();
        }

        // ✅ Wishlist - Type hint सहित
        $wishlistProductIds = $this->getWishlistProductIds();

        $breadcrumbs = [$category];

        return view('frontend.today-deals.show', compact(
            'category',
            'childCategories',
            'breadcrumbs',
            'wishlistProductIds'
        ));
    }

    public function festive($slug, Request $request)
    {
        $category = Category::with([
            'children' => fn($query) => $query->where('status', true)->orderBy('name'),
            'parent',
        ])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $categoryIds = $this->getAllCategoryIds($category);

        $query = Product::whereIn('category_id', $categoryIds)
            ->where('status', 'active')
            ->with(['brand', 'category'])
            ->withReviewStats();

        if ($request->filled('child')) {
            $childCategory = Category::where('slug', $request->child)
                ->where('status', true)
                ->first();

            if ($childCategory) {
                $query->whereIn('category_id', $this->getAllCategoryIds($childCategory));
            }
        }

        if ($request->filled('brand')) {
            $query->whereIn('brand_id', (array) $request->brand);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->latest()->paginate(self::PER_PAGE)->withQueryString();

        $brands = Brand::where('status', true)
            ->whereHas('products', function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds)->where('status', 'active');
            })
            ->withCount([
                'products' => function ($q) use ($categoryIds) {
                    $q->whereIn('category_id', $categoryIds)->where('status', 'active');
                },
            ])
            ->orderBy('name')
            ->get();

        $breadcrumbs = [];
        $current = $category;

        while ($current) {
            array_unshift($breadcrumbs, $current);
            $current = $current->parent_id ? Category::find($current->parent_id) : null;
        }

        // ✅ Wishlist - Type hint सहित
        $wishlistProductIds = $this->getWishlistProductIds();

        return view('frontend.today-deals.festive', compact(
            'category',
            'products',
            'brands',
            'breadcrumbs',
            'wishlistProductIds'
        ));
    }

    public function limitedTime(Request $request)
    {
        $category = Category::with([
            'children' => fn($query) => $query->where('status', true)->orderBy('name'),
        ])
            ->where('slug', 'limited-time-offer')
            ->where('status', true)
            ->firstOrFail();

        $categoryIds = $this->getAllCategoryIds($category);

        $todayStart = now()->startOfDay();
        $tomorrowStart = now()->copy()->addDay()->startOfDay();

        $query = Product::whereIn('category_id', $categoryIds)
            ->where('status', 'active')
            ->where('limited_time_activated_at', '>=', $todayStart)
            ->where('limited_time_activated_at', '<', $tomorrowStart)
            ->with(['brand', 'category'])
            ->withReviewStats();

        if ($request->filled('child')) {
            $childCategory = Category::where('slug', $request->child)
                ->where('status', true)
                ->first();

            if ($childCategory) {
                $query->whereIn('category_id', $this->getAllCategoryIds($childCategory));
            }
        }

        if ($request->filled('brand')) {
            $query->whereIn('brand_id', (array) $request->brand);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->latest()->paginate(self::PER_PAGE)->withQueryString();

        $brands = Brand::where('status', true)
            ->whereHas('products', function ($q) use ($categoryIds, $todayStart, $tomorrowStart) {
                $q->whereIn('category_id', $categoryIds)
                    ->where('status', 'active')
                    ->where('limited_time_activated_at', '>=', $todayStart)
                    ->where('limited_time_activated_at', '<', $tomorrowStart);
            })
            ->withCount([
                'products' => function ($q) use ($categoryIds, $todayStart, $tomorrowStart) {
                    $q->whereIn('category_id', $categoryIds)
                        ->where('status', 'active')
                        ->where('limited_time_activated_at', '>=', $todayStart)
                        ->where('limited_time_activated_at', '<', $tomorrowStart);
                },
            ])
            ->orderBy('name')
            ->get();

        $breadcrumbs = [];
        $current = $category;

        while ($current) {
            array_unshift($breadcrumbs, $current);
            $current = $current->parent_id ? Category::find($current->parent_id) : null;
        }

        // ✅ Wishlist - Type hint सहित
        $wishlistProductIds = $this->getWishlistProductIds();

        return view('frontend.limited-time-offer.limited-time', compact(
            'category',
            'products',
            'brands',
            'breadcrumbs',
            'wishlistProductIds'
        ));
    }

    /**
     * ✅ Recursive CTE-style: सबै category IDs एकैचोटि निकाल्नुहोस्
     */
    private function getAllCategoryIds(Category $category): array
    {
        // Cache check
        if (isset($this->categoryIdsCache[$category->id])) {
            return $this->categoryIdsCache[$category->id];
        }

        $ids = [$category->id];
        $parentIds = [$category->id];

        while (!empty($parentIds)) {
            $children = Category::whereIn('parent_id', $parentIds)
                ->where('status', true)
                ->pluck('id')
                ->toArray();

            if (empty($children)) {
                break;
            }

            $ids = array_merge($ids, $children);
            $parentIds = $children;
        }

        $this->categoryIdsCache[$category->id] = $ids;

        return $ids;
    }

    /**
     * ✅ Wishlist Product IDs - Type-safe helper
     */
    private function getWishlistProductIds(): array
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return [];
        }

        return $user->wishlists()
            ->pluck('product_id')
            ->toArray();
    }
}