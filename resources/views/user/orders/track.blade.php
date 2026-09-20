<x-frontend-layout>

    <div class="bg-gray-100 w-full py-6 sm:py-8">

        <div class="Container mx-auto px-3 sm:px-4">


            {{-- ========================================= --}}
            {{-- BACK BUTTON                               --}}
            {{-- ========================================= --}}
            <div class="mb-4 sm:mb-5">

                <a href="{{ route('user.orders') }}"
                    class="inline-flex items-center gap-1.5 sm:gap-2
                           text-xs sm:text-sm font-medium
                           text-gray-600 hover:text-[#2563EB] transition">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

                    </svg>

                    Back to My Orders

                </a>

            </div>



            {{-- ========================================= --}}
            {{-- ORDER HEADER                              --}}
            {{-- ========================================= --}}
            <div
                class="bg-white rounded-2xl sm:rounded-3xl shadow-sm
                        border border-gray-100 p-4 sm:p-6 mb-4 sm:mb-6">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 sm:gap-5">

                    <div class="min-w-0">

                        <div class="flex flex-wrap items-center gap-2 sm:gap-3">

                            <span class="text-xs sm:text-sm text-gray-500">
                                Order Tracking
                            </span>

                            @php
                                $headerStatus = strtolower($order->order_status ?? 'pending');

                                $headerStatusClass = match ($headerStatus) {
                                    'delivered', 'completed' => 'bg-green-100 text-green-700',
                                    'shipped', 'out_for_delivery' => 'bg-blue-100 text-blue-700',
                                    'processing', 'confirmed' => 'bg-yellow-100 text-yellow-700',
                                    'cancelled', 'canceled' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <span
                                class="px-2.5 sm:px-3 py-1 rounded-full
                                         text-[10px] sm:text-xs font-semibold
                                         {{ $headerStatusClass }}">

                                {{ ucfirst(str_replace('_', ' ', $headerStatus)) }}

                            </span>

                        </div>


                        <h1 class="text-lg sm:text-2xl lg:text-3xl font-bold text-[#111827] mt-2 break-words">
                            Order #{{ $order->order_number ?? $order->id }}
                        </h1>


                        <p class="text-xs sm:text-sm text-gray-500 mt-2">

                            Placed on
                            <span class="font-medium text-gray-700">
                                {{ $order->created_at->format('M d, Y h:i A') }}
                            </span>

                        </p>

                    </div>


                    {{-- Total --}}
                    <div class="lg:text-right flex-shrink-0">

                        <p class="text-xs sm:text-sm text-gray-500">
                            Order Total
                        </p>

                        <p class="text-xl sm:text-2xl font-bold text-[#2563EB] mt-1">
                            Rs {{ number_format($order->grand_total, 2) }}
                        </p>

                    </div>

                </div>

            </div>



            {{-- ========================================= --}}
            {{-- MAIN GRID                                 --}}
            {{-- ========================================= --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 sm:gap-6">


                {{-- ========================================= --}}
                {{-- LEFT SIDE                                 --}}
                {{-- ========================================= --}}
                <div class="xl:col-span-2 space-y-4 sm:space-y-6">


                    {{-- ================================= --}}
                    {{-- ORDER ITEMS                       --}}
                    {{-- ================================= --}}
                    <div
                        class="bg-white rounded-2xl sm:rounded-3xl shadow-sm
                                border border-gray-100 overflow-hidden">

                        <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100">

                            <div class="flex items-center justify-between gap-3">

                                <div class="min-w-0">

                                    <h2 class="text-base sm:text-lg font-bold text-[#111827]">
                                        Ordered Products
                                    </h2>

                                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                        {{ $order->items->count() }}
                                        {{ $order->items->count() == 1 ? 'item' : 'items' }}
                                    </p>

                                </div>

                                <div
                                    class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-50
                                            flex items-center justify-center flex-shrink-0">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-[#2563EB]"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />

                                    </svg>

                                </div>

                            </div>

                        </div>


                        {{-- Products --}}
                        <div class="divide-y divide-gray-100">

                            @forelse($order->items as $item)

                                @php
                                    $product = $item->product;
                                    $variant = $item->variant;

                                    $productImage = null;

                                    if ($product && !empty($product->thumbnails)) {
                                        $productImage = is_array($product->thumbnails)
                                            ? $product->thumbnails[0] ?? null
                                            : $product->thumbnails;
                                    }

                                    $salePrice = $item->price ?? 0;
                                    $originalPrice = $product->price ?? $salePrice;
                                    $discountAmount = max(0, $originalPrice - $salePrice);
                                    $discountPercent =
                                        $originalPrice > 0 ? round(($discountAmount / $originalPrice) * 100) : 0;

                                    $quantity = $item->quantity ?? 1;
                                    $itemTotal = $item->total ?? $salePrice * $quantity;
                                @endphp


                                <div class="p-4 sm:p-6">

                                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-5">

                                        {{-- Product Image --}}
                                        <div class="flex-shrink-0 mx-auto sm:mx-0">

                                            <div
                                                class="w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32
                                                        rounded-2xl bg-gray-50
                                                        border border-gray-200
                                                        overflow-hidden">

                                                @if ($productImage)
                                                    <img src="{{ asset('storage/' . $productImage) }}"
                                                        alt="{{ $product->name ?? 'Product' }}" loading="lazy"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <div
                                                        class="w-full h-full flex items-center justify-center text-gray-400">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="w-8 h-8 sm:w-10 sm:h-10" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">

                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />

                                                        </svg>

                                                    </div>
                                                @endif

                                            </div>

                                        </div>


                                        {{-- Product Details --}}
                                        <div class="flex-1 min-w-0">

                                            <div class="flex flex-col lg:flex-row lg:justify-between gap-3 sm:gap-4">

                                                <div class="min-w-0">

                                                    <h3
                                                        class="text-sm sm:text-base md:text-lg font-semibold
                                                               text-[#111827] break-words">

                                                        {{ $product->name ?? 'Product Unavailable' }}

                                                    </h3>


                                                    {{-- Variant --}}
                                                    @if ($variant?->color || $variant?->size)
                                                        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 mt-2">

                                                            @if ($variant?->color)
                                                                <span
                                                                    class="px-2 sm:px-2.5 py-1 rounded-lg
                                                                             bg-gray-100 text-[10px] sm:text-xs
                                                                             text-gray-600">

                                                                    Color:
                                                                    <span class="font-semibold">
                                                                        {{ $variant->color }}
                                                                    </span>

                                                                </span>
                                                            @endif


                                                            @if ($variant?->size)
                                                                <span
                                                                    class="px-2 sm:px-2.5 py-1 rounded-lg
                                                                             bg-gray-100 text-[10px] sm:text-xs
                                                                             text-gray-600">

                                                                    Size:
                                                                    <span class="font-semibold">
                                                                        {{ $variant->size }}
                                                                    </span>

                                                                </span>
                                                            @endif

                                                        </div>
                                                    @endif


                                                    {{-- Quantity --}}
                                                    <p class="text-xs sm:text-sm text-gray-500 mt-2 sm:mt-3">

                                                        Quantity:
                                                        <span class="font-semibold text-gray-700">
                                                            {{ $quantity }}
                                                        </span>

                                                    </p>

                                                </div>


                                                {{-- Price --}}
                                                <div class="lg:text-right flex-shrink-0">

                                                    <div class="flex items-center lg:justify-end gap-2 flex-wrap">

                                                        <span class="text-base sm:text-lg font-bold text-[#111827]">
                                                            Rs {{ number_format($salePrice, 2) }}
                                                        </span>


                                                        @if ($discountAmount > 0)
                                                            <span class="text-xs sm:text-sm text-gray-400 line-through">
                                                                Rs {{ number_format($originalPrice, 2) }}
                                                            </span>
                                                        @endif

                                                    </div>


                                                    @if ($discountAmount > 0)
                                                        <div class="mt-1 flex flex-wrap items-center gap-1">

                                                            <span
                                                                class="text-[10px] sm:text-xs font-bold text-green-600">
                                                                {{ $discountPercent }}% OFF
                                                            </span>

                                                            <span class="text-[10px] sm:text-xs text-gray-500">
                                                                · Save Rs {{ number_format($discountAmount, 2) }}
                                                            </span>

                                                        </div>
                                                    @endif


                                                    <p class="text-xs sm:text-sm text-gray-500 mt-2">

                                                        Total:
                                                        <span class="font-bold text-[#2563EB]">
                                                            Rs {{ number_format($itemTotal, 2) }}
                                                        </span>

                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="p-6 sm:p-8 text-center text-gray-500 text-xs sm:text-sm">
                                    No products found for this order.
                                </div>

                            @endforelse

                        </div>

                    </div>



                    {{-- ================================= --}}
                    {{-- DELIVERY TIMELINE                 --}}
                    {{-- ================================= --}}
                    <div
                        class="bg-white rounded-2xl sm:rounded-3xl shadow-sm
                                border border-gray-100 p-4 sm:p-6">

                        <div class="mb-6 sm:mb-8">

                            <h2 class="text-base sm:text-lg font-bold text-[#111827]">
                                Delivery Status
                            </h2>

                            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                Track your order from placement to delivery
                            </p>

                        </div>


                        @php
                            $status = strtolower($order->order_status ?? 'pending');

                            $statuses = [
                                'pending' => [
                                    'title' => 'Order Placed',
                                    'description' => 'Your order has been placed successfully.',
                                    'icon' => 'M5 13l4 4L19 7',
                                ],
                                'processing' => [
                                    'title' => 'Processing',
                                    'description' => 'Your order is being prepared.',
                                    'icon' => 'M12 8v4l3 2',
                                ],
                                'shipped' => [
                                    'title' => 'Shipped',
                                    'description' => 'Your order has been handed over for delivery.',
                                    'icon' => 'M9 17a2 2 0 104 0M5 17a2 2 0 104 0',
                                ],
                                'delivered' => [
                                    'title' => 'Delivered',
                                    'description' => 'Your order has been delivered successfully.',
                                    'icon' => 'M5 13l4 4L19 7',
                                ],
                            ];

                            $statusOrder = ['pending', 'processing', 'shipped', 'delivered'];
                            $currentIndex = array_search($status, $statusOrder);
                        @endphp


                        @if (in_array($status, ['cancelled', 'canceled']))

                            {{-- Cancelled --}}
                            <div class="rounded-2xl bg-red-50 border border-red-100 p-4 sm:p-5">

                                <div class="flex items-start gap-3 sm:gap-4">

                                    <div
                                        class="w-10 h-10 sm:w-12 sm:h-12 rounded-full
                                                bg-red-100 text-red-600
                                                flex items-center justify-center flex-shrink-0">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />

                                        </svg>

                                    </div>

                                    <div class="min-w-0">

                                        <h3 class="font-bold text-red-700 text-sm sm:text-base">
                                            Order Cancelled
                                        </h3>

                                        <p class="text-xs sm:text-sm text-red-600/80 mt-1">
                                            This order has been cancelled.
                                        </p>

                                    </div>

                                </div>

                            </div>
                        @else
                            <div class="relative">

                                @foreach ($statusOrder as $index => $statusKey)
                                    @php
                                        $isCompleted = $currentIndex !== false && $index <= $currentIndex;
                                        $isCurrent = $index === $currentIndex;
                                    @endphp


                                    <div
                                        class="relative flex gap-3 sm:gap-4
                                                {{ !$loop->last ? 'pb-8 sm:pb-10' : '' }}">


                                        {{-- Connecting Line --}}
                                        @if (!$loop->last)
                                            <div
                                                class="absolute left-[19px] sm:left-[23px]
                                                       top-10 sm:top-12 w-0.5 h-full
                                                       {{ $currentIndex !== false && $index < $currentIndex ? 'bg-[#2563EB]' : 'bg-gray-200' }}">
                                            </div>
                                        @endif


                                        {{-- Circle --}}
                                        <div
                                            class="relative z-10
                                                   w-10 h-10 sm:w-12 sm:h-12 rounded-full
                                                   flex items-center justify-center
                                                   flex-shrink-0
                                                   {{ $isCompleted ? 'bg-[#2563EB] text-white' : 'bg-gray-100 text-gray-400' }}">

                                            @if ($isCompleted)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="{{ $statuses[$statusKey]['icon'] }}" />

                                                </svg>
                                            @else
                                                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-current"></div>
                                            @endif

                                        </div>


                                        {{-- Text --}}
                                        <div class="pt-0.5 sm:pt-1 min-w-0">

                                            <div class="flex flex-wrap items-center gap-2">

                                                <h3
                                                    class="font-semibold text-sm sm:text-base
                                                           {{ $isCompleted ? 'text-[#111827]' : 'text-gray-400' }}">

                                                    {{ $statuses[$statusKey]['title'] }}

                                                </h3>


                                                @if ($isCurrent)
                                                    <span
                                                        class="px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full
                                                                 bg-blue-50 text-[#2563EB]
                                                                 text-[10px] sm:text-xs font-semibold">

                                                        Current Status

                                                    </span>
                                                @endif

                                            </div>


                                            <p
                                                class="text-xs sm:text-sm mt-1
                                                      {{ $isCompleted ? 'text-gray-500' : 'text-gray-400' }}">

                                                {{ $statuses[$statusKey]['description'] }}

                                            </p>

                                        </div>

                                    </div>
                                @endforeach

                            </div>

                        @endif

                    </div>

                </div>



                {{-- ========================================= --}}
                {{-- RIGHT SIDEBAR                             --}}
                {{-- ========================================= --}}
                <div class="space-y-4 sm:space-y-6">


                    {{-- ================================= --}}
                    {{-- DELIVERY ADDRESS                  --}}
                    {{-- ================================= --}}
                    <div
                        class="bg-white rounded-2xl sm:rounded-3xl shadow-sm
                                border border-gray-100 p-4 sm:p-6">

                        <div class="flex items-center gap-3 mb-4 sm:mb-5">

                            <div
                                class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-50
                                        flex items-center justify-center flex-shrink-0">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-[#2563EB]"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z" />

                                    <circle cx="12" cy="11" r="2.5" />

                                </svg>

                            </div>

                            <div class="min-w-0">

                                <h2 class="font-bold text-[#111827] text-sm sm:text-base">
                                    Delivery Address
                                </h2>

                                <p class="text-[10px] sm:text-xs text-gray-500">
                                    Shipping information
                                </p>

                            </div>

                        </div>


                        @if ($order->address)

                            <div class="space-y-2 text-xs sm:text-sm text-gray-600">

                                <p class="font-bold text-[#111827]">
                                    {{ $order->address->full_name ?? ($order->address->name ?? 'Customer') }}
                                </p>


                                @if ($order->address->phone)
                                    <p>{{ $order->address->phone }}</p>
                                @endif


                                @if ($order->address->address)
                                    <p>{{ $order->address->address }}</p>
                                @endif


                                <p>
                                    {{ $order->address->city ?? '' }}
                                    @if ($order->address->district)
                                        , {{ $order->address->district }}
                                    @endif
                                </p>


                                @if ($order->address->province)
                                    <p>{{ $order->address->province }}</p>
                                @endif


                                @if ($order->address->postal_code)
                                    <p>Postal Code: {{ $order->address->postal_code }}</p>
                                @endif

                            </div>
                        @else
                            <p class="text-xs sm:text-sm text-gray-500">
                                Delivery address not available.
                            </p>

                        @endif

                    </div>



                    {{-- ================================= --}}
                    {{-- PAYMENT                           --}}
                    {{-- ================================= --}}
                    <div
                        class="bg-white rounded-2xl sm:rounded-3xl shadow-sm
                                border border-gray-100 p-4 sm:p-6">

                        <div class="flex items-center gap-3 mb-4 sm:mb-5">

                            <div
                                class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-green-50
                                        flex items-center justify-center flex-shrink-0">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-green-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 7h18M3 10h18M5 17h4" />

                                </svg>

                            </div>

                            <div class="min-w-0">

                                <h2 class="font-bold text-[#111827] text-sm sm:text-base">
                                    Payment
                                </h2>

                                <p class="text-[10px] sm:text-xs text-gray-500">
                                    Payment information
                                </p>

                            </div>

                        </div>


                        <div class="space-y-3 text-xs sm:text-sm">

                            <div class="flex items-center justify-between gap-3">

                                <span class="text-gray-500">Method</span>

                                <span class="font-semibold text-[#111827] text-right">
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}
                                </span>

                            </div>


                            <div class="flex items-center justify-between gap-3">

                                <span class="text-gray-500">Payment Status</span>

                                @php
                                    $paymentStatus = strtolower($order->payment_status ?? 'pending');
                                @endphp

                                <span
                                    class="px-2.5 sm:px-3 py-1 rounded-full
                                             text-[10px] sm:text-xs font-semibold
                                             {{ $paymentStatus === 'paid' ? 'bg-green-50 text-green-600' : 'bg-yellow-50 text-yellow-600' }}">

                                    {{ ucfirst($paymentStatus) }}

                                </span>

                            </div>

                        </div>

                    </div>



                    {{-- ================================= --}}
                    {{-- ORDER SUMMARY                     --}}
                    {{-- ================================= --}}
                    <div
                        class="bg-white rounded-2xl sm:rounded-3xl shadow-sm
                                border border-gray-100 p-4 sm:p-6">

                        <h2 class="text-base sm:text-lg font-bold text-[#111827] mb-4 sm:mb-5">
                            Order Summary
                        </h2>


                        <div class="space-y-2.5 sm:space-y-3 text-xs sm:text-sm">


                            {{-- Subtotal --}}
                            <div class="flex justify-between">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-medium text-gray-700">
                                    Rs {{ number_format($order->subtotal ?? 0, 2) }}
                                </span>
                            </div>


                            {{-- Discount --}}
                            @if (($order->discount ?? 0) > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Discount</span>
                                    <span class="font-semibold text-green-600">
                                        - Rs {{ number_format($order->discount, 2) }}
                                    </span>
                                </div>
                            @endif


                            {{-- Delivery --}}
                            <div class="flex justify-between">
                                <span class="text-gray-500">Delivery</span>

                                @if (($order->delivery_charge ?? 0) > 0)
                                    <span class="font-medium text-gray-700">
                                        Rs {{ number_format($order->delivery_charge, 2) }}
                                    </span>
                                @else
                                    <span class="font-semibold text-green-600">Free</span>
                                @endif

                            </div>


                            {{-- Tax --}}
                            @if (($order->tax ?? 0) > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tax</span>
                                    <span class="font-medium">
                                        Rs {{ number_format($order->tax, 2) }}
                                    </span>
                                </div>
                            @endif


                            {{-- Total --}}
                            <div
                                class="border-t border-gray-200 pt-3 sm:pt-4 mt-3 sm:mt-4
                                        flex items-center justify-between">

                                <span class="font-bold text-[#111827]">Total</span>

                                <span class="text-lg sm:text-xl font-bold text-[#2563EB]">
                                    Rs {{ number_format($order->grand_total, 2) }}
                                </span>

                            </div>

                        </div>

                    </div>





                </div>
                {{-- ================================= --}}
                {{-- SUPPORT CARD --}}
                {{-- ================================= --}}

                <div
                    class="rounded-3xl
                                bg-gradient-to-br
                                from-[#2563EB] to-[#1E40AF]
                                p-6 text-white w-300">

                    <div
                        class="rounded-2xl sm:rounded-3xl
                                bg-gradient-to-br from-[#2563EB] to-[#1E40AF]
                                p-4 sm:p-6 text-white">

                        <div
                            class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl
                                    bg-white/15 flex items-center justify-center mb-3 sm:mb-4">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M18 10a6 6 0 00-12 0v5a2 2 0 002 2h2v-5H6m12 0h-4v5h2a2 2 0 002-2v-5z" />

                            </svg>

                        </div>


                        <h3 class="font-bold text-base sm:text-lg">
                            Need Help?
                        </h3>


                        <p class="text-xs sm:text-sm text-blue-100 mt-1">
                            If you have any questions about your order,
                            please contact our support team.
                        </p>


                        <a href="{{ route('home') }}"
                            class="inline-flex items-center justify-center
                                   mt-3 sm:mt-4 px-4 py-2.5
                                   rounded-xl bg-white text-[#2563EB]
                                   text-xs sm:text-sm font-semibold
                                   hover:bg-blue-50 transition">

                            Contact Support

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-frontend-layout>
