<x-frontend-layout>

    <div class="bg-gray-100 min-h-screen py-10">

        <div class="w-[95%] max-w-7xl mx-auto">
            <form action="{{ route('checkout.continue') }}" method="POST">
                @csrf

                {{-- Header --}}
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-[#111827]">
                        Checkout
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Review your order before continuing.
                    </p>
                </div>


                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Cart Items --}}
                    <div class="lg:col-span-2">

                        {{-- Delivery Address --}}
                        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">

                            <div class="flex items-center justify-between mb-6">

                                <div>
                                    <h2 class="text-xl font-semibold text-[#111827]">
                                        Delivery Address
                                    </h2>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Choose where you want your order delivered.
                                    </p>
                                </div>

                            </div>


                            @if ($addresses->count())

                                <div class="space-y-4">

                                    @foreach ($addresses as $address)
                                        <div
                                            class="border border-gray-200 rounded-xl p-4
                                                hover:border-[#2563EB] transition">

                                            <div class="flex items-start gap-4">

                                                <input type="radio" name="address_id" value="{{ $address->id }}"
                                                    class="mt-1 w-4 h-4 text-[#2563EB]"
                                                    {{ $address->is_default ? 'checked' : '' }}>

                                                <div class="flex-1">

                                                    <div class="flex items-center gap-2">

                                                        <h3 class="font-semibold text-[#111827]">
                                                            {{ $address->full_name }}
                                                        </h3>

                                                        @if ($address->is_default)
                                                            <span
                                                                class="px-2 py-1 rounded-full
                                                                    text-xs font-medium
                                                                    bg-blue-50 text-[#2563EB]">

                                                                Default

                                                            </span>
                                                        @endif

                                                    </div>


                                                    <p class="text-sm text-gray-600 mt-1">
                                                        {{ $address->phone }}
                                                    </p>

                                                    <p class="text-sm text-gray-500 mt-2">
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

                                        </div>
                                    @endforeach

                                </div>
                            @else
                                {{-- No Address --}}
                                <div
                                    class="border border-dashed border-gray-300
                                        rounded-xl p-8 text-center">

                                    <h3 class="font-semibold text-[#111827]">
                                        No delivery address found
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-2">
                                        You need to add a delivery address before placing your order.
                                    </p>

                                    <a href="{{ route('checkout.address.create') }}"
                                        class="inline-block mt-4 px-5 py-2.5 rounded-xl
                                        bg-[#2563EB] hover:bg-blue-700
                                        text-white text-sm font-semibold transition">

                                        Add New Address

                                    </a>
                                </div>

                            @endif

                        </div>

                        {{-- Payment Method --}}
                        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">

                            <div class="mb-6">

                                <h2 class="text-xl font-semibold text-[#111827]">
                                    Payment Method
                                </h2>

                                <p class="text-sm text-gray-500 mt-1">
                                    Choose how you want to pay for your order.
                                </p>

                            </div>


                            <div class="space-y-4">

                                {{-- Cash on Delivery --}}
                                <label
                                    class="flex items-start gap-4
                                        border border-gray-200 rounded-xl p-4
                                        cursor-pointer hover:border-[#2563EB]
                                        transition">

                                    <input type="radio" name="payment_method" value="cod" checked
                                        class="mt-1 w-4 h-4 text-[#2563EB]">

                                    <div class="flex-1">

                                        <h3 class="font-semibold text-[#111827]">
                                            Cash on Delivery
                                        </h3>

                                        <p class="text-sm text-gray-500 mt-1">
                                            Pay when your order is delivered.
                                        </p>

                                    </div>

                                </label>


                                {{-- Online Payment --}}
                                <label
                                    class="flex items-start gap-4
                                            border border-gray-200 rounded-xl p-4
                                            cursor-pointer hover:border-[#2563EB]
                                            transition">

                                    <input type="radio" name="payment_method" value="online"
                                        class="mt-1 w-4 h-4 text-[#2563EB]">

                                    <div class="flex-1">

                                        <h3 class="font-semibold text-[#111827]">
                                            Online Payment
                                        </h3>

                                        <p class="text-sm text-gray-500 mt-1">
                                            Pay securely using eSewa.
                                        </p>

                                    </div>

                                </label>

                            </div>

                        </div>

                        <h2 class="text-xl font-semibold text-[#111827] mb-6">
                            Your Items
                        </h2>


                        <div class="space-y-5">

                            @foreach ($cartItems as $item)
                                <div
                                    class="flex items-center gap-4
                                            border-b border-gray-100
                                            pb-5">

                                    {{-- Product Image --}}
                                    <div
                                        class="w-20 h-20 rounded-xl bg-gray-50 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        @php
                                           
                                            $thumbnails = $item->product->thumbnails ?? [];
                                            $image =
                                                !empty($thumbnails) && is_array($thumbnails)
                                                    ? asset('storage/' . $thumbnails[0])
                                                    : null;
                                        @endphp

                                        @if ($image)
                                            <img src="{{ $image }}" alt="{{ $item->product->name }}"
                                                class="w-full h-full object-contain rounded-xl"
                                                onerror="this.src='{{ asset('images/default-product.png') }}'">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l2.159 2.159m-1.5 1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.409 2.409M3.75 19.5h16.5A1.5 1.5 0 0 0 21.75 18V6A1.5 1.5 0 0 0 20.25 4.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />
                                            </svg>
                                        @endif
                                    </div>


                                    {{-- Product Details --}}
                                    <div class="flex-1 min-w-0">

                                        <h3 class="font-semibold text-[#111827]">
                                            {{ $item->product->name ?? 'Product' }}
                                        </h3>

                                        <p class="text-sm text-gray-500 mt-1">
                                            Quantity: {{ $item->quantity }}
                                        </p>

                                        <p class="text-[#2563EB] font-semibold mt-1">
                                            Rs {{ number_format($item->price, 2) }}
                                        </p>

                                    </div>


                                    {{-- Item Total --}}
                                    <div class="text-right">

                                        <p class="font-bold text-[#111827]">
                                            Rs {{ number_format($item->price * $item->quantity, 2) }}
                                        </p>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                    </div>

                </div>


                {{-- Order Summary --}}
                <div>

                    <div class="bg-white rounded-2xl shadow-sm p-6
                                sticky top-6">

                        <h2 class="text-xl font-semibold text-[#111827] mb-6">
                            Order Summary
                        </h2>


                        <div class="flex justify-between text-sm mb-4">

                            <span class="text-gray-500">
                                Subtotal
                            </span>

                            <span class="font-medium">
                                Rs {{ number_format($subtotal, 2) }}
                            </span>

                        </div>


                        <div class="flex justify-between text-sm mb-4">

                            <span class="text-gray-500">
                                Delivery
                            </span>

                            <span class="font-medium" id="delivery-charge">
                                Rs {{ number_format($deliveryCharge, 2) }}
                            </span>

                        </div>

                        <div id="online-discount-row" class="hidden flex justify-between text-sm mb-4">
                            <span class="text-gray-500">
                                Online Payment Discount (5%)
                            </span>

                            <span class="font-medium text-green-600" id="online-discount">
                                - Rs 0.00
                            </span>
                        </div>

                        <div
                            class="border-t border-gray-200
                                    pt-4 flex justify-between">

                            <span class="font-bold text-[#111827]">
                                Total
                            </span>

                            <span class="font-bold text-xl text-[#2563EB]" id="grand-total">
                                Rs {{ number_format($subtotal + $deliveryCharge, 2) }}
                            </span>

                        </div>


                        <div class="mt-6">

                            <button type="submit"
                                class="w-full py-3 rounded-xl
                                    bg-[#2563EB] hover:bg-blue-700
                                    text-white font-semibold transition">

                                Continue

                            </button>

                        </div>

                    </div>

                </div>

        </div>

    </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const subtotal = {{ $subtotal }};
            const deliveryCharge = {{ $deliveryCharge }};

            const paymentMethods = document.querySelectorAll(
                'input[name="payment_method"]'
            );

            const discountRow = document.getElementById('online-discount-row');
            const discountElement = document.getElementById('online-discount');
            const grandTotalElement = document.getElementById('grand-total');


            function updateOrderSummary() {

                const selectedPayment = document.querySelector(
                    'input[name="payment_method"]:checked'
                );

                let discount = 0;

                if (selectedPayment && selectedPayment.value === 'online') {

                    discount = subtotal * 0.05;

                    discountRow.classList.remove('hidden');

                    discountElement.textContent =
                        '- Rs ' + discount.toFixed(2);

                } else {

                    discountRow.classList.add('hidden');

                    onlinePaymentDetails.classList.add('hidden');

                }

                const grandTotal =
                    subtotal - discount + deliveryCharge;


                grandTotalElement.textContent =
                    'Rs ' + grandTotal.toFixed(2);
            }

            paymentMethods.forEach(function(paymentMethod) {
                paymentMethod.addEventListener(
                    'change',
                    updateOrderSummary
                );
            });

            updateOrderSummary();
        });
    </script>

    </div>

</x-frontend-layout>
