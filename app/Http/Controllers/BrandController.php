<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;

class BrandController extends Controller
{
    /**
     * Show all active brands.
     */
    public function index()
    {
        $brands = Brand::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return view('frontend.brand.view-all-brand', [
            'brands' => $brands,
        ]);
    }

    /**
     * Show products of a specific brand.
     */
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
