<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Job;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Home Page
     */
    public function home()
    {
        $banners = Banner::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $brands = Brand::where('status', true)
            ->orderBy('name')
            ->get();

        $blogs = Blog::with('category')
            ->latest('created_at')
            ->take(4)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TODAY'S DEALS CATEGORY IDS
        |--------------------------------------------------------------------------
        | Today Deals ke parent aur uske saare child/sub-child
        | categories ke products Home Page se hide honge.
        */

        $todayDealsCategoryIds = [];

        $todayDeals = Category::where('slug', 'todays-deals')
            ->where('status', true)
            ->first();

        if ($todayDeals) {
            $todayDealsCategoryIds = $this->getAllCategoryIds($todayDeals);
        }


        /*
        |--------------------------------------------------------------------------
        | PARENT CATEGORIES
        |--------------------------------------------------------------------------
        */

        $parentCategories = Category::query()
            ->whereNull('parent_id')
            ->where('status', true)
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | LATEST 5 PRODUCTS FOR EVERY PARENT CATEGORY
        |--------------------------------------------------------------------------
        */

        foreach ($parentCategories as $category) {

            $category->homeProducts = Product::query()
                ->where('status', true)

                // TODAY'S DEALS PRODUCTS EXCLUDE
                ->when(!empty($todayDealsCategoryIds), function ($query) use ($todayDealsCategoryIds) {

                    $query->whereNotIn(
                        'category_id',
                        $todayDealsCategoryIds
                    );
                })

                /*
                |--------------------------------------------------------------------------
                | CATEGORY PRODUCTS
                |--------------------------------------------------------------------------
                | Parent category ke direct products
                | + uske direct child category ke products
                */

                ->whereHas('category', function ($query) use ($category) {

                    $query->where('id', $category->id)
                        ->orWhere('parent_id', $category->id);
                })

                ->with([
                    'category',
                    'brand',
                ])

                ->withCount('reviews')

                ->orderByDesc('created_at')
                ->orderByDesc('id')

                ->limit(5)

                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | WISHLIST PRODUCTS
        |--------------------------------------------------------------------------
        */

        $wishlistProductIds = [];

        if (Auth::check()) {

            $wishlistProductIds = Auth::user()
                ->wishlists()
                ->pluck('product_id')
                ->toArray();
        }


        return view(
            'frontend.home',
            compact(
                'banners',
                'brands',
                'blogs',
                'parentCategories',
                'wishlistProductIds'
            )
        );
    }


    /**
     * Get Category + All Child/Sub-child Category IDs
     */
    private function getAllCategoryIds(Category $category): array
    {
        $ids = [$category->id];

        $children = Category::query()
            ->where('parent_id', $category->id)
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


    /**
     * Privacy Policy
     */
    public function privacypolicy()
    {
        return view('frontend.privacy-policy');
    }


    /**
     * Refund Policy
     */
    public function refundpolicy()
    {
        return view('frontend.refund-policy');
    }


    /**
     * Terms of Service
     */
    public function termsofservice()
    {
        return view('frontend.terms-of-service');
    }


    /**
     * Contact Us
     */
    public function contactus()
    {
        return view('frontend.contact-us');
    }


    /**
     * Warranty Policy
     */
    public function warrantypolicy()
    {
        return view('frontend.warranty-policy');
    }


    /**
     * Search Products
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        $products = Product::query()
            ->where('status', true)

            ->when($query, function ($q) use ($query) {

                $q->where(function ($search) use ($query) {

                    $search->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                });
            })

            ->with([
                'category',
                'brand',
                'images',
            ])

            ->withCount('reviews')

            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        return view(
            'frontend.search',
            compact(
                'products',
                'query'
            )
        );
    }


    /**
     * Careers
     */
    public function careers()
    {
        $jobs = Job::published()
            ->latest()
            ->get();

        $employeeRating = config(
            'company.employee_rating',
            4.9
        );

        $employeeReviewCount = config(
            'company.employee_review_count'
        );

        return view(
            'frontend.careers',
            compact(
                'jobs',
                'employeeRating',
                'employeeReviewCount'
            )
        );
    }


    /**
     * Brand Products
     */
    public function show($slug, Request $request)
    {
        $brand = Brand::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $products = Product::query()
            ->where('brand_id', $brand->id)
            ->where('status', true)
            ->with([
                'category',
                'brand',
                'images',
            ])
            ->withCount('reviews')
            ->latest('created_at')
            ->paginate(20)
            ->withQueryString();

        return view(
            'frontend.brand.show',
            compact(
                'brand',
                'products'
            )
        );
    }
}
