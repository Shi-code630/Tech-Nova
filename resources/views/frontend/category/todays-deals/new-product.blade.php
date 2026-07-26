<x-frontend-layout>
    <section>
        <!-- Breadcrumb -->
        <div class="bg-white border-b">
            <div class="container py-4">
                <div class="flex items-center justify-between">
                    <!-- Right Side Breadcrumb -->
                    <nav class="flex items-center gap-2 text-sm">
                        <a href="/" class="text-gray-500 hover:text-blue-600 transition">Home</a>
                        <span class="text-gray-400">/</span>
                        <span class="text-blue-600 font-medium">New Products</span>
                    </nav>
                </div>
            </div>
        </div>

        <!-- New Products Section -->
        <div class="py-8 bg-[#f0f9ff]">
            <div class="container">

                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="text-black text-lg font-semibold">
                            New Products
                        </div>
                        <div class="h-px w-12 bg-gradient-to-r from-blue-600 to-transparent"></div>
                    </div>

                    <a href="/new-products"
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
    </section>

    <!-- JavaScript -->
    <script>
        function addToCart(btn) {
            const originalHTML = btn.innerHTML;
            btn.innerHTML = `<i class="fa-solid fa-check"></i> Added!`;
            btn.classList.add('!bg-emerald-600');

            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.classList.remove('!bg-emerald-600');
            }, 1800);
        }

        function toggleWishlist(btn) {
            const icon = btn.querySelector('i');
            if (icon.classList.contains('fa-regular')) {
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid', 'text-red-500');
            } else {
                icon.classList.remove('fa-solid', 'text-red-500');
                icon.classList.add('fa-regular');
            }
        }
    </script>
</x-frontend-layout>
