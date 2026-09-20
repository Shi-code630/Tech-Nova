<x-frontend-layout
    title="Search | TechNova Nepal"
    description="Search laptops, gadgets and accessories at TechNova Nepal."
    robots="noindex,follow"
    :canonical="route('search')"
>
    {{-- =========================================================
        SEARCH RESULTS PAGE
    ========================================================== --}}
    <div class="min-h-screen bg-[#ebf4fa]">

        <div class="Container mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">


            {{-- =================================================
                PAGE HEADER
            ================================================== --}}
            <div class="mb-8">

                <div class="bg-white rounded-2xl border border-blue-100
                            shadow-sm px-5 py-5 md:px-7 md:py-6">

                    <div class="flex flex-col md:flex-row
                                md:items-center
                                md:justify-between
                                gap-4">

                        {{-- Heading --}}
                        <div>

                            <div class="flex items-center gap-2 mb-1">

                                <span class="w-1 h-7 bg-blue-600 rounded-full"></span>

                                <h1 class="text-2xl md:text-3xl
                                           font-bold
                                           text-gray-800">

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

                            <div class="flex items-center gap-2
                                        bg-[#ebf4fa]
                                        border border-blue-100
                                        px-4 py-2
                                        rounded-full
                                        w-fit">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 text-blue-600"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7
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

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4
                            gap-4 md:gap-5 lg:gap-6">

                    @foreach ($products as $product)

                        @php

                            $originalPrice = (float) ($product->price ?? 0);

                            $discountPrice =
                                $product->discount_price !== null
                                    ? (float) $product->discount_price
                                    : null;

                            $discountPercent = 0;

                            if (
                                $discountPrice !== null &&
                                $originalPrice > 0 &&
                                $discountPrice < $originalPrice
                            ) {
                                $discountPercent = round(
                                    (1 - $discountPrice / $originalPrice) * 100
                                );
                            }

                            $finalPrice =
                                $discountPrice !== null &&
                                $discountPrice < $originalPrice
                                    ? $discountPrice
                                    : $originalPrice;

                        @endphp


                        {{-- =================================================
                            PRODUCT CARD
                        ================================================== --}}
                        <div class="group
                                    bg-white
                                    rounded-2xl
                                    overflow-hidden
                                    border border-gray-100
                                    shadow-sm
                                    hover:shadow-xl
                                    hover:border-blue-100
                                    transition-all duration-300
                                    hover:-translate-y-1
                                    flex flex-col">


                            {{-- =================================================
                                PRODUCT IMAGE
                            ================================================== --}}
                            <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                class="block relative
                                       bg-gradient-to-br
                                       from-gray-50
                                       to-[#f5faff]
                                       aspect-square
                                       overflow-hidden">


                                {{-- Image --}}
                                @if (!empty($product->thumbnails))

                                    <img src="{{ asset('storage/' . $product->thumbnails[0]) }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full
                                               object-contain
                                               p-4 md:p-6
                                               group-hover:scale-110
                                               transition-transform
                                               duration-500">

                                @else

                                    <div class="w-full h-full
                                                flex flex-col
                                                items-center
                                                justify-center
                                                text-gray-300">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-12 h-12 mb-2"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M3 16l5-5
                                                   a2 2 0 012.828 0L16 16
                                                   m-2-2l1.5-1.5
                                                   a2 2 0 012.828 0L21 16
                                                   M5 20h14
                                                   a2 2 0 002-2V6
                                                   a2 2 0 00-2-2H5
                                                   a2 2 0 00-2 2v12
                                                   a2 2 0 002 2z" />

                                        </svg>

                                        <span class="text-sm">
                                            No image
                                        </span>

                                    </div>

                                @endif



                                {{-- =================================================
                                    DISCOUNT BADGE
                                ================================================== --}}
                                @if ($discountPercent > 0)

                                    <span class="absolute top-3 left-3
                                                 bg-red-500
                                                 text-white
                                                 text-[11px]
                                                 md:text-xs
                                                 font-bold
                                                 px-2.5 py-1
                                                 rounded-full
                                                 shadow-md">

                                        -{{ $discountPercent }}%

                                    </span>

                                @endif



                                {{-- Quick View Overlay --}}
                                <div class="absolute inset-0
                                            bg-blue-900/0
                                            group-hover:bg-blue-900/5
                                            transition-all duration-300">
                                </div>

                            </a>



                            {{-- =================================================
                                PRODUCT INFORMATION
                            ================================================== --}}
                            <div class="p-3.5 md:p-4
                                        flex flex-col
                                        flex-1">


                                {{-- Category --}}
                                @if ($product->category)

                                    <p class="text-[11px] md:text-xs
                                              text-blue-600
                                              font-semibold
                                              uppercase
                                              tracking-wide
                                              mb-1.5">

                                        {{ $product->category->name }}

                                    </p>

                                @endif



                                {{-- Product Name --}}
                                <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                    class="text-sm md:text-base
                                           font-bold
                                           text-gray-800
                                           leading-snug
                                           mb-2
                                           line-clamp-2
                                           group-hover:text-blue-600
                                           transition-colors duration-200">

                                    {{ $product->name }}

                                </a>



                                {{-- =================================================
                                    PRICE
                                ================================================== --}}
                                <div class="flex flex-wrap items-center
                                            gap-x-2
                                            gap-y-1
                                            mb-4">

                                    @if (
                                        $discountPrice !== null &&
                                        $discountPrice < $originalPrice
                                    )

                                        <span class="text-lg md:text-xl
                                                     font-extrabold
                                                     text-gray-900">

                                            Rs. {{ number_format($finalPrice, 2) }}

                                        </span>

                                        <span class="text-xs md:text-sm
                                                     text-gray-400
                                                     line-through">

                                            Rs. {{ number_format($originalPrice, 2) }}

                                        </span>

                                    @else

                                        <span class="text-lg md:text-xl
                                                     font-extrabold
                                                     text-gray-900">

                                            Rs. {{ number_format($originalPrice, 2) }}

                                        </span>

                                    @endif

                                </div>



                                {{-- =================================================
                                    BUTTONS
                                ================================================== --}}
                                <div class="flex items-center gap-2 mt-auto">


                                    {{-- View Product --}}
                                    <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                        class="flex-1
                                               text-center
                                               bg-gray-900
                                               hover:bg-blue-600
                                               text-white
                                               py-2
                                               rounded-xl
                                               text-xs md:text-sm
                                               font-semibold
                                               transition-all duration-200
                                               hover:shadow-md">

                                        View

                                    </a>



                                    {{-- Add To Cart --}}
                                    @if ((int) $product->stock > 0)

                                        <form action="{{ route('cart.add', $product->id) }}"
                                            method="POST"
                                            class="flex-1">

                                            @csrf

                                            <input type="hidden"
                                                name="quantity"
                                                value="1">

                                            <button type="submit"
                                                class="w-full
                                                       bg-blue-600
                                                       hover:bg-blue-700
                                                       text-white
                                                       py-2
                                                       rounded-xl
                                                       text-xs md:text-sm
                                                       font-semibold
                                                       transition-all duration-200
                                                       hover:shadow-md
                                                       flex items-center
                                                       justify-center
                                                       gap-1.5">

                                                <i class="fa-solid fa-cart-plus"></i>

                                                <span>Add</span>

                                            </button>

                                        </form>

                                    @else

                                        <button type="button"
                                            disabled
                                            class="flex-1
                                                   bg-gray-200
                                                   text-gray-400
                                                   py-2
                                                   rounded-xl
                                                   text-xs md:text-sm
                                                   font-semibold
                                                   cursor-not-allowed
                                                   flex items-center
                                                   justify-center
                                                   gap-1.5">

                                            <i class="fa-solid fa-cart-plus"></i>

                                            <span>Out</span>

                                        </button>

                                    @endif

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>



                {{-- =================================================
                    PAGINATION
                ================================================== --}}
                <div class="mt-10
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
                <div class="min-h-[450px]
                            flex items-center
                            justify-center">

                    <div class="w-full max-w-lg
                                bg-white
                                rounded-3xl
                                border border-blue-100
                                shadow-lg
                                px-6 py-12
                                text-center">


                        {{-- Icon --}}
                        <div class="mx-auto mb-5
                                    w-20 h-20
                                    rounded-full
                                    bg-[#ebf4fa]
                                    flex items-center
                                    justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-10 h-10 text-blue-500"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M21 21l-4.35-4.35
                                       m2.35-5.65
                                       a7.5 7.5 0 11-15 0
                                       7.5 7.5 0 0115 0z" />

                            </svg>

                        </div>



                        {{-- Title --}}
                        <h3 class="text-2xl
                                   font-bold
                                   text-gray-800
                                   mb-2">

                            No Products Found

                        </h3>



                        {{-- Description --}}
                        <p class="text-gray-500
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

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 12h18
                                       m-9-9l-9 9 9 9" />

                            </svg>

                            Back to Home

                        </a>

                    </div>

                </div>

            @endif

        </div>

    </div>

</x-frontend-layout>
