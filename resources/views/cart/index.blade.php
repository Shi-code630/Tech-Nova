<x-frontend-layout>

    <div class="bg-gradient-to-br from-gray-50 to-gray-100 py-8 ">

        <div class="container mx-auto px-4">

            {{-- Page Header --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-200 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Shopping Cart</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Review and manage your items</p>
                        </div>
                    </div>
                    @if($cartItems->count() > 0)
                        <div class="hidden sm:flex items-center gap-3 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 px-5 py-2.5 rounded-xl font-semibold text-sm border border-blue-200 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>
                            </svg>
                            {{ $cartItems->count() }} {{ $cartItems->count() == 1 ? 'Item' : 'Items' }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-4 rounded-xl border border-green-200 bg-gradient-to-r from-green-50 to-emerald-50 px-4 py-3 text-green-700 shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="mb-4 rounded-xl border border-red-200 bg-gradient-to-r from-red-50 to-rose-50 px-4 py-3 text-red-700 shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-red-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            {{-- Location Indicator --}}
            @if (Auth::check())
                <div class="mb-4 rounded-xl border border-blue-200 bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-3 text-sm text-blue-700 shadow-sm">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">📍</span>
                        <span>
                            @if (isset($isInsideValley) && $isInsideValley)
                                <strong>Inside Kathmandu Valley</strong> —
                                @if ($subtotal >= 10000)
                                    <span class="font-semibold text-green-600">🎉 Free Delivery!</span>
                                @else
                                    Delivery charges apply based on your order value.
                                    <a href="{{ route('user.addresses') }}" class="font-medium text-blue-600 hover:underline hover:text-blue-800 transition">
                                        Update your address
                                    </a>
                                @endif
                            @else
                                <strong>Outside Kathmandu Valley</strong> —
                                <span class="text-yellow-600">Delivery charges may be higher.</span>
                                <a href="{{ route('user.addresses') }}" class="font-medium text-blue-600 hover:underline hover:text-blue-800 transition">
                                    Update your address
                                </a>
                            @endif
                        </span>
                    </div>
                </div>
            @endif

            {{-- Cart Content --}}
            @if($cartItems->count() > 0)

                @php
                    $freeDeliveryThreshold = 10000;
                    $remainingForFreeDelivery = max(0, $freeDeliveryThreshold - $subtotal);
                    $deliveryProgress = min(100, ($subtotal / $freeDeliveryThreshold) * 100);
                    $taxRate = $taxRate ?? 13;
                @endphp

                {{-- Free delivery progress --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-5 mb-6">
                    <div class="flex items-center justify-between flex-wrap gap-2">
                        @if($remainingForFreeDelivery > 0)
                            <div class="flex items-center gap-3 text-sm text-gray-700">
                                <span class="text-2xl">🚛</span>
                                <span>
                                    Add <strong class="text-blue-600">Rs. {{ number_format($remainingForFreeDelivery, 2) }}</strong> more for <strong class="text-green-600">free delivery</strong>
                                </span>
                            </div>
                            <span class="text-sm font-semibold text-blue-600">{{ round($deliveryProgress) }}%</span>
                        @else
                            <div class="flex items-center gap-3 text-sm text-green-700 font-semibold">
                                <span class="text-2xl">🎉</span>
                                <span>Free delivery unlocked on this order!</span>
                            </div>
                        @endif
                    </div>
                    <div class="w-full h-2 rounded-full bg-gray-100 overflow-hidden mt-3">
                        <div class="h-full rounded-full transition-all duration-700 {{ $remainingForFreeDelivery > 0 ? 'bg-gradient-to-r from-blue-400 to-blue-600' : 'bg-gradient-to-r from-green-400 to-green-600' }}" style="width: {{ $deliveryProgress }}%"></div>
                    </div>
                </div>

                {{-- Grid Layout --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- CART ITEMS --}}
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

                            <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">

                                <div class="flex flex-col sm:flex-row gap-5">

                                    {{-- Product Image --}}
                                    <div class="w-20 h-20 sm:w-28 sm:h-28 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                                        @if($image)
                                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-3" onerror="this.src='{{ asset('images/default-product.png') }}'">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-300">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l2.159 2.159m-1.5 1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.409 2.409M3.75 19.5h16.5A1.5 1.5 0 0 0 21.75 18V6A1.5 1.5 0 0 0 20.25 4.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"/>
                                            </svg>
                                        @endif
                                    </div>

                                    {{-- Product Details --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                                            <div>
                                                <h3 class="font-semibold text-gray-800 hover:text-blue-600 transition">{{ $product->name ?? 'Product' }}</h3>
                                                @if ($item->variant)
                                                    <p class="text-sm text-gray-500 mt-0.5">{{ $item->variant->full_name ?? 'Standard' }}</p>
                                                @endif
                                                <p class="text-blue-600 font-bold text-xl mt-1">Rs. {{ number_format($unitPrice, 2) }}</p>
                                            </div>
                                            <div class="sm:text-right">
                                                <p class="text-xs text-gray-400">Item Total</p>
                                                <p class="font-bold text-gray-800 text-lg">Rs. {{ number_format($itemTotal, 2) }}</p>
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap items-center justify-between gap-3 mt-3 pt-3 border-t border-gray-100">

                                            {{-- Quantity --}}
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs text-gray-400 font-medium">Qty:</span>
                                                <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                                        <button type="submit" {{ $item->quantity <= 1 ? 'disabled' : '' }} class="w-9 h-9 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition disabled:opacity-40">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <span class="w-10 text-center font-semibold text-gray-800 text-sm">{{ $item->quantity }}</span>
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                                        <button type="submit" {{ $item->quantity >= $stock ? 'disabled' : '' }} class="w-9 h-9 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition disabled:opacity-40">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                                <span class="text-xs text-gray-400">(Max: {{ $stock }})</span>
                                            </div>

                                            {{-- Remove --}}
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Remove this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-500 hover:text-red-700 hover:bg-red-50 px-4 py-2 rounded-xl transition font-medium flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                                    </svg>
                                                    Remove
                                                </button>
                                            </form>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        @endforeach

                        {{-- Clear Cart Button --}}
                        <div class="flex flex-wrap gap-3 justify-between items-center mt-4">
                            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear your entire cart?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-500 hover:text-red-700 hover:bg-red-50 px-5 py-2.5 rounded-xl transition font-medium border border-red-200 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                    </svg>
                                    Clear Cart
                                </button>
                            </form>
                            <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:text-blue-800 hover:underline font-medium flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                                </svg>
                                Continue Shopping
                            </a>
                        </div>

                    </div>

                    {{-- ORDER SUMMARY --}}
                    <div class="lg:col-span-1">

                        <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-6 lg:sticky lg:top-6">

                            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                                </svg>
                                Order Summary
                            </h2>

                            <div class="space-y-3 mt-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Items ({{ $cartItems->count() }})</span>
                                    <span class="font-medium text-gray-800">Rs. {{ number_format($subtotal, 2) }}</span>
                                </div>

                                {{-- Delivery Charge --}}
                                <div class="flex justify-between text-sm border-b border-gray-100 pb-2">
                                    <span class="text-gray-500">Delivery Charge</span>
                                    <span class="font-medium {{ $deliveryCharge > 0 ? 'text-gray-600' : 'text-green-600' }}">
                                        @if($deliveryCharge == 0)
                                            <span class="flex items-center gap-1">Free 🎉</span>
                                        @else
                                            Rs. {{ number_format($deliveryCharge, 2) }}
                                        @endif
                                    </span>
                                </div>

                                {{-- Tax --}}
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Tax ({{ $taxRate }}% VAT)</span>
                                    <span class="font-medium text-gray-800">Rs. {{ number_format($taxAmount, 2) }}</span>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 my-4 pt-4">
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="font-bold text-gray-800">Total</p>
                                        <p class="text-xs text-gray-400">Including tax & delivery</p>
                                    </div>
                                    <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">Rs. {{ number_format($total, 2) }}</p>
                                </div>
                            </div>

                            {{-- Checkout Button --}}
                            <a href="{{ route('checkout') }}" class="mt-4 w-full block text-center px-6 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold transition-all duration-300 shadow-lg shadow-blue-200 hover:shadow-xl hover:-translate-y-0.5">
                                Proceed to Checkout →
                            </a>

                            <div class="flex items-center justify-center gap-2 mt-4 pt-4 border-t border-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-green-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 00-9 0v3.75m-.75 0h10.5A1.5 1.5 0 0118.75 12v6.75a1.5 1.5 0 01-1.5 1.5H6.75a1.5 1.5 0 01-1.5-1.5V12a1.5 1.5 0 011.5-1.5z"/>
                                </svg>
                                <span class="text-xs text-gray-400">Secure checkout • 100% encrypted</span>
                            </div>

                        </div>

                    </div>

                </div>

            @else

                {{-- Empty Cart --}}
                <div class="bg-white rounded-3xl border border-gray-200 shadow-xl p-8 text-center">
                    <div class="py-16">
                        <div class="w-28 h-28 mx-auto mb-6 rounded-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14 text-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Your Cart is Empty</h2>
                        <p class="text-gray-500 mt-3 max-w-md mx-auto">Looks like you haven't added anything to your cart yet. Start exploring our amazing products!</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-8 px-8 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold transition-all duration-300 shadow-lg shadow-blue-200 hover:shadow-xl hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>
                            </svg>
                            Start Shopping
                        </a>
                    </div>
                </div>

            @endif

        </div>

    </div>

</x-frontend-layout>
