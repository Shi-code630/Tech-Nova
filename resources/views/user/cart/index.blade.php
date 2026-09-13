<x-frontend-layout>

    <div class="bg-gray-50 py-8">

        <div class="container mx-auto px-4">

            <div class="flex flex-col lg:flex-row gap-6">

                {{-- Sidebar --}}
                <aside class="w-full lg:w-1/4">
                    <x-user-dashboard.sidebar />
                </aside>

                {{-- Main Content --}}
                <main class="flex-1 min-w-0">

                    {{-- Page Header --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6 text-[#2563EB]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold text-[#111827]">Shopping Cart</h1>
                                    <p class="text-sm text-gray-500 mt-1">Review and manage your items</p>
                                </div>
                            </div>
                            @if($cartItems->count() > 0)
                                <div class="hidden sm:flex items-center gap-2 bg-blue-50 text-[#2563EB] px-4 py-2 rounded-xl font-semibold text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>
                                    </svg>
                                    {{ $cartItems->count() }} {{ $cartItems->count() == 1 ? 'Item' : 'Items' }}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Error Message --}}
                    @if (session('error'))
                        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Location Indicator --}}
                    @if (Auth::check())
                        <div class="mb-4 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-700">
                            <div class="flex items-center gap-2">
                                <span>📍</span>
                                <span>
                                    @if (isset($isInsideValley) && $isInsideValley)
                                        <strong>Inside Kathmandu Valley</strong> —
                                        @if ($subtotal >= 10000)
                                            <span class="font-semibold text-green-600">🎉 Free Delivery!</span>
                                        @else
                                            Delivery charges apply based on your order value.
                                            <a href="{{ route('checkout.addresses') }}" class="font-medium text-blue-600 hover:underline">
                                                Update your address
                                            </a>
                                        @endif
                                    @else
                                        <strong>Outside Kathmandu Valley</strong> —
                                        <span class="text-yellow-600">Delivery charges may be higher.</span>
                                        <a href="{{ route('checkout.addresses') }}" class="font-medium text-blue-600 hover:underline">
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

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                            {{-- ============================= --}}
                            {{-- CART ITEMS (2 columns) --}}
                            {{-- ============================= --}}
                            <div class="lg:col-span-2 space-y-4">

                                {{-- Free delivery progress --}}
                                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                                    @if($remainingForFreeDelivery > 0)
                                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                                            <span class="text-lg">🚛</span>
                                            <span>
                                                Add <strong class="text-[#2563EB]">Rs. {{ number_format($remainingForFreeDelivery, 2) }}</strong> more for <strong>free delivery</strong>
                                            </span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 text-sm text-green-600 mb-2 font-semibold">
                                            <span class="text-lg">🎉</span>
                                            <span>Free delivery unlocked on this order!</span>
                                        </div>
                                    @endif
                                    <div class="w-full h-1.5 rounded-full bg-gray-100 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-500 {{ $remainingForFreeDelivery > 0 ? 'bg-[#2563EB]' : 'bg-green-500' }}" style="width: {{ $deliveryProgress }}%"></div>
                                    </div>
                                </div>

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

                                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition duration-200">

                                        <div class="flex flex-col sm:flex-row gap-5">

                                            {{-- Product Image --}}
                                            <div class="w-full sm:w-24 h-24 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                                                @if($image)
                                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-2" onerror="this.src='{{ asset('images/default-product.png') }}'">
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-300">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l2.159 2.159m-1.5 1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.409 2.409M3.75 19.5h16.5A1.5 1.5 0 0 0 21.75 18V6A1.5 1.5 0 0 0 20.25 4.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"/>
                                                    </svg>
                                                @endif
                                            </div>

                                            {{-- Product Details --}}
                                            <div class="flex-1 min-w-0">
                                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                                                    <div>
                                                        <h3 class="font-semibold text-[#111827]">{{ $product->name ?? 'Product' }}</h3>
                                                        @if ($item->variant)
                                                            <p class="text-sm text-gray-500 mt-0.5">{{ $item->variant->full_name ?? 'Standard' }}</p>
                                                        @endif
                                                        <p class="text-[#2563EB] font-bold text-lg mt-1">Rs. {{ number_format($unitPrice, 2) }}</p>
                                                    </div>
                                                    <div class="sm:text-right">
                                                        <p class="text-sm text-gray-500">Item Total</p>
                                                        <p class="font-bold text-[#111827] text-lg">Rs. {{ number_format($itemTotal, 2) }}</p>
                                                    </div>
                                                </div>

                                                <div class="flex flex-wrap items-center justify-between gap-3 mt-3 pt-3 border-t border-gray-100">

                                                    {{-- Quantity --}}
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-xs text-gray-500">Qty:</span>
                                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-1">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                                            <button type="submit" {{ $item->quantity <= 1 ? 'disabled' : '' }} class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 transition disabled:opacity-40">−</button>
                                                        </form>
                                                        <span class="w-8 text-center font-semibold text-[#111827]">{{ $item->quantity }}</span>
                                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-1">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                                            <button type="submit" {{ $item->quantity >= $stock ? 'disabled' : '' }} class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 transition disabled:opacity-40">+</button>
                                                        </form>
                                                        <span class="text-xs text-gray-400 ml-1">(Max: {{ $stock }})</span>
                                                    </div>

                                                    {{-- Remove --}}
                                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Remove this item?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-sm text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1 rounded-lg transition font-medium">
                                                            Remove
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                @endforeach

                                {{-- Clear Cart Button --}}
                                <div class="flex justify-end">
                                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear your entire cart?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-500 hover:text-red-700 hover:bg-red-50 px-4 py-2 rounded-lg transition font-medium border border-red-200">
                                            🗑️ Clear Cart
                                        </button>
                                    </form>
                                </div>

                            </div>

                            {{-- ============================= --}}
                            {{-- ORDER SUMMARY (1 column) --}}
                            {{-- ============================= --}}
                            <div class="lg:col-span-1">

                                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 lg:sticky lg:top-6">

                                    <h2 class="text-lg font-bold text-[#111827] border-b border-gray-200 pb-4">Order Summary</h2>

                                    <div class="space-y-3 mt-4">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-500">Items ({{ $cartItems->count() }})</span>
                                            <span class="font-medium text-[#111827]">Rs. {{ number_format($subtotal, 2) }}</span>
                                        </div>

                                        {{-- Delivery Charge --}}
                                        <div class="flex justify-between text-sm border-b border-gray-100 pb-2">
                                            <span class="text-gray-500">Delivery Charge</span>
                                            <span class="font-medium {{ $deliveryCharge > 0 ? 'text-gray-600' : 'text-green-600' }}">
                                                @if($deliveryCharge == 0)
                                                    Free 🎉
                                                @else
                                                    Rs. {{ number_format($deliveryCharge, 2) }}
                                                @endif
                                            </span>
                                        </div>

                                        {{-- Tax --}}
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-500">Tax ({{ $taxRate }}% VAT)</span>
                                            <span class="font-medium text-[#111827]">Rs. {{ number_format($taxAmount, 2) }}</span>
                                        </div>
                                    </div>

                                    <div class="border-t border-gray-200 my-4 pt-4">
                                        <div class="flex justify-between items-end">
                                            <div>
                                                <p class="font-bold text-[#111827]">Total</p>
                                                <p class="text-xs text-gray-500">Including tax & delivery</p>
                                            </div>
                                            <p class="text-2xl font-bold text-[#2563EB]">Rs. {{ number_format($total, 2) }}</p>
                                        </div>
                                    </div>

                                    {{-- ✅ Checkout Button - Correct Route --}}
                                    <a href="{{ route('checkout') }}" class="mt-4 w-full block text-center px-6 py-3 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white font-semibold transition shadow-sm hover:shadow-md">
                                        Proceed to Checkout →
                                    </a>

                                    <div class="flex items-center justify-center gap-2 mt-4 pt-4 border-t border-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="w-5 h-5 text-green-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75m-.75 0h10.5A1.5 1.5 0 0 1 18.75 12v6.75a1.5 1.5 0 0 1-1.5 1.5H6.75a1.5 1.5 0 0 1-1.5-1.5V12a1.5 1.5 0 0 1 1.5-1.5Z"/>
                                        </svg>
                                        <span class="text-xs text-gray-500">Secure checkout</span>
                                    </div>

                                    {{-- Continue Shopping Link --}}
                                    <div class="mt-4 text-center">
                                        <a href="{{ route('home') }}" class="text-sm text-[#2563EB] hover:underline font-medium">
                                            ← Continue Shopping
                                        </a>
                                    </div>

                                </div>

                            </div>

                        </div>

                    @else

                        {{-- Empty Cart --}}
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
                            <div class="text-center py-12">
                                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-blue-50 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-[#2563EB]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold text-[#111827]">Your Cart is Empty</h2>
                                <p class="text-gray-500 mt-2 max-w-md mx-auto">Start adding items to your cart and they'll appear here.</p>
                                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white font-semibold transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>
                                    </svg>
                                    Start Shopping
                                </a>
                            </div>
                        </div>

                    @endif

                </main>

            </div>

        </div>

    </div>

</x-frontend-layout>
