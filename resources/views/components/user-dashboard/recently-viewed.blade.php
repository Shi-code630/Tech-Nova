<div class="bg-white rounded-3xl shadow-md p-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">

        <h2 class="text-xl font-bold text-gray-800">
            Recently Viewed
        </h2>

        <a href="#" class="text-blue-600 text-sm font-semibold hover:underline">
            View All →
        </a>

    </div>

    <!-- Products -->
    <div class="space-y-4">

        <!-- Product 1 -->
        <div class="flex items-center gap-4 p-3 border rounded-2xl hover:shadow transition">

            <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                <img
                    src="{{ asset('image/products/laptop.png') }}"
                    alt=""
                    class="w-full h-full object-cover">
            </div>

            <div class="flex-1">

                <h3 class="font-semibold text-gray-800">
                    ASUS TUF Gaming F15
                </h3>

                <p class="text-red-600 font-bold mt-1">
                    Rs 134,999
                </p>

            </div>

            <button class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                View
            </button>

        </div>

        <!-- Product 2 -->
        <div class="flex items-center gap-4 p-3 border rounded-2xl hover:shadow transition">

            <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                <img
                    src="{{ asset('image/products/headphone.png') }}"
                    alt=""
                    class="w-full h-full object-cover">
            </div>

            <div class="flex-1">

                <h3 class="font-semibold text-gray-800">
                    Sony WH-1000XM5
                </h3>

                <p class="text-red-600 font-bold mt-1">
                    Rs 48,500
                </p>

            </div>

            <button class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                View
            </button>

        </div>

        <!-- Product 3 -->
        <div class="flex items-center gap-4 p-3 border rounded-2xl hover:shadow transition">

            <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                <img
                    src="{{ asset('image/products/phone.png') }}"
                    alt=""
                    class="w-full h-full object-cover">
            </div>

            <div class="flex-1">

                <h3 class="font-semibold text-gray-800">
                    Samsung Galaxy S25 Ultra
                </h3>

                <p class="text-red-600 font-bold mt-1">
                    Rs 179,999
                </p>

            </div>

            <button class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                View
            </button>

        </div>

    </div>

</div>
