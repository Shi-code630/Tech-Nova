<div class="bg-white rounded-3xl shadow-md p-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">

        <h2 class="text-2xl font-bold text-gray-800">
            Recommended For You
        </h2>

        <a href="#" class="text-blue-600 font-semibold hover:underline">
            View All →
        </a>

    </div>

    <!-- Scrollable Products -->
    <div class="flex gap-5 overflow-x-auto pb-3 scrollbar-hide">

        <!-- Product Card -->
        <div class="min-w-[220px] bg-white border rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">

            <div class="h-44 bg-gray-100 flex items-center justify-center">

                <img src="{{ asset('image/products/laptop.png') }}"
                    class="w-36 h-36 object-contain group-hover:scale-110 transition duration-300">

            </div>

            <div class="p-4">

                <h3 class="font-semibold text-gray-800 line-clamp-2">
                    ASUS TUF Gaming F15
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Gaming Laptop
                </p>

                <p class="text-blue-600 text-xl font-bold mt-3">
                    Rs 134,999
                </p>

                <button class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl transition">
                    View Product
                </button>

            </div>

        </div>

        <!-- Product Card -->
        <div class="min-w-[220px] bg-white border rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">

            <div class="h-44 bg-gray-100 flex items-center justify-center">

                {{-- <img src="{{ asset('image/products/headphone.png') }}" --}}
                    class="w-32 h-32 object-contain group-hover:scale-110 transition duration-300">

            </div>

            <div class="p-4">

                <h3 class="font-semibold text-gray-800 line-clamp-2">
                    Sony WH-1000XM5
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Noise Cancelling Headphones
                </p>

                <p class="text-blue-600 text-xl font-bold mt-3">
                    Rs 48,500
                </p>

                <button class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl transition">
                    View Product
                </button>

            </div>

        </div>

        <!-- Product Card -->
        <div class="min-w-[220px] bg-white border rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">

            <div class="h-44 bg-gray-100 flex items-center justify-center">

                {{-- <img src="{{ asset('image/products/speaker.png') }}" --}}
                    class="w-32 h-32 object-contain group-hover:scale-110 transition duration-300">

            </div>

            <div class="p-4">

                <h3 class="font-semibold text-gray-800 line-clamp-2">
                    JBL Flip 7
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Bluetooth Speaker
                </p>

                <p class="text-blue-600 text-xl font-bold mt-3">
                    Rs 12,999
                </p>

                <button class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl transition">
                    View Product
                </button>

            </div>

        </div>

        <!-- Product Card -->
        <div class="min-w-[220px] bg-white border rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">

            <div class="h-44 bg-gray-100 flex items-center justify-center">

                {{-- <img src="{{ asset('image/products/mouse.png') }}" --}}
                    class="w-28 h-28 object-contain group-hover:scale-110 transition duration-300">

            </div>

            <div class="p-4">

                <h3 class="font-semibold text-gray-800 line-clamp-2">
                    Logitech MX Master 3S
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Wireless Mouse
                </p>

                <p class="text-blue-600 text-xl font-bold mt-3">
                    Rs 14,999
                </p>

                <button class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl transition">
                    View Product
                </button>

            </div>

        </div>

    </div>

</div>

<style>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-hide {
    scrollbar-width: none;
    -ms-overflow-style: none;
}
</style>
