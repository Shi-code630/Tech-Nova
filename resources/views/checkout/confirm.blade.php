<x-frontend-layout>

    <div class="bg-gray-100 min-h-screen py-10">

        <div class="Container mx-auto px-6">

            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h1 class="text-2xl font-bold text-[#111827]">
                    Confirm Checkout
                </h1>

                @if (session('error'))
                    <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-6 border rounded-xl p-4">

                    <h2 class="font-semibold text-lg">
                        Delivery Address
                    </h2>

                    <p class="text-gray-600 mt-2">
                        {{ $address->full_name }}
                    </p>

                    <p class="text-gray-500">
                        {{ $address->phone }}
                    </p>

                    <p class="text-gray-500 mt-2">
                        {{ $address->full_address }}
                    </p>

                </div>

                <div class="mt-4 border rounded-xl p-4">

                    <h2 class="font-semibold text-lg">
                        Payment Method
                    </h2>

                    <p class="text-gray-600 mt-2">
                        {{ $paymentMethod === 'cod'
                            ? 'Cash on Delivery'
                            : 'Online Payment' }}
                    </p>

                </div>

                <form
                    action="{{ route('checkout.place-order') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="mt-6">

                    @csrf

                    <input
                        type="hidden"
                        name="address_id"
                        value="{{ $address->id }}">

                    <input
                        type="hidden"
                        name="payment_method"
                        value="{{ $paymentMethod }}">

                    @if ($paymentMethod === 'online')
                        <div class="mt-4 border border-blue-100 bg-blue-50 rounded-xl p-4">

                            <h2 class="font-semibold text-lg">
                                eSewa Payment
                            </h2>

                            <p class="text-sm text-gray-600 mt-2">
                                Please upload your eSewa payment screenshot and enter the
                                transaction ID after completing the payment.
                            </p>

                            <div class="mt-5 text-center">

                                <h3 class="font-semibold text-[#111827]">
                                    Scan to Pay with eSewa
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Scan the QR code using your eSewa app.
                                </p>

                                <div class="mt-4 flex justify-center">
                                    <div class="bg-white p-3 rounded-xl shadow-sm border">
                                        <img
                                            src="{{ asset('image/payment/merchant-qr.png') }}"
                                            alt="TechNova Nepal eSewa QR Code"
                                            class="w-56 h-56 object-contain">
                                    </div>
                                </div>

                                <p class="text-sm text-gray-500 mt-4">
                                    Amount to Pay
                                </p>

                                <p class="text-2xl font-bold text-[#2563EB] mt-1">
                                    Rs. {{ number_format($grandTotal, 2) }}
                                </p>

                            </div>

                            <div class="mt-4">
                                <label
                                    for="transaction_id"
                                    class="block text-sm font-medium text-[#111827] mb-2">
                                    Transaction ID
                                </label>

                                <input
                                    type="text"
                                    id="transaction_id"
                                    name="transaction_id"
                                    value="{{ old('transaction_id') }}"
                                    required
                                    maxlength="100"
                                    placeholder="Enter your eSewa transaction ID"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-[#2563EB] focus:ring-[#2563EB]">
                            </div>

                            <div class="mt-4">
                                <label
                                    for="payment_screenshot"
                                    class="block text-sm font-medium text-[#111827] mb-2">
                                    Payment Screenshot
                                </label>

                                <input
                                    type="file"
                                    id="payment_screenshot"
                                    name="payment_screenshot"
                                    accept="image/jpeg,image/png,image/jpg,image/webp"
                                    required
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3">

                                <p class="text-xs text-gray-500 mt-2">
                                    Upload a clear screenshot showing your eSewa payment.
                                    Maximum size: 5 MB.
                                </p>
                            </div>

                        </div>
                    @endif

                @if (!empty($couponCode))
                    <div class="mt-4 border rounded-xl p-4">
                        <h2 class="font-semibold text-lg">Coupon</h2>
                        <p class="text-gray-600 mt-2">{{ $couponCode }}</p>
                        <p class="text-green-600 text-sm">- Rs {{ number_format($couponDiscount ?? 0, 2) }}</p>
                    </div>
                @endif

                    <button
                        type="submit"
                        class="mt-6 w-full bg-[#2563EB] hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition">
                        Place Order
                    </button>

                </form>

            </div>

        </div>

    </div>

</x-frontend-layout>
