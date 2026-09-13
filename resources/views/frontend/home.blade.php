<x-frontend-layout>
    <Section class="bg-[#f0f9ff]">
        <div class="Container mx-auto px-4">
            <div class="mt-[10px]">
                <div class="relative max-w-[1500px] mx-auto h-[350px] overflow-hidden rounded-2xl shadow-2xl">

                    <!-- Slides Wrapper -->
                    <div id="slider"
                        class="flex h-full transition-transform duration-500 ease-in-out will-change-transform">

                        @foreach ($banners as $banner)
                            <!-- Full Banner Clickable -->
                            <div class="relative w-full h-full flex-shrink-0">

                                <a href="{{ $banner->button_link ?? '#' }}" class="block w-full h-100">

                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->alt_text }}"
                                        class="w-full h-full object-cover">

                                </a>

                            </div>
                        @endforeach

                    </div>


                    <!-- Left Arrow -->
                    <button onclick="moveSlide(-1)"
                        class="absolute top-1/2 left-4 -translate-y-1/2
                   bg-black/50 hover:bg-black/70
                   text-white p-3 rounded-full z-10
                   transition">
                        ❮
                    </button>


                    <!-- Right Arrow -->
                    <button onclick="moveSlide(1)"
                        class="absolute top-1/2 right-4 -translate-y-1/2
                   bg-black/50 hover:bg-black/70
                   text-white p-3 rounded-full z-10
                   transition">
                        ❯
                    </button>


                    <!-- Dots -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2
                    flex gap-2 z-10">

                        @foreach ($banners as $index => $banner)
                            <span
                                class="dot w-3 h-3 rounded-full
                             bg-white/50 cursor-pointer"
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
                        <div
                            class="product-card min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="relative bg-gray-100 p-3">
                                <div class="overflow-hidden rounded-xl">
                                    <img src="https://picsum.photos/id/1015/500/350" alt="Lenovo Legion"
                                        class="w-full h-40 object-cover rounded-xl hover:scale-105 transition duration-500">
                                </div>
                                <span
                                    class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">-9%</span>
                                <span
                                    class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">NEW</span>
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
                        <div
                            class="product-card min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="relative bg-gray-100 p-3">
                                <div class="overflow-hidden rounded-xl">
                                    <img src="https://picsum.photos/id/201/500/350" alt="Lenovo Legion"
                                        class="w-full h-40 object-cover rounded-xl hover:scale-105 transition duration-500">
                                </div>
                                <span
                                    class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">-9%</span>
                                <span
                                    class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">NEW</span>
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
                                    <button onclick="addToCart(this)"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-2.5 font-semibold transition text-sm flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                    </button>
                                    <button onclick="toggleWishlist(this)"
                                        class="w-10 h-10 rounded-xl border border-gray-200 hover:bg-red-500 hover:border-red-500 hover:text-white text-gray-500 transition">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div
                            class="product-card min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="relative bg-gray-100 p-3">
                                <div class="overflow-hidden rounded-xl">
                                    <img src="https://picsum.photos/id/1015/500/350" alt="Lenovo Legion"
                                        class="w-full h-40 object-cover rounded-xl hover:scale-105 transition duration-500">
                                </div>
                                <span
                                    class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">-9%</span>
                                <span
                                    class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">NEW</span>
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
                                <div
                                    class="flex items-center justify-between bg-orange-50 rounded-lg p-2 mb-4 text-xs">
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
                        <div
                            class="product-card min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="relative bg-gray-100 p-3">
                                <div class="overflow-hidden rounded-xl">
                                    <img src="https://picsum.photos/id/201/500/350" alt="Lenovo Legion"
                                        class="w-full h-40 object-cover rounded-xl hover:scale-105 transition duration-500">
                                </div>
                                <span
                                    class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">-9%</span>
                                <span
                                    class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">NEW</span>
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
                                <div
                                    class="flex items-center justify-between bg-orange-50 rounded-lg p-2 mb-4 text-xs">
                                    <div class="flex items-center gap-1.5 text-orange-600">
                                        <i class="fa-solid fa-clock"></i>
                                        <span class="font-medium">Ends In</span>
                                    </div>
                                    <span id="timer2" class="font-bold text-orange-700 timer">03:07:31</span>
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="addToCart(this)"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-2.5 font-semibold transition text-sm flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                    </button>
                                    <button onclick="toggleWishlist(this)"
                                        class="w-10 h-10 rounded-xl border border-gray-200 hover:bg-red-500 hover:border-red-500 hover:text-white text-gray-500 transition">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Card 5 -->
                        <div
                            class="product-card min-w-[250px] bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="relative bg-gray-100 p-3">
                                <div class="overflow-hidden rounded-xl">
                                    <img src="https://picsum.photos/id/201/500/350" alt="Lenovo Legion"
                                        class="w-full h-40 object-cover rounded-xl hover:scale-105 transition duration-500">
                                </div>
                                <span
                                    class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">-9%</span>
                                <span
                                    class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">NEW</span>
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
                                <div
                                    class="flex items-center justify-between bg-orange-50 rounded-lg p-2 mb-4 text-xs">
                                    <div class="flex items-center gap-1.5 text-orange-600">
                                        <i class="fa-solid fa-clock"></i>
                                        <span class="font-medium">Ends In</span>
                                    </div>
                                    <span id="timer2" class="font-bold text-orange-700 timer">03:07:31</span>
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="addToCart(this)"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-2.5 font-semibold transition text-sm flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                    </button>
                                    <button onclick="toggleWishlist(this)"
                                        class="w-10 h-10 rounded-xl border border-gray-200 hover:bg-red-500 hover:border-red-500 hover:text-white text-gray-500 transition">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-3 bg-[#f0f9ff]">
                        <div class="">

                            @foreach ($parentCategories as $category)

                                @php
                                    // Is parent category ke latest 5 products
                                    $categoryProducts = $category->homeProducts;
                                @endphp

                                @if ($categoryProducts->count())
                                    <div class="mb-10">

                                        {{-- CATEGORY HEADER --}}
                                        <div class="flex items-center justify-between mb-4">

                                            <div>
                                                <h2 class="text-xl md:text-2xl font-bold text-slate-900">
                                                    {{ $category->name }}
                                                </h2>

                                                <p class="text-sm text-slate-500 mt-1">
                                                    Latest products in {{ $category->name }}
                                                </p>
                                            </div>

                                            <a href="{{ route('category.show', ['slug' => $category->slug]) }}"
                                                class="inline-flex items-center gap-1
                          text-sm font-semibold
                          text-blue-600
                          hover:text-blue-700
                          transition">

                                                View All

                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">

                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M9 5l7 7-7 7" />

                                                </svg>

                                            </a>

                                        </div>


                                        {{-- PRODUCTS --}}
                                        <div
                                            class="grid grid-cols-2
                        sm:grid-cols-3
                        md:grid-cols-4
                        lg:grid-cols-5
                        gap-3">

                                            @foreach ($categoryProducts as $index => $product)
                                                @php
                                                    $hasDiscount =
                                                        isset($product->discount_price) &&
                                                        $product->discount_price &&
                                                        $product->price > $product->discount_price;

                                                    $discountAmount = $hasDiscount
                                                        ? $product->price - $product->discount_price
                                                        : 0;

                                                    $discountPercent = $hasDiscount
                                                        ? round(($discountAmount / $product->price) * 100)
                                                        : 0;

                                                    $isWishlisted = in_array($product->id, $wishlistProductIds ?? []);

                                                    $rating = $product->rating ?? 0;
                                                    $reviewCount = $product->reviews_count ?? 0;

                                                    // PRODUCT IMAGE
                                                    $image = null;

                                                    if (
                                                        isset($product->thumbnails) &&
                                                        is_array($product->thumbnails) &&
                                                        count($product->thumbnails)
                                                    ) {
                                                        $image = $product->thumbnails[0];
                                                    }

                                                    if (!$image && isset($product->image)) {
                                                        $image = $product->image;
                                                    }

                                                    if (is_array($image)) {
                                                        $image = $image[0] ?? null;
                                                    }
                                                @endphp


                                                {{-- PRODUCT CARD --}}
                                                <article
                                                    onclick="window.location.href='{{ route('product.show', ['slug' => $product->slug]) }}'"
                                                    class="product-card group
                                                            bg-white
                                                            rounded-xl
                                                            border border-slate-200
                                                            overflow-hidden
                                                            shadow-sm
                                                            hover:shadow-md
                                                            hover:border-blue-200
                                                            transition duration-300
                                                            cursor-pointer
                                                            flex flex-col">

                                                    {{-- PRODUCT IMAGE --}}
                                                    <div
                                                        class="relative
                                                        bg-slate-50
                                                        h-36
                                                        overflow-hidden">

                                                        {{-- NEW BADGE --}}
                                                        @if ($product->created_at && $product->created_at->gt(now()->subDays(14)))
                                                            <span
                                                                class="absolute top-1.5 left-1.5 z-10
                                                            px-1.5 py-0.5
                                                            rounded
                                                            bg-blue-600
                                                            text-white
                                                            text-[9px]
                                                            font-bold
                                                            shadow-sm">

                                                                NEW

                                                            </span>
                                                        @endif


                                                        {{-- DISCOUNT --}}
                                                        @if ($hasDiscount)
                                                            <span
                                                                class="absolute top-1.5 right-1.5 z-10
                                                                px-1.5 py-0.5
                                                                rounded
                                                                bg-slate-900
                                                                text-white
                                                                text-[9px]
                                                                font-bold">

                                                                -{{ $discountPercent }}%

                                                            </span>
                                                        @endif


                                                        {{-- WISHLIST --}}
                                                       {{-- WISHLIST --}}
<button
    type="button"
    onclick="toggleWishlist(event, this, {{ $product->id }})"
    data-wishlisted="{{ $isWishlisted ? 'true' : 'false' }}"
    aria-label="{{ $isWishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}"
    class="wishlist-button
        absolute
        right-1.5
        bottom-1.5
        z-20
        w-7
        h-7
        rounded-full
        bg-white
        border
        shadow-sm
        flex
        items-center
        justify-center
        transition
        duration-200
        {{ $isWishlisted
            ? 'text-blue-600 border-blue-300'
            : 'text-slate-400 border-slate-200 hover:text-blue-600 hover:border-blue-300' }}">

    <svg
        class="wishlist-icon w-3.5 h-3.5"
        viewBox="0 0 24 24"
        fill="{{ $isWishlisted ? 'currentColor' : 'none' }}"
        stroke="currentColor"
        stroke-width="2">

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" />

    </svg>

</button>


                                                        {{-- IMAGE --}}
                                                        @if ($image)
                                                            <img src="{{ asset('storage/' . ltrim($image, '/')) }}"
                                                                alt="{{ $product->name }}" loading="lazy"
                                                                class="w-full
                                                                h-full
                                                                object-contain
                                                                p-2
                                                                group-hover:scale-105
                                                                transition
                                                                duration-500">
                                                        @else
                                                            <div
                                                                class="w-full h-full
                                                                    flex items-center
                                                                    justify-center">

                                                                <svg class="w-10 h-10 text-slate-300" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">

                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="1.5"
                                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />

                                                                </svg>

                                                            </div>
                                                        @endif

                                                    </div>


                                                    {{-- PRODUCT INFORMATION --}}
                                                    <div class="p-2.5 flex flex-col flex-1">

                                                        {{-- BRAND --}}
                                                        @if ($product->brand)
                                                            <p
                                                                class="text-[10px]
                                                                font-semibold
                                                                uppercase
                                                                tracking-wide
                                                                text-blue-600
                                                                mb-0.5
                                                                truncate">

                                                                {{ $product->brand->name }}

                                                            </p>
                                                        @endif


                                                        {{-- NAME --}}
                                                        <h3
                                                            class="font-semibold
                                                            text-slate-900
                                                            text-[12px]
                                                            leading-4
                                                            line-clamp-2
                                                            min-h-[32px]">

                                                            {{ $product->name }}

                                                        </h3>


                                                        {{-- RATING --}}
                                                        <div class="flex items-center gap-0.5 mt-1">

                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <svg class="w-3 h-3
                                                {{ $i <= round($rating) ? 'text-yellow-400' : 'text-slate-300' }}"
                                                                    fill="currentColor" viewBox="0 0 20 20">

                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />

                                                                </svg>
                                                            @endfor

                                                            <span class="text-[9px] text-slate-500 ml-0.5">
                                                                ({{ $reviewCount }})
                                                            </span>

                                                        </div>


                                                        {{-- PRICE --}}
                                                        <div
                                                            class="mt-1.5
                                                            flex
                                                            items-center
                                                            gap-1
                                                            flex-wrap">

                                                            @if ($hasDiscount)
                                                                <span
                                                                    class="text-[13px]
                                                                        font-bold
                                                                        text-blue-600">

                                                                    Rs.{{ number_format($product->discount_price, 0) }}

                                                                </span>

                                                                <span
                                                                    class="text-[10px]
                                                                        text-slate-400
                                                                        line-through">

                                                                    Rs.{{ number_format($product->price, 0) }}

                                                                </span>

                                                                <span
                                                                    class="text-[9px]
                                                                    font-semibold
                                                                    text-green-600">

                                                                    Save Rs.{{ number_format($discountAmount, 0) }}

                                                                </span>
                                                            @else
                                                                <span
                                                                    class="text-[13px]
                                                                        font-bold
                                                                        text-slate-900">

                                                                    Rs.{{ number_format($product->price, 0) }}

                                                                </span>
                                                            @endif

                                                        </div>


                                                        {{-- STOCK --}}
                                                        @if (isset($product->stock))
                                                            @if ($product->stock > 0)
                                                                <div class="flex items-center gap-1 mt-1">

                                                                    <span
                                                                        class="w-1.5 h-1.5
                                                                        rounded-full
                                                                        bg-green-500">
                                                                    </span>

                                                                    <p
                                                                        class="text-[9px]
                                                                    font-medium
                                                                    text-slate-500">

                                                                        In Stock

                                                                    </p>

                                                                </div>
                                                            @else
                                                                <div class="flex items-center gap-1 mt-1">

                                                                    <span
                                                                        class="w-1.5 h-1.5
                                                                    rounded-full
                                                                    bg-red-500">
                                                                    </span>

                                                                    <p
                                                                        class="text-[9px]
                                                                    font-semibold
                                                                    text-red-500">

                                                                        Out of Stock

                                                                    </p>

                                                                </div>
                                                            @endif
                                                        @endif


                                                        {{-- ADD TO CART --}}
                                                        <div class="mt-auto pt-2">

                                                            @if (isset($product->stock) && $product->stock <= 0)
                                                                <button type="button" disabled
                                                                    onclick="event.stopPropagation();"
                                                                    class="w-full
                                                                    inline-flex
                                                                    items-center
                                                                    justify-center
                                                                    rounded-md
                                                                    bg-slate-100
                                                                    text-slate-400
                                                                    py-1.5
                                                                    text-[11px]
                                                                    font-semibold
                                                                    cursor-not-allowed">

                                                                    Out of Stock

                                                                </button>
                                                            @else
                                                                <form method="POST"
                                                                    action="{{ route('cart.add', ['product' => $product->id]) }}"
                                                                    onclick="event.stopPropagation();" class="w-full">

                                                                    @csrf

                                                                    <input type="hidden" name="quantity"
                                                                        value="1">

                                                                    <button type="submit"
                                                                        onclick="event.stopPropagation();"
                                                                        class="w-full
                                                                        bg-blue-600
                                                                        hover:bg-blue-700
                                                                        text-white
                                                                        py-2.5
                                                                        px-4
                                                                        rounded-lg
                                                                        font-semibold
                                                                        transition
                                                                        duration-200
                                                                        flex
                                                                        items-center
                                                                        justify-center
                                                                        gap-2">

                                                                        <i class="fa-solid fa-cart-shopping"></i>

                                                                        Add to Cart

                                                                    </button>

                                                                </form>
                                                            @endif

                                                        </div>

                                                    </div>

                                                </article>
                                            @endforeach

                                        </div>

                                    </div>
                                @endif

                            @endforeach
                        </div>
                    </div>

                    <div class="py-3 pb-10">

                        <!-- Header -->
                        <div class="flex items-center justify-between mb-6">

                            <!-- Left Side -->
                            <div class="flex items-center gap-3">

                                <div class="text-black text-lg font-semibold py-2 rounded-lg">
                                    Shop By Brands
                                </div>

                                <div class="h-px w-12 bg-gradient-to-r from-blue-600 to-transparent"></div>

                            </div>


                            <!-- Right Side -->
                            <a href="#"
                                class="flex items-center gap-2 text-black-600 hover:text-black-700 font-medium transition-colors group">

                                Explore products from trusted global brands.

                                <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>

                            </a>

                        </div>


                        @if ($brands->where('status', true)->count() > 0)

                            @php
                                $activeBrands = $brands->where('status', true)->values();
                            @endphp


                            <div class="relative overflow-hidden">

                                <!-- Slider Track -->
                                <div class="flex gap-6 animate-scroll hover:pause">


                                    {{-- ========================= --}}
                                    {{-- FIRST SET OF BRANDS --}}
                                    {{-- ========================= --}}

                                    @foreach ($activeBrands as $brand)
                                        <a href="{{ route('brand.show', $brand->slug) }}"
                                            class="flex-shrink-0 w-[120px] h-[110px] bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-200 hover:border-blue-600 transition-all duration-300 hover:-translate-y-1 flex flex-col items-center justify-center p-4 cursor-pointer group">

                                            <div class="w-20 h-20 flex items-center justify-center">

                                                @if ($brand->logo && file_exists(public_path('storage/' . $brand->logo)))
                                                    <img src="{{ asset('storage/' . $brand->logo) }}"
                                                        alt="{{ $brand->name }}"
                                                        class="w-[60px] h-[60px] object-contain group-hover:scale-105 transition-transform duration-300"
                                                        loading="lazy">
                                                @else
                                                    <div
                                                        class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-1xl font-bold">

                                                        {{ strtoupper(substr($brand->name, 0, 1)) }}

                                                    </div>
                                                @endif

                                            </div>


                                            <span
                                                class="mt-3 text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors duration-300 text-center">

                                                {{ $brand->name }}

                                            </span>

                                        </a>
                                    @endforeach



                                    {{-- ========================= --}}
                                    {{-- DUPLICATE FOR SEAMLESS LOOP --}}
                                    {{-- ========================= --}}

                                    @foreach ($activeBrands as $brand)
                                        <a href="{{ route('brand.show', $brand->slug) }}"
                                            class="flex-shrink-0 w-[120px] h-[110px] bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-200 hover:border-blue-600 transition-all duration-300 hover:-translate-y-1 flex flex-col items-center justify-center p-4 cursor-pointer group">

                                            <div class="w-20 h-20 flex items-center justify-center">

                                                @if ($brand->logo && file_exists(public_path('storage/' . $brand->logo)))
                                                    <img src="{{ asset('storage/' . $brand->logo) }}"
                                                        alt="{{ $brand->name }}"
                                                        class="w-[60px] h-[60px] object-contain group-hover:scale-105 transition-transform duration-300"
                                                        loading="lazy">
                                                @else
                                                    <div
                                                        class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-1xl font-bold">

                                                        {{ strtoupper(substr($brand->name, 0, 1)) }}

                                                    </div>
                                                @endif

                                            </div>


                                            <span
                                                class="mt-3 text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors duration-300 text-center">

                                                {{ $brand->name }}

                                            </span>

                                        </a>
                                    @endforeach

                                </div>


                                <!-- Gradient masks to fade edges -->

                                <div
                                    class="absolute inset-y-0 left-0 w-16 bg-gradient-to-r from-white to-transparent pointer-events-none">
                                </div>

                                <div
                                    class="absolute inset-y-0 right-0 w-16 bg-gradient-to-l from-white to-transparent pointer-events-none">
                                </div>

                            </div>
                        @else
                            <p class="text-center text-gray-500">
                                No brands available at the moment.
                            </p>

                        @endif

                    </div>


                    <style>
                        @keyframes scroll {

                            0% {
                                transform: translateX(0);
                            }

                            100% {
                                transform: translateX(-50%);
                            }

                        }


                        .animate-scroll {

                            animation: scroll 30s linear infinite;

                            width: max-content;

                        }


                        .hover\:pause:hover {

                            animation-play-state: paused;

                        }
                    </style>

                    <div class="pb-5">
                        <!-- Header -->
                        <div class="flex items-center justify-between ">
                            <!-- Left Side -->
                            <div class="flex items-center gap-3">
                                <div class="text-black text-lg font-semibold  py-2 rounded-lg">
                                    Blogs & Articles
                                </div>
                                <div class="h-px w-12 bg-gradient-to-r from-blue-600 to-transparent"></div>
                            </div>

                            <!-- Right Side -->
                            <a href="{{ route('blogs.index') }}"
                                class="flex items-center gap-2 text-[#155dfc] hover:text-blue-700 font-medium transition-colors group">
                                Read more articles.
                                <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 pt-5 gap-6 pb-10">

                            @foreach ($blogs as $blog)
                                <article
                                    class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition duration-300">

                                    {{-- Blog Image --}}
                                    <div class="h-52 overflow-hidden">

                                        <img src="{{ $blog->featured_image
                                            ? asset('storage/' . $blog->featured_image)
                                            : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=900&q=80' }}"
                                            alt="{{ $blog->title }}"
                                            class="w-full h-full object-cover hover:scale-105 transition duration-500">

                                    </div>


                                    <div class="p-4">

                                        {{-- Category + Date --}}
                                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">

                                            <span class="text-blue-600 font-medium line-clamp-1">
                                                {{ $blog->category->name ?? 'Blog' }}
                                            </span>



                                        </div>


                                        {{-- Title --}}
                                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2">
                                            {{ $blog->title }}
                                        </h3>


                                        {{-- Excerpt - Maximum 3 Lines --}}
                                        <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                                            {{ $blog->excerpt }}
                                        </p>


                                        {{-- Date + Read More --}}
                                        <div class="flex items-center justify-between">

                                            {{-- Date - Left --}}
                                            <span class="text-sm text-gray-500">📅
                                                {{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}
                                            </span>

                                            {{-- Read More - Right --}}
                                            <a href="{{ route('blogs.view', $blog->slug) }}"
                                                class="text-sm text-blue-600 hover:text-blue-800 inline-flex items-center">
                                                Read More
                                                <span class="ml-2">→</span>
                                            </a>

                                        </div>
                                    </div>

                                </article>
                            @endforeach

                        </div>
                    </div>
                    <!-- Modern & User-Friendly Professional Contact Box -->
                    <div
                        class="relative overflow-hidden bg-white via-blue-50/50 to-slate-50 rounded-3xl border border-blue-100 shadow-xl shadow-blue-900/5 p-6 md:p-10 transition-all duration-300">

                        <!-- Background Soft Glow Effect -->
                        <div
                            class="absolute -top-12 -right-12 w-40 h-40 bg-blue-400/10 rounded-full blur-3xl pointer-events-none">
                        </div>
                        <div
                            class="absolute -bottom-12 -left-12 w-40 h-40 bg-indigo-400/10 rounded-full blur-3xl pointer-events-none">
                        </div>

                        <div
                            class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-6 divide-y md:divide-y-0 md:divide-x divide-blue-100">

                            <!-- Email Item -->
                            <a href="mailto:support@technova.com.np"
                                class="group flex flex-col items-center md:items-start pt-6 md:pt-0 md:pr-6 transition-all duration-300 hover:translate-y-[-2px]">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-blue-100/80 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/30 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold uppercase tracking-wider text-blue-600/80 mb-1">Email
                                    Us</span>
                                <h3
                                    class="text-base md:text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors break-all">
                                    support@technova.com.np</h3>
                                <p class="text-xs text-gray-500 mt-1">24/7 Quick Online Support</p>
                            </a>

                            <!-- Phone Item -->
                            <a href="tel:+97715551234"
                                class="group flex flex-col items-center md:items-start pt-6 md:pt-0 md:px-6 transition-all duration-300 hover:translate-y-[-2px]">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-blue-100/80 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/30 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold uppercase tracking-wider text-blue-600/80 mb-1">Call
                                    Us</span>
                                <h3
                                    class="text-base md:text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                                    +977 1-555-1234</h3>
                                <p class="text-xs text-gray-500 mt-1">Sun-Fri 9AM-7PM, Sat Closed</p>
                            </a>

                            <!-- Address Item -->
                            <a href="https://maps.google.com/?q=Kathmandu,Nepal" target="_blank"
                                rel="noopener noreferrer"
                                class="group flex flex-col items-center md:items-start pt-6 md:pt-0 md:pl-6 transition-all duration-300 hover:translate-y-[-2px]">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-blue-100/80 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/30 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold uppercase tracking-wider text-blue-600/80 mb-1">Our
                                    Location</span>
                                <h3
                                    class="text-base md:text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                                    Kathmandu, Nepal</h3>
                                <p class="text-xs text-gray-500 mt-1">Click to view on Google Maps</p>
                            </a>

                        </div>
                    </div>
                </div>

    </Section>
<script>
    async function toggleWishlist(event, button, productId) {
        event.preventDefault();
        event.stopPropagation();

        const token = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content');

        if (!token) {
            alert('Security token not found. Please refresh the page.');
            return;
        }

        try {
            const response = await fetch(
                "{{ route('user.wishlist.toggle') }}",
                {
                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": token,
                        "X-Requested-With": "XMLHttpRequest"
                    },

                    body: JSON.stringify({
                        product_id: productId
                    })
                }
            );

            const data = await response.json();

            console.log('Wishlist Response:', data);

            if (!response.ok) {
                throw new Error(
                    data.message || "Wishlist update failed."
                );
            }

            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || "Wishlist update failed.");
            }

        } catch (error) {
            console.error('Wishlist Error:', error);
            alert(error.message || 'Something went wrong.');
        }
    }
</script>
</x-frontend-layout>
