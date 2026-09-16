<x-frontend-layout>

    <div class="bg-gray-100 min-h-screen py-6 sm:py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">

            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">

                <h1 class="text-xl sm:text-2xl font-bold text-[#111827]">
                    Confirm Checkout
                </h1>

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="mt-4 rounded-lg border border-green-200 bg-green-50 p-3 sm:p-4 text-sm text-green-700">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if (session('error'))
                    <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-3 sm:p-4 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-3 sm:p-4 text-sm text-red-700">
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Delivery Address --}}
                <div class="mt-6 border rounded-xl p-3 sm:p-4">
                    <h2 class="font-semibold text-base sm:text-lg">Delivery Address</h2>
                    <p class="text-gray-600 mt-2 break-words">{{ $address->full_name }}</p>
                    <p class="text-gray-600 mt-2 break-words">{{ $address->phone }}</p>
                    <p class="text-gray-600 mt-2 break-words">
                        {{ $address->province }}, {{ $address->city }}, {{ $address->ward_number }}
                        {{ $address->full_address }}
                    </p>
                </div>

                {{-- Payment Method --}}
                <div class="mt-4 border rounded-xl p-3 sm:p-4">
                    <h2 class="font-semibold text-base sm:text-lg">Payment Method</h2>
                    <p class="text-gray-600 mt-2">
                        {{ $paymentMethod === 'cod' ? 'Cash on Delivery' : 'Online Payment' }}
                    </p>
                </div>

                {{-- ✅ Coupon Section — NO JS --}}
                <div class="mt-4 border rounded-xl p-3 sm:p-4">
                    <h2 class="font-semibold text-base sm:text-lg mb-3 flex items-center gap-2">
                        <span>🎁</span> Coupon
                    </h2>

                    @if (!empty($couponCode))
                        {{-- Coupon Applied → Remove Form --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl bg-green-50 border border-green-200 px-3 sm:px-4 py-3">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="text-lg flex-shrink-0">✅</span>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-green-700 truncate">{{ $couponCode }}</p>
                                    <p class="text-xs text-green-600">
                                        Discount: Rs. {{ number_format($couponDiscount, 2) }}
                                    </p>
                                </div>
                            </div>

                            {{-- ✅ Normal form — JS बिना --}}
                            <form action="{{ route('checkout.coupon.remove') }}" method="POST" class="flex-shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-xs font-semibold text-red-600 hover:text-red-800 hover:underline transition">
                                    Remove
                                </button>
                            </form>
                        </div>
                    @else
                        {{-- Coupon Input → Apply Form --}}
                        <form action="{{ route('checkout.coupon.apply') }}" method="POST">
                            @csrf

                            <div class="flex gap-2">
                                <div class="relative flex-1 min-w-0">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                        🎟️
                                    </span>
                                    <input type="text" name="code" placeholder="Enter coupon code"
                                           value="{{ old('code') }}"
                                           class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 text-sm uppercase focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100 outline-none transition">
                                </div>
                                <button type="submit"
                                        class="px-4 py-2 rounded-lg bg-[#2563EB] hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold flex-shrink-0 transition">
                                    Apply
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

                {{-- ✅ Order Summary --}}
                <div class="mt-4 border rounded-xl overflow-hidden">
                    <div class="bg-gray-50 px-3 sm:px-4 py-3 border-b">
                        <h2 class="font-semibold text-base sm:text-lg text-[#111827]">Order Summary</h2>
                    </div>

                    <div class="p-3 sm:p-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-medium">Rs. {{ number_format($subtotal, 2) }}</span>
                        </div>

                        @if (!empty($couponCode))
                            <div class="flex justify-between text-sm">
                                <span class="text-green-600 flex items-center gap-1">
                                    <span>🎁</span> {{ $couponCode }}
                                </span>
                                <span class="font-medium text-green-600">
                                    - Rs. {{ number_format($couponDiscount, 2) }}
                                </span>
                            </div>
                        @endif

                        @if ($pointsDiscount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-green-600 flex items-center gap-1">
                                    <span>⭐</span> {{ number_format($redeemPoints) }} pts
                                </span>
                                <span class="font-medium text-green-600">
                                    - Rs. {{ number_format($pointsDiscount, 2) }}
                                </span>
                            </div>
                        @endif

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Delivery</span>
                            <span class="font-medium">
                                @if($deliveryCharge == 0)
                                    <span class="text-green-600">Free</span>
                                @else
                                    Rs. {{ number_format($deliveryCharge, 2) }}
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Tax (13%)</span>
                            <span class="font-medium">Rs. {{ number_format($tax, 2) }}</span>
                        </div>
                    </div>

                    <div class="bg-blue-50 px-3 sm:px-4 py-3 border-t flex justify-between font-bold text-base sm:text-lg">
                        <span class="text-[#111827]">Total</span>
                        <span class="text-[#2563EB]">Rs. {{ number_format($grandTotal, 2) }}</span>
                    </div>
                </div>

                {{-- Place Order Form --}}
                <form action="{{ route('checkout.place-order') }}" method="POST" enctype="multipart/form-data" class="mt-6">
                    @csrf

                    <input type="hidden" name="address_id" value="{{ $address->id }}">
                    <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
                    <input type="hidden" name="coupon_code" value="{{ $couponCode }}">
                    <input type="hidden" name="redeem_points" value="{{ $redeemPoints }}">

                    @if ($paymentMethod === 'online')
                        <div class="mt-4 border border-blue-100 bg-blue-50 rounded-xl p-3 sm:p-4">
                            <h2 class="font-semibold text-base sm:text-lg">eSewa Payment</h2>
                            <p class="text-sm text-gray-600 mt-2">
                                Please upload your eSewa payment screenshot and enter the
                                transaction ID after completing the payment.
                            </p>

                            <div class="mt-4 sm:mt-5 text-center">
                                <h3 class="font-semibold text-[#111827]">Scan to Pay with eSewa</h3>
                                <p class="text-sm text-gray-500 mt-1">Scan the QR code.</p>

                                <div class="mt-4 flex justify-center">
                                    <div class="bg-white p-3 rounded-xl shadow-sm border">
                                        <img src="{{ asset('image/payment/merchant-qr.png') }}"
                                             alt="TechNova Nepal eSewa QR Code"
                                             class="w-48 h-48 sm:w-56 sm:h-56 object-contain">
                                    </div>
                                </div>

                                <p class="text-sm text-gray-500 mt-4">Amount to Pay</p>
                                <p class="text-xl sm:text-2xl font-bold text-[#2563EB] mt-1">
                                    Rs. {{ number_format($grandTotal, 2) }}
                                </p>
                            </div>

                            <div class="mt-4">
                                <label for="transaction_id" class="block text-sm font-medium text-[#111827] mb-2">
                                    Transaction ID
                                </label>
                                <input type="text" id="transaction_id" name="transaction_id"
                                       value="{{ old('transaction_id') }}" required maxlength="100"
                                       placeholder="Enter your eSewa transaction ID"
                                       class="w-full rounded-xl border border-gray-300 px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100 outline-none transition">
                            </div>

                            <div class="mt-4">
                                <label for="payment_screenshot" class="block text-sm font-medium text-[#111827] mb-2">
                                    Payment Screenshot
                                </label>
                                <input type="file" id="payment_screenshot" name="payment_screenshot"
                                       accept="image/jpeg,image/png,image/jpg,image/webp" required
                                       class="w-full rounded-xl border border-gray-300 bg-white px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs sm:file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100 outline-none transition">
                                <p class="text-xs text-gray-500 mt-2">
                                    Upload a clear screenshot. Maximum size: 5 MB.
                                </p>
                            </div>
                        </div>
                    @endif

                    <button type="submit"
                            class="mt-6 w-full bg-[#2563EB] hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-2.5 sm:py-3 text-sm sm:text-base rounded-xl transition">
                        Place Order
                    </button>

                </form>

            </div>
        </div>
    </div>

</x-frontend-layout>
