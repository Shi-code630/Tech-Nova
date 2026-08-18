<x-frontend-layout>

    <div class="bg-gray-100 min-h-screen py-10">

        <div class="max-w-4xl mx-auto px-6">

            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h1 class="text-2xl font-bold text-[#111827]">
                    Confirm Checkout
                </h1>

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

            </div>

        </div>

    </div>

</x-frontend-layout>
