<x-frontend-layout>

    <div class="bg-gray-100 w-full min-h-screen py-6 sm:py-8">

        <div class="Container mx-auto px-3 sm:px-4">

            <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">

                {{-- =====================================================
                    SIDEBAR
                ====================================================== --}}
                <aside class="w-full lg:w-64 flex-shrink-0">
                    <x-user-dashboard.sidebar />
                </aside>


                {{-- =====================================================
                    MAIN CONTENT
                ====================================================== --}}
                <main class="flex-1 min-w-0 w-full">

                    {{-- =====================================================
                        PAGE HEADER
                    ====================================================== --}}
                    <div class="bg-white rounded-2xl shadow-sm
                                p-4 sm:p-6 mb-4 sm:mb-6">

                        <div class="flex items-center justify-between gap-3">

                            <div class="min-w-0">

                                <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-slate-900">
                                    My Wishlist
                                </h1>

                                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                                    Products you have saved for later
                                </p>

                            </div>


                            <div
                                class="flex items-center justify-center
                                        w-10 h-10 sm:min-w-[45px] sm:h-[45px]
                                        rounded-full
                                        bg-blue-50 text-blue-600
                                        flex-shrink-0">

                                <svg
                                    class="w-6 h-6"
                                    viewBox="0 0 24 24"
                                    fill="currentColor">

                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" />

                                </svg>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        WISHLIST PRODUCTS
                    ================================================== --}}

                    @if ($wishlist->count() > 0)

                        <div class="bg-white rounded-2xl shadow-sm p-5 md:p-6">

                            {{-- HEADER --}}
                            <div class="flex items-center justify-between mb-5">

                                <div class="min-w-0">

                                    <h2 class="text-base sm:text-lg font-bold text-slate-900">
                                        Wishlist Products
                                    </h2>

                                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                                        {{ $wishlist->count() }}
                                        {{ $wishlist->count() == 1 ? 'product' : 'products' }}
                                        saved
                                    </p>

                                </div>

                            </div>


                            {{-- =================================================
                                PRODUCT GRID
                            ================================================== --}}
                            <div
                                class="grid
                                       grid-cols-2
                                       sm:grid-cols-3
                                       lg:grid-cols-4
                                       gap-3">

                                @foreach ($wishlist as $item)
                                    @php
                                        $product = $item->product;

                                        if (!$product) {
                                            continue;
                                        }


                                        /*
                                        |--------------------------------------------------------------------------
                                        | PRODUCT IMAGE
                                        |--------------------------------------------------------------------------
                                        */

                                        $image = null;

                                        if (
                                            isset($product->thumbnails) &&
                                            is_array($product->thumbnails) &&
                                            count($product->thumbnails) > 0
                                        ) {
                                            $image = $product->thumbnails[0];
                                        }

                                        if (!$image && !empty($product->image)) {
                                            $image = $product->image;
                                        }

                                        if (!$image && !empty($product->thumbnail)) {
                                            $image = $product->thumbnail;
                                        }

                                        if (is_array($image)) {
                                            $image = $image[0] ?? null;
                                        }


                                        /*
                                        |--------------------------------------------------------------------------
                                        | PRICE
                                        |--------------------------------------------------------------------------
                                        */

                                        $price = (float) ($product->price ?? 0);

                                        $salePrice = $product->discount_price
                                            ?? $product->sale_price
                                            ?? null;

                                        $salePrice = $salePrice !== null
                                            ? (float) $salePrice
                                            : null;


                                        /*
                                        |--------------------------------------------------------------------------
                                        | DISCOUNT
                                        |--------------------------------------------------------------------------
                                        */

                                        $hasDiscount =
                                            $salePrice !== null &&
                                            $price > 0 &&
                                            $salePrice < $price;

                                        $discountAmount = $hasDiscount
                                            ? $price - $salePrice
                                            : 0;

                                        $discountPercent = $hasDiscount
                                            ? round(($discountAmount / $price) * 100)
                                            : 0;


                                        /*
                                        |--------------------------------------------------------------------------
                                        | RATING
                                        |--------------------------------------------------------------------------
                                        */

                                        $rating = (float) (
                                            $product->rating
                                            ?? $product->average_rating
                                            ?? 0
                                        );

                                        $reviewCount = $product->reviews_count ?? 0;


                                        /*
                                        |--------------------------------------------------------------------------
                                        | STOCK
                                        |--------------------------------------------------------------------------
                                        */

                                        $stock = $product->stock ?? null;

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
                                            @if (
                                                $product->created_at &&
                                                $product->created_at->gt(now()->subDays(14))
                                            )

                                                <span
                                                    class="absolute
                                                           top-1.5
                                                           left-1.5
                                                           z-10
                                                           px-1.5
                                                           py-0.5
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
                                                    class="absolute
                                                           top-1.5
                                                           right-1.5
                                                           z-10
                                                           px-1.5
                                                           py-0.5
                                                           rounded
                                                           bg-slate-900
                                                           text-white
                                                           text-[9px]
                                                           font-bold">

                                                    -{{ $discountPercent }}%

                                                </span>
                                            @endif


                                            {{-- =================================================
                                                REMOVE FROM WISHLIST
                                            ================================================== --}}
                                            <button
                                                type="button"
                                                onclick="removeWishlistItem(
                                                    event,
                                                    {{ $product->id }},
                                                    this
                                                )"
                                                aria-label="Remove from wishlist"
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
                                                       border-blue-300
                                                       text-blue-600
                                                       shadow-sm
                                                       flex
                                                       items-center
                                                       justify-center
                                                       hover:bg-blue-50
                                                       hover:border-blue-400
                                                       transition
                                                       duration-200">

                                                <svg
                                                    class="w-3.5 h-3.5"
                                                    viewBox="0 0 24 24"
                                                    fill="currentColor">

                                                    <path
                                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" />

                                                </svg>

                                            </button>


                                            {{-- =================================================
                                                PRODUCT IMAGE
                                            ================================================== --}}
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
                                                    class="w-full
                                                           h-full
                                                           flex
                                                           items-center
                                                           justify-center">

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
                                        <div
                                            class="p-2.5
                                                   flex
                                                   flex-col
                                                   flex-1">


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
                                                       min-h-[32px]
                                                       group-hover:text-blue-600
                                                       transition">

                                                {{ $product->name }}

                                            </h3>


                                            {{-- RATING --}}
                                            <div
                                                class="flex
                                                       items-center
                                                       gap-0.5
                                                       mt-1">

                                                @for ($i = 1; $i <= 5; $i++)

                                                    <svg
                                                        class="w-3 h-3
                                                            {{ $i <= round($rating)
                                                                ? 'text-yellow-400'
                                                                : 'text-slate-300' }}"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20">

                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />

                                                    </svg>

                                                @endfor

                                                <span
                                                    class="text-[9px]
                                                           text-slate-500
                                                           ml-0.5">

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

                                                        Rs.{{ number_format($salePrice, 0) }}

                                                    </span>

                                                    <span
                                                        class="text-[10px]
                                                               text-slate-400
                                                               line-through">

                                                        Rs.{{ number_format($price, 0) }}

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

                                                        Rs.{{ number_format($price, 0) }}

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
                                                    <div class="mt-1.5 sm:mt-2">

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


                                            {{-- =================================================
                                                ADD TO CART
                                            ================================================== --}}
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
                                                               rounded-lg
                                                               bg-slate-100
                                                               text-slate-400
                                                               py-2
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
                                                            class="w-full bg-blue-600 hover:bg-blue-700
                                                                   text-white
                                                                   py-2
                                                                   px-3
                                                                   rounded-lg
                                                                   font-semibold
                                                                   text-[11px]
                                                                   transition
                                                                   duration-200
                                                                   flex
                                                                   items-center
                                                                   justify-center
                                                                   gap-1.5">

                                                            <span>🛍️</span>

                                                            <span>Add to Cart</span>

                                                        </button>

                                                    </form>
                                                @endif

                                            </div>

                                        </div>

                                    </article>
                                @endforeach

                            </div>

                        </div>


                    @else
                        {{-- =================================================
                            EMPTY WISHLIST
                        ================================================== --}}
                        <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-12 text-center">

                            <div
                                class="w-16 h-16 sm:w-20 sm:h-20 mx-auto rounded-full
                                        bg-blue-50 text-blue-600
                                        flex items-center justify-center mb-4 sm:mb-5">

                                <svg
                                    class="w-10 h-10"
                                    viewBox="0 0 24 24"
                                    fill="currentColor">

                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" />

                                </svg>

                            </div>

                            <h2 class="text-lg sm:text-xl font-bold text-slate-900">
                                Your Wishlist is Empty
                            </h2>

                            <p class="text-xs sm:text-sm text-slate-500 mt-2 mb-4 sm:mb-6">
                                You haven't added any products to your wishlist yet.
                            </p>

                            <a href="{{ route('home') }}"
                                class="inline-flex items-center justify-center gap-2
                                       bg-blue-600 hover:bg-blue-700
                                       text-white
                                       px-5 sm:px-6 py-2.5 sm:py-3
                                       rounded-lg font-semibold
                                       text-xs sm:text-sm transition">

                                <span>🛍️</span>

                                <span>Continue Shopping</span>

                            </a>

                        </div>

                    @endif

                </main>

            </div>

        </div>

    </div>


    {{-- =============================================================
        JAVASCRIPT (unchanged)
    ============================================================== --}}
    <script>
        function removeWishlistItem(event, productId, button) {

            event.preventDefault();
            event.stopPropagation();

            if (button.disabled) {
                return;
            }

            button.disabled = true;

            const tokenElement = document.querySelector('meta[name="csrf-token"]');

            if (!tokenElement) {
                alert('Security token not found. Please refresh the page.');
                button.disabled = false;
                return;
            }

            const token = tokenElement.getAttribute('content');

            fetch("{{ url('/wishlist') }}/" + productId, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(async response => {
                    const data = await response.json();

                const contentType =
                    response.headers.get("content-type") || "";

                if (!contentType.includes("application/json")) {

                    throw new Error(
                        "Server returned an invalid response. Please refresh the page."
                    );

                }

                const data = await response.json();

                if (!response.ok) {

                    throw new Error(
                        data.message ||
                        'Unable to remove product from wishlist.'
                    );

                }

                return data;

            })
            .then(data => {

                if (!data.success) {

                    throw new Error(
                        data.message ||
                        'Something went wrong.'
                    );

                }

                window.location.reload();

            })
            .catch(error => {

                console.error(
                    'Wishlist Remove Error:',
                    error
                );

                alert(
                    error.message ||
                    'Unable to remove product from wishlist.'
                );

                button.disabled = false;

            });

                    window.location.reload();
                })
                .catch(error => {
                    console.error('Wishlist Remove Error:', error);
                    alert(error.message || 'Unable to remove product from wishlist.');
                    button.disabled = false;
                });
        
    </script>

</x-frontend-layout>

