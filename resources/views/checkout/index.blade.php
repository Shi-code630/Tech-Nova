<x-frontend-layout title="Checkout">

    <div class="bg-gray-100 min-h-screen py-6 sm:py-10">
        <div class="w-[95%] max-w-7xl mx-auto">

            {{-- Flash Messages --}}
            @if (session('error'))
                <div class="mb-4 sm:mb-6 bg-red-50 border border-red-200 text-red-700 px-3 sm:px-4 py-3 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 sm:mb-6 bg-red-50 border border-red-200 text-red-700 px-3 sm:px-4 py-3 rounded-xl text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="checkoutForm" action="{{ route('checkout.place-order') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Header --}}
                <div class="mb-6 sm:mb-8">
                    <h1 class="text-2xl sm:text-3xl font-bold text-[#111827]">Checkout</h1>
                    <p class="text-sm sm:text-base text-gray-500 mt-1 sm:mt-2">Review your order before placing it.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">

                    {{-- Left Column: Order Details --}}
                    <div class="lg:col-span-2 space-y-4 sm:space-y-6">

                        {{-- Delivery Address --}}
                        <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                            <div class="mb-4 sm:mb-6">
                                <h2 class="text-lg sm:text-xl font-semibold text-[#111827]">Delivery Address</h2>
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">Choose or add a new delivery address.</p>
                            </div>

                            @if ($addresses->count())
                                <div class="space-y-3 sm:space-y-4">
                                    @foreach ($addresses as $address)
                                        <label class="block border border-gray-200 rounded-xl p-3 sm:p-4 hover:border-[#2563EB] transition cursor-pointer">
                                            <div class="flex items-start gap-3 sm:gap-4">
                                                <input
                                                    type="radio"
                                                    name="address_id"
                                                    value="{{ $address->id }}"
                                                    class="mt-1 w-4 h-4 text-[#2563EB] address-radio flex-shrink-0"
                                                    {{ $address->is_default ? 'checked' : '' }}
                                                >

                                                <div class="flex-1 min-w-0">
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <h3 class="font-semibold text-[#111827] text-sm sm:text-base break-words">
                                                            {{ $address->full_name }}
                                                        </h3>

                                                        @if ($address->is_default)
                                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-[#2563EB] whitespace-nowrap">
                                                                Default
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <p class="text-xs sm:text-sm text-gray-600 mt-1">
                                                        {{ $address->phone }}
                                                    </p>

                                                    <p class="text-xs sm:text-sm text-gray-500 mt-2 break-words">
                                                        {{ $address->address }},
                                                        {{ $address->city }},
                                                        {{ $address->district }},
                                                        {{ $address->province }}
                                                        @if ($address->postal_code)
                                                            - {{ $address->postal_code }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="mt-4">
                                    <label class="flex items-center gap-2 cursor-pointer text-[#2563EB] hover:underline">
                                        <input
                                            type="radio"
                                            name="address_id"
                                            value="new"
                                            id="newAddressRadio"
                                            class="w-4 h-4 text-[#2563EB] address-radio"
                                        >
                                        <span class="text-sm font-medium">+ Add New Address</span>
                                    </label>
                                </div>
                            @else
                                <div class="border border-dashed border-gray-300 rounded-xl p-6 sm:p-8 text-center">
                                    <h3 class="font-semibold text-[#111827] text-sm sm:text-base">
                                        No delivery address found
                                    </h3>
                                    <p class="text-xs sm:text-sm text-gray-500 mt-2">
                                        Please add a delivery address.
                                    </p>
                                </div>
                            @endif

                            {{-- New Address Form --}}
                            <div id="newAddressForm" style="display: none;" class="mt-4 sm:mt-6 p-3 sm:p-4 border border-blue-200 rounded-xl bg-blue-50">
                                <h3 class="font-semibold text-[#111827] mb-4 text-sm sm:text-base">
                                    Add New Address
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                                    @php
                                        $fields = [
                                            ['new_full_name', 'Full Name', true],
                                            ['new_phone', 'Phone', true],
                                            ['new_province', 'Province', true],
                                            ['new_district', 'District', true],
                                            ['new_city', 'City', true],
                                            ['new_address', 'Address', true],
                                            ['new_postal_code', 'Postal Code', false],
                                        ];
                                    @endphp

                                    @foreach ($fields as [$id, $label, $required])
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                                                {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
                                            </label>
                                            <input
                                                type="text"
                                                name="{{ $id }}"
                                                id="{{ $id }}"
                                                class="w-full px-3 sm:px-4 py-2 text-sm rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-blue-200 transition"
                                            >
                                        </div>
                                    @endforeach

                                    <div class="flex flex-col sm:flex-row items-stretch sm:items-end gap-2 md:col-span-2">
                                        <button
                                            type="button"
                                            onclick="saveNewAddress(event)"
                                            class="px-4 sm:px-6 py-2 bg-[#2563EB] hover:bg-blue-700 text-white rounded-lg font-semibold transition text-sm">
                                            Save Address
                                        </button>
                                        <button
                                            type="button"
                                            onclick="cancelNewAddress()"
                                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Method --}}
                        <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                            <div class="mb-4 sm:mb-6">
                                <h2 class="text-lg sm:text-xl font-semibold text-[#111827]">Payment Method</h2>
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">Choose how you want to pay.</p>
                            </div>

                            <div class="space-y-3 sm:space-y-4">
                                <label class="flex items-start gap-3 sm:gap-4 border border-gray-200 rounded-xl p-3 sm:p-4 cursor-pointer hover:border-[#2563EB] transition">
                                    <input type="radio" name="payment_method" value="cod" id="paymentCod" checked class="mt-1 w-4 h-4 text-[#2563EB] flex-shrink-0">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-[#111827] text-sm sm:text-base">Cash on Delivery</h3>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Pay when your order is delivered.</p>
                                    </div>
                                </label>

                                <label class="flex items-start gap-3 sm:gap-4 border border-gray-200 rounded-xl p-3 sm:p-4 cursor-pointer hover:border-[#2563EB] transition">
                                    <input type="radio" name="payment_method" value="online" id="paymentOnline" class="mt-1 w-4 h-4 text-[#2563EB] flex-shrink-0">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-[#111827] text-sm sm:text-base">Online Payment</h3>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Pay securely using eSewa / Khalti.</p>
                                    </div>
                                </label>
                            </div>

                            {{-- Online Payment Details --}}
                            <div id="onlinePaymentDetails" style="display: none;" class="mt-4 p-3 sm:p-4 border border-blue-200 rounded-xl bg-blue-50 space-y-4">
                                <div class="text-center">
                                    <div class="bg-white p-3 sm:p-4 rounded-xl inline-block shadow-sm border border-gray-200">
                                        <img
                                            src="{{ asset('images/qr-code.png') }}"
                                            alt="Payment QR Code"
                                            class="w-40 h-40 sm:w-48 sm:h-48 object-contain mx-auto"
                                            onerror="this.src='{{ asset('images/default-qr.png') }}'"
                                        >
                                        <p class="text-xs sm:text-sm font-medium text-gray-700 mt-2">Scan to Pay</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Scan this QR code with your eSewa / Khalti app
                                    </p>
                                </div>

                                <p class="text-xs sm:text-sm text-gray-600 text-center">
                                    Send payment to <strong>eSewa ID: 98XXXXXXXX</strong>,
                                    then enter the transaction ID and upload a screenshot below.
                                </p>

                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                                        Transaction ID <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="transaction_id"
                                        id="transaction_id"
                                        class="w-full px-3 sm:px-4 py-2 text-sm rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-blue-200 transition"
                                        placeholder="e.g. 9A7B2C1D0E"
                                    >
                                </div>

                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                                        Payment Screenshot <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="file"
                                        name="payment_screenshot"
                                        id="payment_screenshot"
                                        accept="image/jpeg,image/jpg,image/png,image/webp"
                                        class="w-full text-xs sm:text-sm text-gray-600 file:mr-3 file:py-2 file:px-3 sm:file:px-4
                                               file:rounded-lg file:border-0 file:font-semibold file:text-xs sm:file:text-sm
                                               file:bg-[#2563EB] file:text-white hover:file:bg-blue-700
                                               border border-gray-300 rounded-lg"
                                    >
                                    <p class="text-xs text-gray-400 mt-1">JPG, PNG or WEBP. Max 5MB.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Order Items --}}
                        <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                            <h2 class="text-lg sm:text-xl font-semibold text-[#111827] mb-4 sm:mb-6">
                                Your Items
                            </h2>

                            @foreach ($cartItems as $item)
                                <div class="flex items-start sm:items-center gap-3 sm:gap-4 border-b border-gray-100 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-gray-50 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        @php
                                            $thumbnails = $item->product->thumbnails ?? [];
                                            $image = !empty($thumbnails) && is_array($thumbnails)
                                                ? asset('storage/' . $thumbnails[0])
                                                : null;
                                        @endphp

                                        @if ($image)
                                            <img
                                                src="{{ $image }}"
                                                alt="{{ $item->product->name }}"
                                                class="w-full h-full object-contain rounded-xl"
                                                onerror="this.src='{{ asset('images/default-product.png') }}'"
                                            >
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l2.159 2.159m-1.5 1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.409 2.409M3.75 19.5h16.5A1.5 1.5 0 0 0 21.75 18V6A1.5 1.5 0 0 0 20.25 4.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />
                                            </svg>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-[#111827] text-sm sm:text-base truncate">
                                            {{ $item->product->name ?? 'Product' }}
                                        </h3>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                            Qty: {{ $item->quantity }}
                                        </p>
                                        <p class="text-[#2563EB] font-semibold mt-1 text-sm sm:text-base">
                                            Rs {{ number_format($item->price, 2) }}
                                        </p>
                                    </div>

                                    <div class="text-right flex-shrink-0">
                                        <p class="font-bold text-[#111827] text-sm sm:text-base">
                                            Rs {{ number_format($item->price * $item->quantity, 2) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    {{-- Right Column: Order Summary --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 lg:sticky lg:top-6">

                            <h2 class="text-lg sm:text-xl font-semibold text-[#111827] mb-4 sm:mb-6">
                                Order Summary
                            </h2>

                            {{-- Subtotal --}}
                            <div class="flex justify-between text-sm mb-3 sm:mb-4">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-medium" id="subtotalDisplay">Rs {{ number_format($subtotal, 2) }}</span>
                            </div>

                            {{-- Delivery --}}
                            <div class="flex justify-between text-sm mb-3 sm:mb-4">
                                <span class="text-gray-500">Delivery</span>
                                <span class="font-medium" id="deliveryDisplay">
                                    @if($deliveryCharge == 0)
                                        <span class="text-green-600">Free</span>
                                    @else
                                        Rs {{ number_format($deliveryCharge, 2) }}
                                    @endif
                                </span>
                            </div>

                            {{-- Location Notice --}}
                            @if(isset($isInsideValley) && $isInsideValley)
                                <div class="text-xs text-gray-500 mb-3 sm:mb-4 p-2 bg-blue-50 rounded-lg">
                                    <span>📍 </span>Inside Kathmandu Valley
                                    @if($deliveryCharge == 0)
                                        <span class="text-green-600 block">Free delivery applies!</span>
                                    @else
                                        <span class="block mt-1">Delivery charge depends on your order value.</span>
                                    @endif
                                </div>
                            @else
                                <div class="text-xs text-gray-500 mb-3 sm:mb-4 p-2 bg-blue-50 rounded-lg">
                                    <span>📍 </span>Outside Kathmandu Valley
                                    @if($deliveryCharge > 0)
                                        <span class="block text-yellow-600">Higher delivery charges apply</span>
                                    @endif
                                </div>
                            @endif

                            {{-- Tax --}}
                            <div class="flex justify-between text-sm mb-3 sm:mb-4">
                                <span class="text-gray-500">Tax (13%)</span>
                                <span class="font-medium" id="taxDisplay">Rs {{ number_format($tax, 2) }}</span>
                            </div>

                            {{-- Coupon Section --}}
                            <div class="border-t border-gray-200 pt-3 sm:pt-4 mt-3 sm:mt-4 mb-3 sm:mb-4">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-lg">🎁</span>
                                    <span class="font-medium text-[#111827] text-sm sm:text-base">Coupon</span>
                                </div>

                                <div id="couponIdle" class="{{ !empty($appliedCoupon) ? 'hidden' : '' }}">
                                    <div class="flex gap-2">
                                        <input type="text" id="couponInput" placeholder="Enter code"
                                               value="{{ old('coupon_code', $appliedCoupon['code'] ?? '') }}"
                                               class="flex-1 min-w-0 px-3 py-2 rounded-lg border border-gray-200 text-sm uppercase focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100 outline-none">
                                        <button type="button" onclick="applyCoupon()"
                                                class="px-3 sm:px-4 py-2 rounded-lg bg-[#2563EB] hover:bg-blue-700 text-white text-sm font-semibold flex-shrink-0">
                                            Apply
                                        </button>
                                    </div>
                                    <p id="couponMessage" class="text-xs mt-2"></p>
                                </div>

                                <div id="couponApplied" class="{{ empty($appliedCoupon) ? 'hidden' : '' }}">
                                    <div class="flex items-center justify-between gap-2 rounded-xl bg-green-50 border border-green-200 px-3 py-2">
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-green-700 truncate" id="couponCodeLabel">{{ $appliedCoupon['code'] ?? '' }}</p>
                                            <p class="text-xs text-green-600">Discount: Rs. <span id="couponDiscountLabel">{{ number_format($couponDiscount ?? 0, 2) }}</span></p>
                                        </div>
                                        <button type="button" onclick="removeCoupon()" class="text-xs font-semibold text-red-600 hover:underline flex-shrink-0">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="couponDiscountRow" class="flex justify-between text-sm mb-3 sm:mb-4 {{ ($couponDiscount ?? 0) > 0 ? '' : 'hidden' }}">
                                <span class="text-green-600">Coupon discount</span>
                                <span class="font-medium text-green-600">- Rs <span id="couponDiscountDisplay">{{ number_format($couponDiscount ?? 0, 2) }}</span></span>
                            </div>

                            <input type="hidden" name="coupon_code" id="couponCodeHidden" value="{{ $appliedCoupon['code'] ?? '' }}">

                            {{-- Reward Coins Section --}}
                            @if($coinSummary['available'] > 0)
                                <div class="border-t border-gray-200 pt-3 sm:pt-4 mt-3 sm:mt-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-lg">⭐</span>
                                        <span class="font-medium text-[#111827] text-sm sm:text-base">Reward Coins</span>
                                    </div>

                                    <p class="text-xs sm:text-sm text-gray-500">
                                        Available: <strong id="availableCoins">{{ number_format($coinSummary['available']) }}</strong> coins
                                        (Value: Rs. <span id="coinsValue">{{ number_format($coinSummary['value'], 2) }}</span>)
                                    </p>

                                    <label class="flex items-center gap-2 cursor-pointer mt-2">
                                        <input type="checkbox" id="useCoins" onchange="toggleCoinSection()">
                                        <span class="text-xs sm:text-sm">Use coins for discount</span>
                                    </label>

                                    <div id="coinSection" style="display: none;" class="mt-3">
                                        <div class="flex items-center gap-3">
                                            <input
                                                type="range"
                                                id="redeemPoints"
                                                min="0"
                                                max="{{ $maxRedeemPoints }}"
                                                value="0"
                                                step="1"
                                                oninput="updateCoinValue(this.value)"
                                                class="flex-1 min-w-0"
                                            >
                                            <span class="font-bold min-w-[50px] sm:min-w-[60px] text-center text-sm" id="pointsDisplay">0</span>
                                        </div>

                                        <div class="flex justify-between text-xs text-gray-500 mt-1 gap-2">
                                            <span>0 pts</span>
                                            <span>Discount: Rs. <span id="discountDisplay">0.00</span></span>
                                            <span>Max: {{ number_format($maxRedeemPoints) }}</span>
                                        </div>

                                        <p class="text-xs text-gray-400 mt-1">
                                            Max {{ $coinSummary['max_discount_percent'] }}% of order |
                                            {{ $coinSummary['redeem_rate'] }} coins = Rs.1
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{-- Total --}}
                            <div class="border-t border-gray-200 pt-3 sm:pt-4 mt-3 sm:mt-4">
                                <div class="flex justify-between font-bold text-lg sm:text-xl">
                                    <span class="text-[#111827]">Total</span>
                                    <span class="text-[#2563EB]" id="grandTotal">
                                        Rs {{ number_format($subtotal + $deliveryCharge + $tax, 2) }}
                                    </span>
                                </div>

                                <p class="text-xs text-gray-500 mt-1" id="savingsText" style="display: none;">
                                    You save: Rs. <span id="savingsAmount">0.00</span>
                                </p>
                            </div>

                            {{-- Hidden Values --}}
                            <input type="hidden" name="redeem_points" id="redeemPointsHidden" value="0">
                            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                            <input type="hidden" name="delivery_charge" value="{{ $deliveryCharge }}">
                            <input type="hidden" name="tax" value="{{ $tax }}">

                            {{-- Place Order --}}
                            <button
                                type="submit"
                                id="placeOrderBtn"
                                class="w-full mt-4 sm:mt-6 py-3 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white font-semibold transition text-sm sm:text-base"
                            >
                                Place Order
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        // ============ Data from PHP ============
        const subtotal = {{ $subtotal }};
        const deliveryCharge = {{ $deliveryCharge }};
        const tax = {{ $tax }};
        const redeemRate = {{ $coinSummary['redeem_rate'] ?? 20 }};
        const maxDiscountPercent = {{ $coinSummary['max_discount_percent'] ?? 10 }};
        let couponDiscount = {{ $couponDiscount ?? 0 }};

        // ============ DOM Elements ============
        const grandTotalEl = document.getElementById('grandTotal');
        const savingsText = document.getElementById('savingsText');
        const savingsAmount = document.getElementById('savingsAmount');
        const redeemPointsInput = document.getElementById('redeemPointsHidden');

        // ============ Address Radio Toggle ============
        document.querySelectorAll('.address-radio').forEach(el => {
            el.addEventListener('change', function () {
                const form = document.getElementById('newAddressForm');
                const isNew = this.value === 'new';

                form.style.display = isNew ? 'block' : 'none';

                document.querySelectorAll('input[name="address_id"]').forEach(radio => {
                    if (radio.value !== 'new') radio.required = !isNew;
                });
            });
        });

        // ============ Payment Method Toggle ============
        const paymentCod = document.getElementById('paymentCod');
        const paymentOnline = document.getElementById('paymentOnline');
        const onlinePaymentDetails = document.getElementById('onlinePaymentDetails');
        const transactionIdInput = document.getElementById('transaction_id');
        const paymentScreenshotInput = document.getElementById('payment_screenshot');

        function toggleOnlinePaymentFields() {
            const isOnline = paymentOnline.checked;

            onlinePaymentDetails.style.display = isOnline ? 'block' : 'none';
            transactionIdInput.required = isOnline;
            paymentScreenshotInput.required = isOnline;

            if (!isOnline) {
                transactionIdInput.value = '';
                paymentScreenshotInput.value = '';
            }
        }

        paymentCod.addEventListener('change', toggleOnlinePaymentFields);
        paymentOnline.addEventListener('change', toggleOnlinePaymentFields);

        // ============ Save New Address via AJAX ============
        function saveNewAddress(event) {
            const formData = new FormData();
            const required = ['full_name', 'phone', 'province', 'district', 'city', 'address'];

            for (let field of required) {
                const val = document.getElementById('new_' + field).value.trim();
                if (!val) {
                    alert('Please fill in all required fields.');
                    return;
                }
            }

            formData.append('full_name', document.getElementById('new_full_name').value);
            formData.append('phone', document.getElementById('new_phone').value);
            formData.append('province', document.getElementById('new_province').value);
            formData.append('district', document.getElementById('new_district').value);
            formData.append('city', document.getElementById('new_city').value);
            formData.append('address', document.getElementById('new_address').value);
            formData.append('postal_code', document.getElementById('new_postal_code').value);
            formData.append('_token', '{{ csrf_token() }}');

            const btn = event.target;
            btn.disabled = true;
            btn.textContent = 'Saving...';

            fetch('{{ route("checkout.address.store") }}', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Address saved successfully!');
                    location.reload();
                } else {
                    alert(data.message || 'Failed to save address.');
                }
            })
            .catch(() => alert('An error occurred. Please try again.'))
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Save Address';
            });
        }

        function cancelNewAddress() {
            document.getElementById('newAddressForm').style.display = 'none';
            document.getElementById('newAddressRadio').checked = false;

            document.querySelectorAll('input[name="address_id"]').forEach(radio => {
                if (radio.value !== 'new') radio.required = true;
            });

            document.querySelectorAll('#newAddressForm input').forEach(input => input.value = '');
        }

        // ============ Coin Section Toggle ============
        function toggleCoinSection() {
            const checked = document.getElementById('useCoins').checked;

            document.getElementById('coinSection').style.display = checked ? 'block' : 'none';

            if (!checked) {
                document.getElementById('redeemPoints').value = 0;
                updateCoinValue(0);
            }
        }

        function updateCoinValue(value) {
            const points = parseInt(value) || 0;
            const coinDiscount = points / redeemRate;

            document.getElementById('pointsDisplay').textContent = points;
            document.getElementById('discountDisplay').textContent = coinDiscount.toFixed(2);
            redeemPointsInput.value = points;

            updateOrderSummary();
        }

        // ============ Main Update Order Summary ============
        function updateOrderSummary() {
            const coinPoints = parseInt(redeemPointsInput.value) || 0;
            const coinDiscount = coinPoints / redeemRate;
            const maxCoinDiscount = subtotal * (maxDiscountPercent / 100);
            const finalCoinDiscount = Math.min(coinDiscount, maxCoinDiscount);

            const totalDiscount = Math.min(subtotal, couponDiscount + finalCoinDiscount);

            // Savings
            if (totalDiscount > 0) {
                savingsText.style.display = 'block';
                savingsAmount.textContent = totalDiscount.toFixed(2);
            } else {
                savingsText.style.display = 'none';
            }

            // Coupon row
            const couponRow = document.getElementById('couponDiscountRow');
            if (couponDiscount > 0) {
                couponRow.classList.remove('hidden');
                document.getElementById('couponDiscountDisplay').textContent = couponDiscount.toFixed(2);
            } else {
                couponRow.classList.add('hidden');
            }

            // Grand total
            const grandTotal = subtotal + deliveryCharge + tax - totalDiscount;
            grandTotalEl.textContent = 'Rs ' + Math.max(grandTotal, 0).toFixed(2);
        }

        // ============ Coupon Apply ============
        function applyCoupon() {
            const code = document.getElementById('couponInput').value.trim();
            const msg = document.getElementById('couponMessage');

            if (!code) {
                msg.className = 'text-xs mt-2 text-red-600';
                msg.textContent = 'Enter a coupon code.';
                return;
            }

            fetch('{{ route("checkout.coupon.apply") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ code }),
            })
            .then(async (res) => {
                const data = await res.json();
                if (!res.ok || !data.success) throw new Error(data.message || 'Could not apply coupon.');

                couponDiscount = parseFloat(data.discount) || 0;

                document.getElementById('couponCodeHidden').value = data.code;
                document.getElementById('couponCodeLabel').textContent = data.code;
                document.getElementById('couponDiscountLabel').textContent = couponDiscount.toFixed(2);
                document.getElementById('couponIdle').classList.add('hidden');
                document.getElementById('couponApplied').classList.remove('hidden');
                msg.textContent = '';

                updateOrderSummary();
            })
            .catch((err) => {
                msg.className = 'text-xs mt-2 text-red-600';
                msg.textContent = err.message;
            });
        }

        // ============ Coupon Remove ============
        function removeCoupon() {
            fetch('{{ route("checkout.coupon.remove") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            })
            .then(() => {
                couponDiscount = 0;

                document.getElementById('couponCodeHidden').value = '';
                document.getElementById('couponInput').value = '';
                document.getElementById('couponIdle').classList.remove('hidden');
                document.getElementById('couponApplied').classList.add('hidden');
                document.getElementById('couponMessage').textContent = '';

                updateOrderSummary();
            });
        }

        // ============ Place Order Validation ============
        document.getElementById('checkoutForm').addEventListener('submit', function (e) {
            const address = document.querySelector('input[name="address_id"]:checked');

            if (!address) {
                e.preventDefault();
                alert('Please select a shipping address.');
                return;
            }

            if (address.value === 'new') {
                e.preventDefault();
                alert('Please save the new address first.');
                return;
            }

            const payment = document.querySelector('input[name="payment_method"]:checked');

            if (!payment) {
                e.preventDefault();
                alert('Please select a payment method.');
                return;
            }

            if (payment.value === 'online') {
                if (!transactionIdInput.value.trim()) {
                    e.preventDefault();
                    alert('Please enter the transaction ID for your online payment.');
                    return;
                }

                if (!paymentScreenshotInput.files || paymentScreenshotInput.files.length === 0) {
                    e.preventDefault();
                    alert('Please upload a screenshot of your payment.');
                    return;
                }
            }
        });

        // ============ Initial Update ============
        document.addEventListener('DOMContentLoaded', function () {
            updateOrderSummary();
            toggleOnlinePaymentFields();
        });
    </script>

</x-frontend-layout>
