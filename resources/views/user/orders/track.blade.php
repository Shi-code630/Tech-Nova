<x-frontend-layout>

    <div class="bg-gray-100 min-h-screen py-8">

        <div class="w-[95%] max-w-6xl mx-auto">

            {{-- Back --}}
            <div class="mb-5">

                <a
                    href="{{ route('user.orders') }}"
                    class="inline-flex items-center gap-2 text-sm
                           font-medium text-gray-600 hover:text-[#2563EB]
                           transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M15 19l-7-7 7-7" />

                    </svg>

                    Back to My Orders

                </a>

            </div>


            {{-- Header --}}
            <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">

                <div class="flex flex-col sm:flex-row
                            sm:items-center sm:justify-between gap-4">

                    <div>

                        <p class="text-sm text-gray-500">
                            Order Tracking
                        </p>

                        <h1 class="text-2xl font-bold text-[#111827] mt-1">

                            Order #{{ $order->order_number ?? $order->id }}

                        </h1>

                        <p class="text-sm text-gray-500 mt-2">

                            Placed on
                            {{ $order->created_at->format('M d, Y') }}

                        </p>

                    </div>


                    <div class="text-left sm:text-right">

                        <p class="text-sm text-gray-500">
                            Order Total
                        </p>

                        <p class="text-xl font-bold text-[#2563EB]">
                            Rs {{ number_format($order->grand_total, 2) }}
                        </p>

                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Tracking Timeline --}}
                <div class="lg:col-span-2">

                    <div class="bg-white rounded-3xl shadow-sm p-6">

                        <h2 class="text-lg font-bold text-[#111827] mb-8">
                            Delivery Status
                        </h2>


                        @php

                            $status = strtolower($order->order_status);

                            $statuses = [
                                'pending' => [
                                    'title' => 'Order Placed',
                                    'description' => 'Your order has been placed successfully.'
                                ],

                                'processing' => [
                                    'title' => 'Processing',
                                    'description' => 'Your order is being prepared.'
                                ],

                                'shipped' => [
                                    'title' => 'Shipped',
                                    'description' => 'Your order has been handed over for delivery.'
                                ],

                                'delivered' => [
                                    'title' => 'Delivered',
                                    'description' => 'Your order has been delivered successfully.'
                                ],
                            ];

                            $statusOrder = [
                                'pending',
                                'processing',
                                'shipped',
                                'delivered'
                            ];

                            $currentIndex = array_search(
                                $status,
                                $statusOrder
                            );

                        @endphp


                        @if($status === 'cancelled')

                            {{-- Cancelled --}}
                            <div class="flex items-start gap-4">

                                <div class="w-11 h-11 rounded-full
                                            bg-red-100 text-red-600
                                            flex items-center justify-center
                                            flex-shrink-0">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-6 h-6"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12" />

                                    </svg>

                                </div>

                                <div>

                                    <h3 class="font-semibold text-red-600">
                                        Order Cancelled
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-1">
                                        This order has been cancelled.
                                    </p>

                                </div>

                            </div>

                        @else

                            <div class="relative">

                                @foreach($statusOrder as $index => $statusKey)

                                    @php

                                        $isCompleted =
                                            $currentIndex !== false &&
                                            $index <= $currentIndex;

                                        $isCurrent =
                                            $index === $currentIndex;

                                    @endphp


                                    <div class="relative flex gap-4
                                                {{ !$loop->last ? 'pb-10' : '' }}">

                                        {{-- Connecting line --}}
                                        @if(!$loop->last)

                                            <div class="absolute left-[21px]
                                                        top-11 w-0.5 h-full
                                                        {{ $currentIndex !== false && $index < $currentIndex
                                                            ? 'bg-[#2563EB]'
                                                            : 'bg-gray-200' }}">
                                            </div>

                                        @endif


                                        {{-- Status circle --}}
                                        <div class="relative z-10
                                                    w-11 h-11 rounded-full
                                                    flex items-center justify-center
                                                    flex-shrink-0
                                                    {{ $isCompleted
                                                        ? 'bg-[#2563EB] text-white'
                                                        : 'bg-gray-100 text-gray-400' }}">

                                            @if($isCompleted)

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="w-5 h-5"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor">

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M5 13l4 4L19 7" />

                                                </svg>

                                            @else

                                                <div class="w-3 h-3 rounded-full
                                                            bg-current">
                                                </div>

                                            @endif

                                        </div>


                                        {{-- Status text --}}
                                        <div class="pt-1">

                                            <div class="flex items-center gap-2">

                                                <h3 class="font-semibold
                                                           {{ $isCompleted
                                                              ? 'text-[#111827]'
                                                              : 'text-gray-400' }}">

                                                    {{ $statuses[$statusKey]['title'] }}

                                                </h3>


                                                @if($isCurrent)

                                                    <span class="px-2 py-0.5
                                                                 rounded-full
                                                                 bg-blue-50
                                                                 text-[#2563EB]
                                                                 text-xs font-medium">

                                                        Current

                                                    </span>

                                                @endif

                                            </div>


                                            <p class="text-sm mt-1
                                                      {{ $isCompleted
                                                         ? 'text-gray-500'
                                                         : 'text-gray-400' }}">

                                                {{ $statuses[$statusKey]['description'] }}

                                            </p>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @endif

                    </div>

                </div>


                {{-- Order Information --}}
                <div class="space-y-6">

                    {{-- Delivery Address --}}
                    <div class="bg-white rounded-3xl shadow-sm p-6">

                        <h2 class="text-lg font-bold text-[#111827] mb-4">
                            Delivery Address
                        </h2>

                        @if($order->address)

                            <div class="space-y-1 text-sm text-gray-600">

                                <p class="font-semibold text-[#111827]">
                                    {{ $order->address->name ?? '' }}
                                </p>

                                <p>
                                    {{ $order->address->address ?? '' }}
                                </p>

                                <p>
                                    {{ $order->address->city ?? '' }}
                                </p>

                                @if($order->address->phone ?? null)

                                    <p class="pt-2">
                                        {{ $order->address->phone }}
                                    </p>

                                @endif

                            </div>

                        @else

                            <p class="text-sm text-gray-500">
                                Delivery address not available.
                            </p>

                        @endif

                    </div>


                    {{-- Payment --}}
                    <div class="bg-white rounded-3xl shadow-sm p-6">

                        <h2 class="text-lg font-bold text-[#111827] mb-4">
                            Payment
                        </h2>

                        <div class="flex items-center justify-between">

                            <span class="text-sm text-gray-500">
                                Method
                            </span>

                            <span class="text-sm font-medium
                                         text-[#111827]">
                                {{ ucfirst($order->payment_method ?? 'N/A') }}
                            </span>

                        </div>


                        <div class="flex items-center justify-between mt-3">

                            <span class="text-sm text-gray-500">
                                Status
                            </span>

                            <span class="px-3 py-1 rounded-full
                                         text-xs font-medium
                                         {{ $order->payment_status === 'paid'
                                            ? 'bg-green-50 text-green-600'
                                            : 'bg-yellow-50 text-yellow-600' }}">

                                {{ ucfirst($order->payment_status ?? 'Pending') }}

                            </span>

                        </div>

                    </div>


                    {{-- Order Summary --}}
                    <div class="bg-white rounded-3xl shadow-sm p-6">

                        <h2 class="text-lg font-bold text-[#111827] mb-4">
                            Order Summary
                        </h2>

                        <div class="flex justify-between text-sm">

                            <span class="text-gray-500">
                                Subtotal
                            </span>

                            <span class="font-medium">
                                Rs {{ number_format($order->subtotal, 2) }}
                            </span>

                        </div>


                        <div class="flex justify-between text-sm mt-3">

                            <span class="text-gray-500">
                                Discount
                            </span>

                            <span class="font-medium text-green-600">
                                - Rs {{ number_format($order->discount, 2) }}
                            </span>

                        </div>


                        <div class="flex justify-between text-sm mt-3">

                            <span class="text-gray-500">
                                Delivery
                            </span>

                            <span class="font-medium">
                                Rs {{ number_format($order->delivery_charge, 2) }}
                            </span>

                        </div>


                        <div class="border-t mt-4 pt-4
                                    flex justify-between">

                            <span class="font-bold text-[#111827]">
                                Total
                            </span>

                            <span class="font-bold text-[#2563EB]">
                                Rs {{ number_format($order->grand_total, 2) }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-frontend-layout>
