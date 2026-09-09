<x-frontend-layout>

    <div class=" bg-gray-100 py-8">

        <div class="Container mx-auto ">

            <div class="flex gap-6">

                {{-- Sidebar --}}
                <x-user-dashboard.sidebar />

                {{-- Main Content --}}
                <main class="flex-1 min-w-0">

                    {{-- Page Header --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

                        <div class="flex items-center justify-between gap-4">

                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 rounded-xl bg-blue-50
                                            flex items-center justify-center">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor"
                                         class="w-6 h-6 text-[#2563EB]">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>

                                    </svg>

                                </div>

                                <div>

                                    <h1 class="text-2xl font-bold text-[#111827]">
                                        My Cart
                                    </h1>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Review your selected products before checkout.
                                    </p>

                                </div>

                            </div>


                            @if($cartItems->count() > 0)

                                <div class="hidden sm:flex items-center gap-2
                                            bg-blue-50 text-[#2563EB]
                                            px-4 py-2 rounded-xl
                                            font-semibold text-sm">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor"
                                         class="w-5 h-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>

                                    </svg>

                                    {{ $cartItems->count() }}
                                    {{ $cartItems->count() == 1 ? 'Item' : 'Items' }}

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- Cart Content --}}
                    @if($cartItems->count() > 0)

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                            {{-- ============================= --}}
                            {{-- CART ITEMS --}}
                            {{-- ============================= --}}
                            <div class="lg:col-span-2 space-y-4">

                                @foreach($cartItems as $item)

                                    @php

                                        $product = $item->product;

                                        $thumbnails = $product->thumbnails ?? [];

                                        $image = null;

                                        if (is_array($thumbnails) && !empty($thumbnails)) {

                                            $image = $thumbnails[0];

                                        } elseif (!empty($thumbnails)) {

                                            $image = $thumbnails;

                                        } elseif (!empty($product->image)) {

                                            $image = $product->image;

                                        }

                                        $unitPrice = $item->price ?? 0;

                                        $itemTotal = $unitPrice * $item->quantity;

                                        $stock = $product->stock ?? 0;

                                    @endphp


                                    <div class="bg-white rounded-2xl border border-gray-100
                                                shadow-sm p-5
                                                hover:shadow-md
                                                transition duration-300">

                                        <div class="flex flex-col sm:flex-row gap-5">


                                            {{-- Product Image --}}
                                            <div class="w-full sm:w-28 h-28
                                                        rounded-xl bg-gray-50
                                                        border border-gray-100
                                                        flex items-center justify-center
                                                        overflow-hidden flex-shrink-0">

                                                @if($image)

                                                    <img
                                                        src="{{ asset('storage/' . $image) }}"
                                                        alt="{{ $product->name }}"
                                                        class="w-full h-full object-contain p-3
                                                               hover:scale-105 transition duration-300"
                                                        onerror="this.src='{{ asset('images/default-product.png') }}'"
                                                    >

                                                @else

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke-width="1.5"
                                                         stroke="currentColor"
                                                         class="w-12 h-12 text-gray-300">

                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l2.159 2.159m-1.5 1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.409 2.409M3.75 19.5h16.5A1.5 1.5 0 0 0 21.75 18V6A1.5 1.5 0 0 0 20.25 4.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"/>

                                                    </svg>

                                                @endif

                                            </div>


                                            {{-- Product Details --}}
                                            <div class="flex-1 min-w-0">

                                                <div class="flex items-start justify-between gap-3">

                                                    <div class="min-w-0">

                                                        <h2 class="text-lg font-bold text-[#111827]
                                                                   truncate">

                                                            {{ $product->name ?? 'Product' }}

                                                        </h2>

                                                        {{-- Product Price --}}
                                                        <p class="text-[#2563EB] font-bold mt-1">

                                                            Rs. {{ number_format($unitPrice, 2) }}

                                                        </p>

                                                    </div>

                                                </div>


                                                {{-- Stock Status --}}
                                                <div class="mt-2">

                                                    @if($stock > 0)

                                                        <span class="inline-flex items-center gap-1.5
                                                                     text-xs font-semibold
                                                                     text-green-600">

                                                            <span class="w-2 h-2 rounded-full bg-green-500"></span>

                                                            In Stock

                                                        </span>

                                                    @else

                                                        <span class="inline-flex items-center gap-1.5
                                                                     text-xs font-semibold
                                                                     text-red-600">

                                                            <span class="w-2 h-2 rounded-full bg-red-500"></span>

                                                            Out of Stock

                                                        </span>

                                                    @endif

                                                </div>


                                                {{-- Quantity + Remove --}}
                                                <div class="flex flex-wrap items-center
                                                            justify-between gap-4 mt-4">


                                                    {{-- Quantity --}}
                                                    <div class="flex items-center gap-2">

                                                        <span class="text-sm text-gray-500 mr-1">
                                                            Quantity:
                                                        </span>


                                                        {{-- Decrease --}}
                                                        <form
                                                            action="{{ route('cart.update', $item->id) }}"
                                                            method="POST"
                                                        >

                                                            @csrf
                                                            @method('PATCH')

                                                            <input
                                                                type="hidden"
                                                                name="quantity"
                                                                value="{{ max(1, $item->quantity - 1) }}"
                                                            >

                                                            <button
                                                                type="submit"
                                                                {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                                                class="w-9 h-9 rounded-lg
                                                                       border border-gray-200
                                                                       flex items-center justify-center
                                                                       text-gray-700 font-bold
                                                                       hover:bg-blue-50
                                                                       hover:text-[#2563EB]
                                                                       hover:border-blue-200
                                                                       transition
                                                                       disabled:opacity-40
                                                                       disabled:cursor-not-allowed"
                                                            >
                                                                −
                                                            </button>

                                                        </form>


                                                        {{-- Quantity --}}
                                                        <div class="w-11 h-9 rounded-lg
                                                                    bg-gray-100
                                                                    flex items-center justify-center
                                                                    font-bold text-gray-800">

                                                            {{ $item->quantity }}

                                                        </div>


                                                        {{-- Increase --}}
                                                        <form
                                                            action="{{ route('cart.update', $item->id) }}"
                                                            method="POST"
                                                        >

                                                            @csrf
                                                            @method('PATCH')

                                                            <input
                                                                type="hidden"
                                                                name="quantity"
                                                                value="{{ $item->quantity + 1 }}"
                                                            >

                                                            <button
                                                                type="submit"
                                                                {{ $item->quantity >= $stock ? 'disabled' : '' }}
                                                                class="w-9 h-9 rounded-lg
                                                                       border border-gray-200
                                                                       flex items-center justify-center
                                                                       text-gray-700 font-bold
                                                                       hover:bg-blue-50
                                                                       hover:text-[#2563EB]
                                                                       hover:border-blue-200
                                                                       transition
                                                                       disabled:opacity-40
                                                                       disabled:cursor-not-allowed"
                                                            >
                                                                +
                                                            </button>

                                                        </form>

                                                    </div>


                                                    {{-- Remove --}}
                                                    <form
                                                        action="{{ route('cart.remove', $item->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to remove this product from your cart?');"
                                                    >

                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="inline-flex items-center gap-1.5
                                                                   text-sm font-semibold
                                                                   text-red-500
                                                                   hover:text-red-700
                                                                   transition"
                                                        >

                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 fill="none"
                                                                 viewBox="0 0 24 24"
                                                                 stroke-width="1.8"
                                                                 stroke="currentColor"
                                                                 class="w-4 h-4">

                                                                <path stroke-linecap="round"
                                                                      stroke-linejoin="round"
                                                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21.75H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12.132.562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.132 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0C7.91 2.613 7 3.597 7 4.777v.916m7.132 0a48.667 48.667 0 0 0-7.132 0"/>

                                                            </svg>

                                                            Remove

                                                        </button>

                                                    </form>

                                                </div>

                                            </div>


                                            {{-- Item Total --}}
                                            <div class="sm:w-32 flex sm:block
                                                        justify-between items-center
                                                        sm:text-right">

                                                <p class="text-sm text-gray-500">
                                                    Item Total
                                                </p>

                                                <p class="text-xl font-bold text-[#111827] mt-1">

                                                    Rs. {{ number_format($itemTotal, 2) }}

                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach


                                {{-- Continue Shopping --}}
                                <div class="pt-2">

                                    <a
                                        href="{{ route('home') }}"
                                        class="inline-flex items-center gap-2
                                               text-sm font-semibold
                                               text-[#2563EB]
                                               hover:text-blue-800
                                               transition"
                                    >

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke-width="1.8"
                                             stroke="currentColor"
                                             class="w-5 h-5">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>

                                        </svg>

                                        Continue Shopping

                                    </a>

                                </div>

                            </div>


                            {{-- ============================= --}}
                            {{-- ORDER SUMMARY --}}
                            {{-- ============================= --}}
                            <div class="lg:col-span-1">

                                <div class="bg-white rounded-2xl shadow-sm
                                            border border-gray-100
                                            p-6
                                            lg:sticky lg:top-6">

                                    <h2 class="text-lg font-bold text-[#111827]">
                                        Order Summary
                                    </h2>


                                    {{-- Items --}}
                                    <div class="flex justify-between items-center
                                                mt-5 text-sm">

                                        <span class="text-gray-500">
                                            Items
                                        </span>

                                        <span class="font-semibold text-gray-800">
                                            {{ $cartItems->count() }}
                                        </span>

                                    </div>


                                    {{-- Subtotal --}}
                                    <div class="flex justify-between items-center
                                                mt-3 text-sm">

                                        <span class="text-gray-500">
                                            Subtotal
                                        </span>

                                        <span class="font-semibold text-gray-800">
                                            Rs. {{ number_format($subtotal, 2) }}
                                        </span>

                                    </div>


                                    {{-- Delivery --}}
                                    <div class="flex justify-between items-center
                                                mt-3 text-sm">

                                        <span class="text-gray-500">
                                            Delivery
                                        </span>

                                        <span class="font-semibold text-green-600">
                                            Calculated at checkout
                                        </span>

                                    </div>


                                    {{-- Divider --}}
                                    <div class="border-t border-gray-200 my-5"></div>


                                    {{-- Total --}}
                                    <div class="flex justify-between items-end gap-3">

                                        <div>

                                            <p class="text-sm text-gray-500">
                                                Cart Total
                                            </p>

                                            <p class="text-xs text-gray-400 mt-1">
                                                Taxes & delivery may apply
                                            </p>

                                        </div>

                                        <p class="text-2xl font-bold text-[#2563EB]">

                                            Rs. {{ number_format($subtotal, 2) }}

                                        </p>

                                    </div>


                                    {{-- Checkout --}}
                                    <a
                                        href="{{ route('checkout') }}"
                                        class="mt-6 w-full
                                               inline-flex items-center justify-center gap-2
                                               px-6 py-3.5
                                               rounded-xl
                                               bg-[#2563EB]
                                               hover:bg-blue-700
                                               text-white
                                               font-bold
                                               shadow-sm
                                               hover:shadow-md
                                               transition duration-200"
                                    >

                                        Proceed to Checkout

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke-width="2"
                                             stroke="currentColor"
                                             class="w-5 h-5">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>

                                        </svg>

                                    </a>


                                    {{-- Secure Checkout --}}
                                    <div class="flex items-center justify-center gap-2
                                                mt-5 pt-5
                                                border-t border-gray-100">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke-width="1.6"
                                             stroke="currentColor"
                                             class="w-5 h-5 text-green-500">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75m-.75 0h10.5A1.5 1.5 0 0 1 18.75 12v6.75a1.5 1.5 0 0 1-1.5 1.5H6.75a1.5 1.5 0 0 1-1.5-1.5V12a1.5 1.5 0 0 1 1.5-1.5Z"/>

                                        </svg>

                                        <span class="text-xs text-gray-500">
                                            Secure checkout
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>


                    @else

                        {{-- ============================= --}}
                        {{-- EMPTY CART --}}
                        {{-- ============================= --}}
                        <div class="bg-white rounded-2xl shadow-sm
                                    border border-gray-100 p-8">

                            <div class="text-center py-16">

                                {{-- Icon --}}
                                <div class="w-24 h-24 mx-auto mb-6
                                            rounded-full bg-blue-50
                                            flex items-center justify-center">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="w-12 h-12 text-[#2563EB]">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>

                                    </svg>

                                </div>


                                <h2 class="text-2xl font-bold text-[#111827]">
                                    Your Cart is Empty
                                </h2>


                                <p class="text-gray-500 mt-2 max-w-md mx-auto">
                                    You haven't added anything to your cart yet.
                                    Browse our products and find something you'll love.
                                </p>


                                <a
                                    href="{{ route('home') }}"
                                    class="inline-flex items-center justify-center gap-2
                                           mt-7 px-7 py-3.5
                                           rounded-xl
                                           bg-[#2563EB]
                                           hover:bg-blue-700
                                           text-white
                                           font-semibold
                                           shadow-sm
                                           transition"
                                >

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor"
                                         class="w-5 h-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>

                                    </svg>

                                    Continue Shopping

                                </a>

                            </div>

                        </div>

                    @endif

                </main>

            </div>

        </div>

    </div>

</x-frontend-layout>
