<x-frontend-layout>

    {{-- =========================================================
        SEARCH RESULTS PAGE
    ========================================================== --}}
    <div class="bg-[#ebf4fa] py-8 md:py-8">

        <div class="Container mx-auto px-4 ">

            {{-- =================================================
                PAGE HEADER
            ================================================== --}}
            <div class="mb-8">

                <div
                    class="bg-white rounded-2xl border border-blue-100
                            shadow-sm px-5 py-5 md:px-7 md:py-6">

                    <div
                        class="flex flex-col md:flex-row
                                md:items-center
                                md:justify-between
                                gap-4">

                        {{-- Heading --}}
                        <div>

                            <div class="flex items-center gap-2 mb-1">

                                <span class="w-1 h-7 bg-blue-600 rounded-full"></span>

                                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                                    Search Results
                                </h1>

                            </div>

                            @if (!empty($query))
                                <p class="text-sm md:text-base text-gray-500 ml-3">
                                    Showing results for
                                    <span class="font-semibold text-blue-600">
                                        “{{ $query }}”
                                    </span>
                                </p>
                            @else
                                <p class="text-sm md:text-base text-gray-500 ml-3">
                                    Explore our latest products
                                </p>
                            @endif

                        </div>


                        {{-- Result Count --}}
                        @if ($products->total() > 0)
                            <div
                                class="flex items-center gap-2
                                        bg-[#ebf4fa]
                                        border border-blue-100
                                        px-4 py-2
                                        rounded-full
                                        w-fit">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7
                                           m16 0l-8 5-8-5
                                           m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5" />

                                </svg>

                                <span class="text-sm font-semibold text-gray-700">
                                    {{ $products->total() }} Products
                                </span>

                            </div>
                        @endif

                    </div>

                </div>

            </div>


            {{-- =================================================
                PRODUCTS
            ================================================== --}}
            @if ($products->count() > 0)

                <div
                    class="grid grid-cols-2
                            sm:grid-cols-3
                            md:grid-cols-4
                            lg:grid-cols-5
                            gap-3 mb-10">

                    @foreach ($products as $product)
                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | PRICE
                            |--------------------------------------------------------------------------
                            */

                            $originalPrice = (float) ($product->price ?? 0);

                            $discountPrice =
                                $product->discount_price !== null ? (float) $product->discount_price : null;

                            $hasDiscount =
                                $discountPrice !== null && $originalPrice > 0 && $discountPrice < $originalPrice;

                            $discountAmount = $hasDiscount ? $originalPrice - $discountPrice : 0;

                            $discountPercent = $hasDiscount ? round(($discountAmount / $originalPrice) * 100) : 0;

                            /*
                            |--------------------------------------------------------------------------
                            | WISHLIST
                            |--------------------------------------------------------------------------
                            */

                            $isWishlisted = in_array($product->id, $wishlistProductIds ?? []);

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
                                   flex flex-col">


                            {{-- =================================================
                                PRODUCT IMAGE
                            ================================================== --}}
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


                                {{-- DISCOUNT BADGE --}}
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


                                {{-- =================================================
                                    WISHLIST BUTTON
                                ================================================== --}}
                                <button type="button" onclick="toggleWishlist(event, this, {{ $product->id }})"
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
                                        fill="{{ $isWishlisted ? 'currentColor' : 'none' }}" stroke="currentColor"
                                        stroke-width="2">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" />

                                    </svg>

                                </button>


                                {{-- =================================================
                                    PRODUCT IMAGE
                                ================================================== --}}
                                @if ($image)
                                    <img src="{{ asset('storage/' . ltrim($image, '/')) }}" alt="{{ $product->name }}"
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
                                        class="w-full h-full
                                                flex items-center
                                                justify-center">

                                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />

                                        </svg>

                                    </div>
                                @endif

                            </div>


                            {{-- =================================================
                                PRODUCT INFORMATION
                            ================================================== --}}
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
                                @elseif ($product->category)
                                    <p
                                        class="text-[10px]
                                              font-semibold
                                              uppercase
                                              tracking-wide
                                              text-blue-600
                                              mb-0.5
                                              truncate">

                                        {{ $product->category->name }}

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


                                {{-- =================================================
                                    RATING
                                ================================================== --}}
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


                                {{-- =================================================
                                    PRICE
                                ================================================== --}}
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

                                            Rs.{{ number_format($discountPrice, 0) }}

                                        </span>

                                        <span
                                            class="text-[10px]
                                                   text-slate-400
                                                   line-through">

                                            Rs.{{ number_format($originalPrice, 0) }}

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

                                            Rs.{{ number_format($originalPrice, 0) }}

                                        </span>
                                    @endif

                                </div>


                                {{-- =================================================
                                    STOCK
                                ================================================== --}}
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


                                {{-- =================================================
                                    ADD TO CART
                                ================================================== --}}
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


                {{-- =================================================
                    PAGINATION
                ================================================== --}}
                <div
                    class="mt-10 mb-10
                            bg-white
                            rounded-2xl
                            border border-blue-100
                            shadow-sm
                            px-4 py-4
                            flex justify-center">

                    {{ $products->withQueryString()->links() }}

                </div>
            @else
                {{-- =================================================
                    NO PRODUCTS FOUND
                ================================================== --}}
                <div
                    class="min-h-[450px]
                            flex items-center
                            justify-center">

                    <div
                        class="w-full max-w-lg
                                bg-white
                                rounded-3xl
                                border border-blue-100
                                shadow-lg
                                px-6 py-12
                                text-center">


                        {{-- Icon --}}
                        <div
                            class="mx-auto mb-5
                                    w-20 h-20
                                    rounded-full
                                    bg-[#ebf4fa]
                                    flex items-center
                                    justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-blue-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35
                                       m2.35-5.65
                                       a7.5 7.5 0 11-15 0
                                       a7.5 7.5 0 0115 0z" />

                            </svg>

                        </div>


                        {{-- Title --}}
                        <h3
                            class="text-2xl
                                   font-bold
                                   text-gray-800
                                   mb-2">

                            No Products Found

                        </h3>


                        {{-- Description --}}
                        <p
                            class="text-gray-500
                                  text-sm
                                  leading-relaxed
                                  max-w-md
                                  mx-auto
                                  mb-7">

                            @if (!empty($query))
                                We couldn't find any products matching

                                <strong class="text-gray-700">
                                    “{{ $query }}”
                                </strong>.

                                Try searching with another keyword.
                            @else
                                Please enter a keyword to search for products.
                            @endif

                        </p>


                        {{-- Back Home --}}
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center
                                   gap-2
                                   bg-blue-600
                                   hover:bg-blue-700
                                   text-white
                                   font-semibold
                                   px-6 py-3
                                   rounded-xl
                                   shadow-md
                                   hover:shadow-lg
                                   transition-all duration-200">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18
                                       m-9-9l-9 9 9 9" />

                            </svg>

                            Back to Home

                        </a>

                    </div>

                </div>

            @endif
            <div class="relative overflow-hidden  bg-white via-blue-50/50 to-slate-50 rounded-3xl border border-blue-100 shadow-xl shadow-blue-900/5 p-6 md:p-10  transition-all duration-300">

                <!-- Background Soft Glow Effect -->
                <div
                    class="absolute -top-12 -right-12 w-40 h-40 bg-blue-400/10 rounded-full blur-3xl pointer-events-none">
                </div>
                <div
                    class="absolute -bottom-12 -left-12 w-40 h-40 bg-indigo-400/10 rounded-full blur-3xl pointer-events-none">
                </div>

                <div
                    class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-6 divide-y md:divide-y-0 md:divide-x divide-blue-100">

                    <!-- Email Item -->
                    <a href="mailto:support@technova.com.np"
                        class="group flex flex-col items-center md:items-start pt-6 md:pt-0 md:pr-6 transition-all duration-300 hover:translate-y-[-2px]">
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-100/80 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/30 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600/80 mb-1">Email
                            Us</span>
                        <h3
                            class="text-base md:text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors break-all">
                            support@technova.com.np</h3>
                        <p class="text-xs text-gray-500 mt-1">24/7 Quick Online Support</p>
                    </a>

                    <!-- Phone Item -->
                    <a href="tel:+97715551234"
                        class="group flex flex-col items-center md:items-start pt-6 md:pt-0 md:px-6 transition-all duration-300 hover:translate-y-[-2px]">
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-100/80 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/30 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600/80 mb-1">Call
                            Us</span>
                        <h3
                            class="text-base md:text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                            +977 1-555-1234</h3>
                        <p class="text-xs text-gray-500 mt-1">Sun-Fri 9AM-7PM, Sat Closed</p>
                    </a>

                    <!-- Address Item -->
                    <a href="https://maps.google.com/?q=Kathmandu,Nepal" target="_blank" rel="noopener noreferrer"
                        class="group flex flex-col items-center md:items-start pt-6 md:pt-0 md:pl-6 transition-all duration-300 hover:translate-y-[-2px]">
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-100/80 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/30 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600/80 mb-1">Our
                            Location</span>
                        <h3
                            class="text-base md:text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                            Kathmandu, Nepal</h3>
                        <p class="text-xs text-gray-500 mt-1">Click to view on Google Maps</p>
                    </a>

                </div>
            </div>
        </div>

    </div>


    {{-- =========================================================
        WISHLIST SCRIPT
    ========================================================== --}}
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

                    /*
                    |--------------------------------------------------------------------------
                    | Same behavior as Category page
                    |--------------------------------------------------------------------------
                    */

                    window.location.reload();

                } else {

                    alert(
                        data.message ||
                        "Wishlist update failed."
                    );

                }

            } catch (error) {

                console.error(
                    'Wishlist Error:',
                    error
                );

                alert(
                    error.message ||
                    'Something went wrong.'
                );
            }
        }
    </script>

</x-frontend-layout>
