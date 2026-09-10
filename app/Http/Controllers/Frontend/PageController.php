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

    public function careers()
    {
        $jobs = [
            [
                'id' => 1,
                'title' => 'Senior Laravel Developer',
                'department' => 'Engineering',
                'location' => 'Kathmandu, Nepal',
                'type' => 'Full-time',
                'experience' => '3+ years',
                'salary' => 'Negotiable',
                'posted' => '2 days ago',
            ],
            [
                'id' => 2,
                'title' => 'Frontend Developer (React)',
                'department' => 'Engineering',
                'location' => 'Kathmandu, Nepal',
                'type' => 'Full-time',
                'experience' => '2+ years',
                'salary' => 'Negotiable',
                'posted' => '5 days ago',
            ],
            [
                'id' => 3,
                'title' => 'Digital Marketing Specialist',
                'department' => 'Marketing',
                'location' => 'Kathmandu, Nepal',
                'type' => 'Full-time',
                'experience' => '1+ years',
                'salary' => 'Negotiable',
                'posted' => '1 week ago',
            ],
            [
                'id' => 4,
                'title' => 'UI/UX Designer',
                'department' => 'Design',
                'location' => 'Remote / Kathmandu',
                'type' => 'Full-time',
                'experience' => '2+ years',
                'salary' => 'Negotiable',
                'posted' => '3 days ago',
            ],
            [
                'id' => 5,
                'title' => 'Customer Support Executive',
                'department' => 'Support',
                'location' => 'Kathmandu, Nepal',
                'type' => 'Full-time',
                'experience' => '0-1 years',
                'salary' => 'Negotiable',
                'posted' => '1 day ago',
            ],
            [
                'id' => 6,
                'title' => 'Product Manager',
                'department' => 'Product',
                'location' => 'Kathmandu, Nepal',
                'type' => 'Full-time',
                'experience' => '4+ years',
                'salary' => 'Negotiable',
                'posted' => '3 days ago',
            ],
        ];

        return view('frontend.careers', compact('jobs'));
    }
}
