<x-frontend-layout class="bg-[#eef7fd]">
 <div>
    @if (session('success'))
        <div class="Container mx-auto px-4 pt-5" x-data="{ show: true }" x-show="show" x-transition>
            <div
                class="flex items-center justify-between gap-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800 shadow-sm">
                <div class="flex items-center gap-3">

                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>

                    <span class="font-medium">
                        {{ session('success') }}
                    </span>

                </div>

                <button type="button" @click="show = false" class="text-green-600 hover:text-green-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif


    @if (session('error'))
        <div class="Container mx-auto px-4 pt-5" x-data="{ show: true }" x-show="show" x-transition>
            <div
                class="flex items-center justify-between gap-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-sm">
                <div class="flex items-center gap-3">

                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100">
                        <i class="fa-solid fa-circle-exclamation text-red-600"></i>
                    </div>

                    <span class="font-medium">
                        {{ session('error') }}
                    </span>

                </div>

                <button type="button" @click="show = false" class="text-red-600 hover:text-red-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>
        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- Validation Errors --}}
    {{-- ========================================================= --}}

    @if ($errors->any())

        <div class="Container mx-auto px-4 pt-5" x-data="{ show: true }" x-show="show" x-transition>

            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-sm">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <div class="flex items-center gap-2 font-semibold mb-2">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            Please check the following:
                        </div>

                        <ul class="list-disc ml-6 text-sm space-y-1">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                    <button type="button" @click="show = false" class="text-red-600 hover:text-red-800">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                </div>

            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- Main Container --}}
    {{-- ========================================================= --}}

    <div class="Container mx-auto px-4">

        @php

            $category = $product->category;

            $ancestors = $category ? $category->getAncestors() : collect();

            $images = $product->thumbnails ?? [];

            $mainImage = $images[0] ?? null;

            /*
            |--------------------------------------------------------------------------
            | Product Price
            |--------------------------------------------------------------------------
            */

            $originalPrice = (float) ($product->price ?? 0);

            $discountPrice =
                $product->discount_price !== null && (float) $product->discount_price > 0
                    ? (float) $product->discount_price
                    : null;

            /*
            |--------------------------------------------------------------------------
            | Discount Percentage
            |--------------------------------------------------------------------------
            */

            $discountPercent = 0;

            if ($discountPrice !== null && $originalPrice > 0 && $discountPrice < $originalPrice) {
                $discountPercent = round((1 - $discountPrice / $originalPrice) * 100);
            }

            /*
            |--------------------------------------------------------------------------
            | Final Product Price
            |--------------------------------------------------------------------------
            */

            $finalPrice = $discountPrice !== null && $discountPrice < $originalPrice ? $discountPrice : $originalPrice;
            $productStock = (int) ($product->stock ?? 0);
        @endphp


        {{-- ========================================================= --}}
        {{-- Breadcrumb --}}
        {{-- ========================================================= --}}

        <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500 mb-6 mt-6">

            <a href="{{ route('home') }}" class="hover:text-blue-600 transition">
                Home
            </a>


            @foreach ($ancestors as $ancestor)
                <span>/</span>

                <a href="{{ route('category.show', ['slug' => $ancestor->slug]) }}"
                    class="hover:text-blue-600 transition">
                    {{ $ancestor->name }}
                </a>
            @endforeach


            @if ($category)
                <span>/</span>

                <a href="{{ route('category.show', ['slug' => $category->slug]) }}"
                    class="hover:text-blue-600 transition">
                    {{ $category->name }}
                </a>
            @endif


            <span>/</span>

            <span class="text-gray-800 font-medium">
                {{ $product->name }}
            </span>

        </nav>



        {{-- ========================================================= --}}
        {{-- Main Product Card --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-10">


                {{-- ================================================= --}}
                {{-- Product Images --}}
                {{-- ================================================= --}}

                <div>

                    {{-- Main Image --}}

                    <div
                        class="bg-gray-50 rounded-xl p-4 flex items-center justify-center min-h-[300px] border border-gray-200">

                        @if ($mainImage)
                            <img id="mainProductImage" src="{{ asset('storage/' . $mainImage) }}"
                                alt="{{ $product->name }}"
                                class="max-h-[400px] w-auto object-contain transition duration-300">
                        @else
                            <div class="text-gray-400 text-sm">
                                No image available
                            </div>
                        @endif

                    </div>


                    {{-- Thumbnails --}}

                    @if (count($images) > 1)

                        <div class="flex gap-3 mt-4 overflow-x-auto pb-2">

                            @foreach ($images as $index => $image)
                                <button type="button"
                                    onclick="changeProductImage(
                                        @js(asset('storage/' . $image)),
                                        this
                                    )"
                                    class="
                                        thumb-btn
                                        flex-shrink-0
                                        w-16
                                        h-16
                                        rounded-lg
                                        border-2
                                        {{ $index === 0 ? 'border-blue-500' : 'border-gray-200' }}
                                        hover:border-blue-500
                                        transition
                                        focus:outline-none
                                        focus:ring-2
                                        focus:ring-blue-400
                                    ">

                                    <img src="{{ asset('storage/' . $image) }}" alt="Thumbnail {{ $index + 1 }}"
                                        class="w-full h-full object-cover rounded-lg">

                                </button>
                            @endforeach

                        </div>

                    @endif

                </div>



                {{-- ================================================= --}}
                {{-- Product Details --}}
                {{-- ================================================= --}}

                <div>

                    {{-- Product Name --}}

                    <h1 class="text-2xl md:text-3xl font-bold border-blue-500' ">
                        {{ $product->name }}
                    </h1>



                    {{-- Brand / Category / SKU --}}

                    <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-gray-500">

                        {{-- Brand --}}

                        @if ($product->brand)
                            <span class="flex items-center">

                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />

                                </svg>

                                {{ $product->brand->name }}

                            </span>
                        @endif



                        {{-- Category --}}

                        @if ($product->category)
                            <span class="flex items-center">

                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />

                                </svg>

                                <a href="{{ route('category.show', ['slug' => $product->category->slug]) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $product->category->name }}
                                </a>

                            </span>
                        @endif



                        {{-- SKU --}}

                        @if ($product->sku)
                            <span class="flex items-center">

                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a3 3 0 006 0M9 5a2 2 0 012-2h2a2 2 0 012 2" />

                                </svg>

                                SKU: {{ $product->sku }}

                            </span>
                        @endif

                    </div>



                    {{-- ================================================= --}}
                    {{-- Price --}}
                    {{-- ================================================= --}}

                    <div class="mt-5">

                        @if ($discountPrice !== null && $discountPrice < $originalPrice)

                            <span class="text-3xl font-bold text-gray-900">
                                Rs.
                                {{ number_format($discountPrice, 2) }}
                            </span>


                            <span class="ml-3 text-lg text-gray-400 line-through">
                                Rs.
                                {{ number_format($originalPrice, 2) }}
                            </span>


                            @if ($discountPercent > 0)
                                <span
                                    class="ml-2 inline-block bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded-full">
                                    -{{ $discountPercent }}%
                                </span>
                            @endif
                        @else
                            <span class="text-3xl font-bold text-gray-900">
                                Rs.
                                {{ number_format($originalPrice, 2) }}
                            </span>

                        @endif

                    </div>



                    {{-- ================================================= --}}
                    {{-- Stock --}}
                    {{-- ================================================= --}}

                    <div class="mt-4">

                        @if ($productStock > 0)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-medium">

                                <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>

                                In Stock ({{ $productStock }})

                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-medium">

                                <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>

                                Out of Stock

                            </span>
                        @endif

                    </div>

                    {{-- Quantity + Actions --}}
                    @if($product->stock > 0)

                        <form method="POST" action="{{ route('cart.add', $product->id) }}">
                            @csrf

                            <div class="mt-6 flex flex-wrap items-center gap-4">

                                {{-- Quantity --}}
                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">

                                    <button
                                        type="button"
                                        onclick="changeQty(-1)"
                                        class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition focus:outline-none">
                                        −
                                    </button>

                                    <input
                                        type="number"
                                        id="quantity"
                                        name="quantity"
                                        value="1"
                                        min="1"
                                        max="{{ $product->stock }}"
                                        class="w-14 text-center border-0 focus:ring-0 focus:outline-none text-gray-700 font-medium">

                                    <button
                                        type="button"
                                        onclick="changeQty(1)"
                                        class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition focus:outline-none">
                                        +
                                    </button>

                                </div>

                                {{-- Add to Cart --}}
                                <button
                                    type="submit"
                                    class="flex-1 min-w-[180px] py-3 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white font-semibold transition">

                                    Add to Cart

                                </button>

                            </div>

                        </form>

                        {{-- Buy Now --}}
                        <button
                            type="button"
                            onclick="buyNow({{ $product->id }})"
                            class="mt-3 w-full px-6 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition shadow-sm">

                            Buy Now

                        </button>

                        {{-- Wishlist --}}
                        <div class="mt-4">

                            <button
                                type="button"
                                onclick="addToWishlist({{ $product->id }})"
                                class="text-sm text-gray-500 hover:text-red-500 transition flex items-center gap-1">

                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>

                                </svg>

                                Add to Wishlist

                            </button>

                        </div>

                    @endif



            {{-- ========================================================= --}}
            {{-- Description / Reviews / Shipping --}}
            {{-- ========================================================= --}}

            <div class="border-t border-gray-100 p-6 md:p-10" x-data="{ activeTab: 'description' }">

                {{-- Tabs --}}

                <div class="flex flex-wrap border-b border-gray-200">

                    <button type="button" @click="activeTab = 'description'"
                        :class="activeTab === 'description'
                            ?
                            'border-b-2 border-blue-600 text-blue-600' :
                            'text-gray-500'"
                        class="px-4 py-2 text-sm font-medium hover:text-gray-700 transition focus:outline-none">
                        Description
                    </button>


                    <button type="button" @click="activeTab = 'reviews'"
                        :class="activeTab === 'reviews'
                            ?
                            'border-b-2 border-blue-600 text-blue-600' :
                            'text-gray-500'"
                        class="px-4 py-2 text-sm font-medium hover:text-gray-700 transition focus:outline-none">
                        Reviews ({{ $product->reviews_count ?? 0 }})
                    </button>


                    <button type="button" @click="activeTab = 'shipping'"
                        :class="activeTab === 'shipping'
                            ?
                            'border-b-2 border-blue-600 text-blue-600' :
                            'text-gray-500'"
                        class="px-4 py-2 text-sm font-medium hover:text-gray-700 transition focus:outline-none">
                        Shipping
                    </button>

                </div>



                {{-- Tab Content --}}

                <div class="mt-6">

                    {{-- Description --}}

                    <div x-show="activeTab === 'description'" x-transition>

                        @if ($product->description)
                            <div class="text-gray-600 leading-7 whitespace-pre-line">
                                {{ $product->description }}
                            </div>
                        @else
                            <p class="text-gray-400">
                                No description provided.
                            </p>
                        @endif

                    </div>



                    {{-- Reviews --}}

                    <div x-show="activeTab === 'reviews'" x-transition>

                        <p class="text-gray-500">
                            Reviews will appear here.
                        </p>

                    </div>



                    {{-- Shipping --}}

                    <div x-show="activeTab === 'shipping'" x-transition>

                        <p class="text-gray-500">
                            Shipping information will be displayed here.
                        </p>

                    </div>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- Related Products --}}
        {{-- ========================================================= --}}

        @if (isset($relatedProducts) && $relatedProducts->count())

            <div class="mt-12 mb-12">

                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    You may also like
                </h2>


                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">

                    @foreach ($relatedProducts as $related)
                        @php

                            $relatedOriginalPrice = (float) ($related->price ?? 0);

                            $relatedDiscountPrice =
                                $related->discount_price !== null ? (float) $related->discount_price : null;

                            $relatedDiscount = 0;

                            if (
                                $relatedDiscountPrice !== null &&
                                $relatedOriginalPrice > 0 &&
                                $relatedDiscountPrice < $relatedOriginalPrice
                            ) {
                                $relatedDiscount = round((1 - $relatedDiscountPrice / $relatedOriginalPrice) * 100);
                            }

                            $relatedFinalPrice =
                                $relatedDiscountPrice !== null && $relatedDiscountPrice < $relatedOriginalPrice
                                    ? $relatedDiscountPrice
                                    : $relatedOriginalPrice;
                        @endphp


                        <div
                            class="
                                group
                                bg-white
                                rounded-2xl
                                overflow-hidden
                                border
                                border-gray-100
                                shadow-sm
                                hover:shadow-xl
                                transition-all
                                duration-300
                                hover:-translate-y-1
                                flex
                                flex-col
                            ">

                            {{-- Product Image --}}

                            <a href="{{ route('product.show', ['slug' => $related->slug]) }}"
                                class="block relative bg-gray-50 aspect-square overflow-hidden">

                                @if (!empty($related->thumbnails))
                                    <img src="{{ asset('storage/' . $related->thumbnails[0]) }}"
                                        alt="{{ $related->name }}"
                                        class="
                                            w-full
                                            h-full
                                            object-contain
                                            p-4
                                            group-hover:scale-110
                                            transition
                                            duration-500
                                        ">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 text-sm">
                                        No image
                                    </div>
                                @endif


                                {{-- Discount Badge --}}

                                @if ($relatedDiscount > 0)
                                    <span
                                        class="
                                            absolute
                                            top-3
                                            left-3
                                            bg-red-500
                                            text-white
                                            text-xs
                                            font-bold
                                            px-2.5
                                            py-1
                                            rounded-full
                                        ">
                                        -{{ $relatedDiscount }}%
                                    </span>
                                @endif

                            </a>



                            {{-- Product Info --}}

                            <div class="p-4 flex flex-col flex-1">

                                {{-- Category --}}

                                @if ($related->category)
                                    <p class="text-xs text-blue-600 font-semibold mb-1">
                                        {{ $related->category->name }}
                                    </p>
                                @endif



                                {{-- Product Name --}}

                                <a href="{{ route('product.show', ['slug' => $related->slug]) }}"
                                    class="
                                        text-sm
                                        font-bold
                                        text-gray-800
                                        leading-snug
                                        mb-2
                                        line-clamp-2
                                        group-hover:text-blue-600
                                        transition
                                    ">
                                    {{ $related->name }}
                                </a>



                                {{-- Price --}}

                                <div class="flex items-center gap-2 mb-4">

                                    @if ($relatedDiscountPrice !== null && $relatedDiscountPrice < $relatedOriginalPrice)
                                        <span class="text-xl font-bold text-gray-900">
                                            Rs.
                                            {{ number_format($relatedFinalPrice, 2) }}
                                        </span>

                                        <span class="text-sm text-gray-400 line-through">
                                            Rs.
                                            {{ number_format($relatedOriginalPrice, 2) }}
                                        </span>
                                    @else
                                        <span class="text-xl font-bold text-gray-900">
                                            Rs.
                                            {{ number_format($relatedOriginalPrice, 2) }}
                                        </span>
                                    @endif

                                </div>



                                {{-- View + Add --}}

                                <div class="flex items-center gap-2 mt-auto">

                                    {{-- View Product --}}

                                    <a href="{{ route('product.show', ['slug' => $related->slug]) }}"
                                        class="
                                            flex-1
                                            text-center
                                            bg-gray-900
                                            hover:bg-blue-600
                                            text-white
                                            py-2
                                            rounded-xl
                                            text-sm
                                            font-semibold
                                            transition
                                        ">
                                        View Product
                                    </a>



                                    {{-- Add To Cart --}}
                                    {{-- No variant selection at this level, so
                                         variant_id is simply omitted -> NULL. --}}

                                    @if ((int) $related->stock > 0)
                                        <form action="{{ route('cart.add') }}" method="POST" class="flex-1">

                                            @csrf

                                            <input type="hidden" name="product_id" value="{{ $related->id }}">

                                            <input type="hidden" name="quantity" value="1">


                                            <button type="submit"
                                                class="
                                                    w-full
                                                    bg-blue-600
                                                    hover:bg-blue-700
                                                    text-white
                                                    py-2
                                                    rounded-xl
                                                    text-sm
                                                    font-semibold
                                                    transition
                                                    flex
                                                    items-center
                                                    justify-center
                                                    gap-1
                                                ">

                                                <i class="fa-solid fa-cart-plus"></i>

                                                Add

                                            </button>

                                        </form>
                                    @else
                                        <button type="button" disabled
                                            class="
                                                flex-1
                                                bg-gray-300
                                                text-gray-500
                                                py-2
                                                rounded-xl
                                                text-sm
                                                font-semibold
                                                cursor-not-allowed
                                                flex
                                                items-center
                                                justify-center
                                                gap-1
                                            ">

                                            <i class="fa-solid fa-cart-plus"></i>

                                            Out

                                        </button>
                                    @endif

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

        @endif

    </div>



    {{-- ========================================================= --}}
    {{-- JavaScript --}}
    {{-- ========================================================= --}}

    <script>
        /*
            |--------------------------------------------------------------------------
            | Change Main Product Image
            |--------------------------------------------------------------------------
            */

        function changeProductImage(src, btn) {

            const mainImage =
                document.getElementById('mainProductImage');

            if (mainImage) {
                mainImage.src = src;
            }


            document
                .querySelectorAll('.thumb-btn')
                .forEach(function(element) {

                    element.classList.remove(
                        'border-blue-500'
                    );

                    element.classList.add(
                        'border-gray-200'
                    );

                });


            if (btn) {

                btn.classList.remove(
                    'border-gray-200'
                );

                btn.classList.add(
                    'border-blue-500'
                );

            }

        }



        /*
        |--------------------------------------------------------------------------
        | Change Quantity
        |--------------------------------------------------------------------------
        */

        function changeQty(delta) {

            const input =
                document.getElementById('quantity');

            if (!input) {
                return;
            }


            let value =
                parseInt(input.value) || 1;


            const min =
                parseInt(input.min) || 1;


            const max =
                parseInt(input.max) || 10;


            value += delta;


            if (value < min) {
                value = min;
            }


            if (value > max) {
                value = max;
            }


            input.value = value;


            syncCartQuantity();

        }



        /*
        |--------------------------------------------------------------------------
        | Sync Quantity To Both Forms
        |--------------------------------------------------------------------------
        */

        function syncCartQuantity() {

            const quantityInput =
                document.getElementById('quantity');

            if (!quantityInput) {
                return;
            }


            let quantity =
                parseInt(quantityInput.value) || 1;


            const min =
                parseInt(quantityInput.min) || 1;


            const max =
                parseInt(quantityInput.max) || 10;


            if (quantity < min) {
                quantity = min;
            }


            if (quantity > max) {
                quantity = max;
            }


            quantityInput.value = quantity;


            const cartQuantity =
                document.getElementById('cartQuantity');


            const buyNowQuantity =
                document.getElementById('buyNowQuantity');


            if (cartQuantity) {
                cartQuantity.value = quantity;
            }


            if (buyNowQuantity) {
                buyNowQuantity.value = quantity;
            }

        }

        function buyNowSubmit() {

            syncCartQuantity();

            return true;

        }

        function addToWishlist(productId) {

            alert(
                'Wishlist functionality will be connected soon.'
            );

        }


        document.addEventListener(
            'DOMContentLoaded',
            function() {

                syncCartQuantity();

            }
        );
    </script>


 </div>

</x-frontend-layout>
