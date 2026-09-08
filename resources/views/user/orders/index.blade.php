<x-frontend-layout>

    <div class="bg-gray-100 min-h-screen py-8">

        <div class="Container mx-auto flex gap-6 items-start">

            {{-- Dashboard Sidebar --}}
            <x-user-dashboard.sidebar />

            {{-- Main Content --}}
            <main class="flex-1 min-w-0">

                <div class="bg-white rounded-3xl shadow-sm p-6">

                    {{-- Page Header --}}
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-[#111827]">
                            My Orders
                        </h1>

                        <p class="text-sm text-gray-500 mt-1">
                            View and manage your orders
                        </p>
                    </div>


                    @if($orders->count())

                        <div class="space-y-6">

                            @foreach($orders as $order)

                                {{-- ========================================= --}}
                                {{-- ORDER CARD --}}
                                {{-- ========================================= --}}

                                <div class="border border-gray-200 rounded-2xl overflow-hidden
                                            hover:shadow-md transition bg-white">


                                    {{-- =============================== --}}
                                    {{-- ORDER HEADER --}}
                                    {{-- =============================== --}}

                                    <div class="bg-gray-50 px-5 py-4
                                                border-b border-gray-200">

                                        <div class="flex flex-col lg:flex-row
                                                    lg:items-center
                                                    lg:justify-between gap-4">

                                            {{-- Order Information --}}
                                            <div class="flex flex-wrap items-center gap-x-6 gap-y-2">

                                                <div>
                                                    <p class="text-xs text-gray-500 uppercase">
                                                        Order ID
                                                    </p>

                                                    <p class="font-bold text-[#111827]">
                                                        #{{ $order->order_number ?? $order->id }}
                                                    </p>
                                                </div>


                                                <div>
                                                    <p class="text-xs text-gray-500 uppercase">
                                                        Order Date
                                                    </p>

                                                    <p class="font-medium text-gray-700">
                                                        {{ $order->created_at->format('M d, Y') }}
                                                    </p>
                                                </div>


                                                @if($order->payment_method)
                                                    <div>
                                                        <p class="text-xs text-gray-500 uppercase">
                                                            Payment
                                                        </p>

                                                        <p class="font-medium text-gray-700">
                                                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                                        </p>
                                                    </div>
                                                @endif

                                            </div>


                                            {{-- Status --}}
                                            <div>

                                                @php
                                                    $status = strtolower($order->order_status ?? $order->status ?? 'pending');

                                                    $statusClasses = match($status) {
                                                        'delivered', 'completed' =>
                                                            'bg-green-100 text-green-700',

                                                        'shipped', 'out_for_delivery' =>
                                                            'bg-blue-100 text-blue-700',

                                                        'processing', 'confirmed' =>
                                                            'bg-yellow-100 text-yellow-700',

                                                        'cancelled', 'canceled' =>
                                                            'bg-red-100 text-red-700',

                                                        'returned', 'refunded' =>
                                                            'bg-purple-100 text-purple-700',

                                                        default =>
                                                            'bg-gray-100 text-gray-700',
                                                    };

                                                    $statusText = match($status) {
                                                        'out_for_delivery' => 'Out for Delivery',
                                                        'completed' => 'Completed',
                                                        'cancelled', 'canceled' => 'Cancelled',
                                                        default => ucfirst(str_replace('_', ' ', $status)),
                                                    };
                                                @endphp

                                                <span class="inline-flex items-center gap-2
                                                             px-3 py-1.5 rounded-full
                                                             text-xs font-semibold
                                                             {{ $statusClasses }}">

                                                    <span class="w-2 h-2 rounded-full bg-current"></span>

                                                    {{ $statusText }}

                                                </span>

                                            </div>

                                        </div>

                                    </div>



                                    {{-- =============================== --}}
                                    {{-- PRODUCTS --}}
                                    {{-- =============================== --}}

                                    <div class="divide-y divide-gray-100">

                                        @forelse($order->items as $item)

                                            @php

                                                $product = $item->product;

                                                $variant = $item->variant;

                                                /*
                                                 * Product image
                                                 */
                                                $productImage = null;

                                                if ($product && !empty($product->thumbnails)) {

                                                    $productImage = is_array($product->thumbnails)
                                                        ? ($product->thumbnails[0] ?? null)
                                                        : $product->thumbnails;

                                                }

                                                /*
                                                 * Variant information
                                                 */
                                                $variantColor = $variant->color ?? null;
                                                $variantSize = $variant->size ?? null;

                                                /*
                                                 * Price
                                                 */
                                                $salePrice = $item->price ?? 0;

                                                $originalPrice = $product->price ?? $salePrice;

                                                /*
                                                 * Discount
                                                 */
                                                $discountAmount = max(
                                                    0,
                                                    $originalPrice - $salePrice
                                                );

                                                $discountPercent = $originalPrice > 0
                                                    ? round(($discountAmount / $originalPrice) * 100)
                                                    : 0;

                                                /*
                                                 * Quantity
                                                 */
                                                $quantity = $item->quantity ?? 1;

                                                /*
                                                 * Total
                                                 */
                                                $itemTotal = $item->total
                                                    ?? ($salePrice * $quantity);

                                            @endphp


                                            <div class="p-5">

                                                <div class="flex flex-col sm:flex-row gap-4">


                                                    {{-- ================= --}}
                                                    {{-- PRODUCT IMAGE --}}
                                                    {{-- ================= --}}

                                                    <div class="flex-shrink-0">

                                                        <div class="w-24 h-24 rounded-xl
                                                                    bg-gray-100 border
                                                                    border-gray-200
                                                                    overflow-hidden">

                                                            @if($productImage)

                                                                <img
                                                                    src="{{ asset('storage/' . $productImage) }}"
                                                                    alt="{{ $product->name ?? 'Product' }}"
                                                                    class="w-full h-full object-cover"
                                                                >

                                                            @else

                                                                <div class="w-full h-full
                                                                            flex items-center
                                                                            justify-center
                                                                            text-gray-400">

                                                                    <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        class="w-10 h-10"
                                                                        fill="none"
                                                                        viewBox="0 0 24 24"
                                                                        stroke="currentColor">

                                                                        <path
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            stroke-width="1.5"
                                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"
                                                                        />

                                                                    </svg>

                                                                </div>

                                                            @endif

                                                        </div>

                                                    </div>



                                                    {{-- ================= --}}
                                                    {{-- PRODUCT DETAILS --}}
                                                    {{-- ================= --}}

                                                    <div class="flex-1 min-w-0">

                                                        <div class="flex flex-col lg:flex-row
                                                                    lg:justify-between gap-4">


                                                            {{-- Product Info --}}
                                                            <div class="min-w-0">

                                                                <h3 class="font-semibold text-[#111827]
                                                                           text-base leading-6">

                                                                    {{ $product->name ?? 'Product Unavailable' }}

                                                                </h3>


                                                                {{-- Variant --}}
                                                                @if($variantColor || $variantSize)

                                                                    <div class="flex flex-wrap
                                                                                items-center gap-3
                                                                                mt-2 text-sm">

                                                                        @if($variantColor)

                                                                            <span class="inline-flex
                                                                                         items-center gap-1.5
                                                                                         text-gray-600">

                                                                                <span class="font-medium">
                                                                                    Color:
                                                                                </span>

                                                                                <span>
                                                                                    {{ $variantColor }}
                                                                                </span>

                                                                            </span>

                                                                        @endif


                                                                        @if($variantSize)

                                                                            <span class="text-gray-300">
                                                                                |
                                                                            </span>

                                                                            <span class="inline-flex
                                                                                         items-center gap-1.5
                                                                                         text-gray-600">

                                                                                <span class="font-medium">
                                                                                    Size:
                                                                                </span>

                                                                                <span>
                                                                                    {{ $variantSize }}
                                                                                </span>

                                                                            </span>

                                                                        @endif

                                                                    </div>

                                                                @endif



                                                                {{-- Quantity --}}
                                                                <p class="text-sm text-gray-500 mt-2">

                                                                    Quantity:
                                                                    <span class="font-medium text-gray-700">
                                                                        {{ $quantity }}
                                                                    </span>

                                                                </p>

                                                            </div>



                                                            {{-- ================= --}}
                                                            {{-- PRICE --}}
                                                            {{-- ================= --}}

                                                            <div class="lg:text-right flex-shrink-0">

                                                                <div class="flex lg:justify-end
                                                                            items-center gap-2">

                                                                    <span class="font-bold
                                                                                 text-[#111827] text-lg">

                                                                        Rs {{ number_format($salePrice) }}

                                                                    </span>


                                                                    @if($discountAmount > 0)

                                                                        <span class="text-sm
                                                                                     text-gray-400
                                                                                     line-through">

                                                                            Rs {{ number_format($originalPrice) }}

                                                                        </span>

                                                                    @endif

                                                                </div>


                                                                @if($discountAmount > 0)

                                                                    <div class="mt-1">

                                                                        <span class="text-xs
                                                                                     font-semibold
                                                                                     text-green-600">

                                                                            {{ $discountPercent }}% OFF

                                                                        </span>

                                                                        <span class="text-xs
                                                                                     text-gray-500 ml-1">

                                                                            Save Rs {{ number_format($discountAmount) }}

                                                                        </span>

                                                                    </div>

                                                                @endif


                                                                <p class="text-xs text-gray-500 mt-1">

                                                                    {{ $quantity }} ×
                                                                    Rs {{ number_format($salePrice) }}

                                                                </p>


                                                                <p class="font-semibold
                                                                          text-[#2563EB] mt-1">

                                                                    Rs {{ number_format($itemTotal) }}

                                                                </p>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        @empty

                                            <div class="p-8 text-center text-gray-500">
                                                No products found for this order.
                                            </div>

                                        @endforelse

                                    </div>



                                    {{-- =============================== --}}
                                    {{-- ORDER SUMMARY --}}
                                    {{-- =============================== --}}

                                    <div class="border-t border-gray-200
                                                bg-gray-50 px-5 py-5">

                                        <div class="flex flex-col lg:flex-row
                                                    lg:items-end
                                                    lg:justify-between gap-6">


                                            {{-- Summary --}}
                                            <div class="w-full lg:max-w-md">

                                                <h4 class="font-semibold text-[#111827] mb-3">
                                                    Order Summary
                                                </h4>


                                                <div class="space-y-2 text-sm">


                                                    {{-- Subtotal --}}
                                                    <div class="flex justify-between">

                                                        <span class="text-gray-500">
                                                            Subtotal
                                                        </span>

                                                        <span class="font-medium text-gray-700">
                                                            Rs {{ number_format($order->subtotal ?? 0) }}
                                                        </span>

                                                    </div>


                                                    {{-- Discount --}}
                                                    @if(($order->discount ?? 0) > 0)

                                                        <div class="flex justify-between">

                                                            <span class="text-gray-500">
                                                                Discount
                                                            </span>

                                                            <span class="font-medium text-green-600">
                                                                - Rs {{ number_format($order->discount) }}
                                                            </span>

                                                        </div>

                                                    @endif


                                                    {{-- Delivery --}}
                                                    <div class="flex justify-between">

                                                        <span class="text-gray-500">
                                                            Delivery Charge
                                                        </span>

                                                        <span class="font-medium text-gray-700">

                                                            @if(($order->delivery_charge ?? 0) > 0)

                                                                Rs {{ number_format($order->delivery_charge) }}

                                                            @else

                                                                <span class="text-green-600">
                                                                    Free
                                                                </span>

                                                            @endif

                                                        </span>

                                                    </div>


                                                    {{-- Tax --}}
                                                    @if(($order->tax ?? 0) > 0)

                                                        <div class="flex justify-between">

                                                            <span class="text-gray-500">
                                                                Tax
                                                            </span>

                                                            <span class="font-medium text-gray-700">
                                                                Rs {{ number_format($order->tax) }}
                                                            </span>

                                                        </div>

                                                    @endif


                                                    {{-- Grand Total --}}
                                                    <div class="border-t border-gray-200
                                                                pt-3 mt-3
                                                                flex justify-between">

                                                        <span class="font-bold text-[#111827]">
                                                            Total
                                                        </span>

                                                        <span class="font-bold text-xl
                                                                     text-[#2563EB]">

                                                            Rs {{ number_format($order->grand_total ?? 0) }}

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>



                                            {{-- =============================== --}}
                                            {{-- ACTION BUTTONS --}}
                                            {{-- =============================== --}}

                                            <div class="flex flex-wrap
                                                        justify-end items-center gap-3">


                                                {{-- View Order --}}
                                                <a
                                                    href="{{ route('user.order.view', $order->id) }}"
                                                    class="px-5 py-2.5 rounded-xl
                                                           border border-gray-200
                                                           bg-white
                                                           text-gray-700
                                                           hover:bg-gray-100
                                                           text-sm font-semibold
                                                           transition">

                                                    <span class="inline-flex items-center gap-2">

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="w-4 h-4"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor">

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                            />

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5
                                                                   c4.477 0 8.268 2.943 9.542 7
                                                                   -1.274 4.057-5.065 7-9.542 7
                                                                   -4.477 0-8.268-2.943-9.542-7z"
                                                            />

                                                        </svg>

                                                        View Order

                                                    </span>

                                                </a>



                                                {{-- Track Order --}}
                                                @if(!in_array($status, ['cancelled', 'canceled']))

                                                    <a
                                                        href="{{ route('user.order.track', $order->id) }}"
                                                        class="px-5 py-2.5 rounded-xl
                                                               bg-[#2563EB]
                                                               hover:bg-blue-700
                                                               text-white
                                                               text-sm font-semibold
                                                               transition">

                                                        <span class="inline-flex items-center gap-2">

                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="w-4 h-4"
                                                                fill="none"
                                                                viewBox="0 0 24 24"
                                                                stroke="currentColor">

                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 17a2 2 0 104 0M5 17a2 2 0 104 0M13 17h1a2 2 0 002-2V7a2 2 0 00-2-2h-1m0 0H4
                                                                       a2 2 0 00-2 2v8a2 2 0 002 2h1
                                                                       m8-10h3l4 4v6h-4"
                                                                />

                                                            </svg>

                                                            Track Order

                                                        </span>

                                                    </a>

                                                @endif



                                                {{-- Review --}}
                                                @if(in_array($status, ['delivered', 'completed']))

                                                    <a
                                                        href="{{ route('orders.review', $order->id) }}"
                                                        class="px-5 py-2.5 rounded-xl
                                                               bg-[#F59E0B]
                                                               hover:bg-[#D97706]
                                                               text-white
                                                               text-sm font-semibold
                                                               transition">

                                                        ⭐ Review

                                                    </a>

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>


                    @else

                        {{-- ========================================= --}}
                        {{-- EMPTY ORDERS --}}
                        {{-- ========================================= --}}

                        <div class="border border-gray-200 rounded-2xl
                                    min-h-[300px]
                                    flex flex-col
                                    items-center justify-center
                                    text-center px-4">


                            <div class="w-16 h-16 rounded-full
                                        bg-blue-50
                                        flex items-center justify-center mb-4">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-8 h-8 text-[#2563EB]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4
                                           M7 13L5.4 5M7 13l-2.293 2.293
                                           c-.63.63-.184 1.707.707 1.707H17
                                           m0 0a2 2 0 100 4
                                           2 2 0 000-4
                                           zm-8 2a2 2 0 11-4 0
                                           2 2 0 014 0z"
                                    />

                                </svg>

                            </div>


                            <h2 class="text-lg font-semibold text-[#111827]">
                                You haven't placed any orders yet.
                            </h2>


                            <p class="text-sm text-gray-500 mt-2">
                                Start shopping and your orders will appear here.
                            </p>


                            <a
                                href="{{ route('home') }}"
                                class="mt-5 px-6 py-2.5 rounded-xl
                                       bg-[#2563EB]
                                       hover:bg-blue-700
                                       text-white text-sm
                                       font-semibold transition">

                                Start Shopping

                            </a>

                        </div>

                    @endif

                </div>

            </main>

        </div>

    </div>

</x-frontend-layout>
