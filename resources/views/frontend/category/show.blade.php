<x-frontend-layout
    :title="($category->meta_title ?: $category->name) . ' | TechNova Nepal'"
    :description="$category->meta_description ?: ('Shop ' . $category->name . ' at TechNova Nepal. Genuine tech, Kathmandu.')"
    :keywords="$category->meta_keywords"
    :canonical="route('category.show', $category->slug)">

    <div class="Container mx-auto px-3 sm:px-4 lg:px-0 py-5">

        {{-- =====================================================
            BREADCRUMB
        ====================================================== --}}
        <div class="bg-white overflow-hidden">
            <div class="Container mx-auto sm:px-4 lg:px-4">

                <nav class="flex items-center gap-2 text-[12px] overflow-x-auto whitespace-nowrap">

                    <a href="{{ url('/') }}" class="text-slate-500 hover:text-blue-600 transition">
                        Home
                    </a>

                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>

                    @foreach ($ancestors ?? collect() as $ancestor)
                        <a href="{{ route('category.show', $ancestor->slug) }}"
                            class="text-slate-500 hover:text-blue-600 transition">
                            {{$ancestor->name }}
                        </a>

                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    @endforeach

                    <span class="font-semibold text-[12px] text-slate-800">
                        {{ $category->name }}
                    </span>

                </nav>

            </div>
        </div>


        {{-- =====================================================
            MAIN CONTENT
        ====================================================== --}}
        <div class="px-0 sm:px-2 lg:px-8 py-5">

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">


                {{-- =================================================
                    SIDEBAR
                ================================================== --}}
                <aside class="lg:col-span-1 w-full min-w-0">

                    <div
                        class="bg-white rounded-2xl
                                border border-slate-200
                                shadow-sm
                                overflow-hidden
                                lg:sticky lg:top-6">


                        {{-- FILTER HEADER --}}
                        <div class="px-5 py-4 border-b border-slate-200">

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-9 h-9 rounded-lg bg-blue-50
                                            flex items-center justify-center">

                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 12.414V19a1 1 0 01-.553.894l-4 2A1 1 0 019 21v-8.586L3.293 6.707A1 1 0 013 6V4z" />

                                    </svg>

                                </div>

                                <div>

                                    <h2 class="font-bold text-slate-900">
                                        Filters
                                    </h2>

                                    <p class="text-xs text-slate-500">
                                        Refine your results
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            CATEGORIES (STATIC)
                        ================================================== --}}
                        @if (isset($category->children) && $category->children->count())

                            <div class="p-5 border-b border-slate-200">

                                <h3 class="text-sm font-bold text-slate-900 mb-4">
                                    Categories
                                </h3>


                                <div class="space-y-1">

                                    {{-- ALL CATEGORIES --}}
                                    @php
                                        $allCategoryParams = request()->query();
                                        unset($allCategoryParams['page']);
                                        unset($allCategoryParams['child']);
                                        $allCategoryUrl = route('category.show', $category->slug);

                                        if (!empty($allCategoryParams)) {
                                            $allCategoryUrl .= '?' . http_build_query($allCategoryParams);
                                        }
                                    @endphp

                                    <a href="{{ $allCategoryUrl }}"
                                        class="flex items-center justify-between
                                              px-3 py-2 rounded-lg transition
                                              {{ !request('child') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">

                                        <span class="text-[13px] font-medium">
                                            All Categories
                                        </span>

                                    </a>


                                    @foreach ($category->children as $child)
                                        @php

                                            $childUrl = route('category.show', $category->slug);

                                            $childParams = request()->query();

                                            unset($childParams['page']);

                                            $childParams['child'] = $child->slug;

                                            if (!empty($childParams)) {
                                                $childUrl .= '?' . http_build_query($childParams);
                                            }

                                        @endphp


                                        <a href="{{ $childUrl }}"
                                            class="flex items-center justify-between
                                                  px-3 py-2 rounded-lg transition
                                                  {{ request('child') === $child->slug
                                                      ? 'bg-blue-50 text-blue-700'
                                                      : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">

                                            <span class="text-[13px] font-medium">
                                                {{ $child->name }}
                                            </span>

                                            @if (isset($child->products_count))
                                                <span class="text-xs text-slate-400">
                                                    {{ $child->products_count }}
                                                </span>
                                            @endif

                                        </a>
                                    @endforeach

                                </div>

                            </div>

                        @endif


                        {{-- =================================================
                            BRANDS
                        ================================================== --}}
                        <div class="p-5 border-b border-slate-200">

                            <h3 class="text-sm font-bold text-slate-900 mb-4">
                                Brands
                            </h3>


                            <div
                                class="space-y-1
                                        max-h-64
                                        overflow-y-auto
                                        pr-1
                                        -mr-1">

                                {{-- ALL BRANDS --}}
                                @php
                                    $allBrandParams = request()->query();
                                    unset($allBrandParams['page']);
                                    unset($allBrandParams['brand']);
                                    $allBrandUrl = route('category.show', $category->slug);

                                    if (!empty($allBrandParams)) {
                                        $allBrandUrl .= '?' . http_build_query($allBrandParams);
                                    }
                                @endphp

                                <a href="{{ $allBrandUrl }}"
                                    class="flex items-center justify-between
                                          px-3 py-2.5 rounded-lg transition
                                          {{ !request('brand') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">

                                    <span class="text-sm font-medium">
                                        All Brands
                                    </span>

                                </a>


                                @forelse($brands as $brand)
                                    @php

                                        $brandUrl = route('category.show', $category->slug);

                                        $brandParams = request()->query();

                                        unset($brandParams['page']);

                                        $brandParams['brand'] = $brand->slug;

                                        if (!empty($brandParams)) {
                                            $brandUrl .= '?' . http_build_query($brandParams);
                                        }

                                    @endphp


                                    <a href="{{ $brandUrl }}"
                                        class="flex items-center justify-between
                                              px-3 py-2.5 rounded-lg transition
                                              {{ request('brand') === $brand->slug
                                                  ? 'bg-blue-50 text-blue-700'
                                                  : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">

                                        <span class="text-sm font-medium">
                                            {{ $brand->name }}
                                        </span>

                                        @if (isset($brand->products_count))
                                            <span class="text-xs text-slate-400">
                                                {{ $brand->products_count }}
                                            </span>
                                        @endif

                                    </a>

                                @empty

                                    <p class="text-sm text-slate-500">
                                        No brands available.
                                    </p>
                                @endforelse

                            </div>

                        </div>


                        {{-- =================================================
                            PRICE FILTER
                        ================================================== --}}
                        <div class="p-5">

                            <h3 class="text-sm font-bold text-slate-900 mb-4">
                                Price Range
                            </h3>


                            <form method="GET" action="{{ route('category.show', $category->slug) }}"
                                class="space-y-4">


                                @if (request('brand'))
                                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                                @endif


                                @if (request('child'))
                                    <input type="hidden" name="child" value="{{ request('child') }}">
                                @endif


                                <div class="grid grid-cols-2 gap-3">

                                    <div>

                                        <label
                                            class="block text-xs font-medium
                                                      text-slate-500 mb-1.5">

                                            Min Price

                                        </label>

                                        <input type="number" name="min_price" value="{{ request('min_price') }}"
                                            placeholder="Min" min="0"
                                            class="w-full rounded-lg
                                                      border border-slate-200
                                                      bg-white
                                                      px-3 py-2.5
                                                      text-sm text-slate-800
                                                      focus:border-blue-500
                                                      focus:ring-2
                                                      focus:ring-blue-100
                                                      outline-none">

                                    </div>


                                    <div>

                                        <label
                                            class="block text-xs font-medium
                                                      text-slate-500 mb-1.5">

                                            Max Price

                                        </label>

                                        <input type="number" name="max_price" value="{{ request('max_price') }}"
                                            placeholder="Max" min="0"
                                            class="w-full rounded-lg
                                                      border border-slate-200
                                                      bg-white
                                                      px-3 py-2.5
                                                      text-sm text-slate-800
                                                      focus:border-blue-500
                                                      focus:ring-2
                                                      focus:ring-blue-100
                                                      outline-none">

                                    </div>

                                </div>


                                <button type="submit"
                                    class="w-full inline-flex items-center
                                               justify-center gap-2
                                               rounded-lg
                                               bg-blue-600
                                               hover:bg-blue-700
                                               text-white
                                               py-2.5
                                               text-sm
                                               font-semibold
                                               transition">

                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4h18M6 12h12M10 20h4" />

                                    </svg>

                                    Apply Filter

                                </button>

                            </form>


                            @if (request('min_price') || request('max_price'))
                                @php
                                    $clearPriceParams = request()->query();
                                    unset($clearPriceParams['page']);
                                    unset($clearPriceParams['min_price']);
                                    unset($clearPriceParams['max_price']);

                                    $clearPriceUrl = route('category.show', $category->slug);

                                    if (!empty($clearPriceParams)) {
                                        $clearPriceUrl .= '?' . http_build_query($clearPriceParams);
                                    }
                                @endphp

                                <a href="{{ $clearPriceUrl }}"
                                    class="block text-center mt-3
                                          text-xs font-semibold
                                          text-blue-600
                                          hover:text-blue-700">

                                    Clear Price Filter

                                </a>
                            @endif

                        </div>

                    </div>

                </aside>


                {{-- =================================================
                    PRODUCTS
                ================================================== --}}
                <main class="lg:col-span-3 min-w-0">


                    {{-- PRODUCT TOOLBAR --}}
                    <div
                        class="bg-white rounded-2xl
                                border border-slate-200
                                shadow-sm
                                px-5 py-4
                                mb-6">

                        <div
                            class="flex flex-col sm:flex-row
                                    sm:items-center
                                    sm:justify-between
                                    gap-4">


                            <div class="min-w-0">

                                <h2 class="text-lg font-bold text-slate-900">
                                    {{ $category->name }} Products
                                </h2>

                                <p class="text-sm text-slate-500 mt-1">

                                    Showing

                                    <span class="font-semibold text-slate-700">
                                        {{ $products->firstItem() ?? 0 }}
                                    </span>

                                    –

                                    <span class="font-semibold text-slate-700">
                                        {{ $products->lastItem() ?? 0 }}
                                    </span>

                                    of

                                    <span class="font-semibold text-slate-700">
                                        {{ $products->total() }}
                                    </span>

                                    products

                                </p>

                            </div>


                            {{-- ACTIVE FILTERS --}}
                            <div class="flex flex-wrap items-center gap-2 min-w-0">

                                @if (request('child'))
                                    <span
                                        class="inline-flex items-center
                                                 px-3 py-1.5
                                                 rounded-full
                                                 bg-blue-50
                                                 text-blue-700
                                                 text-xs
                                                 font-semibold">

                                        Category: {{ request('child') }}

                                    </span>
                                @endif


                                @if (request('brand'))
                                    <span
                                        class="inline-flex items-center
                                                 px-3 py-1.5
                                                 rounded-full
                                                 bg-blue-50
                                                 text-blue-700
                                                 text-xs
                                                 font-semibold">

                                        Brand: {{ request('brand') }}

                                    </span>
                                @endif


                                @if (request('min_price') || request('max_price'))
                                    <span
                                        class="inline-flex items-center
                                                 px-3 py-1.5
                                                 rounded-full
                                                 bg-blue-50
                                                 text-blue-700
                                                 text-xs
                                                 font-semibold">

                                        Price Filter

                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        PRODUCTS GRID
                    ================================================== --}}
                    @if ($products->count())

                        <div id="productGrid"
                            class="grid grid-cols-2
                                    sm:grid-cols-3
                                    lg:grid-cols-4
                                    gap-3">

                            @foreach ($products as $index => $product)
                                @php
                                    $hasDiscount =
                                        isset($product->discount_price) &&
                                        $product->discount_price &&
                                        $product->price > $product->discount_price;

                                    $discountAmount = $hasDiscount ? $product->price - $product->discount_price : 0;

                                    $discountPercent = $hasDiscount
                                        ? round(($discountAmount / $product->price) * 100)
                                        : 0;

                                    $isWishlisted = in_array($product->id, $wishlistProductIds ?? []);

                                    $rating = $product->rating ?? 0;
                                    $reviewCount = $product->reviews_count ?? 0;
                                @endphp


                                <article
                                    onclick="window.location.href='{{ route('product.show', ['slug' => $product->slug]) }}'"
                                    class="product-card group
                                           bg-white
                                           rounded-xl
                                           border border-slate-200
                                           overflow-hidden
                                           shadow-sm
                                           hover:shadow-md
                                           hover:border-blue-200
                                           transition duration-300
                                           cursor-pointer
                                           flex flex-col
                                           min-w-0"
                                    data-index="{{ $index }}">


                                    {{-- PRODUCT IMAGE --}}
                                    <div
                                        class="relative
                                                bg-slate-50
                                                h-36
                                                overflow-hidden">


                                        {{-- NEW --}}
                                        @if ($product->created_at && $product->created_at->gt(now()->subDays(14)))
                                            <span
                                                class="absolute top-1.5 left-1.5 z-10
                                                         px-1.5 py-0.5
                                                         rounded
                                                         bg-blue-600
                                                         text-white
                                                         text-[9px]
                                                         font-bold
                                                         shadow-sm">

                                                NEW

                                            </span>
                                        @endif


                                        {{-- DISCOUNT % --}}
                                        @if ($hasDiscount)
                                            <span
                                                class="absolute top-1.5 right-1.5 z-10
                                                         px-1.5 py-0.5
                                                         rounded
                                                         bg-slate-900
                                                         text-white
                                                         text-[9px]
                                                         font-bold">

                                                -{{ $discountPercent }}%

                                            </span>
                                        @endif


                                        {{-- WISHLIST --}}
                                        <button type="button"
                                            onclick="toggleWishlist(event, this, {{ $product->id }})"
                                            data-wishlisted="{{ $isWishlisted ? 'true' : 'false' }}"
                                            aria-label="{{ $isWishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}"
                                            class="wishlist-button
                                                   absolute
                                                   right-1.5
                                                   bottom-1.5
                                                   z-20
                                                   w-7
                                                   h-7
                                                   rounded-full
                                                   bg-white
                                                   border
                                                   shadow-sm
                                                   flex
                                                   items-center
                                                   justify-center
                                                   transition
                                                   duration-200
                                                   {{ $isWishlisted
                                                       ? 'text-blue-600 border-blue-300'
                                                       : 'text-slate-400 border-slate-200 hover:text-blue-600 hover:border-blue-300' }}">

                                            <svg class="wishlist-icon w-3.5 h-3.5" viewBox="0 0 24 24"
                                                fill="{{ $isWishlisted ? 'currentColor' : 'none' }}"
                                                stroke="currentColor" stroke-width="2">

                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" />

                                            </svg>

                                        </button>


                                        {{-- IMAGE --}}
                                        @php

                                            $image = null;

                                            if (
                                                isset($product->thumbnails) &&
                                                is_array($product->thumbnails) &&
                                                count($product->thumbnails)
                                            ) {
                                                $image = $product->thumbnails[0];
                                            }

                                            if (!$image && isset($product->image)) {
                                                $image = $product->image;
                                            }

                                            if (is_array($image)) {
                                                $image = $image[0] ?? null;
                                            }

                                        @endphp


                                        @if ($image)
                                            <img src="{{ asset('storage/' . ltrim($image, '/')) }}"
                                                alt="{{ $product->name }}" loading="lazy"
                                                class="w-full
                                                       h-full
                                                       object-contain
                                                       p-2
                                                       group-hover:scale-105
                                                       transition
                                                       duration-500">
                                        @else
                                            <div
                                                class="w-full h-full
                                                        flex items-center
                                                        justify-center">

                                                <svg class="w-10 h-10 text-slate-300" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">

                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />

                                                </svg>

                                            </div>
                                        @endif

                                    </div>


                                    {{-- PRODUCT INFORMATION --}}
                                    <div class="p-2.5 flex flex-col flex-1 min-w-0">


                                        {{-- BRAND --}}
                                        @if ($product->brand)
                                            <p
                                                class="text-[10px]
                                                      font-semibold
                                                      uppercase
                                                      tracking-wide
                                                      text-blue-600
                                                      mb-0.5
                                                      truncate">

                                                {{ $product->brand->name }}

                                            </p>
                                        @endif


                                        {{-- NAME --}}
                                        <h3
                                            class="font-semibold
                                                   text-slate-900
                                                   text-[12px]
                                                   leading-4
                                                   line-clamp-2
                                                   min-h-[32px]">

                                            {{ $product->name }}

                                        </h3>


                                        {{-- STARS --}}
                                        <div class="flex items-center gap-0.5 mt-1">

                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= round($rating) ? 'text-yellow-400' : 'text-slate-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">

                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />

                                                </svg>
                                            @endfor

                                            <span class="text-[9px] text-slate-500 ml-0.5">
                                                ({{ $reviewCount }})
                                            </span>

                                        </div>


                                        {{-- PRICE --}}
                                        <div
                                            class="mt-1.5
                                                    flex
                                                    items-center
                                                    gap-1
                                                    flex-wrap
                                                    min-w-0">

                                            @if ($hasDiscount)
                                                <span
                                                    class="text-[13px]
                                                             font-bold
                                                             text-blue-600">

                                                    Rs.{{ number_format($product->discount_price, 0) }}

                                                </span>


                                                <span
                                                    class="text-[10px]
                                                             text-slate-400
                                                             line-through">

                                                    Rs.{{ number_format($product->price, 0) }}

                                                </span>


                                                <span
                                                    class="text-[9px]
                                                             font-semibold
                                                             text-green-600">

                                                    Save Rs.{{ number_format($discountAmount, 0) }}

                                                </span>
                                            @else
                                                <span
                                                    class="text-[13px]
                                                             font-bold
                                                             text-slate-900">

                                                    Rs.{{ number_format($product->price, 0) }}

                                                </span>
                                            @endif

                                        </div>


                                        {{-- STOCK --}}
                                        @if (isset($product->stock))
                                            @if ($product->stock > 0)
                                                <div class="flex items-center gap-1 mt-1">

                                                    <span
                                                        class="w-1.5 h-1.5
                                                                 rounded-full
                                                                 bg-green-500">
                                                    </span>

                                                    <p
                                                        class="text-[9px]
                                                              font-medium
                                                              text-slate-500">

                                                        In Stock

                                                    </p>

                                                </div>
                                            @else
                                                <div class="flex items-center gap-1 mt-1">

                                                    <span
                                                        class="w-1.5 h-1.5
                                                                 rounded-full
                                                                 bg-red-500">
                                                    </span>

                                                    <p
                                                        class="text-[9px]
                                                              font-semibold
                                                              text-red-500">

                                                        Out of Stock

                                                    </p>

                                                </div>
                                            @endif
                                        @endif


                                        {{-- ADD TO CART --}}
                                        <div class="mt-auto pt-2">

                                            @if (isset($product->stock) && $product->stock <= 0)
                                                <button type="button" disabled onclick="event.stopPropagation();"
                                                    class="w-full
                                                    inline-flex
                                                    items-center
                                                    justify-center
                                                    rounded-md
                                                    bg-slate-100
                                                    text-slate-400
                                                    py-1.5
                                                    text-[11px]
                                                    font-semibold
                                                    cursor-not-allowed">

                                                    Out of Stock

                                                </button>
                                            @else
                                                <form method="POST"
                                                    action="{{ route('cart.add', ['product' => $product->id]) }}"
                                                    onclick="event.stopPropagation();" class="w-full">

                                                    @csrf

                                                    <input type="hidden" name="quantity" value="1">

                                                    <button type="submit" onclick="event.stopPropagation();"
                                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-lg font-semibold transition duration-200 flex items-center justify-center gap-2">

                                                        <i class="fa-solid fa-cart-shopping"></i>

                                                        Add to Cart

                                                    </button>

                                                </form>
                                            @endif

                                        </div>

                                    </div>

                                </article>
                            @endforeach

                        </div>


                        {{-- =====================================================
                            PAGINATION
                        ====================================================== --}}
                        @if ($products->hasPages())

                            @php

                                $currentPage = $products->currentPage();

                                $lastPage = $products->lastPage();

                                $window = 1;

                                $start = max(1, $currentPage - $window);

                                $end = min($lastPage, $currentPage + $window);

                            @endphp


                            <nav class="flex items-center justify-center mt-8 px-2 overflow-x-auto"
                                aria-label="Pagination">

                                <ul class="inline-flex items-center gap-1 flex-shrink-0">

                                    {{-- PREVIOUS --}}
                                    @if ($products->onFirstPage())
                                        <li>

                                            <span
                                                class="inline-flex items-center
                                                         justify-center
                                                         w-8 h-8
                                                         rounded-md
                                                         border border-slate-200
                                                         text-slate-300
                                                         text-sm
                                                         cursor-not-allowed">

                                                &lsaquo;

                                            </span>

                                        </li>
                                    @else
                                        <li>

                                            <a href="{{ $products->previousPageUrl() }}"
                                                class="inline-flex items-center
                                                      justify-center
                                                      w-8 h-8
                                                      rounded-md
                                                      border border-slate-200
                                                      bg-white
                                                      text-slate-600
                                                      hover:border-blue-300
                                                      hover:text-blue-600
                                                      text-sm
                                                      transition">

                                                &lsaquo;

                                            </a>

                                        </li>
                                    @endif


                                    {{-- FIRST + ELLIPSIS --}}
                                    @if ($start > 1)

                                        <li>

                                            <a href="{{ $products->url(1) }}"
                                                class="inline-flex items-center
                                                      justify-center
                                                      w-8 h-8
                                                      rounded-md
                                                      border border-slate-200
                                                      bg-white
                                                      text-slate-600
                                                      hover:border-blue-300
                                                      hover:text-blue-600
                                                      text-sm
                                                      transition">

                                                1

                                            </a>

                                        </li>


                                        @if ($start > 2)
                                            <li>

                                                <span
                                                    class="inline-flex items-center
                                                             justify-center
                                                             w-8 h-8
                                                             text-slate-400
                                                             text-sm">

                                                    &hellip;

                                                </span>

                                            </li>
                                        @endif

                                    @endif


                                    {{-- PAGE NUMBERS --}}
                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $currentPage)
                                            <li>

                                                <span
                                                    class="inline-flex items-center
                                                             justify-center
                                                             w-8 h-8
                                                             rounded-md
                                                             bg-blue-600
                                                             border border-blue-600
                                                             text-white
                                                             text-sm
                                                             font-semibold">

                                                    {{ $page }}

                                                </span>

                                            </li>
                                        @else
                                            <li>

                                                <a href="{{ $products->url($page) }}"
                                                    class="inline-flex items-center
                                                          justify-center
                                                          w-8 h-8
                                                          rounded-md
                                                          border border-slate-200
                                                          bg-white
                                                          text-slate-600
                                                          hover:border-blue-300
                                                          hover:text-blue-600
                                                          text-sm
                                                          font-medium
                                                          transition">

                                                    {{ $page }}

                                                </a>

                                            </li>
                                        @endif
                                    @endfor


                                    {{-- LAST + ELLIPSIS --}}
                                    @if ($end < $lastPage)

                                        @if ($end < $lastPage - 1)
                                            <li>

                                                <span
                                                    class="inline-flex items-center
                                                             justify-center
                                                             w-8 h-8
                                                             text-slate-400
                                                             text-sm">

                                                    &hellip;

                                                </span>

                                            </li>
                                        @endif


                                        <li>

                                            <a href="{{ $products->url($lastPage) }}"
                                                class="inline-flex items-center
                                                      justify-center
                                                      w-8 h-8
                                                      rounded-md
                                                      border border-slate-200
                                                      bg-white
                                                      text-slate-600
                                                      hover:border-blue-300
                                                      hover:text-blue-600
                                                      text-sm
                                                      transition">

                                                {{ $lastPage }}

                                            </a>

                                        </li>

                                    @endif


                                    {{-- NEXT --}}
                                    @if ($products->hasMorePages())
                                        <li>

                                            <a href="{{ $products->nextPageUrl() }}"
                                                class="inline-flex items-center
                                                      justify-center
                                                      w-8 h-8
                                                      rounded-md
                                                      border border-slate-200
                                                      bg-white
                                                      text-slate-600
                                                      hover:border-blue-300
                                                      hover:text-blue-600
                                                      text-sm
                                                      transition">

                                                &rsaquo;

                                            </a>

                                        </li>
                                    @else
                                        <li>

                                            <span
                                                class="inline-flex items-center
                                                         justify-center
                                                         w-8 h-8
                                                         rounded-md
                                                         border border-slate-200
                                                         text-slate-300
                                                         text-sm
                                                         cursor-not-allowed">

                                                &rsaquo;

                                            </span>

                                        </li>
                                    @endif

                                </ul>

                            </nav>

                        @endif
                    @else
                        {{-- EMPTY STATE --}}
                        <div
                            class="bg-white
                                    rounded-2xl
                                    border border-slate-200
                                    shadow-sm
                                    py-16
                                    px-6
                                    text-center">

                            <div
                                class="w-20 h-20
                                        mx-auto
                                        rounded-full
                                        bg-blue-50
                                        flex
                                        items-center
                                        justify-center">

                                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 2h12M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />

                                </svg>

                            </div>


                            <h2
                                class="mt-5
                                       text-xl
                                       font-bold
                                       text-slate-900">

                                No Products Found

                            </h2>


                            <p
                                class="mt-2
                                      text-sm
                                      text-slate-500
                                      max-w-md
                                      mx-auto">

                                We couldn't find any products matching
                                your selected filters.

                            </p>


                            <a href="{{ route('category.show', $category->slug) }}"
                                class="inline-flex
                                       items-center
                                       justify-center
                                       mt-6
                                       px-5
                                       py-2.5
                                       rounded-lg
                                       bg-blue-600
                                       hover:bg-blue-700
                                       text-white
                                       text-sm
                                       font-semibold
                                       transition">

                                Clear Filters

                            </a>

                        </div>

                    @endif

                </main>

            </div>


            {{-- =====================================================
                CATEGORY DESCRIPTION (BELOW EVERYTHING)
            ====================================================== --}}
            @if (!empty($category->description))
                <section class="mt-10">

                    <div
                        class="bg-white
                                rounded-2xl
                                border border-slate-200
                                shadow-sm
                                p-6 sm:p-8">

                        <div class="flex items-center gap-3 mb-4">

                            <div
                                class="w-9 h-9
                                        rounded-lg
                                        bg-blue-50
                                        flex
                                        items-center
                                        justify-center">

                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />

                                </svg>

                            </div>

                            <h2
                                class="text-base sm:text-lg
                                       font-bold
                                       text-slate-900">

                                About {{ $category->name }}

                            </h2>

                        </div>


                        <div
                            class="text-sm
                                    leading-7
                                    text-slate-600
                                    prose prose-sm
                                    max-w-none">

                            {!! nl2br(e($category->description)) !!}

                        </div>

                    </div>

                </section>
            @endif

        </div>
        {{-- =========================================================
LIMITED DEALS CATEGORY CTA
========================================================= --}}

        <section class="Conteiner mx-auto px-8 mt-3 mb-6">
            <div
                class="relative overflow-hidden
    rounded-3xl
    bg-gradient-to-r
    from-gray-900
    via-gray-800
    to-gray-900
    shadow-xl">

                {{-- Decorative elements --}}
                <div class="absolute -top-24 -right-20
        w-72 h-72
        rounded-full
        bg-red-600/20">
                </div>

                <div
                    class="absolute -bottom-32 -left-20
        w-80 h-80
        rounded-full
        bg-orange-500/10">
                </div>


                <div class="relative
        px-6 py-9
        md:px-10 md:py-11">

                    <div
                        class="flex flex-col
            md:flex-row
            md:items-center
            md:justify-between
            gap-7">


                        {{-- Content --}}
                        <div class="max-w-2xl">

                            <div
                                class="inline-flex items-center gap-2
                    bg-red-500/10
                    border border-red-400/20
                    text-red-400
                    px-3 py-1.5
                    rounded-full
                    text-[10px]
                    font-bold
                    uppercase
                    tracking-widest
                    mb-4">

                                <i class="fa-solid fa-bolt"></i>

                                More Flash Deals

                            </div>


                            <h2
                                class="text-2xl md:text-3xl
                    font-extrabold
                    text-white
                    leading-tight">

                                Don't Miss Our
                                <span class="text-red-400">
                                    Limited-Time Offers
                                </span>

                            </h2>


                            <p
                                class="mt-3
                    text-sm
                    text-gray-400
                    leading-relaxed
                    max-w-xl">

                                Explore more limited-time categories and discover
                                exclusive deals available for a short period.
                                New offers can disappear quickly.

                            </p>

                        </div>


                        {{-- CTA --}}
                        <div class="flex-shrink-0">

                            <a href="{{ route('limited-time') }}"
                                class="group inline-flex
                    items-center
                    justify-center
                    gap-3
                    bg-red-600
                    hover:bg-red-500
                    text-white
                    px-6 py-3.5
                    rounded-2xl
                    text-sm
                    font-bold
                    shadow-lg
                    shadow-red-900/20
                    transition-all
                    duration-300
                    hover:-translate-y-0.5">

                                <span>
                                    Explore All Deals
                                </span>

                                <span
                                    class="w-8 h-8
                        rounded-xl
                        bg-white/15
                        flex items-center
                        justify-center
                        group-hover:translate-x-1
                        transition-transform">

                                    <i class="fa-solid fa-arrow-right text-xs"></i>

                                </span>

                            </a>

                        </div>

                    </div>




                </div>

            </div>


        </section>
    </div>


    {{-- =============================================================
        JAVASCRIPT
    ============================================================== --}}

    <script>
        /*
                                    |--------------------------------------------------------------------------
                                    | WISHLIST
                                    |--------------------------------------------------------------------------
                                    */

        async function toggleWishlist(event, button, productId) {

            event.preventDefault();
            event.stopPropagation();

            const token = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute('content');

            if (!token) {

                alert('Security token not found. Please refresh the page.');

                return;
            }

            try {

                const response = await fetch(
                    "{{ route('user.wishlist.toggle') }}", {
                        method: "POST",

                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": token,
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    }
                );

                const data = await response.json();

                if (!response.ok) {

                    throw new Error(
                        data.message || "Wishlist update failed."
                    );

                }

                if (data.success) {

                    window.location.reload();

                }

            } catch (error) {

                console.error(error);

                alert(error.message);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | ADD TO CART
        |--------------------------------------------------------------------------
        */

        function addToCart(productId) {

            /*
             * Replace this with your actual cart AJAX route
             * when your cart controller is ready.
             */

            console.log(
                'Add to cart:',
                productId
            );

        }
    </script>


</x-frontend-layout>
