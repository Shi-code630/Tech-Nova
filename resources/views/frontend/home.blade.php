<x-frontend-layout>
    <Section class="bg-[#f0f9ff]">
        <div class="Container mx-auto px-3 sm:px-4 md:px-6 lg:px-4">
            <div class="mt-2 sm:mt-[10px]">
                <div
                    class="relative max-w-[1500px] mx-auto h-[220px] sm:h-[280px] md:h-[320px] lg:h-[350px] overflow-hidden rounded-xl sm:rounded-2xl shadow-2xl">

                    <!-- Slides Wrapper -->
                    <div id="slider"
                        class="flex h-full transition-transform duration-500 ease-in-out will-change-transform">

                        @foreach ($banners as $banner)
                            <!-- Full Banner Clickable -->
                            <div class="relative w-full h-full flex-shrink-0">

                                <a href="{{ $banner->button_link ?? '#' }}" class="block w-full h-full">

                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->alt_text }}"
                                        class="w-full h-full object-cover">

                                </a>

                            </div>
                        @endforeach

                    </div>


                    <!-- Left Arrow -->
                    <button onclick="moveSlide(-1)"
                        class="absolute top-1/2 left-2 sm:left-4 -translate-y-1/2
                   bg-black/50 hover:bg-black/70
                   text-white p-2 sm:p-3 rounded-full z-10
                   transition text-sm sm:text-base">
                        ❮
                    </button>


                    <!-- Right Arrow -->
                    <button onclick="moveSlide(1)"
                        class="absolute top-1/2 right-2 sm:right-4 -translate-y-1/2
                   bg-black/50 hover:bg-black/70
                   text-white p-2 sm:p-3 rounded-full z-10
                   transition text-sm sm:text-base">
                        ❯
                    </button>


                    <!-- Dots -->
                    <div
                        class="absolute bottom-2 sm:bottom-4 left-1/2 -translate-x-1/2
                    flex gap-1.5 sm:gap-2 z-10">

                        @foreach ($banners as $index => $banner)
                            <span
                                class="dot w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full
                             bg-white/50 cursor-pointer"
                                data-index="{{ $index }}">
                            </span>
                        @endforeach

                    </div>

                </div>
            </div>

            <div class="py-5 bg-[#f0f9ff]">
                <div class="mb-6">


                    <div onclick="window.location.href='{{ route('limited-time') }}'"
                        class="group relative overflow-hidden cursor-pointer
           bg-gradient-to-r from-red-600 via-red-500 to-orange-500
           rounded-2xl px-4 py-3
           shadow-md hover:shadow-lg
           transition-all duration-300">

                        {{-- Decorative Circle --}}
                        <div class="absolute -right-8 -top-10 w-28 h-35
                rounded-full bg-white/10"></div>

                        <div class="absolute -left-8 -bottom-12 w-24 h-24
                rounded-full bg-black/10">
                        </div>

                        <div class="relative flex items-center justify-between gap-3">

                            {{-- Left Content --}}
                            <div class="flex items-center gap-3 min-w-0">

                                {{-- Icon --}}
                                <div
                                    class="flex-shrink-0 w-10 h-10
                       rounded-xl bg-white/20
                       backdrop-blur-sm
                       flex items-center justify-center
                       text-xl">

                                    ⚡

                                </div>

                                {{-- Text --}}
                                <div class="min-w-0">

                                    <div class="flex items-center gap-2">

                                        <span
                                            class="text-[9px] font-bold uppercase
                               tracking-widest
                               text-yellow-200">

                                            Limited Time Offer

                                        </span>

                                        <span
                                            class="px-1.5 py-0.5 rounded-full
                               bg-white text-red-600
                               text-[8px] font-black">

                                            HOT

                                        </span>

                                    </div>

                                    <h3
                                        class="text-sm sm:text-base
                           font-black text-white
                           leading-tight">

                                        Flash Deals Are Live!

                                    </h3>

                                    <p
                                        class="text-[9px] sm:text-[10px]
                           text-white/80 mt-0.5">

                                        Grab amazing deals before time runs out.

                                    </p>

                                </div>

                            </div>


                            {{-- Right Button --}}
                            <div
                                class="flex-shrink-0
                   bg-white text-red-600
                   px-3 py-2
                   rounded-lg
                   text-[9px] sm:text-[10px]
                   font-extrabold
                   flex items-center gap-1
                   group-hover:bg-yellow-300
                   transition-colors duration-300">

                                Shop Now

                                <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />

                                </svg>

                            </div>

                        </div>

                    </div>

{{-- =========================================================
    HOME PRODUCTS - 5 PRODUCTS
========================================================= --}}

<section class="py-5">

    <div class="">

        {{-- Section Header --}}
        <div class="flex items-center justify-between mb-5">

            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900">
                    Featured Products
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Explore our latest products
                </p>
            </div>

        </div>


        @if ($homeProducts->count())

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">

                @foreach ($homeProducts as $product)

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | DISCOUNT
                        |--------------------------------------------------------------------------
                        */

                        $hasDiscount =
                            isset($product->discount_price) &&
                            $product->discount_price &&
                            $product->price > $product->discount_price;

                        $discountAmount = $hasDiscount
                            ? $product->price - $product->discount_price
                            : 0;

                        $discountPercent = $hasDiscount && $product->price > 0
                            ? round(($discountAmount / $product->price) * 100)
                            : 0;


                        /*
                        |--------------------------------------------------------------------------
                        | WISHLIST
                        |--------------------------------------------------------------------------
                        */

                        $isWishlisted = in_array(
                            $product->id,
                            $wishlistProductIds ?? []
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | RATING
                        |--------------------------------------------------------------------------
                        */

                        $rating = $product->rating ?? 0;

                        $reviewCount = $product->reviews_count ?? 0;


                        /*
                        |--------------------------------------------------------------------------
                        | PRODUCT IMAGE
                        |--------------------------------------------------------------------------
                        */

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


                    {{-- =================================================
                        PRODUCT CARD
                    ================================================== --}}

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
                               min-w-0">


                        {{-- =================================================
                            IMAGE
                        ================================================== --}}

                        <div class="relative bg-slate-50 h-36 overflow-hidden">


                            {{-- NEW --}}
                            @if (
                                $product->created_at &&
                                $product->created_at->gt(now()->subDays(14))
                            )

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


                            {{-- DISCOUNT --}}
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
                            <button
                                type="button"
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


                                <svg
                                    class="wishlist-icon w-3.5 h-3.5"
                                    viewBox="0 0 24 24"
                                    fill="{{ $isWishlisted ? 'currentColor' : 'none' }}"
                                    stroke="currentColor"
                                    stroke-width="2">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" />

                                </svg>

                            </button>


                            {{-- PRODUCT IMAGE --}}
                            @if ($image)

                                <img
                                    src="{{ asset('storage/' . ltrim($image, '/')) }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                    class="w-full
                                           h-full
                                           object-contain
                                           p-2
                                           group-hover:scale-105
                                           transition
                                           duration-500">

                            @else

                                <div
                                    class="w-full h-full flex items-center justify-center">

                                    <svg
                                        class="w-10 h-10 text-slate-300"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />

                                    </svg>

                                </div>

                            @endif

                        </div>


                        {{-- =================================================
                            PRODUCT INFORMATION
                        ================================================== --}}

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


                            {{-- PRODUCT NAME --}}
                            <h3
                                class="font-semibold
                                       text-slate-900
                                       text-[12px]
                                       leading-4
                                       line-clamp-2
                                       min-h-[32px]">

                                {{ $product->name }}

                            </h3>


                            {{-- RATING --}}
                            <div class="flex items-center gap-0.5 mt-1">

                                @for ($i = 1; $i <= 5; $i++)

                                    <svg
                                        class="w-3 h-3 {{ $i <= round($rating) ? 'text-yellow-400' : 'text-slate-300' }}"
                                        fill="currentColor"
                                        viewBox="0 0 20 20">

                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />

                                    </svg>

                                @endfor

                                <span
                                    class="text-[9px] text-slate-500 ml-0.5">

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

                                        Save
                                        Rs.{{ number_format($discountAmount, 0) }}

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

                                    <div
                                        class="flex
                                               items-center
                                               gap-1
                                               mt-1">

                                        <span
                                            class="w-1.5
                                                   h-1.5
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

                                    <div
                                        class="flex
                                               items-center
                                               gap-1
                                               mt-1">

                                        <span
                                            class="w-1.5
                                                   h-1.5
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

                                    <button
                                        type="button"
                                        disabled
                                        onclick="event.stopPropagation();"
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

                                    <form
                                        method="POST"
                                        action="{{ route('cart.add', ['product' => $product->id]) }}"
                                        onclick="event.stopPropagation();"
                                        class="w-full">

                                        @csrf

                                        <input
                                            type="hidden"
                                            name="quantity"
                                            value="1">

                                        <button
                                            type="submit"
                                            onclick="event.stopPropagation();"
                                            class="w-full
                                                   bg-blue-600
                                                   hover:bg-blue-700
                                                   text-white
                                                   py-2.5
                                                   px-4
                                                   rounded-lg
                                                   font-semibold
                                                   transition
                                                   duration-200
                                                   flex
                                                   items-center
                                                   justify-center
                                                   gap-2">

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

        @else

            <div
                class="bg-white
                       rounded-xl
                       border
                       border-slate-200
                       p-8
                       text-center">

                <p class="text-slate-500">
                    No products available.
                </p>

            </div>

        @endif

    </div>

</section>
                    <div class="py-4 bg-[#f0f9ff]">
                        <div class="">

                            @foreach ($parentCategories as $category)

                                @php
                                    // Is parent category ke latest 5 products
                                    $categoryProducts = $category->homeProducts;
                                @endphp

                                @if ($categoryProducts->count())
                                    <div class="mb-10">

                                        {{-- CATEGORY HEADER --}}
                                        <div class="flex items-center justify-between mb-4">

                                            <div>
                                                <h2 class="text-xl md:text-2xl font-bold text-slate-900">
                                                    {{ $category->name }}
                                                </h2>

                                                <p class="text-sm text-slate-500 mt-1">
                                                    Latest products in {{ $category->name }}
                                                </p>
                                            </div>

                                            <a href="{{ route('category.show', ['slug' => $category->slug]) }}"
                                                class="inline-flex items-center gap-1
                          text-sm font-semibold
                          text-blue-600
                          hover:text-blue-700
                          transition">

                                                View All

                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">

                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M9 5l7 7-7 7" />

                                                </svg>

                                            </a>

                                        </div>


                                        {{-- PRODUCTS --}}
                                        <div
                                            class="grid grid-cols-2
                        sm:grid-cols-3
                        md:grid-cols-4
                        lg:grid-cols-5
                        gap-3">

                                            @foreach ($categoryProducts as $index => $product)
                                                @php
                                                    $hasDiscount =
                                                        isset($product->discount_price) &&
                                                        $product->discount_price &&
                                                        $product->price > $product->discount_price;

                                                    $discountAmount = $hasDiscount
                                                        ? $product->price - $product->discount_price
                                                        : 0;

                                                    $discountPercent = $hasDiscount
                                                        ? round(($discountAmount / $product->price) * 100)
                                                        : 0;

                                                    $isWishlisted = in_array($product->id, $wishlistProductIds ?? []);

                                                    $rating = $product->rating ?? 0;
                                                    $reviewCount = $product->reviews_count ?? 0;

                                                    // PRODUCT IMAGE
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


                                                {{-- PRODUCT CARD --}}
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
                                                            flex flex-col">

                                                    {{-- PRODUCT IMAGE --}}
                                                    <div
                                                        class="relative
                                                        bg-slate-50
                                                        h-36
                                                        overflow-hidden">

                                                        {{-- NEW BADGE --}}
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


                                                        {{-- DISCOUNT --}}
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
                                                    <div class="p-2.5 flex flex-col flex-1">

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


                                                        {{-- RATING --}}
                                                        <div class="flex items-center gap-0.5 mt-1">

                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <svg class="w-3 h-3
                                                {{ $i <= round($rating) ? 'text-yellow-400' : 'text-slate-300' }}"
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
                                                            flex-wrap">

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
                                                                <button type="button" disabled
                                                                    onclick="event.stopPropagation();"
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

                                                                    <input type="hidden" name="quantity"
                                                                        value="1">

                                                                    <button type="submit"
                                                                        onclick="event.stopPropagation();"
                                                                        class="w-full
                                                                        bg-blue-600
                                                                        hover:bg-blue-700
                                                                        text-white
                                                                        py-2.5
                                                                        px-4
                                                                        rounded-lg
                                                                        font-semibold
                                                                        transition
                                                                        duration-200
                                                                        flex
                                                                        items-center
                                                                        justify-center
                                                                        gap-2">

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

                                    </div>
                                @endif

                            @endforeach
                        </div>
                    </div>

                    {{-- =========================================================
    BRANDS HEADER
========================================================= --}}

<div class="flex items-center justify-between mb-6">

    {{-- Left Side --}}
    <div class="flex items-center gap-3">

        <div class="text-black text-lg font-semibold py-2 rounded-lg">
            Shop By Brands
        </div>

        <div class="h-px w-12 bg-gradient-to-r from-blue-600 to-transparent"></div>

    </div>


    {{-- Right Side --}}
    <a href="{{ route('brands.all') }}"
   class="flex items-center gap-2 text-gray-700 hover:text-blue-600 font-medium transition-colors group text-sm">


        View All Brand

        <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
</a>

</div>


@if ($brands->where('status', true)->count() > 0)

    @php
        $activeBrands = $brands->where('status', true)->values();
    @endphp


    <div class="relative overflow-hidden">

        {{-- =================================================
            SLIDER TRACK
        ================================================== --}}

        <div class="flex gap-6 animate-scroll hover:pause">


            {{-- =========================
                FIRST SET OF BRANDS
            ========================== --}}

            @foreach ($activeBrands as $brand)

                <a
                    href="{{ route('brand.show', $brand->slug) }}"
                    class="flex-shrink-0
                           w-[120px] h-[110px]
                           bg-white rounded-2xl
                           shadow-md hover:shadow-xl
                           border border-gray-200
                           hover:border-blue-600
                           transition-all duration-300
                           hover:-translate-y-1
                           flex flex-col items-center
                           justify-center p-4
                           cursor-pointer group">

                    <div class="w-20 h-20 flex items-center justify-center">

                        @if ($brand->logo && file_exists(public_path('storage/' . $brand->logo)))

                            <img
                                src="{{ asset('storage/' . $brand->logo) }}"
                                alt="{{ $brand->name }}"
                                class="w-[60px] h-[60px]
                                       object-contain
                                       group-hover:scale-105
                                       transition-transform duration-300"
                                loading="lazy">

                        @else

                            <div
                                class="w-20 h-20
                                       rounded-full
                                       bg-blue-100
                                       flex items-center justify-center
                                       text-blue-700
                                       text-1xl font-bold">

                                {{ strtoupper(substr($brand->name, 0, 1)) }}

                            </div>

                        @endif

                    </div>


                    <span
                        class="mt-3
                               text-sm font-medium
                               text-gray-700
                               group-hover:text-blue-600
                               transition-colors duration-300
                               text-center">

                        {{ $brand->name }}

                    </span>

                </a>

            @endforeach


            {{-- =========================
                DUPLICATE FOR LOOP
            ========================== --}}

            @foreach ($activeBrands as $brand)

                <a
                    href="{{ route('brand.show', $brand->slug) }}"
                    class="flex-shrink-0
                           w-[120px] h-[110px]
                           bg-white rounded-2xl
                           shadow-md hover:shadow-xl
                           border border-gray-200
                           hover:border-blue-600
                           transition-all duration-300
                           hover:-translate-y-1
                           flex flex-col items-center
                           justify-center p-4
                           cursor-pointer group">

                    <div class="w-20 h-20 flex items-center justify-center">

                        @if ($brand->logo && file_exists(public_path('storage/' . $brand->logo)))

                            <img
                                src="{{ asset('storage/' . $brand->logo) }}"
                                alt="{{ $brand->name }}"
                                class="w-[60px] h-[60px]
                                       object-contain
                                       group-hover:scale-105
                                       transition-transform duration-300"
                                loading="lazy">

                        @else

                            <div
                                class="w-20 h-20
                                       rounded-full
                                       bg-blue-100
                                       flex items-center justify-center
                                       text-blue-700
                                       text-1xl font-bold">

                                {{ strtoupper(substr($brand->name, 0, 1)) }}

                            </div>

                        @endif

                    </div>


                    <span
                        class="mt-3
                               text-sm font-medium
                               text-gray-700
                               group-hover:text-blue-600
                               transition-colors duration-300
                               text-center">

                        {{ $brand->name }}

                    </span>

                </a>

            @endforeach

        </div>


        {{-- =================================================
            LEFT FADE
        ================================================== --}}

        <div
            class="absolute inset-y-0 left-0 w-16
                   bg-gradient-to-r from-white to-transparent
                   pointer-events-none">
        </div>


        {{-- =================================================
            RIGHT FADE
        ================================================== --}}

        <div
            class="absolute inset-y-0 right-0 w-16
                   bg-gradient-to-l from-white to-transparent
                   pointer-events-none">
        </div>

    </div>

@else

    <p class="text-center text-gray-500">
        No brands available at the moment.
    </p>

@endif


<style>
    @keyframes scroll {

        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }

    }

    .animate-scroll {

        /* Pehle 30s tha, ab thoda slow */
        animation: scroll 45s linear infinite;

        width: max-content;

    }

    .hover\:pause:hover {

        animation-play-state: paused;

    }
</style>

                    <div class="pb-5">
                        <!-- Header -->
                        <div class="flex items-center justify-between ">
                            <!-- Left Side -->
                            <div class="flex items-center gap-3">
                                <div class="text-black text-lg font-semibold  py-2 rounded-lg">
                                    Blogs & Articles
                                </div>
                                <div class="h-px w-12 bg-gradient-to-r from-blue-600 to-transparent"></div>
                            </div>

                            <!-- Right Side -->
                            <a href="{{ route('blogs.index') }}"
                                class="flex items-center gap-2 text-[#155dfc] hover:text-blue-700 font-medium transition-colors group">
                                Read more articles.
                                <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 pt-4 gap-3 pb-8">

                            @foreach ($blogs as $blog)
                                <article
                                    class="bg-white rounded-xl overflow-hidden border border-gray-100
                   shadow-sm hover:shadow-lg transition duration-300">

                                    {{-- Blog Image --}}
                                    <div class="h-36 overflow-hidden">

                                        <img src="{{ $blog->featured_image
                                            ? asset('storage/' . $blog->featured_image)
                                            : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=900&q=80' }}"
                                            alt="{{ $blog->title }}"
                                            class="w-full h-full object-cover
                           hover:scale-105 transition duration-500">

                                    </div>


                                    {{-- Blog Content --}}
                                    <div class="p-3">

                                        {{-- Category --}}
                                        <div class="flex items-center mb-1.5">

                                            <span
                                                class="text-[10px] font-semibold text-blue-600
                                 line-clamp-1">
                                                {{ $blog->category->name ?? 'Blog' }}
                                            </span>

                                        </div>


                                        {{-- Title --}}
                                        <h3
                                            class="text-sm font-bold text-gray-900
                           leading-5 mb-1.5 line-clamp-2">
                                            {{ $blog->title }}
                                        </h3>


                                        {{-- Excerpt --}}
                                        <p
                                            class="text-[11px] text-gray-600
                           leading-4 mb-3 line-clamp-2">
                                            {{ $blog->excerpt }}
                                        </p>


                                        {{-- Date + Read More --}}
                                        <div class="flex items-center justify-between gap-2">

                                            {{-- Date --}}
                                            <span class="text-[10px] text-gray-500 whitespace-nowrap">
                                                📅
                                                {{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}
                                            </span>


                                            {{-- Read More --}}
                                            <a href="{{ route('blogs.view', $blog->slug) }}"
                                                class="text-[10px] font-semibold
                               text-blue-600 hover:text-blue-800
                               inline-flex items-center whitespace-nowrap">

                                                Read More

                                                <span class="ml-1">→</span>

                                            </a>

                                        </div>

                                    </div>

                                </article>
                            @endforeach

                        </div>
                    </div>
                    <!-- Modern & User-Friendly Professional Contact Box -->
                    <div
                        class="relative overflow-hidden bg-white rounded-2xl
           border border-blue-100
           shadow-md shadow-blue-900/5
           p-4 md:p-5
           transition-all duration-300">

                        {{-- Background Soft Glow --}}
                        <div
                            class="absolute -top-5 -right-10 w-28 h-28
               bg-blue-400/10 rounded-full blur-2xl
               pointer-events-none">
                        </div>

                        <div
                            class="absolute -bottom-5 -left-10 w-28 h-28
               bg-indigo-400/10 rounded-full blur-2xl
               pointer-events-none">
                        </div>


                        <div
                            class="relative z-10 grid grid-cols-1 md:grid-cols-3
               gap-3 md:gap-0
               divide-y md:divide-y-0 md:divide-x
               divide-blue-100">


                            {{-- Email --}}
                            <a href="mailto:support@technova.com.np"
                                class="group flex items-center md:items-center
                   gap-3
                   py-3 md:py-1 md:pr-5
                   transition-all duration-300
                   hover:translate-y-[-1px]">

                                <div
                                    class="flex-shrink-0
                       w-9 h-9
                       rounded-xl
                       bg-blue-100/80
                       text-blue-600
                       flex items-center justify-center
                       group-hover:bg-blue-600
                       group-hover:text-white
                       transition-all duration-300">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>

                                <div class="min-w-0">

                                    <span
                                        class="block text-[9px] font-bold uppercase
                           tracking-wider text-blue-600/80">
                                        Email Us
                                    </span>

                                    <h3
                                        class="text-xs md:text-sm font-bold
                           text-gray-800
                           group-hover:text-blue-600
                           transition-colors truncate">
                                        support@technova.com.np
                                    </h3>

                                    <p class="text-[9px] text-gray-500 mt-0.5">
                                        24/7 Quick Online Support
                                    </p>

                                </div>

                            </a>


                            {{-- Phone --}}
                            <a href="tel:+97715551234"
                                class="group flex items-center
                   gap-3
                   py-3 md:py-1 md:px-5
                   transition-all duration-300
                   hover:translate-y-[-1px]">

                                <div
                                    class="flex-shrink-0
                       w-9 h-9
                       rounded-xl
                       bg-blue-100/80
                       text-blue-600
                       flex items-center justify-center
                       group-hover:bg-blue-600
                       group-hover:text-white
                       transition-all duration-300">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <span
                                        class="block text-[9px] font-bold uppercase
                           tracking-wider text-blue-600/80">
                                        Call Us
                                    </span>

                                    <h3
                                        class="text-xs md:text-sm font-bold
                           text-gray-800
                           group-hover:text-blue-600
                           transition-colors">
                                        +977 1-555-1234
                                    </h3>

                                    <p class="text-[9px] text-gray-500 mt-0.5">
                                        Sun-Fri 9AM-7PM, Sat Closed
                                    </p>

                                </div>

                            </a>


                            {{-- Address --}}
                            <a href="https://maps.google.com/?q=Kathmandu,Nepal" target="_blank"
                                rel="noopener noreferrer"
                                class="group flex items-center
                   gap-3
                   py-3 md:py-1 md:pl-5
                   transition-all duration-300
                   hover:translate-y-[-1px]">

                                <div
                                    class="flex-shrink-0
                       w-9 h-9
                       rounded-xl
                       bg-blue-100/80
                       text-blue-600
                       flex items-center justify-center
                       group-hover:bg-blue-600
                       group-hover:text-white
                       transition-all duration-300">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <span
                                        class="block text-[9px] font-bold uppercase
                           tracking-wider text-blue-600/80">
                                        Our Location
                                    </span>

                                    <h3
                                        class="text-xs md:text-sm font-bold
                           text-gray-800
                           group-hover:text-blue-600
                           transition-colors">
                                        Kathmandu, Nepal
                                    </h3>

                                    <p class="text-[9px] text-gray-500 mt-0.5">
                                        Click to view on Google Maps
                                    </p>

                                </div>

                            </a>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </Section>
    <script>
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

                console.log('Wishlist Response:', data);

                if (!response.ok) {
                    throw new Error(
                        data.message || "Wishlist update failed."
                    );
                }

                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || "Wishlist update failed.");
                }

            } catch (error) {
                console.error('Wishlist Error:', error);
                alert(error.message || 'Something went wrong.');
            }
        }
    </script>
</x-frontend-layout>
