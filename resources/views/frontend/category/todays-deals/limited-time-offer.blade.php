<x-frontend-layout>
     <section class="bg-[#eef7fd] cantainer ">
        <div class="max-w-7xl mx-auto px-4 py-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-r from-purple-600 to-violet-600 text-white text-xl font-bold px-6 py-3 rounded-2xl shadow-lg">
                    Limited Time Offer
                </div>
                <div class="text-gray-500 text-sm font-medium">
                    Hurry! Offer ends soon
                </div>
            </div>

            <a href="#"
               class="flex items-center gap-3 text-purple-600 hover:text-purple-700 font-semibold text-lg group">
                View All Products
                <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

        <!-- Product Cards -->
        <div class="flex gap-6 overflow-x-auto pb-8 snap-x snap-mandatory scrollbar-hide">

            <!-- Card 1 -->
            <div class="product-card min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative bg-gray-100 p-3">
                    <div class="overflow-hidden rounded-xl">
                        <img src="https://picsum.photos/id/1015/500/350"
                             alt="Lenovo Legion"
                             class="w-full h-40 object-cover rounded-xl hover:scale-105 transition duration-500">
                    </div>
                    <span class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">-9%</span>
                    <span class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">NEW</span>
                </div>
                <div class="p-4">
                    <p class="text-blue-600 text-xs font-semibold mb-1">Gaming Laptop</p>
                    <h3 class="text-sm font-bold text-gray-800 leading-tight mb-2 line-clamp-2">
                        Lenovo Legion 7i Intel Ultra 7 255HX Series 2 | 32GB RAM
                    </h3>
                    <div class="flex items-center gap-1 mb-2">
                        <span class="text-yellow-400">★★★★★</span>
                        <span class="text-gray-500 text-xs">(4.9)</span>
                    </div>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-xl font-bold text-gray-900">Rs. 319,999</span>
                        <span class="text-gray-400 line-through text-sm">Rs. 350,000</span>
                    </div>
                    <div class="flex items-center justify-between bg-orange-50 rounded-lg p-2 mb-4 text-xs">
                        <div class="flex items-center gap-1.5 text-orange-600">
                            <i class="fa-solid fa-clock"></i>
                            <span class="font-medium">Ends In</span>
                        </div>
                        <span id="timer1" class="font-bold text-orange-700 timer">03:07:31</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="addToCart(this)" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-2.5 font-semibold transition text-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                        <button onclick="toggleWishlist(this)" class="w-10 h-10 rounded-xl border border-gray-200 hover:bg-red-500 hover:border-red-500 hover:text-white text-gray-500 transition">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="product-card min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative bg-gray-100 p-3">
                    <div class="overflow-hidden rounded-xl">
                        <img src="https://picsum.photos/id/201/500/350"
                             alt="Lenovo Legion"
                             class="w-full h-40 object-cover rounded-xl hover:scale-105 transition duration-500">
                    </div>
                    <span class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">-9%</span>
                    <span class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">NEW</span>
                </div>
                <div class="p-4">
                    <p class="text-blue-600 text-xs font-semibold mb-1">Gaming Laptop</p>
                    <h3 class="text-sm font-bold text-gray-800 leading-tight mb-2 line-clamp-2">
                        Lenovo Legion 7i Intel Ultra 7 255HX Series 2 | 32GB RAM
                    </h3>
                    <div class="flex items-center gap-1 mb-2">
                        <span class="text-yellow-400">★★★★★</span>
                        <span class="text-gray-500 text-xs">(4.9)</span>
                    </div>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-xl font-bold text-gray-900">Rs. 319,999</span>
                        <span class="text-gray-400 line-through text-sm">Rs. 350,000</span>
                    </div>
                    <div class="flex items-center justify-between bg-orange-50 rounded-lg p-2 mb-4 text-xs">
                        <div class="flex items-center gap-1.5 text-orange-600">
                            <i class="fa-solid fa-clock"></i>
                            <span class="font-medium">Ends In</span>
                        </div>
                        <span id="timer2" class="font-bold text-orange-700 timer">03:07:31</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="addToCart(this)" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-2.5 font-semibold transition text-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                        <button onclick="toggleWishlist(this)" class="w-10 h-10 rounded-xl border border-gray-200 hover:bg-red-500 hover:border-red-500 hover:text-white text-gray-500 transition">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="product-card min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative bg-gray-100 p-3">
                    <div class="overflow-hidden rounded-xl">
                        <img src="https://picsum.photos/id/201/500/350"
                             alt="Lenovo Legion"
                             class="w-full h-40 object-cover rounded-xl hover:scale-105 transition duration-500">
                    </div>
                    <span class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">-9%</span>
                    <span class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">NEW</span>
                </div>
                <div class="p-4">
                    <p class="text-blue-600 text-xs font-semibold mb-1">Gaming Laptop</p>
                    <h3 class="text-sm font-bold text-gray-800 leading-tight mb-2 line-clamp-2">
                        Lenovo Legion 7i Intel Ultra 7 255HX Series 2 | 32GB RAM
                    </h3>
                    <div class="flex items-center gap-1 mb-2">
                        <span class="text-yellow-400">★★★★★</span>
                        <span class="text-gray-500 text-xs">(4.9)</span>
                    </div>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-xl font-bold text-gray-900">Rs. 319,999</span>
                        <span class="text-gray-400 line-through text-sm">Rs. 350,000</span>
                    </div>
                    <div class="flex items-center justify-between bg-orange-50 rounded-lg p-2 mb-4 text-xs">
                        <div class="flex items-center gap-1.5 text-orange-600">
                            <i class="fa-solid fa-clock"></i>
                            <span class="font-medium">Ends In</span>
                        </div>
                        <span id="timer2" class="font-bold text-orange-700 timer">03:07:31</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="addToCart(this)" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-2.5 font-semibold transition text-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                        <button onclick="toggleWishlist(this)" class="w-10 h-10 rounded-xl border border-gray-200 hover:bg-red-500 hover:border-red-500 hover:text-white text-gray-500 transition">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="product-card min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative bg-gray-100 p-3">
                    <div class="overflow-hidden rounded-xl">
                        <img src="https://picsum.photos/id/201/500/350"
                             alt="Lenovo Legion"
                             class="w-full h-40 object-cover rounded-xl hover:scale-105 transition duration-500">
                    </div>
                    <span class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">-9%</span>
                    <span class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">NEW</span>
                </div>
                <div class="p-4">
                    <p class="text-blue-600 text-xs font-semibold mb-1">Gaming Laptop</p>
                    <h3 class="text-sm font-bold text-gray-800 leading-tight mb-2 line-clamp-2">
                        Lenovo Legion 7i Intel Ultra 7 255HX Series 2 | 32GB RAM
                    </h3>
                    <div class="flex items-center gap-1 mb-2">
                        <span class="text-yellow-400">★★★★★</span>
                        <span class="text-gray-500 text-xs">(4.9)</span>
                    </div>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-xl font-bold text-gray-900">Rs. 319,999</span>
                        <span class="text-gray-400 line-through text-sm">Rs. 350,000</span>
                    </div>
                    <div class="flex items-center justify-between bg-orange-50 rounded-lg p-2 mb-4 text-xs">
                        <div class="flex items-center gap-1.5 text-orange-600">
                            <i class="fa-solid fa-clock"></i>
                            <span class="font-medium">Ends In</span>
                        </div>
                        <span id="timer2" class="font-bold text-orange-700 timer">03:07:31</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="addToCart(this)" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-2.5 font-semibold transition text-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                        <button onclick="toggleWishlist(this)" class="w-10 h-10 rounded-xl border border-gray-200 hover:bg-red-500 hover:border-red-500 hover:text-white text-gray-500 transition">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>


        </div>
    </div>
     </section>



</x-frontend-layout>
