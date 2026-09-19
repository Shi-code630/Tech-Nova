<x-frontend-layout>

    {{-- =========================================================
        PAGE BACKGROUND
    ========================================================== --}}
    <div class="Container mx-auto py-5">

        {{-- =========================================================
            BREADCRUMB
        ========================================================== --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <nav class="flex items-center gap-2 text-[12px] overflow-x-auto whitespace-nowrap">

                <a href="{{ route('home') }}" class="text-slate-500 hover:text-blue-600 transition-colors duration-200">

                    Home

                </a>

                <span>/</span>

                <a href="{{ route('category.show', ['slug' => 'todays-deals']) }}"
                    class="hover:text-orange-600 transition">
                    Today's Deals
                </a>

                <span>/</span>

                <span class="text-gray-800 font-medium">
                    {{ $category->name }}
                </span>

            </nav>

        </div>


        {{-- =========================================================
            HERO SECTION
        ========================================================== --}}

        <section class="Container mx-auto px-3 pt-5 pb-6">

            <div
                class="relative overflow-hidden rounded-3xl
               bg-gradient-to-r from-orange-500 via-orange-600 to-amber-500
               px-6 py-7 md:px-10 md:py-9 shadow-xl">

                {{-- Decorative circles --}}
                <div class="absolute -top-16 -right-16 w-48 h-48
                    rounded-full bg-white/10">
                </div>

                <div class="absolute -bottom-20 -left-12 w-44 h-44
                    rounded-full bg-yellow-300/10">
                </div>

                <div class="relative z-10 text-center text-white">

                    {{-- Badge --}}
                    <div
                        class="inline-flex items-center gap-2
                       bg-white/20 backdrop-blur-sm
                       px-4 py-1.5 rounded-full
                       text-xs font-bold uppercase
                       tracking-wider mb-3">

                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3l1.8 4.6L18 9l-4.2 1.4L12 15l-1.8-4.6L6 9l4.2-1.4L12 3z" />

                        </svg>

                        Festive Season

                    </div>


                    {{-- Title --}}
                    <h1 class="text-2xl md:text-4xl font-extrabold tracking-tight">
                        {{ $category->name }}
                    </h1>


                    {{-- Description --}}
                    <p
                        class="mt-2 max-w-2xl mx-auto
                      text-orange-50
                      text-xs md:text-sm
                      leading-relaxed">

                        Celebrate the festive season with exclusive discounts,
                        special offers and amazing deals.

                    </p>

                </div>

            </div>

        </section>




        {{-- =========================================================
            SUB CATEGORIES
        ========================================================== --}}
        @if ($category->children->count())

            <div class="Container mx-auto px-4 pb-8">

                <div class="flex flex-wrap justify-center gap-3">

                    {{-- All --}}
                    <a href="{{ route('category.show', ['slug' => $category->slug]) }}"
                        class="px-5 py-2.5 rounded-full
                               bg-orange-600 text-white
                               font-semibold text-sm
                               shadow-md
                               hover:bg-orange-700
                               hover:-translate-y-0.5
                               transition-all duration-200">

                        All Festive Deals

                    </a>


                    {{-- Children --}}
                    @foreach ($category->children as $child)
                        <a href="{{ route('category.show', ['slug' => $child->slug]) }}"
                            class="px-5 py-2.5 rounded-full
                                   bg-white text-gray-700
                                   font-medium text-sm
                                   border border-gray-200
                                   hover:border-orange-300
                                   hover:bg-orange-50
                                   hover:text-orange-600
                                   hover:-translate-y-0.5
                                   transition-all duration-200">

                            {{ $child->name }}

                        </a>
                    @endforeach

                </div>

            </div>

        @endif


        {{-- =========================================================
            PRODUCTS SECTION
        ========================================================== --}}
        <section class="Container mx-auto px-4 pb-14"> {{-- ========================================================= SECTION HEADER ========================================================== --}} <div
                class="flex items-end justify-between gap-4 mb-7">
                <div>
                    <div class="flex items-center gap-2 mb-1"> <span
                            class="w-1.5 h-6 bg-gradient-to-b from-orange-500 to-amber-400 rounded-full"> </span>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900"> Festive Offers </h2>
                    </div>
                    <p class="text-sm text-gray-500"> Discover our special festive deals </p>
                </div> {{-- PRODUCT COUNT --}} <div
                    class="hidden sm:flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 text-sm text-gray-600 shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg> {{ $products->total() }} Products </div>
            </div> {{-- ========================================================= PRODUCTS ========================================================== --}} @if ($products->count())
                {{-- 2 cards : mobile 3 cards : small 4 cards : large 5 cards : extra large --}} <div id="productGrid"
                    class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                    @foreach ($products as $index => $product)
                        @php
                            /* |-------------------------------------------------------------------------- | DISCOUNT |-------------------------------------------------------------------------- */ $hasDiscount = isset($product->discount_price) && $product->discount_price && $product->price > $product->discount_price;
                            $discountAmount = $hasDiscount ? $product->price - $product->discount_price : 0;
                            $discountPercent = $hasDiscount ? round(($discountAmount / $product->price) * 100) : 0;
                            /* |-------------------------------------------------------------------------- | WISHLIST |-------------------------------------------------------------------------- */ $isWishlisted = in_array($product->id, $wishlistProductIds ?? []);
                            /* |-------------------------------------------------------------------------- | RATING |-------------------------------------------------------------------------- */ $rating = $product->rating ?? 0;
                            $reviewCount = $product->reviews_count ?? 0;
                            /* |-------------------------------------------------------------------------- | PRODUCT IMAGE |-------------------------------------------------------------------------- */ $image = null;
                            if (isset($product->thumbnails) && is_array($product->thumbnails) && count($product->thumbnails)) {
                                $image = $product->thumbnails[0];
                            }
                            if (!$image && isset($product->image)) {
                                $image = $product->image;
                            }
                            if (is_array($image)) {
                                $image = $image[0] ?? null;
                            }
                        @endphp {{-- ===================================================== PRODUCT CARD ====================================================== --}} <article
                            onclick="window.location.href='{{ route('product.show', ['slug' => $product->slug]) }}'"
                            class="product-card group bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md hover:border-blue-200 transition duration-300 cursor-pointer flex flex-col"
                            data-index="{{ $index }}"> {{-- ================================================= PRODUCT IMAGE ================================================== --}} <div
                                class="relative bg-slate-50 h-36 overflow-hidden"> {{-- NEW BADGE --}} @if ($product->created_at && $product->created_at->gt(now()->subDays(14)))
                                    <span
                                        class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-blue-600 text-white text-[9px] font-bold shadow-sm">
                                        NEW </span>
                                    @endif {{-- DISCOUNT --}} @if ($hasDiscount)
                                        <span
                                            class="absolute top-1.5 right-1.5 z-10 px-1.5 py-0.5 rounded bg-slate-900 text-white text-[9px] font-bold">
                                            -{{ $discountPercent }}% </span>
                                        @endif {{-- WISHLIST --}} <button type="button"
                                            onclick="toggleWishlist( event, this, {{ $product->id }} )"
                                            data-wishlisted="{{ $isWishlisted ? 'true' : 'false' }}"
                                            aria-label="{{ $isWishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}"
                                            class="wishlist-button absolute right-1.5 bottom-1.5 z-20 w-7 h-7 rounded-full bg-white border shadow-sm flex items-center justify-center transition duration-200 {{ $isWishlisted ? 'text-blue-600 border-blue-300' : 'text-slate-400 border-slate-200 hover:text-blue-600 hover:border-blue-300' }}">
                                            <svg class="wishlist-icon w-3.5 h-3.5" viewBox="0 0 24 24"
                                                fill="{{ $isWishlisted ? 'currentColor' : 'none' }}"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" />
                                            </svg> </button> {{-- ================================================= IMAGE ================================================== --}} @if ($image)
                                            <img src="{{ asset('storage/' . ltrim($image, '/')) }}"
                                                alt="{{ $product->name }}" loading="lazy"
                                                class="w-full h-full object-contain p-2 group-hover:scale-105 transition duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center"> <svg
                                                    class="w-10 h-10 text-slate-300" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg> </div>
                                            @endif </div> {{-- ================================================= PRODUCT INFORMATION ================================================== --}} <div
                                class="p-2.5 flex flex-col flex-1"> {{-- BRAND --}} @if ($product->brand)
                                    <p
                                        class="text-[10px] font-semibold uppercase tracking-wide text-blue-600 mb-0.5 truncate">
                                        {{ $product->brand->name }} </p>
                                    @endif {{-- PRODUCT NAME --}} <h3
                                        class="font-semibold text-slate-900 text-[12px] leading-4 line-clamp-2 min-h-[32px]">
                                        {{ $product->name }} </h3> {{-- ================================================= RATING ================================================== --}} <div
                                        class="flex items-center gap-0.5 mt-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-3 h-3 {{ $i <= round($rating) ? 'text-yellow-400' : 'text-slate-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            @endfor <span class="text-[9px] text-slate-500 ml-0.5">
                                                ({{ $reviewCount }}) </span>
                                    </div> {{-- ================================================= PRICE ================================================== --}} <div class="mt-1.5 flex items-center gap-1 flex-wrap">
                                        @if ($hasDiscount)
                                            {{-- Discount Price --}} <span class="text-[13px] font-bold text-blue-600">
                                                Rs.{{ number_format($product->discount_price, 0) }} </span>
                                            {{-- Original Price --}} <span
                                                class="text-[10px] text-slate-400 line-through">
                                                Rs.{{ number_format($product->price, 0) }} </span>
                                            {{-- Save Amount --}} <span
                                                class="text-[9px] font-semibold text-green-600"> Save
                                                Rs.{{ number_format($discountAmount, 0) }} </span>
                                        @else
                                            <span class="text-[13px] font-bold text-slate-900">
                                                Rs.{{ number_format($product->price, 0) }} </span>
                                            @endif
                                    </div> {{-- ================================================= STOCK ================================================== --}} @if (isset($product->stock))
                                        @if ($product->stock > 0)
                                            <div class="flex items-center gap-1 mt-1"> <span
                                                    class="w-1.5 h-1.5 rounded-full bg-green-500"> </span>
                                                <p class="text-[9px] font-medium text-slate-500"> In Stock </p>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1 mt-1"> <span
                                                    class="w-1.5 h-1.5 rounded-full bg-red-500"> </span>
                                                <p class="text-[9px] font-semibold text-red-500"> Out of Stock </p>
                                            </div>
                                        @endif
                                        @endif {{-- ================================================= ADD TO CART ================================================== --}} <div class="mt-auto pt-2">
                                            @if (isset($product->stock) && $product->stock <= 0)
                                                <button type="button" disabled onclick="event.stopPropagation();"
                                                    class="w-full inline-flex items-center justify-center rounded-md bg-slate-100 text-slate-400 py-1.5 text-[11px] font-semibold cursor-not-allowed">
                                                    Out of Stock </button>
                                            @else
                                                <form method="POST"
      action="{{ route('cart.add', ['product' => $product->id]) }}"
      onclick="event.stopPropagation();"
      class="w-full">
    @csrf

    <input type="hidden" name="quantity" value="1">


<button
    type="submit"
    onclick="event.stopPropagation();"
    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-lg font-semibold transition duration-200 flex items-center justify-center gap-2">

    <span class="text-base">🛍️</span>
    <span>Add to Cart</span>

</button>

</form>
                                            @endif
                                        </div>
                            </div>
                        </article>
                        @endforeach
                </div> {{-- ========================================================= PAGINATION 25 PRODUCTS PER PAGE ========================================================== --}} @if ($products->hasPages())
                    @php
                        $currentPage = $products->currentPage();
                        $lastPage = $products->lastPage();
                        $window = 1;
                        $start = max(1, $currentPage - $window);
                        $end = min($lastPage, $currentPage + $window);
                    @endphp <nav class="flex items-center justify-center mt-8" aria-label="Pagination">
                        <ul class="inline-flex items-center gap-1"> {{-- PREVIOUS --}} @if ($products->onFirstPage())
                                <li> <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-slate-200 text-slate-300 text-sm cursor-not-allowed">
                                        &lsaquo; </span> </li>
                            @else
                                <li> <a href="{{ $products->previousPageUrl() }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-slate-200 bg-white text-slate-600 hover:border-blue-300 hover:text-blue-600 text-sm transition">
                                        &lsaquo; </a> </li>
                                @endif {{-- FIRST PAGE --}} @if ($start > 1)
                                    <li> <a href="{{ $products->url(1) }}"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-slate-200 bg-white text-slate-600 hover:border-blue-300 hover:text-blue-600 text-sm transition">
                                            1 </a> </li>
                                    @if ($start > 2)
                                        <li> <span
                                                class="inline-flex items-center justify-center w-8 h-8 text-slate-400 text-sm">
                                                &hellip; </span> </li>
                                        @endif @endif {{-- PAGE NUMBERS --}} @for ($page = $start; $page <= $end; $page++)
                                            @if ($page == $currentPage)
                                                <li> <span
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-blue-600 border border-blue-600 text-white text-sm font-semibold">
                                                        {{ $page }} </span> </li>
                                            @else
                                                <li> <a href="{{ $products->url($page) }}"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-slate-200 bg-white text-slate-600 hover:border-blue-300 hover:text-blue-600 text-sm font-medium transition">
                                                        {{ $page }} </a> </li>
                                            @endif
                                            @endfor {{-- LAST PAGE --}} @if ($end < $lastPage)
                                                @if ($end < $lastPage - 1)
                                                    <li> <span
                                                            class="inline-flex items-center justify-center w-8 h-8 text-slate-400 text-sm">
                                                            &hellip; </span> </li>
                                                    @endif <li> <a href="{{ $products->url($lastPage) }}"
                                                            class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-slate-200 bg-white text-slate-600 hover:border-blue-300 hover:text-blue-600 text-sm transition">
                                                            {{ $lastPage }} </a> </li> @endif
                                                    {{-- NEXT --}} @if ($products->hasMorePages())
                                                        <li> <a href="{{ $products->nextPageUrl() }}"
                                                                class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-slate-200 bg-white text-slate-600 hover:border-blue-300 hover:text-blue-600 text-sm transition">
                                                                &rsaquo; </a> </li>
                                                    @else
                                                        <li> <span
                                                                class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-slate-200 text-slate-300 text-sm cursor-not-allowed">
                                                                &rsaquo; </span> </li>
                                                    @endif
                        </ul>
                    </nav>
                @endif
            @else
                {{-- ========================================================= EMPTY STATE ========================================================== --}} <div
                    class="bg-white rounded-3xl border border-gray-200 shadow-sm py-20 text-center">
                    <div class="w-20 h-20 mx-auto mb-5 rounded-full bg-orange-50 flex items-center justify-center">
                        <svg class="w-10 h-10 text-orange-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg> </div>
                    <h3 class="text-xl font-bold text-gray-800"> No festive offers right now </h3>
                    <p class="text-gray-500 mt-2"> Check back later for seasonal deals. </p> <a
                        href="{{ route('category.show', ['slug' => 'todays-deals']) }}"
                        class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-xl font-semibold text-sm transition">
                        Browse Today's Deals <svg class="w-4 h-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg> </a>
                </div>
            @endif
        </section>
@if (!empty($category->description))
                <section class="px-8">

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
                                        flex items-center
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


    {{-- =============================================================
        JAVASCRIPT
    ============================================================== --}}
    <script>
        function toggleWishlist(button, productId) {

            const icon = button.querySelector('svg');

            button.classList.toggle('bg-red-500');
            button.classList.toggle('text-white');
            button.classList.toggle('text-gray-600');

            if (button.classList.contains('bg-red-500')) {

                icon.setAttribute('fill', 'currentColor');

            } else {

                icon.setAttribute('fill', 'none');

            }

            console.log(
                'Toggle wishlist for product:',
                productId
            );
        }


        function addToCart(productId) {

            console.log(
                'Add product to cart:',
                productId
            );

            /*
             * Aapke existing addToCart() function ko
             * yahan use kar sakte hain agar layout me
             * already defined hai.
             */

        }
    </script>

</x-frontend-layout>
