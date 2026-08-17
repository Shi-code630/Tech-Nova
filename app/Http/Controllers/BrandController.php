<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;

class BrandController extends Controller
{
    public function show(string $slug)
    {
        $brand = Brand::query()
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $products = Product::query()
            ->where('brand_id', $brand->id)
            ->where('status', true)
            ->latest()
            ->paginate(24)
            ->withQueryString();

        return view('brand.show', [
            'brand' => $brand,
            'products' => $products,
        ]);
    }
}
