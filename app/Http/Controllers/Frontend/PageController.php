<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }

    public function limitedTimeOffer()
    {
        return view('frontend.category.todays-deals.limited-time-offer');
    }

    public function newProduct()
    {
        return view('frontend.category.todays-deals.new-product');
    }
}
