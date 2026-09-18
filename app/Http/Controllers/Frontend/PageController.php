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

        // Parent Categories
        $parentCategories = Category::query()
            ->whereNull('parent_id')
            ->where('status', true)
            ->orderBy('name')
            ->get();

        // Latest 5 products for every parent category
        foreach ($parentCategories as $category) {

            $category->homeProducts = Product::query()
                ->where('status', true)
                ->whereHas('category', function ($query) use ($category) {
                    $query->where('id', $category->id)
                        ->orWhere('parent_id', $category->id);
                })
                ->with(['category', 'brand'])
                ->withCount('reviews')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->limit(5)
                ->get();
        }

        // Wishlist products
        $wishlistProductIds = [];

        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            $wishlistProductIds = $user->wishlists()
                ->pluck('product_id')
                ->toArray();
        }

        return view('frontend.home', compact(
            'banners',
            'brands',
            'blogs',
            'parentCategories',
            'wishlistProductIds'
        ));
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
            compact('products', 'query')
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
}
