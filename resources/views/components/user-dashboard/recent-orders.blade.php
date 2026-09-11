<div class="bg-white rounded-2xl shadow-sm border border-gray-100">

    {{-- =========================
         HEADER
    ========================== --}}
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">

        <div>
            <h2 class="text-lg font-bold text-gray-900">
                Recent Orders
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Your latest orders
            </p>
        </div>

        <a
            href="{{ route('user.orders') }}"
            class="text-sm font-semibold text-blue-600 hover:text-blue-700"
        >
            View All
        </a>

    </div>


    {{-- =========================
         ORDERS
    ========================== --}}
    <div class="divide-y divide-gray-100">

        @forelse($recentOrders as $order)

            <div class="px-6 py-5">

                {{-- ORDER TOP --}}
                <div class="flex items-center justify-between gap-4 mb-4">

                    {{-- ORDER NUMBER + DATE --}}
                    <div class="min-w-0">

                        <p class="font-semibold text-gray-900">
                            #{{ $order->order_number }}
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $order->created_at->format('M d, Y') }}
                        </p>

                    </div>


                    {{-- STATUS --}}
                    <div class="text-center">

                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            @if($order->order_status === 'delivered')
                                bg-green-100 text-green-700
                            @elseif($order->order_status === 'cancelled')
                                bg-red-100 text-red-700
                            @elseif($order->order_status === 'shipped')
                                bg-blue-100 text-blue-700
                            @else
                                bg-yellow-100 text-yellow-700
                            @endif"
                        >
                            {{ ucfirst($order->order_status) }}
                        </span>

                    </div>

                </div>


                {{-- =========================
                     ORDER PRODUCTS
                ========================== --}}
                <div class="space-y-3">

                    @foreach($order->items as $item)

                        <div
                            class="flex items-center gap-4
                                   bg-gray-50 rounded-xl
                                   p-3 border border-gray-100"
                        >

                            {{-- PRODUCT IMAGE --}}
                            <div
                                class="w-16 h-16 flex-shrink-0
                                       rounded-xl overflow-hidden
                                       bg-white border border-gray-200"
                            >

                                @if($item->product && $item->product->image)

                                    <img
                                        src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}"
                                        class="w-full h-full object-cover"
                                    >

                                @else

                                    <div
                                        class="w-full h-full flex items-center justify-center
                                               text-gray-400 text-2xl"
                                    >
                                        🛍️
                                    </div>

                                @endif

                            </div>


                            {{-- PRODUCT INFORMATION --}}
                            <div class="flex-1 min-w-0">

                                <h3
                                    class="font-semibold text-gray-900
                                           text-sm sm:text-base
                                           truncate"
                                >
                                    {{ $item->product->name ?? 'Product' }}
                                </h3>

                                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                    Qty: {{ $item->quantity }}
                                </p>

                            </div>


                            {{-- PRODUCT PRICE --}}
                            <div class="text-right flex-shrink-0">

                                <p class="font-semibold text-gray-900 text-sm">
                                    Rs. {{ number_format($item->price * $item->quantity, 2) }}
                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- =========================
                     ORDER BOTTOM
                ========================== --}}
                <div
                    class="flex items-center justify-between
                           gap-4 mt-4 pt-4
                           border-t border-gray-100"
                >

                    {{-- TOTAL --}}
                    <div>

                        <span class="text-sm text-gray-500">
                            Order Total
                        </span>

                        <p class="font-bold text-gray-900">
                            Rs. {{ number_format($order->grand_total, 2) }}
                        </p>

                    </div>


                    {{-- VIEW ORDER --}}
                    <a
                        href="{{ route('user.order.view', $order->id) }}"
                        class="inline-flex items-center
                               px-4 py-2
                               bg-blue-600 text-white
                               text-sm font-semibold
                               rounded-xl
                               hover:bg-blue-700
                               transition"
                    >
                        View Order
                    </a>

                </div>

            </div>

        @empty

            {{-- =========================
                 NO ORDERS
            ========================== --}}
            <div class="px-6 py-10 text-center">

                <div class="flex justify-center mb-3">

                    <div
                        class="w-12 h-12 rounded-full
                               bg-blue-50
                               flex items-center justify-center"
                    >
                        🛍️
                    </div>

                </div>

                <h3 class="font-semibold text-gray-900">
                    No orders yet
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Start shopping and your recent orders will appear here.
                </p>

                <a
                    href="{{ url('/products') }}"
                    class="inline-flex items-center
                           mt-4 px-5 py-2.5
                           bg-blue-600 text-white
                           text-sm font-semibold
                           rounded-xl
                           hover:bg-blue-700
                           transition"
                >
                    Start Shopping
                </a>

            </div>

        @endforelse

    </div>

</div>
