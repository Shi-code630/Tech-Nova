<x-frontend-layout>

    <div class="bg-gray-100 py-5">

        <div class="Container mx-auto px-8">

            {{-- BREADCRUMB --}}
            <div class="mb-5 text-[12px] text-gray-500">

                <a href="{{ route('home') }}"
                    class="hover:text-blue-600">
                    Home
                </a>

                <span class="mx-2">/</span>

                <span class="text-gray-800 font-medium">
                    {{ $brand->name }}
                </span>

            </div>


            {{-- BRAND HEADER --}}
            <div class="mb-6">

                <h1 class="text-2xl font-bold text-slate-900">
                    {{ $brand->name }}
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Products by {{ $brand->name }}
                </p>

            </div>


            {{-- PRODUCT GRID --}}
            @if ($products->count())

                <div id="productGrid"
                    class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">


                    @foreach ($products as $index => $product)

                        @php
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

                            $isWishlisted = in_array(
                                $product->id,
                                $wishlistProductIds ?? []
                            );

                            $rating = $product->rating ?? 0;

                            $reviewCount = $product->reviews_count ?? 0;

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
                                   flex flex-col"
                            data-index="{{ $index }}">


                            {{-- PRODUCT IMAGE --}}
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


                                {{-- WISHLIST BUTTON --}}
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
                                            class="w-3 h-3 {{ $i <= round($rating)
                                                ? 'text-yellow-400'
                                                : 'text-slate-300' }}"
                                            fill="currentColor"
                                            viewBox="0 0 20 20">

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

                                    @if (
                                        isset($product->stock) &&
                                        $product->stock <= 0
                                    )

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
                                            onclick="event.stopPropagation()"
                                            class="w-full">

                                            @csrf

                                            <input
                                                type="hidden"
                                                name="quantity"
                                                value="1">

                                            <button
                                                type="submit"
                                                onclick="event.stopPropagation()"
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


                {{-- PAGINATION --}}
                @if ($products->hasPages())

                    @php
                        $currentPage = $products->currentPage();
                        $lastPage = $products->lastPage();
                        $window = 1;

                        $start = max(
                            1,
                            $currentPage - $window
                        );

                        $end = min(
                            $lastPage,
                            $currentPage + $window
                        );
                    @endphp


                    <nav
                        class="flex items-center justify-center mt-8"
                        aria-label="Pagination">

                        <ul class="inline-flex items-center gap-1">


                            {{-- PREVIOUS --}}
                            @if ($products->onFirstPage())

                                <li>

                                    <span
                                        class="inline-flex
                                               items-center
                                               justify-center
                                               w-8
                                               h-8
                                               rounded-md
                                               border
                                               border-slate-200
                                               text-slate-300
                                               text-sm
                                               cursor-not-allowed">

                                        &lsaquo;

                                    </span>

                                </li>

                            @else

                                <li>

                                    <a
                                        href="{{ $products->previousPageUrl() }}"
                                        class="inline-flex
                                               items-center
                                               justify-center
                                               w-8
                                               h-8
                                               rounded-md
                                               border
                                               border-slate-200
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


                            {{-- FIRST PAGE --}}
                            @if ($start > 1)

                                <li>

                                    <a
                                        href="{{ $products->url(1) }}"
                                        class="inline-flex
                                               items-center
                                               justify-center
                                               w-8
                                               h-8
                                               rounded-md
                                               border
                                               border-slate-200
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
                                            class="inline-flex
                                                   items-center
                                                   justify-center
                                                   w-8
                                                   h-8
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
                                            class="inline-flex
                                                   items-center
                                                   justify-center
                                                   w-8
                                                   h-8
                                                   rounded-md
                                                   bg-blue-600
                                                   border
                                                   border-blue-600
                                                   text-white
                                                   text-sm
                                                   font-semibold">

                                            {{ $page }}

                                        </span>

                                    </li>

                                @else

                                    <li>

                                        <a
                                            href="{{ $products->url($page) }}"
                                            class="inline-flex
                                                   items-center
                                                   justify-center
                                                   w-8
                                                   h-8
                                                   rounded-md
                                                   border
                                                   border-slate-200
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


                            {{-- LAST PAGE --}}
                            @if ($end < $lastPage)

                                @if ($end < $lastPage - 1)

                                    <li>

                                        <span
                                            class="inline-flex
                                                   items-center
                                                   justify-center
                                                   w-8
                                                   h-8
                                                   text-slate-400
                                                   text-sm">

                                            &hellip;

                                        </span>

                                    </li>

                                @endif


                                <li>

                                    <a
                                        href="{{ $products->url($lastPage) }}"
                                        class="inline-flex
                                               items-center
                                               justify-center
                                               w-8
                                               h-8
                                               rounded-md
                                               border
                                               border-slate-200
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

                                    <a
                                        href="{{ $products->nextPageUrl() }}"
                                        class="inline-flex
                                               items-center
                                               justify-center
                                               w-8
                                               h-8
                                               rounded-md
                                               border
                                               border-slate-200
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
                                        class="inline-flex
                                               items-center
                                               justify-center
                                               w-8
                                               h-8
                                               rounded-md
                                               border
                                               border-slate-200
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

                {{-- NO PRODUCTS --}}
                <div
                    class="bg-white
                           rounded-xl
                           border
                           border-slate-200
                           text-center
                           py-16">

                    <h3 class="text-xl font-semibold text-slate-800">
                        No products found
                    </h3>

                    <p class="text-sm text-slate-500 mt-2">
                        No products are available for this brand.
                    </p>

                </div>

            @endif

        </div>

    </div>


</x-frontend-layout>
