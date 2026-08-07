<x-frontend-layout >
    <Section class="bg-[#f0f9ff]">
        <div class=" container mx-auto">
        <div class="mt-[10px] ">
    <div class="relative max-w-[1500px] mx-auto h-[400px] overflow-hidden rounded-2xl shadow-2xl ">

        <!-- Slides Wrapper -->
  <div id="slider" class="flex h-full transition-transform duration-500 ease-in-out will-change-transform">

            @foreach($banners as $banner)
                <div class="relative w-full h-full flex-shrink-0">

                    <img
                        src="{{ asset('storage/' . $banner->image) }}"
                        alt="{{ $banner->alt_text }}"
                        class="w-full h-full object-cover">

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/40 ">
                        <div class="max-w-4xl px-12 py-60 text-white">

                            <h1 class="text-3xl font-bold ">
                                {{ $banner->title }}
                            </h1>

                            <p class="text-lg mb-6">
                                {{ $banner->subtitle }}
                            </p>

                            @if($banner->button_text)
                                <a href="{{ $banner->button_link }}"
                                   class="inline-block bg-blue-600 hover:bg-blue-900 px-6 py-3 rounded-lg font-semibold transition">
                                    {{ $banner->button_text }}
                                </a>
                            @endif

                        </div>
                    </div>

                </div>
            @endforeach

        </div>

        <!-- Left Arrow -->
        <button onclick="moveSlide(-1)"
            class="absolute top-1/2 left-4 -translate-y-1/2 bg-black/50 text-white p-3 rounded-full z-10">
            ❮
        </button>

        <!-- Right Arrow -->
        <button onclick="moveSlide(1)"
            class="absolute top-1/2 right-4 -translate-y-1/2 bg-black/50 text-white p-3 rounded-full z-10">
            ❯
        </button>

        <!-- Dots -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
            @foreach($banners as $index => $banner)
                <span
                    class="dot w-3 h-3 rounded-full bg-white/50 cursor-pointer"
                    data-index="{{ $index }}">
                </span>
            @endforeach
        </div>

    </div>
</div>

    <div class="py-3 bg-[#f0f9ff]">
        <div class=" mb-6 ">
        <div class="flex items-center justify-between">

        <!-- Left Side: Limited Time Offer -->
            <div class="flex items-center gap-3">
            <div class=" text-black text-lg font-semibold px-5 py-2 rounded-lg ">
                Limited Time Offer
            </div>
            <div class="h-px w-12 bg-gradient-to-r from-purple-600 to-transparent"></div>
            </div>

        <!-- Right Side: View More -->
            <a href=""
           class="flex items-center gap-2 text-purple-600 hover:text-purple-700 font-medium transition-colors group">
            View More
            <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
            </a>

        </div>
<div class="flex gap-6 overflow-x-auto pb-6 snap-x snap-mandatory scrollbar-hide">

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

            <!-- Timer -->
            <div class="flex items-center justify-between bg-orange-50 rounded-lg p-2 mb-4 text-xs">
                <div class="flex items-center gap-1.5 text-orange-600">
                    <i class="fa-solid fa-clock"></i>
                    <span class="font-medium">Ends In</span>
                </div>
                <span id="timer1" class="font-bold text-orange-700 timer">03:07:31</span>
            </div>

            <div class="flex gap-2">
                <button onclick="addToCart(this)"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-2.5 font-semibold transition text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-cart-plus"></i>
                    Add to Cart
                </button>
                <button onclick="toggleWishlist(this)"
                        class="w-10 h-10 rounded-xl border border-gray-200 hover:bg-red-500 hover:border-red-500 hover:text-white text-gray-500 transition">
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

            <!-- Timer -->
            <div class="flex items-center justify-between bg-orange-50 rounded-lg p-2 mb-4 text-xs">
                <div class="flex items-center gap-1.5 text-orange-600">
                    <i class="fa-solid fa-clock"></i>
                    <span class="font-medium">Ends In</span>
                </div>
                <span id="timer1" class="font-bold text-orange-700 timer">03:07:31</span>
            </div>

            <div class="flex gap-2">
                <button onclick="addToCart(this)"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-2.5 font-semibold transition text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-cart-plus"></i>
                    Add to Cart
                </button>
                <button onclick="toggleWishlist(this)"
                        class="w-10 h-10 rounded-xl border border-gray-200 hover:bg-red-500 hover:border-red-500 hover:text-white text-gray-500 transition">
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
    <!-- Card 5 -->
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
<div class="py-3 bg-[#f0f9ff]">
    <div class=" mb-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <!-- Left Side -->
            <div class="flex items-center gap-3">
                <div class="text-black text-lg font-semibold  py-2 rounded-lg">
                    New Products
                </div>
                <div class="h-px w-12 bg-gradient-to-r from-blue-600 to-transparent"></div>
            </div>

            <!-- Right Side -->
            <a href=""
               class="flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium transition-colors group">
                View More
                <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

        <!-- Cards -->
        <div class="flex gap-6 overflow-x-auto pb-6 snap-x snap-mandatory scrollbar-hide">

            <!-- Card 1 -->
            <div class="group min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative overflow-hidden">
                    <img src="https://picsum.photos/id/1015/500/400"
                         alt="New Product"
                         class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">

                    <span class="absolute top-3 left-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                        NEW
                    </span>

                    <button onclick="toggleWishlist(this)"
                            class="absolute top-3 right-3 w-9 h-9 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-600 hover:bg-red-500 hover:text-white transition shadow-sm">
                        <i class="fa-regular fa-heart text-sm"></i>
                    </button>
                </div>

                <div class="p-4">
                    <p class="text-xs text-blue-600 font-semibold mb-1">Electronics</p>
                    <h3 class="text-sm font-bold text-gray-800 leading-snug mb-3 line-clamp-2 group-hover:text-blue-600 transition">
                        Lenovo Legion 7i Intel Ultra 7 | 32GB RAM | RTX Graphics
                    </h3>

                    <div class="flex items-center gap-1 mb-3">
                        <div class="flex text-yellow-400 text-sm">★★★★★</div>
                        <span class="text-gray-500 text-xs">(128)</span>
                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-xl font-bold text-gray-900">Rs. 319,999</span>
                        <span class="text-sm text-gray-400 line-through">Rs. 350,000</span>
                    </div>

                    <button onclick="addToCart(this)"
                            class="w-full bg-gray-900 hover:bg-blue-600 text-white py-2.5 rounded-xl font-semibold text-sm transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-plus"></i>
                        Add to Cart
                    </button>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="group min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative overflow-hidden">
                    <img src="https://picsum.photos/id/201/500/400"
                         alt="New Product"
                         class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                    <span class="absolute top-3 left-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                    <button onclick="toggleWishlist(this)"
                            class="absolute top-3 right-3 w-9 h-9 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-600 hover:bg-red-500 hover:text-white transition shadow-sm">
                        <i class="fa-regular fa-heart text-sm"></i>
                    </button>
                </div>
                <div class="p-4">
                    <p class="text-xs text-blue-600 font-semibold mb-1">Electronics</p>
                    <h3 class="text-sm font-bold text-gray-800 leading-snug mb-3 line-clamp-2 group-hover:text-blue-600 transition">
                        Lenovo Legion 7i Intel Ultra 7 | 32GB RAM | RTX Graphics
                    </h3>
                    <div class="flex items-center gap-1 mb-3">
                        <div class="flex text-yellow-400 text-sm">★★★★★</div>
                        <span class="text-gray-500 text-xs">(128)</span>
                    </div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-xl font-bold text-gray-900">Rs. 319,999</span>
                        <span class="text-sm text-gray-400 line-through">Rs. 350,000</span>
                    </div>
                    <button onclick="addToCart(this)"
                            class="w-full bg-gray-900 hover:bg-blue-600 text-white py-2.5 rounded-xl font-semibold text-sm transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-plus"></i>
                        Add to Cart
                    </button>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="group min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative overflow-hidden">
                    <img src="https://picsum.photos/id/133/500/400"
                         alt="New Product"
                         class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                    <span class="absolute top-3 left-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                    <button onclick="toggleWishlist(this)"
                            class="absolute top-3 right-3 w-9 h-9 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-600 hover:bg-red-500 hover:text-white transition shadow-sm">
                        <i class="fa-regular fa-heart text-sm"></i>
                    </button>
                </div>
                <div class="p-4">
                    <p class="text-xs text-blue-600 font-semibold mb-1">Electronics</p>
                    <h3 class="text-sm font-bold text-gray-800 leading-snug mb-3 line-clamp-2 group-hover:text-blue-600 transition">
                        Lenovo Legion 7i Intel Ultra 7 | 32GB RAM | RTX Graphics
                    </h3>
                    <div class="flex items-center gap-1 mb-3">
                        <div class="flex text-yellow-400 text-sm">★★★★★</div>
                        <span class="text-gray-500 text-xs">(128)</span>
                    </div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-xl font-bold text-gray-900">Rs. 319,999</span>
                        <span class="text-sm text-gray-400 line-through">Rs. 350,000</span>
                    </div>
                    <button onclick="addToCart(this)"
                            class="w-full bg-gray-900 hover:bg-blue-600 text-white py-2.5 rounded-xl font-semibold text-sm transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-plus"></i>
                        Add to Cart
                    </button>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="group min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative overflow-hidden">
                    <img src="https://picsum.photos/id/180/500/400"
                         alt="New Product"
                         class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                    <span class="absolute top-3 left-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                    <button onclick="toggleWishlist(this)"
                            class="absolute top-3 right-3 w-9 h-9 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-600 hover:bg-red-500 hover:text-white transition shadow-sm">
                        <i class="fa-regular fa-heart text-sm"></i>
                    </button>
                </div>
                <div class="p-4">
                    <p class="text-xs text-blue-600 font-semibold mb-1">Electronics</p>
                    <h3 class="text-sm font-bold text-gray-800 leading-snug mb-3 line-clamp-2 group-hover:text-blue-600 transition">
                        Lenovo Legion 7i Intel Ultra 7 | 32GB RAM | RTX Graphics
                    </h3>
                    <div class="flex items-center gap-1 mb-3">
                        <div class="flex text-yellow-400 text-sm">★★★★★</div>
                        <span class="text-gray-500 text-xs">(128)</span>
                    </div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-xl font-bold text-gray-900">Rs. 319,999</span>
                        <span class="text-sm text-gray-400 line-through">Rs. 350,000</span>
                    </div>
                    <button onclick="addToCart(this)"
                            class="w-full bg-gray-900 hover:bg-blue-600 text-white py-2.5 rounded-xl font-semibold text-sm transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-plus"></i>
                        Add to Cart
                    </button>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="group min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative overflow-hidden">
                    <img src="https://picsum.photos/id/251/500/400"
                         alt="New Product"
                         class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                    <span class="absolute top-3 left-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                    <button onclick="toggleWishlist(this)"
                            class="absolute top-3 right-3 w-9 h-9 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-600 hover:bg-red-500 hover:text-white transition shadow-sm">
                        <i class="fa-regular fa-heart text-sm"></i>
                    </button>
                </div>
                <div class="p-4">
                    <p class="text-xs text-blue-600 font-semibold mb-1">Electronics</p>
                    <h3 class="text-sm font-bold text-gray-800 leading-snug mb-3 line-clamp-2 group-hover:text-blue-600 transition">
                        Lenovo Legion 7i Intel Ultra 7 | 32GB RAM | RTX Graphics
                    </h3>
                    <div class="flex items-center gap-1 mb-3">
                        <div class="flex text-yellow-400 text-sm">★★★★★</div>
                        <span class="text-gray-500 text-xs">(128)</span>
                    </div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-xl font-bold text-gray-900">Rs. 319,999</span>
                        <span class="text-sm text-gray-400 line-through">Rs. 350,000</span>
                    </div>
                    <button onclick="addToCart(this)"
                            class="w-full bg-gray-900 hover:bg-blue-600 text-white py-2.5 rounded-xl font-semibold text-sm transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-plus"></i>
                        Add to Cart
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modern & User-Friendly Professional Contact Box -->
        <div class="relative overflow-hidden bg-white via-blue-50/50 to-slate-50 rounded-3xl border border-blue-100 shadow-xl shadow-blue-900/5 p-6 md:p-10 transition-all duration-300">

            <!-- Background Soft Glow Effect -->
            <div class="absolute -top-12 -right-12 w-40 h-40 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-indigo-400/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-6 divide-y md:divide-y-0 md:divide-x divide-blue-100">

                <!-- Email Item -->
                <a href="mailto:support@technova.com.np" class="group flex flex-col items-center md:items-start pt-6 md:pt-0 md:pr-6 transition-all duration-300 hover:translate-y-[-2px]">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100/80 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/30 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600/80 mb-1">Email Us</span>
                    <h3 class="text-base md:text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors break-all">support@technova.com.np</h3>
                    <p class="text-xs text-gray-500 mt-1">24/7 Quick Online Support</p>
                </a>

                <!-- Phone Item -->
                <a href="tel:+97715551234" class="group flex flex-col items-center md:items-start pt-6 md:pt-0 md:px-6 transition-all duration-300 hover:translate-y-[-2px]">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100/80 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/30 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600/80 mb-1">Call Us</span>
                    <h3 class="text-base md:text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors">+977 1-555-1234</h3>
                    <p class="text-xs text-gray-500 mt-1">Sun-Fri 9AM-7PM, Sat Closed</p>
                </a>

                <!-- Address Item -->
                <a href="https://maps.google.com/?q=Kathmandu,Nepal" target="_blank" rel="noopener noreferrer" class="group flex flex-col items-center md:items-start pt-6 md:pt-0 md:pl-6 transition-all duration-300 hover:translate-y-[-2px]">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100/80 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/30 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600/80 mb-1">Our Location</span>
                    <h3 class="text-base md:text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors">Kathmandu, Nepal</h3>
                    <p class="text-xs text-gray-500 mt-1">Click to view on Google Maps</p>
                </a>

            </div>
        </div>
</div>

    </Section>
</x-frontend-layout>
