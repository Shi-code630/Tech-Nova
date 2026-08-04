<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class PageController extends Controller
{
    public function home()
    {
        $banners = Banner::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('frontend.home', compact('banners'));
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
}
