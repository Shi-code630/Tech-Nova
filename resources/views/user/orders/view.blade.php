<x-frontend-layout>

    <div class="bg-gray-100 py-8">

        <div class="Container mx-auto px-4">

            {{-- ========================================= --}}
            {{-- BACK --}}
            {{-- ========================================= --}}

            <div class="mb-5">

                <a
                    href="{{ route('user.orders') }}"
                    class="inline-flex items-center gap-2
                           text-sm font-medium text-gray-600
                           hover:text-[#2563EB] transition">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7" />

                    </svg>

                    Back to My Orders

                </a>

            </div>



            {{-- ========================================= --}}
            {{-- ORDER HEADER --}}
            {{-- ========================================= --}}

            <div class="bg-white rounded-3xl shadow-sm
                        border border-gray-100 p-6 mb-6">

                <div class="flex flex-col lg:flex-row
                            lg:items-center
                            lg:justify-between gap-5">

                    <div>

                        <p class="text-sm text-gray-500">
                            Order Details
                        </p>

                        <div class="flex flex-wrap
                                    items-center gap-3 mt-1">

                            <h1 class="text-2xl lg:text-3xl
                                       font-bold text-[#111827]">

                                Order #{{ $order->order_number ?? $order->id }}

                            </h1>


                            @php

                                $status = strtolower(
                                    $order->order_status ?? 'pending'
                                );

                                $statusClass = match($status) {

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

                            @endphp


                            <span class="px-3 py-1.5
                                         rounded-full
                                         text-xs font-semibold
                                         {{ $statusClass }}">

                                {{ ucfirst(str_replace('_', ' ', $status)) }}

                            </span>

                        </div>


                        <p class="text-sm text-gray-500 mt-2">

                            Placed on

                            <span class="font-medium text-gray-700">
                                {{ $order->created_at->format('M d, Y h:i A') }}
                            </span>

                        </p>

                    </div>



                    {{-- Total --}}
                    <div class="lg:text-right">

                        <p class="text-sm text-gray-500">
                            Order Total
                        </p>

                        <p class="text-2xl font-bold
                                  text-[#2563EB] mt-1">

                            Rs {{ number_format($order->grand_total ?? 0, 2) }}

                        </p>

                    </div>

                </div>

            </div>



            {{-- ========================================= --}}
            {{-- RETURN / EXCHANGE NOTICE --}}
            {{-- ========================================= --}}

            @if ($order->canRequestReturnExchange() && $hasReturnableItems)

                <div class="mb-6 rounded-2xl
                            border border-blue-200
                            bg-blue-50 p-5">

                    <div class="flex flex-col
                                lg:flex-row
                                lg:items-center
                                lg:justify-between gap-4">

                        <div class="flex gap-3">

                            <div class="w-10 h-10 rounded-xl
                                        bg-blue-100
                                        text-blue-600
                                        flex items-center
                                        justify-center
                                        flex-shrink-0">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M4 4v6h6M20 20v-6h-6
                                           M5.5 15a7 7 0 0011.5 1
                                           M18.5 9a7 7 0 00-11.5-1" />

                                </svg>

                            </div>


                            <div>

                                <p class="font-semibold text-blue-900">
                                    Need to return or exchange an item?
                                </p>

                                <p class="mt-1 text-sm text-blue-700">
                                    You can submit a request within 7 days
                                    of delivery.
                                </p>

                            </div>

                        </div>


                        <a
                            href="{{ route('return-requests.create', $order) }}"
                            class="inline-flex justify-center
                                   items-center gap-2
                                   rounded-xl
                                   bg-blue-600
                                   px-5 py-2.5
                                   text-sm font-semibold
                                   text-white
                                   hover:bg-blue-700
                                   transition">

                            Request Return / Exchange

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
                                    d="M9 5l7 7-7 7" />

                            </svg>

                        </a>

                    </div>

                </div>

            @endif



            {{-- ========================================= --}}
            {{-- MAIN GRID --}}
            {{-- ========================================= --}}

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">


                {{-- ========================================= --}}
                {{-- LEFT --}}
                {{-- ========================================= --}}

                <div class="xl:col-span-2 space-y-6">


                    {{-- ================================= --}}
                    {{-- PRODUCTS --}}
                    {{-- ================================= --}}

                    <div class="bg-white rounded-3xl shadow-sm
                                border border-gray-100
                                overflow-hidden">

                        <div class="px-6 py-5
                                    border-b border-gray-100">

                            <div class="flex items-center
                                        justify-between">

                                <div>

                                    <h2 class="text-lg font-bold
                                               text-[#111827]">

                                        Products

                                    </h2>

                                    <p class="text-sm text-gray-500 mt-1">

                                        {{ $items->count() }}
                                        {{ $items->count() == 1 ? 'item' : 'items' }}
                                        in this order

                                    </p>

                                </div>


                                <div class="w-10 h-10 rounded-xl
                                            bg-blue-50
                                            flex items-center
                                            justify-center">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-[#2563EB]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />

                                    </svg>

                                </div>

                            </div>

                        </div>



                        {{-- Product List --}}
                        <div class="divide-y divide-gray-100">

                            @foreach($items as $item)

                                @php

                                    $product = $item->product;
                                    $variant = $item->variant;

                                    /*
                                     * Product Image
                                     */
                                    $productImage = null;

                                    if ($product && !empty($product->thumbnails)) {

                                        $productImage = is_array($product->thumbnails)
                                            ? ($product->thumbnails[0] ?? null)
                                            : $product->thumbnails;

                                    } elseif ($product && $product->image) {

                                        $productImage = $product->image;

                                    }


                                    /*
                                     * Price
                                     */
                                    $price = $item->price ?? 0;

                                    $originalPrice = $product->price
                                        ?? $price;

                                    $discount = max(
                                        0,
                                        $originalPrice - $price
                                    );

                                    $discountPercent = $originalPrice > 0
                                        ? round(($discount / $originalPrice) * 100)
                                        : 0;


                                    /*
                                     * Quantity
                                     */
                                    $quantity = $item->quantity ?? 1;


                                    /*
                                     * Item Total
                                     */
                                    $itemTotal = $item->total
                                        ?? ($price * $quantity);

                                @endphp



                                <div class="p-6">

                                    <div class="flex flex-col
                                                sm:flex-row gap-5">


                                        {{-- ================= --}}
                                        {{-- IMAGE --}}
                                        {{-- ================= --}}

                                        <div class="flex-shrink-0">

                                            <div class="w-28 h-28
                                                        sm:w-32 sm:h-32
                                                        rounded-2xl
                                                        bg-gray-50
                                                        border
                                                        border-gray-200
                                                        overflow-hidden">

                                                @if($productImage)

                                                    <img
                                                        src="{{ asset('storage/' . $productImage) }}"
                                                        alt="{{ $product->name ?? 'Product' }}"
                                                        class="w-full h-full
                                                               object-contain
                                                               p-2"
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
                                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />

                                                        </svg>

                                                    </div>

                                                @endif

                                            </div>

                                        </div>



                                        {{-- ================= --}}
                                        {{-- DETAILS --}}
                                        {{-- ================= --}}

                                        <div class="flex-1 min-w-0">

                                            <div class="flex flex-col
                                                        lg:flex-row
                                                        lg:justify-between
                                                        gap-4">


                                                {{-- Product --}}
                                                <div>

                                                    <h3 class="text-base
                                                               sm:text-lg
                                                               font-semibold
                                                               text-[#111827]">

                                                        {{ $product->name ?? 'Product Unavailable' }}

                                                    </h3>


                                                    {{-- Variant --}}
                                                    <div class="flex flex-wrap
                                                                items-center
                                                                gap-2 mt-3">

                                                        @if($variant?->color)

                                                            <span class="px-3 py-1
                                                                         rounded-lg
                                                                         bg-gray-100
                                                                         text-xs
                                                                         text-gray-600">

                                                                Color:
                                                                <span class="font-semibold
                                                                             text-gray-800">

                                                                    {{ $variant->color }}

                                                                </span>

                                                            </span>

                                                        @endif


                                                        @if($variant?->size)

                                                            <span class="px-3 py-1
                                                                         rounded-lg
                                                                         bg-gray-100
                                                                         text-xs
                                                                         text-gray-600">

                                                                Size:
                                                                <span class="font-semibold
                                                                             text-gray-800">

                                                                    {{ $variant->size }}

                                                                </span>

                                                            </span>

                                                        @endif

                                                    </div>


                                                    {{-- Quantity --}}
                                                    <div class="mt-3">

                                                        <span class="text-sm text-gray-500">
                                                            Quantity:
                                                        </span>

                                                        <span class="font-semibold
                                                                     text-gray-700">

                                                            {{ $quantity }}

                                                        </span>

                                                    </div>

                                                </div>



                                                {{-- ================= --}}
                                                {{-- PRICE --}}
                                                {{-- ================= --}}

                                                <div class="lg:text-right
                                                            flex-shrink-0">

                                                    <div class="flex items-center
                                                                lg:justify-end
                                                                gap-2">

                                                        <span class="text-lg
                                                                     font-bold
                                                                     text-[#111827]">

                                                            Rs {{ number_format($price, 2) }}

                                                        </span>


                                                        @if($discount > 0)

                                                            <span class="text-sm
                                                                         text-gray-400
                                                                         line-through">

                                                                Rs {{ number_format($originalPrice, 2) }}

                                                            </span>

                                                        @endif

                                                    </div>


                                                    @if($discount > 0)

                                                        <p class="mt-1
                                                                  text-xs
                                                                  font-semibold
                                                                  text-green-600">

                                                            {{ $discountPercent }}% OFF

                                                            · Save
                                                            Rs {{ number_format($discount, 2) }}

                                                        </p>

                                                    @endif


                                                    <p class="text-sm
                                                              text-gray-500 mt-2">

                                                        Item Total:

                                                        <span class="font-bold
                                                                     text-[#2563EB]">

                                                            Rs {{ number_format($itemTotal, 2) }}

                                                        </span>

                                                    </p>

                                                </div>

                                            </div>



                                            {{-- ================= --}}
                                            {{-- RETURN REQUESTS --}}
                                            {{-- ================= --}}

                                            @if ($item->returnRequests->isNotEmpty())

                                                <div class="mt-5
                                                            rounded-2xl
                                                            border
                                                            border-gray-200
                                                            bg-gray-50
                                                            p-4">

                                                    <div class="flex items-center
                                                                gap-2 mb-3">

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="w-5 h-5 text-gray-500"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor">

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="1.8"
                                                                d="M4 4v6h6M20 20v-6h-6
                                                                   M5.5 15a7 7 0 0011.5 1
                                                                   M18.5 9a7 7 0 00-11.5-1" />

                                                        </svg>

                                                        <h4 class="font-semibold
                                                                   text-gray-800">

                                                            Return / Exchange Requests

                                                        </h4>

                                                    </div>


                                                    <div class="space-y-3">

                                                        @foreach($item->returnRequests as $returnRequest)

                                                            @php

                                                                $returnStatusClass = match(
                                                                    $returnRequest->status
                                                                ) {

                                                                    'requested' =>
                                                                        'bg-yellow-100 text-yellow-800',

                                                                    'approved' =>
                                                                        'bg-blue-100 text-blue-800',

                                                                    'rejected' =>
                                                                        'bg-red-100 text-red-800',

                                                                    'received' =>
                                                                        'bg-indigo-100 text-indigo-800',

                                                                    'completed' =>
                                                                        'bg-green-100 text-green-800',

                                                                    default =>
                                                                        'bg-gray-100 text-gray-800',

                                                                };

                                                            @endphp


                                                            <div class="rounded-xl
                                                                        border
                                                                        border-gray-200
                                                                        bg-white
                                                                        p-3">

                                                                <div class="flex flex-wrap
                                                                            items-center
                                                                            justify-between
                                                                            gap-2">

                                                                    <span class="text-sm
                                                                                 font-medium
                                                                                 text-gray-800">

                                                                        {{ $returnRequest->request_type_label }}
                                                                        Request

                                                                        · Qty:
                                                                        {{ $returnRequest->quantity }}

                                                                    </span>


                                                                    <span
                                                                        class="rounded-full
                                                                               px-2.5 py-1
                                                                               text-xs
                                                                               font-semibold
                                                                               {{ $returnStatusClass }}">

                                                                        {{ $returnRequest->status_label }}

                                                                    </span>

                                                                </div>


                                                                @if(
                                                                    $returnRequest->request_type === 'exchange'
                                                                    && $returnRequest->exchangeVariant
                                                                )

                                                                    <p class="mt-2 text-xs
                                                                              text-gray-600">

                                                                        Replacement:

                                                                        <span class="font-medium">

                                                                            {{ $returnRequest->exchangeVariant->color ?: 'Default color' }}

                                                                            {{ $returnRequest->exchangeVariant->size
                                                                                ? ' · ' . $returnRequest->exchangeVariant->size
                                                                                : '' }}

                                                                        </span>

                                                                    </p>

                                                                @endif


                                                                @if($returnRequest->admin_note)

                                                                    <div class="mt-2
                                                                                rounded-lg
                                                                                bg-gray-50
                                                                                p-2">

                                                                        <p class="text-xs
                                                                                  text-gray-600">

                                                                            <span class="font-semibold">
                                                                                TechNova:
                                                                            </span>

                                                                            {{ $returnRequest->admin_note }}

                                                                        </p>

                                                                    </div>

                                                                @endif

                                                            </div>

                                                        @endforeach

                                                    </div>

                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>



                    {{-- ================================= --}}
                    {{-- ORDER INFORMATION --}}
                    {{-- ================================= --}}

                    <div class="bg-white rounded-3xl shadow-sm
                                border border-gray-100 p-6">

                        <h2 class="text-lg font-bold
                                   text-[#111827] mb-5">

                            Order Information

                        </h2>


                        <div class="grid grid-cols-1
                                    sm:grid-cols-2 gap-5">


                            {{-- Order ID --}}
                            <div class="rounded-xl bg-gray-50 p-4">

                                <p class="text-xs uppercase
                                          tracking-wide
                                          text-gray-500">

                                    Order ID

                                </p>

                                <p class="font-semibold
                                          text-gray-800 mt-1">

                                    #{{ $order->order_number ?? $order->id }}

                                </p>

                            </div>


                            {{-- Date --}}
                            <div class="rounded-xl bg-gray-50 p-4">

                                <p class="text-xs uppercase
                                          tracking-wide
                                          text-gray-500">

                                    Order Date

                                </p>

                                <p class="font-semibold
                                          text-gray-800 mt-1">

                                    {{ $order->created_at->format('M d, Y') }}

                                </p>

                            </div>


                            {{-- Payment --}}
                            <div class="rounded-xl bg-gray-50 p-4">

                                <p class="text-xs uppercase
                                          tracking-wide
                                          text-gray-500">

                                    Payment Method

                                </p>

                                <p class="font-semibold
                                          text-gray-800 mt-1">

                                    {{ ucfirst(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $order->payment_method ?? 'N/A'
                                        )
                                    ) }}

                                </p>

                            </div>


                            {{-- Payment Status --}}
                            <div class="rounded-xl bg-gray-50 p-4">

                                <p class="text-xs uppercase
                                          tracking-wide
                                          text-gray-500">

                                    Payment Status

                                </p>

                                @php
                                    $paymentStatus = strtolower(
                                        $order->payment_status ?? 'pending'
                                    );
                                @endphp

                                <span
                                    class="inline-flex mt-1
                                           px-2.5 py-1
                                           rounded-full
                                           text-xs font-semibold
                                           {{ $paymentStatus === 'paid'
                                              ? 'bg-green-100 text-green-700'
                                              : 'bg-yellow-100 text-yellow-700' }}">

                                    {{ ucfirst($paymentStatus) }}

                                </span>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- ========================================= --}}
                {{-- RIGHT --}}
                {{-- ========================================= --}}

                <div class="space-y-6">


                    {{-- ================================= --}}
                    {{-- DELIVERY ADDRESS --}}
                    {{-- ================================= --}}

                    <div class="bg-white rounded-3xl
                                shadow-sm
                                border border-gray-100
                                p-6">

                        <div class="flex items-center
                                    gap-3 mb-5">

                            <div class="w-10 h-10 rounded-xl
                                        bg-blue-50
                                        flex items-center
                                        justify-center">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-[#2563EB]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z" />

                                    <circle
                                        cx="12"
                                        cy="11"
                                        r="2.5" />

                                </svg>

                            </div>


                            <div>

                                <h2 class="font-bold text-[#111827]">
                                    Delivery Address
                                </h2>

                                <p class="text-xs text-gray-500">
                                    Shipping information
                                </p>

                            </div>

                        </div>


                        @if($order->address)

                            <div class="space-y-2
                                        text-sm text-gray-600">

                                <p class="font-bold
                                          text-[#111827]">

                                    {{ $order->address->full_name
                                        ?? $order->address->name
                                        ?? 'Customer' }}

                                </p>


                                @if($order->address->phone)

                                    <p>
                                        {{ $order->address->phone }}
                                    </p>

                                @endif


                                @if($order->address->address)

                                    <p>
                                        {{ $order->address->address }}
                                    </p>

                                @endif


                                <p>

                                    {{ $order->address->city ?? '' }}

                                    @if($order->address->district)
                                        , {{ $order->address->district }}
                                    @endif

                                </p>


                                @if($order->address->province)

                                    <p>
                                        {{ $order->address->province }}
                                    </p>

                                @endif


                                @if($order->address->postal_code)

                                    <p>
                                        Postal Code:
                                        {{ $order->address->postal_code }}
                                    </p>

                                @endif

                            </div>

                        @else

                            <p class="text-sm text-gray-500">
                                Delivery address not available.
                            </p>

                        @endif

                    </div>



                    {{-- ================================= --}}
                    {{-- PAYMENT --}}
                    {{-- ================================= --}}

                    <div class="bg-white rounded-3xl
                                shadow-sm
                                border border-gray-100
                                p-6">

                        <h2 class="text-lg font-bold
                                   text-[#111827] mb-5">

                            Payment

                        </h2>


                        <div class="space-y-4">


                            <div class="flex justify-between
                                        items-center gap-4">

                                <span class="text-sm text-gray-500">
                                    Method
                                </span>

                                <span class="text-sm font-semibold
                                             text-gray-800 text-right">

                                    {{ ucfirst(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $order->payment_method ?? 'N/A'
                                        )
                                    ) }}

                                </span>

                            </div>


                            <div class="flex justify-between
                                        items-center gap-4">

                                <span class="text-sm text-gray-500">
                                    Status
                                </span>

                                <span
                                    class="px-3 py-1
                                           rounded-full
                                           text-xs font-semibold
                                           {{ $paymentStatus === 'paid'
                                              ? 'bg-green-100 text-green-700'
                                              : 'bg-yellow-100 text-yellow-700' }}">

                                    {{ ucfirst($paymentStatus) }}

                                </span>

                            </div>

                        </div>

                    </div>



                    {{-- ================================= --}}
                    {{-- ORDER SUMMARY --}}
                    {{-- ================================= --}}

                    <div class="bg-white rounded-3xl
                                shadow-sm
                                border border-gray-100
                                p-6">

                        <h2 class="text-lg font-bold
                                   text-[#111827] mb-5">

                            Order Summary

                        </h2>


                        <div class="space-y-3 text-sm">


                            {{-- Subtotal --}}
                            <div class="flex justify-between">

                                <span class="text-gray-500">
                                    Subtotal
                                </span>

                                <span class="font-medium text-gray-700">

                                    Rs {{ number_format(
                                        $order->subtotal ?? 0,
                                        2
                                    ) }}

                                </span>

                            </div>


                            {{-- Discount --}}
                            @if(($order->discount ?? 0) > 0)

                                <div class="flex justify-between">

                                    <span class="text-gray-500">
                                        Discount
                                    </span>

                                    <span class="font-semibold
                                                 text-green-600">

                                        - Rs {{ number_format(
                                            $order->discount,
                                            2
                                        ) }}

                                    </span>

                                </div>

                            @endif


                            {{-- Delivery --}}
                            <div class="flex justify-between">

                                <span class="text-gray-500">
                                    Delivery
                                </span>

                                @if(($order->delivery_charge ?? 0) > 0)

                                    <span class="font-medium">

                                        Rs {{ number_format(
                                            $order->delivery_charge,
                                            2
                                        ) }}

                                    </span>

                                @else

                                    <span class="font-semibold
                                                 text-green-600">

                                        Free

                                    </span>

                                @endif

                            </div>


                            {{-- Tax --}}
                            @if(($order->tax ?? 0) > 0)

                                <div class="flex justify-between">

                                    <span class="text-gray-500">
                                        Tax
                                    </span>

                                    <span class="font-medium">

                                        Rs {{ number_format(
                                            $order->tax,
                                            2
                                        ) }}

                                    </span>

                                </div>

                            @endif


                            {{-- Total --}}
                            <div class="border-t
                                        border-gray-200
                                        pt-4 mt-4
                                        flex justify-between
                                        items-center">

                                <span class="font-bold
                                             text-[#111827]">

                                    Total

                                </span>

                                <span class="text-xl
                                             font-bold
                                             text-[#2563EB]">

                                    Rs {{ number_format(
                                        $order->grand_total ?? 0,
                                        2
                                    ) }}

                                </span>

                            </div>

                        </div>

                    </div>



                    {{-- ================================= --}}
                    {{-- TRACK ORDER --}}
                    {{-- ================================= --}}

                    @if(!in_array($status, ['cancelled', 'canceled']))

                        <a
                            href="{{ route('user.order.track', $order->id) }}"
                            class="w-full
                                   inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   rounded-2xl
                                   bg-[#2563EB]
                                   hover:bg-blue-700
                                   px-5 py-3
                                   text-sm font-semibold
                                   text-white
                                   transition">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M9 17a2 2 0 104 0M5 17a2 2 0 104 0
                                       M13 17h1a2 2 0 002-2V7a2 2 0 00-2-2h-1
                                       M12 5H4a2 2 0 00-2 2v8a2 2 0 002 2h1
                                       m10-10h3l4 4v6h-4" />

                            </svg>

                            Track Order

                        </a>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-frontend-layout>
