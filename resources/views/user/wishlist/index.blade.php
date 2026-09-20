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

                                <span class="text-lg sm:text-xl">🩵</span>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        WISHLIST PRODUCTS
                    ================================================== --}}
                    @if ($wishlist->count() > 0)

                        <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">

                            {{-- COUNT --}}
                            <div class="flex items-center justify-between gap-3 mb-4 sm:mb-6">

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
                                class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4
                                        gap-3 sm:gap-5">

                                @foreach ($wishlist as $item)
                                    @php
                                        $product = $item->product;

                                        if (!$product) {
                                            continue;
                                        }

                                        $isWishlisted = true;

                                        $image = $product->image ?? ($product->thumbnail ?? null);

                                        $price = $product->price ?? 0;
                                        $salePrice = $product->sale_price ?? null;
                                        $stock = $product->stock ?? null;

                                        $discount = 0;

                                        if ($salePrice !== null && $price > 0 && $salePrice < $price) {
                                            $discount = round((($price - $salePrice) / $price) * 100);
                                        }

                                        $rating = $product->average_rating ?? ($product->rating ?? 0);
                                    @endphp


                                    {{-- =================================================
                                        PRODUCT CARD
                                    ================================================== --}}
                                    <article
                                        class="group bg-white border border-slate-200
                                               rounded-xl overflow-hidden
                                               hover:shadow-lg transition duration-200
                                               flex flex-col h-full cursor-pointer min-w-0"
                                        onclick="window.location.href='{{ route('product.show', ['slug' => $product->slug]) }}'">


                                        {{-- =================================================
                                            PRODUCT IMAGE
                                        ================================================== --}}
                                        <div
                                            class="relative w-full h-[140px] sm:h-[180px] md:h-[200px] lg:h-[220px]
                                                    bg-slate-50 overflow-hidden">

                                            @if ($image)
                                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}"
                                                    loading="lazy"
                                                    class="w-full h-full object-contain
                                                           p-2 sm:p-4
                                                           group-hover:scale-105
                                                           transition duration-300">
                                            @else
                                                <div
                                                    class="w-full h-full flex items-center justify-center text-slate-300">

                                                    <i class="fa-regular fa-image text-3xl sm:text-5xl"></i>

                                                </div>
                                            @endif


                                            {{-- DISCOUNT --}}
                                            @if ($discount > 0)
                                                <span
                                                    class="absolute top-2 sm:top-3 left-2 sm:left-3
                                                             bg-red-500 text-white
                                                             text-[9px] sm:text-[10px] font-bold
                                                             px-1.5 sm:px-2 py-0.5 sm:py-1
                                                             rounded-md">

                                                    {{ $discount }}% OFF

                                                </span>
                                            @endif


                                            {{-- =================================================
                                                REMOVE FROM WISHLIST
                                            ================================================== --}}
                                            <button type="button"
                                                onclick="removeWishlistItem(event, {{ $product->id }}, this)"
                                                aria-label="Remove from wishlist"
                                                class="wishlist-button absolute top-2 sm:top-3 right-2 sm:right-3
                                                       w-7 h-7 sm:w-9 sm:h-9
                                                       rounded-full bg-white
                                                       shadow-sm border border-blue-300
                                                       text-blue-600
                                                       flex items-center justify-center
                                                       hover:bg-blue-50 transition">

                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="currentColor">

                                                    <path
                                                        d="M12 21s-7-4.35-9.5-9.15C.5 7.8 2.42 4 6.5 4c2.04 0 3.48 1.17 4.5 2.53C12.02 5.17 13.46 4 15.5 4 19.58 4 21.5 7.8 21.5 11.85 19 16.65 12 21 12 21z" />

                                                </svg>

                                            </button>

                                        </div>


                                        {{-- =================================================
                                            PRODUCT DETAILS
                                        ================================================== --}}
                                        <div class="p-2.5 sm:p-4 flex flex-col flex-1 min-w-0">


                                            {{-- BRAND --}}
                                            @if (!empty($product->brand))
                                                <p
                                                    class="text-[9px] sm:text-[10px] font-semibold uppercase
                                                          tracking-wide text-blue-600 mb-1 truncate">

                                                    {{ $product->brand->name }}

                                                </p>
                                            @elseif (!empty($product->brand_name))
                                                <p
                                                    class="text-[9px] sm:text-[10px] font-semibold uppercase
                                                          tracking-wide text-blue-600 mb-1 truncate">

                                                    {{ $product->brand_name }}

                                                </p>
                                            @endif


                                            {{-- PRODUCT NAME --}}
                                            <h3
                                                class="text-xs sm:text-sm font-semibold text-slate-900
                                                       line-clamp-2
                                                       min-h-[32px] sm:min-h-[40px]
                                                       leading-4 sm:leading-5
                                                       group-hover:text-blue-600 transition
                                                       break-words">

                                                {{ $product->name }}

                                            </h3>


                                            {{-- RATING --}}
                                            <div class="flex items-center gap-1 mt-1.5 sm:mt-2">

                                                <div class="flex items-center gap-0.5">

                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= round($rating))
                                                            <i
                                                                class="fa-solid fa-star text-[9px] sm:text-[10px] text-yellow-400"></i>
                                                        @else
                                                            <i
                                                                class="fa-regular fa-star text-[9px] sm:text-[10px] text-slate-300"></i>
                                                        @endif
                                                    @endfor

                                                </div>

                                                @if ($rating > 0)
                                                    <span class="text-[9px] sm:text-[10px] text-slate-400">
                                                        {{ number_format($rating, 1) }}
                                                    </span>
                                                @endif

                                            </div>


                                            {{-- PRICE --}}
                                            <div
                                                class="flex items-center gap-1.5 sm:gap-2 mt-1.5 sm:mt-2 flex-wrap min-w-0">

                                                @if ($salePrice !== null && $salePrice < $price)
                                                    <span
                                                        class="text-sm sm:text-base font-bold text-blue-600 whitespace-nowrap">
                                                        Rs. {{ number_format($salePrice, 0) }}
                                                    </span>

                                                    <span
                                                        class="text-[10px] sm:text-xs text-slate-400 line-through whitespace-nowrap">
                                                        Rs. {{ number_format($price, 0) }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="text-sm sm:text-base font-bold text-blue-600 whitespace-nowrap">
                                                        Rs. {{ number_format($price, 0) }}
                                                    </span>
                                                @endif

                                            </div>


                                            {{-- STOCK STATUS --}}
                                            @if (isset($stock))
                                                @if ($stock > 0)
                                                    <div class="mt-1.5 sm:mt-2">

                                                        <p
                                                            class="text-[8px] sm:text-[9px] font-semibold text-green-600">
                                                            {{ $stock }} in stock
                                                        </p>

                                                    </div>
                                                @else
                                                    <div class="mt-1.5 sm:mt-2">

                                                        <p class="text-[8px] sm:text-[9px] font-semibold text-red-500">
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
                                                        class="w-full inline-flex items-center justify-center
                                                               rounded-md bg-slate-100 text-slate-400
                                                               py-1.5 text-[10px] sm:text-[11px] font-semibold
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
                                                                   py-2 sm:py-2.5
                                                                   px-2 sm:px-4
                                                                   rounded-lg font-semibold
                                                                   transition duration-200
                                                                   flex items-center justify-center gap-1 sm:gap-2
                                                                   text-[10px] sm:text-xs md:text-sm">

                                                            <i
                                                                class="fa-solid fa-cart-shopping text-[10px] sm:text-xs"></i>
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

                                <i class="fa-regular fa-heart text-2xl sm:text-3xl"></i>

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

                                <i class="fa-solid fa-shop"></i>
                                Continue Shopping

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

                    if (!response.ok) {
                        throw new Error(data.message || 'Unable to remove product from wishlist.');
                    }

                    return data;
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Something went wrong.');
                    }

                    window.location.reload();
                })
                .catch(error => {
                    console.error('Wishlist Remove Error:', error);
                    alert(error.message || 'Unable to remove product from wishlist.');
                    button.disabled = false;
                });
        }
    </script>

</x-frontend-layout>
