<x-frontend-layout>

    <div class="bg-gray-100 min-h-screen py-10">
        <div class="w-[95%] max-w-7xl mx-auto">

            <form id="checkoutForm" action="{{ route('checkout.place-order') }}" method="POST">
                @csrf

                {{-- Header --}}
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-[#111827]">Checkout</h1>
                    <p class="text-gray-500 mt-2">Review your order before placing it.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Left Column: Order Details --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- ✅ Delivery Address (With New Address Option) --}}
                        <div class="bg-white rounded-2xl shadow-sm p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h2 class="text-xl font-semibold text-[#111827]">Delivery Address</h2>
                                    <p class="text-sm text-gray-500 mt-1">Choose or add a new delivery address.</p>
                                </div>
                            </div>

                            {{-- Saved Addresses --}}
                            @if ($addresses->count())
                                <div class="space-y-4">
                                    @foreach ($addresses as $address)
                                        <div class="border border-gray-200 rounded-xl p-4 hover:border-[#2563EB] transition">
                                            <div class="flex items-start gap-4">
                                                <input type="radio" name="address_id" value="{{ $address->id }}"
                                                    class="mt-1 w-4 h-4 text-[#2563EB] address-radio"
                                                    {{ $address->is_default ? 'checked' : '' }}>
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2">
                                                        <h3 class="font-semibold text-[#111827]">{{ $address->full_name }}</h3>
                                                        @if ($address->is_default)
                                                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-[#2563EB]">Default</span>
                                                        @endif
                                                    </div>
                                                    <p class="text-sm text-gray-600 mt-1">{{ $address->phone }}</p>
                                                    <p class="text-sm text-gray-500 mt-2">
                                                        {{ $address->address }}, {{ $address->city }}, {{ $address->district }}, {{ $address->province }}
                                                        @if ($address->postal_code) - {{ $address->postal_code }} @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- ✅ New Address Option --}}
                                <div class="mt-4">
                                    <label class="flex items-center gap-2 cursor-pointer text-[#2563EB] hover:underline">
                                        <input type="radio" name="address_id" value="new" id="newAddressRadio"
                                            class="w-4 h-4 text-[#2563EB] address-radio">
                                        <span class="text-sm font-medium">+ Add New Address</span>
                                    </label>
                                </div>

                            @else
                                {{-- No Address --}}
                                <div class="border border-dashed border-gray-300 rounded-xl p-8 text-center">
                                    <h3 class="font-semibold text-[#111827]">No delivery address found</h3>
                                    <p class="text-sm text-gray-500 mt-2">Please add a delivery address.</p>
                                </div>
                            @endif

                            {{-- ✅ New Address Form (Hidden by default) --}}
                            <div id="newAddressForm" style="display: none;" class="mt-6 p-4 border border-blue-200 rounded-xl bg-blue-50">
                                <h3 class="font-semibold text-[#111827] mb-4">Add New Address</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                        <input type="text" name="new_full_name" id="new_full_name"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-blue-200 transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                                        <input type="text" name="new_phone" id="new_phone"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-blue-200 transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Province *</label>
                                        <input type="text" name="new_province" id="new_province"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-blue-200 transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">District *</label>
                                        <input type="text" name="new_district" id="new_district"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-blue-200 transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                        <input type="text" name="new_city" id="new_city"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-blue-200 transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                                        <input type="text" name="new_address" id="new_address"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-blue-200 transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                        <input type="text" name="new_postal_code" id="new_postal_code"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-blue-200 transition">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" onclick="saveNewAddress()"
                                            class="px-6 py-2 bg-[#2563EB] hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                                            Save Address
                                        </button>
                                        <button type="button" onclick="cancelNewAddress()"
                                            class="ml-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Method --}}
                        <div class="bg-white rounded-2xl shadow-sm p-6">
                            <div class="mb-6">
                                <h2 class="text-xl font-semibold text-[#111827]">Payment Method</h2>
                                <p class="text-sm text-gray-500 mt-1">Choose how you want to pay.</p>
                            </div>

                            <div class="space-y-4">
                                <label class="flex items-start gap-4 border border-gray-200 rounded-xl p-4 cursor-pointer hover:border-[#2563EB] transition">
                                    <input type="radio" name="payment_method" value="cod" checked
                                        class="mt-1 w-4 h-4 text-[#2563EB]">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-[#111827]">Cash on Delivery</h3>
                                        <p class="text-sm text-gray-500 mt-1">Pay when your order is delivered.</p>
                                    </div>
                                </label>

                                <label class="flex items-start gap-4 border border-gray-200 rounded-xl p-4 cursor-pointer hover:border-[#2563EB] transition">
                                    <input type="radio" name="payment_method" value="online"
                                        class="mt-1 w-4 h-4 text-[#2563EB]">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-[#111827]">Online Payment</h3>
                                        <p class="text-sm text-gray-500 mt-1">Pay securely using eSewa / Khalti.</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Order Items --}}
                        <div class="bg-white rounded-2xl shadow-sm p-6">
                            <h2 class="text-xl font-semibold text-[#111827] mb-6">Your Items</h2>

                            @foreach ($cartItems as $item)
                                <div class="flex items-center gap-4 border-b border-gray-100 pb-5 mb-5 last:border-0 last:pb-0 last:mb-0">
                                    {{-- Product Image --}}
                                    <div class="w-20 h-20 rounded-xl bg-gray-50 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        @php
                                            $thumbnails = $item->product->thumbnails ?? [];
                                            $image = !empty($thumbnails) && is_array($thumbnails) ? asset('storage/' . $thumbnails[0]) : null;
                                        @endphp
                                        @if ($image)
                                            <img src="{{ $image }}" alt="{{ $item->product->name }}"
                                                class="w-full h-full object-contain rounded-xl"
                                                onerror="this.src='{{ asset('images/default-product.png') }}'">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l2.159 2.159m-1.5 1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.409 2.409M3.75 19.5h16.5A1.5 1.5 0 0 0 21.75 18V6A1.5 1.5 0 0 0 20.25 4.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"/>
                                            </svg>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-[#111827]">{{ $item->product->name ?? 'Product' }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">Quantity: {{ $item->quantity }}</p>
                                        <p class="text-[#2563EB] font-semibold mt-1">Rs {{ number_format($item->price, 2) }}</p>
                                    </div>

                                    <div class="text-right">
                                        <p class="font-bold text-[#111827]">Rs {{ number_format($item->price * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Right Column: Order Summary --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-6">

                            <h2 class="text-xl font-semibold text-[#111827] mb-6">Order Summary</h2>

                            {{-- Subtotal --}}
                            <div class="flex justify-between text-sm mb-4">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-medium" id="subtotalDisplay">Rs {{ number_format($subtotal, 2) }}</span>
                            </div>

                            {{-- Delivery Charge --}}
                            <div class="flex justify-between text-sm mb-4">
                                <span class="text-gray-500">Delivery</span>
                                <span class="font-medium" id="deliveryDisplay">Rs {{ number_format($deliveryCharge, 2) }}</span>
                            </div>

                            {{-- Tax --}}
                            <div class="flex justify-between text-sm mb-4">
                                <span class="text-gray-500">Tax (13%)</span>
                                <span class="font-medium" id="taxDisplay">Rs {{ number_format($tax, 2) }}</span>
                            </div>

                            {{-- ✅ Coin Discount Section --}}
                            @if($coinSummary['available'] > 0)
                                <div class="border-t border-gray-200 pt-4 mt-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-lg">⭐</span>
                                        <span class="font-medium text-[#111827]">Reward Coins</span>
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        Available: <strong id="availableCoins">{{ number_format($coinSummary['available']) }}</strong> coins
                                        (Value: Rs. <span id="coinsValue">{{ number_format($coinSummary['value'], 2) }}</span>)
                                    </p>

                                    <div class="mt-2">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" id="useCoins" onchange="toggleCoinSection()">
                                            <span class="text-sm">Use coins for discount</span>
                                        </label>
                                    </div>

                                    <div id="coinSection" style="display: none;" class="mt-3">
                                        <div class="flex items-center gap-3">
                                            <input type="range" name="redeem_points" id="redeemPoints"
                                                min="0" max="{{ $maxRedeemPoints }}" value="0" step="1"
                                                oninput="updateCoinValue(this.value)" class="flex-1">
                                            <span class="font-bold min-w-[60px] text-center" id="pointsDisplay">0</span>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-500 mt-1">
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
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <div class="flex justify-between font-bold text-xl">
                                    <span class="text-[#111827]">Total</span>
                                    <span class="text-[#2563EB]" id="grandTotal">Rs {{ number_format($subtotal + $deliveryCharge + $tax, 2) }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1" id="savingsText" style="display: none;">
                                    You save: Rs. <span id="savingsAmount">0.00</span>
                                </p>
                            </div>

                            {{-- Hidden Inputs --}}
                            <input type="hidden" name="redeem_points" id="redeemPointsHidden" value="0">
                            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                            <input type="hidden" name="delivery_charge" value="{{ $deliveryCharge }}">
                            <input type="hidden" name="tax" value="{{ $tax }}">

                            {{-- Place Order Button --}}
                            <button type="submit" id="placeOrderBtn"
                                class="w-full mt-6 py-3 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white font-semibold transition">
                                Place Order
                            </button>

                        </div>
                    </div>

                </div>

            </form>

        </div>
    </div>

    <script>
        // ✅ Data from PHP
        const subtotal = {{ $subtotal }};
        const deliveryCharge = {{ $deliveryCharge }};
        const tax = {{ $tax }};
        const redeemRate = {{ $coinSummary['redeem_rate'] ?? 20 }};
        const maxDiscountPercent = {{ $coinSummary['max_discount_percent'] ?? 10 }};

        // ✅ DOM elements
        const grandTotalEl = document.getElementById('grandTotal');
        const savingsText = document.getElementById('savingsText');
        const savingsAmount = document.getElementById('savingsAmount');
        const redeemPointsInput = document.getElementById('redeemPointsHidden');

        // ✅ Address radio toggle
        document.querySelectorAll('.address-radio').forEach(el => {
            el.addEventListener('change', function() {
                const form = document.getElementById('newAddressForm');
                if (this.value === 'new') {
                    form.style.display = 'block';
                    // Disable saved address validation
                    document.querySelectorAll('input[name="address_id"]').forEach(radio => {
                        if (radio.value !== 'new') {
                            radio.required = false;
                        }
                    });
                } else {
                    form.style.display = 'none';
                    document.querySelectorAll('input[name="address_id"]').forEach(radio => {
                        if (radio.value !== 'new') {
                            radio.required = true;
                        }
                    });
                }
            });
        });

        // ✅ Save new address via AJAX
        function saveNewAddress() {
            const formData = new FormData();
            formData.append('full_name', document.getElementById('new_full_name').value);
            formData.append('phone', document.getElementById('new_phone').value);
            formData.append('province', document.getElementById('new_province').value);
            formData.append('district', document.getElementById('new_district').value);
            formData.append('city', document.getElementById('new_city').value);
            formData.append('address', document.getElementById('new_address').value);
            formData.append('postal_code', document.getElementById('new_postal_code').value);
            formData.append('_token', '{{ csrf_token() }}');

            // Validate required fields
            const required = ['full_name', 'phone', 'province', 'district', 'city', 'address'];
            for (let field of required) {
                const val = document.getElementById('new_' + field).value.trim();
                if (!val) {
                    alert('Please fill in all required fields.');
                    return;
                }
            }

            // Show loading
            const btn = event.target;
            btn.disabled = true;
            btn.textContent = 'Saving...';

            fetch('{{ route("checkout.address.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // ✅ Success: Add new address to list
                    const addressHtml = `
                        <div class="border border-[#2563EB] rounded-xl p-4 hover:border-[#2563EB] transition">
                            <div class="flex items-start gap-4">
                                <input type="radio" name="address_id" value="${data.address.id}"
                                    class="mt-1 w-4 h-4 text-[#2563EB] address-radio" checked>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-semibold text-[#111827]">${data.address.full_name}</h3>
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-[#2563EB]">New</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">${data.address.phone}</p>
                                    <p class="text-sm text-gray-500 mt-2">
                                        ${data.address.address}, ${data.address.city}, ${data.address.district}, ${data.address.province}
                                        ${data.address.postal_code ? '- ' + data.address.postal_code : ''}
                                    </p>
                                </div>
                            </div>
                        </div>
                    `;

                    // Insert new address before "Add New Address" option
                    const addressContainer = document.querySelector('.space-y-4');
                    addressContainer.insertAdjacentHTML('beforeend', addressHtml);

                    // Hide new address form
                    document.getElementById('newAddressForm').style.display = 'none';

                    // Reset form
                    document.querySelectorAll('#newAddressForm input').forEach(input => input.value = '');

                    alert('Address saved successfully!');

                    // Refresh the page to show updated address list
                    location.reload();
                } else {
                    alert(data.message || 'Failed to save address.');
                }
            })
            .catch(error => {
                alert('An error occurred. Please try again.');
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Save Address';
            });
        }

        // ✅ Cancel new address
        function cancelNewAddress() {
            document.getElementById('newAddressForm').style.display = 'none';
            document.getElementById('newAddressRadio').checked = false;
            document.querySelectorAll('input[name="address_id"]').forEach(radio => {
                if (radio.value !== 'new') {
                    radio.required = true;
                }
            });
            // Reset form
            document.querySelectorAll('#newAddressForm input').forEach(input => input.value = '');
        }

        // ✅ Coin section toggle
        function toggleCoinSection() {
            const checked = document.getElementById('useCoins').checked;
            document.getElementById('coinSection').style.display = checked ? 'block' : 'none';
            if (!checked) {
                document.getElementById('redeemPoints').value = 0;
                updateCoinValue(0);
            }
        }

        // ✅ Update coin value and discount
        function updateCoinValue(value) {
            const points = parseInt(value) || 0;
            const coinDiscount = points / redeemRate;

            document.getElementById('pointsDisplay').textContent = points;
            document.getElementById('discountDisplay').textContent = coinDiscount.toFixed(2);
            redeemPointsInput.value = points;

            updateOrderSummary();
        }

        // ✅ Main update function
        function updateOrderSummary() {
            const coinPoints = parseInt(redeemPointsInput.value) || 0;
            const coinDiscount = coinPoints / redeemRate;
            const maxCoinDiscount = subtotal * (maxDiscountPercent / 100);
            const finalCoinDiscount = Math.min(coinDiscount, maxCoinDiscount);

            if (finalCoinDiscount > 0) {
                savingsText.style.display = 'block';
                savingsAmount.textContent = finalCoinDiscount.toFixed(2);
            } else {
                savingsText.style.display = 'none';
            }

            const grandTotal = subtotal + deliveryCharge + tax - finalCoinDiscount;
            grandTotalEl.textContent = 'Rs ' + grandTotal.toFixed(2);
        }

        // ✅ Place order validation
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
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
        });

        // ✅ Initial update
        document.addEventListener('DOMContentLoaded', function() {
            updateOrderSummary();
        });
    </script>

</x-frontend-layout>
