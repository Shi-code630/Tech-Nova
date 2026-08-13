<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function show($slug, Request $request)
    {
        // 1. Fetch the category
        $category = Category::where('slug', $slug)->firstOrFail();

        // 2. Get all category IDs (self + all descendants)
        $categoryIds = $this->getAllCategoryIds($category);

        // 3. Base product query (only active products)
        $productsQuery = Product::whereIn('category_id', $categoryIds)
                                ->where('status', true)
                                ->with('brand'); // eager load brand

        // 4. Apply brand filter
        if ($brandSlug = $request->query('brand')) {
            $brand = Brand::where('slug', $brandSlug)->first();
            if ($brand) {
                $productsQuery->where('brand_id', $brand->id);
            }
        }

        // 5. Apply price filter
        if ($request->has('min_price') && $request->min_price !== '') {
            $productsQuery->where('price', '>=', (float) $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price !== '') {
            $productsQuery->where('price', '<=', (float) $request->max_price);
        }

        // 6. Fetch brands for the sidebar (with product counts in this category)
        $brands = Brand::whereHas('products', function ($query) use ($categoryIds) {
                            $query->whereIn('category_id', $categoryIds)
                                  ->where('status', true);
                        })
                        ->withCount(['products' => function ($query) use ($categoryIds) {
                            $query->whereIn('category_id', $categoryIds)
                                  ->where('status', true);
                        }])
                        ->get();

        // 7. Paginate results (and append all query string parameters)
        $products = $productsQuery->paginate(12)->appends($request->query());

        // 8. Return view
        // 8. Check Today's Deals category
           // Today's Deals main page
if ($category->slug === 'todays-deals') {

    return view('frontend.today-deals.show', compact(
        'category',
        'products',
        'brands'
    ));
}


// Limited Time Offer - separate page
if ($category->slug === 'limited-time-offer') {

    return view('frontend.today-deals.limited-time', compact(
        'category',
        'products',
        'brands'
    ));
}


// Today's Deals child categories
if ($category->parent_id) {

    $parent = Category::find($category->parent_id);

    // Today's Deals ke andar ke sabhi children
    if ($parent && $parent->slug === 'todays-deals') {

        // Sirf Limited Time ka alag design
        if ($category->slug === 'limited-time-offer') {

            return view(
                'frontend.today-deals.limited-time',
                compact('category', 'products', 'brands')
            );
        }

        // Today's Deals ke baaki sabhi children
        return view(
            'frontend.today-deals.festive',
            compact('category', 'products', 'brands')
        );
    }
}


// All other categories
return view('frontend.category.show', compact(
    'category',
    'products',
    'brands'
));

            // Normal category
            return view('frontend.category.show', compact(
                'category',
                'products',
                'brands'
            ));   }

                /**
                 * Recursively get all category IDs (self + children).
                 * If you use a nested set package (e.g. kalnoy/nestedset),
                 * you can replace this with: $category->descendants()->pluck('id')->push($category->id)->toArray()
                 */
                private function getAllCategoryIds($category)
                {
                    $ids = collect([$category->id]);

                    foreach ($category->children as $child) {
                        $ids = $ids->merge($this->getAllCategoryIds($child));
                    }

                    return $ids->unique()->values()->toArray();
                }

            public function todayDeals(Request $request)
            {
                // Today's Deals parent category
                $category = Category::where('slug', 'today-deals')
                    ->where('status', true)
                    ->firstOrFail();

                // Today's Deals + all child categories
                $categoryIds = $this->getAllCategoryIds($category);

                // Products
                $productsQuery = Product::whereIn('category_id', $categoryIds)
                    ->where('status', true)
                    ->with('brand');

                // Brand filter
                if ($brandSlug = $request->query('brand')) {

                    $brand = Brand::where('slug', $brandSlug)->first();

                    if ($brand) {
                        $productsQuery->where('brand_id', $brand->id);
                    }
                }

                // Minimum price
                if ($request->has('min_price') && $request->min_price !== '') {
                    $productsQuery->where(
                        'price',
                        '>=',
                        (float) $request->min_price
                    );
                }

                // Maximum price
                if ($request->has('max_price') && $request->max_price !== '') {
                    $productsQuery->where(
                        'price',
                        '<=',
                        (float) $request->max_price
                    );
                }

                // Products pagination
                $products = $productsQuery
                    ->paginate(12)
                    ->appends($request->query());

                // Brands
                $brands = Brand::whereHas('products', function ($query) use ($categoryIds) {

                    $query->whereIn('category_id', $categoryIds)
                        ->where('status', true);

                })
                ->withCount(['products' => function ($query) use ($categoryIds) {

                    $query->whereIn('category_id', $categoryIds)
                        ->where('status', true);

                }])
                ->get();

                return view('frontend.today-deals.show', compact(
                    'category',
                    'products',
                    'brands'
                ));
            }
}
