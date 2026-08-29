<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Brand;
use Illuminate\Http\Request;


class PageController extends Controller
{
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

        return view('frontend.home', compact('banners', 'brands', 'blogs'));
    }





    public function privacypolicy()
    {
        return view('frontend.privacy-policy');
    }
    public function refundpolicy()
    {
        return view('frontend.refund-policy');
    }
    public function termsofservice()
    {
        return view('frontend.terms-of-service');
    }
    public function contactus()
    {
        return view('frontend.contact-us');
    }
    public function warrantypolicy()
    {
        return view('frontend.warranty-policy');
    }
    public function careers()
    {
        return view('frontend.careers');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $products = \App\Models\Product::query()
            ->where('status', 'active')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->with(['category', 'brand', 'images'])
            ->latest()
            ->paginate(12);

        return view('frontend.search', compact('products', 'query'));
    }
}
