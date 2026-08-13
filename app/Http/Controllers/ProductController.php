<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
   public function show(string $slug)
{
    $product = Product::where('slug', $slug)
        ->where('status', 'active')
        ->with('category')
        ->firstOrFail();

    return view('frontend.product.show', compact('product'));

// Inside ProductController@show
$relatedProducts = Product::where('category_id', $product->category_id)
                          ->where('id', '!=', $product->id)
                          ->where('status', true)
                          ->limit(8)
                          ->get();

return view('frontend.product.show', compact('product', 'relatedProducts'));
}
}
