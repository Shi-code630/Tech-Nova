<x-frontend-layout title="Today's deals | TechNova Nepal" description="Limited-time laptop and gadget deals at TechNova Nepal, Kathmandu." :canonical="route('today-deals')">  <div class="bg-[#ebf4fa] full py-2">

        {{-- Breadcrumb --}}
        <nav
            class="Container mx-auto px-3 sm:px-4 flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-5 sm:mb-6 mt-4 sm:mt-6 overflow-x-auto whitespace-nowrap scrollbar-hide">

            <a href="{{ route('home') }}" class="hover:text-blue-600 transition flex-shrink-0">
                Home
            </a>

            @php
                $ancestors = $category->getAncestors();
            @endphp

            @foreach ($ancestors as $ancestor)
                <span class="flex-shrink-0">/</span>

                <a href="{{ route('category.show', ['slug' => $ancestor->slug]) }}"
                    class="hover:text-blue-600 transition flex-shrink-0">
                    {{ $ancestor->name }}
                </a>
            @endforeach

            <span class="flex-shrink-0">/</span>

            <span class="text-gray-800 font-medium truncate max-w-[180px] sm:max-w-none">
                {{ $category->name }}
            </span>

        </nav>

        {{-- Category Title --}}
        <div class="mb-5 sm:mb-6 text-center px-3 sm:px-4">

            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight break-words">
                {{ $category->name }}
            </h1>

        </div>

        {{-- Sub-Categories --}}
        @if ($category->children->count())
            <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-7 sm:mb-10 px-3 sm:px-4">

                @foreach ($category->children as $child)
                    <a href="{{ route('category.show', ['slug' => $child->slug]) }}"
                        class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-full bg-gray-100 text-gray-700 font-medium text-xs sm:text-sm hover:bg-blue-100 hover:text-blue-600 transition border border-transparent hover:border-blue-300 text-center">
                        {{ $child->name }}
                    </a>
                @endforeach

            </div>
        @endif

        {{-- Main Content with Sidebar --}}
        <div
            class="Container mx-auto px-3 sm:px-4 bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 md:p-6 lg:p-8 mb-8 sm:mb-10">

            <div class="flex flex-col lg:flex-row gap-5 sm:gap-6 lg:gap-8">

                {{-- Sidebar Filters --}}
                <aside class="w-full lg:w-64 flex-shrink-0">

                    <div class="space-y-5 sm:space-y-6 lg:sticky lg:top-24">

                        {{-- Brand Filter --}}
                        @if ($brands->count())
                            <div>

                                <h3 class="font-semibold text-gray-800 text-base sm:text-lg mb-3 flex items-center">

                                    <svg class="w-5 h-5 mr-2 text-blue-500 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />

                                    </svg>

                                    Brands

                                </h3>

                                <div class="space-y-1">

                                    @php
                                        $activeBrand = request()->query('brand');
                                        $queryWithoutBrand = request()->except('brand', 'page');
                                    @endphp

                                    <a href="{{ route('category.show', array_merge(['slug' => $category->slug], $queryWithoutBrand)) }}"
                                        class="flex items-center justify-between gap-3 px-3 py-2 rounded-lg text-sm transition {{ !$activeBrand ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">

                                        <span class="truncate">
                                            All Brands
                                        </span>

                                        <span
                                            class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full flex-shrink-0">
                                            {{ $products->total() }}
                                        </span>

                                    </a>

                                    @foreach ($brands as $brand)
                                        @php
                                            $isActive = $activeBrand == $brand->slug;

                                            $queryWithBrand = array_merge($queryWithoutBrand, [
                                                'brand' => $brand->slug,
                                            ]);
                                        @endphp

                                        <a href="{{ route('category.show', array_merge(['slug' => $category->slug], $queryWithBrand)) }}"
                                            class="flex items-center justify-between gap-3 px-3 py-2 rounded-lg text-sm transition {{ $isActive ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">

                                            <span class="truncate">
                                                {{ $brand->name }}
                                            </span>

                                            <span
                                                class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full flex-shrink-0">
                                                {{ $brand->products_count }}
                                            </span>

                                        </a>
                                    @endforeach

                                </div>
                            </div>
                        @endif

                        {{-- Price Filter --}}
                        <div>

                            <h3 class="font-semibold text-gray-800 text-base sm:text-lg mb-3 flex items-center">

                                <svg class="w-5 h-5 mr-2 text-blue-500 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />

                                </svg>

                                Price Range

                            </h3>

                            <form action="{{ route('category.show', ['slug' => $category->slug]) }}" method="GET"
                                class="space-y-3">

                                @foreach (request()->except('min_price', 'max_price', 'page') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach

                                <div class="flex items-center gap-2">

                                    <input type="number" name="min_price" placeholder="Min"
                                        value="{{ request('min_price') }}"
                                        class="w-full min-w-0 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">

                                    <span class="text-gray-400 flex-shrink-0">
                                        —
                                    </span>

                                    <input type="number" name="max_price" placeholder="Max"
                                        value="{{ request('max_price') }}"
                                        class="w-full min-w-0 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">

                                </div>

                                <div class="flex gap-2">

                                    <button type="submit"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition">
                                        Apply
                                    </button>

                                    @if (request()->has('min_price') || request()->has('max_price'))
                                        <a href="{{ route('category.show', array_merge(['slug' => $category->slug], request()->except('min_price', 'max_price', 'page'))) }}"
                                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                                            Clear
                                        </a>
                                    @endif

                                </div>

                            </form>
                        </div>

                        {{-- Active filters summary --}}
                        @if (request()->has('brand') || request()->has('min_price') || request()->has('max_price'))

                            <div class="pt-4 border-t border-gray-200">

                                <p class="text-xs text-gray-500 mb-2">
                                    Active filters:
                                </p>

                                <div class="flex flex-wrap gap-2">

                                    @if (request()->has('brand'))
                                        @php
                                            $brandName =
                                                $brands->firstWhere('slug', request('brand'))?->name ??
                                                request('brand');
                                        @endphp

                                        <span
                                            class="inline-flex items-center max-w-full bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-full">

                                            <span class="truncate max-w-[180px]">
                                                {{ $brandName }}
                                            </span>

                                            <a href="{{ route('category.show', array_merge(['slug' => $category->slug], request()->except('brand', 'page'))) }}"
                                                class="ml-1 hover:text-blue-900 flex-shrink-0">
                                                ✕
                                            </a>

                                        </span>
                                    @endif

                                    @if (request()->has('min_price') || request()->has('max_price'))
                                        <span
                                            class="inline-flex items-center max-w-full bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-full">

                                            <span class="truncate">
                                                {{ request('min_price') ? 'Rs. ' . number_format(request('min_price')) : '' }}
                                                {{ request('min_price') && request('max_price') ? ' — ' : '' }}
                                                {{ request('max_price') ? 'Rs. ' . number_format(request('max_price')) : '' }}
                                            </span>

                                            <a href="{{ route('category.show', array_merge(['slug' => $category->slug], request()->except('min_price', 'max_price', 'page'))) }}"
                                                class="ml-1 hover:text-blue-900 flex-shrink-0">
                                                ✕
                                            </a>

                                        </span>
                                    @endif

                                </div>
                            </div>

                        @endif

                    </div>
                </aside>

                {{-- Product Grid --}}
                <div class="flex-1 min-w-0">

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-5 sm:mb-6">

                        <h2 class="text-lg sm:text-xl font-semibold text-gray-800">

                            Products

                            <span class="ml-1 sm:ml-2 text-xs sm:text-sm font-normal text-gray-400">
                                ({{ $products->total() }})
                            </span>

                        </h2>

                    </div>

                    @if ($products->count())

                        <div
                            class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4 lg:gap-5">

                            @foreach ($products as $product)
                                @php
                                    $thumb = !empty($product->thumbnails)
                                        ? asset('storage/' . $product->thumbnails[0])
                                        : null;

                                    $discountPercent =
                                        $product->discount_price && $product->price > 0
                                            ? round((1 - $product->discount_price / $product->price) * 100)
                                            : null;
                                @endphp

                                <div
                                    class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col min-w-0">

                                    {{-- Product Image --}}
                                    <div class="relative overflow-hidden bg-gray-50 aspect-square">

                                        <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                            class="block w-full h-full">

                                            @if ($thumb)
                                                <img src="{{ $thumb }}" alt="{{ $product->name }}"
                                                    class="w-full h-full object-contain p-2 sm:p-3 md:p-4 group-hover:scale-110 transition duration-500">
                                            @else
                                                <div
                                                    class="w-full h-full flex items-center justify-center text-gray-300 text-xs sm:text-sm text-center px-2">
                                                    No image
                                                </div>
                                            @endif

                                        </a>

                                        {{-- Discount --}}
                                        @if ($discountPercent)
                                            <span
                                                class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-red-500 text-white text-[10px] sm:text-xs font-bold px-2 sm:px-3 py-1 rounded-full shadow-md">
                                                -{{ $discountPercent }}%
                                            </span>
                                        @endif

                                        {{-- Wishlist --}}
                                        <button onclick="toggleWishlist(this, {{ $product->id }})"
                                            class="absolute top-2 right-2 sm:top-3 sm:right-3 w-8 h-8 sm:w-9 sm:h-9 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-600 hover:bg-red-500 hover:text-white transition shadow-sm">

                                            <i class="fa-regular fa-heart text-xs sm:text-sm"></i>

                                        </button>

                                    </div>

                                    {{-- Product Info --}}
                                    <div class="p-2.5 sm:p-3 md:p-4 flex flex-col flex-1 min-w-0">

                                        @if ($product->category)
                                            <p class="text-[10px] sm:text-xs text-blue-600 font-semibold mb-1 truncate">
                                                {{ $product->category->name }}
                                            </p>
                                        @endif

                                        <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                            class="text-xs sm:text-sm font-bold text-gray-800 leading-snug mb-2 line-clamp-2 group-hover:text-blue-600 transition break-words">

                                            {{ $product->name }}

                                        </a>

                                        {{-- Rating --}}
                                        <div class="flex items-center gap-1 mb-2 sm:mb-3 min-w-0">

                                            <div class="flex text-yellow-400 text-xs sm:text-sm flex-shrink-0">
                                                ★★★★★
                                            </div>

                                            <span class="text-gray-500 text-[10px] sm:text-xs">
                                                (0)
                                            </span>

                                        </div>

                                        {{-- Price --}}
                                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mb-3 sm:mb-4 min-w-0">

                                            @if ($product->discount_price)
                                                <span
                                                    class="text-sm sm:text-base md:text-xl font-bold text-gray-900 break-words">
                                                    Rs. {{ number_format($product->discount_price) }}
                                                </span>

                                                <span
                                                    class="text-[10px] sm:text-xs md:text-sm text-gray-400 line-through">
                                                    Rs. {{ number_format($product->price) }}
                                                </span>
                                            @else
                                                <span
                                                    class="text-sm sm:text-base md:text-xl font-bold text-gray-900 break-words">
                                                    Rs. {{ number_format($product->price) }}
                                                </span>
                                            @endif

                                        </div>

                                        {{-- Add To Cart --}}
                                        @if ($product->stock > 0)
                                            <button onclick="addToCart({{ $product->id }})"
                                                class="w-full bg-gray-900 hover:bg-blue-600 text-white py-2 sm:py-2.5 px-2 rounded-lg sm:rounded-xl font-semibold text-[11px] sm:text-xs md:text-sm transition flex items-center justify-center gap-1.5 sm:gap-2 mt-auto">

                                                <i class="fa-solid fa-cart-plus text-[10px] sm:text-xs"></i>

                                                <span>
                                                    Add to Cart
                                                </span>

                                            </button>
                                        @else
                                            <button disabled
                                                class="w-full bg-gray-300 text-gray-500 py-2 sm:py-2.5 px-2 rounded-lg sm:rounded-xl font-semibold text-[11px] sm:text-xs md:text-sm cursor-not-allowed flex items-center justify-center gap-1.5 sm:gap-2 mt-auto">

                                                <i class="fa-solid fa-cart-plus text-[10px] sm:text-xs"></i>

                                                <span>
                                                    Out of Stock
                                                </span>

                                            </button>
                                        @endif

                                    </div>
                                </div>
                            @endforeach

                        </div>

                        {{-- Pagination --}}
                        <div class="mt-8 sm:mt-10 overflow-x-auto">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 sm:py-16 bg-white rounded-xl border border-gray-200 px-4">

                            <div class="text-4xl sm:text-5xl mb-4">
                                🛍️
                            </div>

                            <h3 class="text-lg sm:text-xl font-semibold text-gray-700">
                                No products found
                            </h3>

                            <p class="text-sm sm:text-base text-gray-400 mt-2">
                                Try adjusting your filters.
                            </p>

                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleWishlist(btn, productId) {
            btn.classList.toggle('text-red-500');
            btn.querySelector('i').classList.toggle('fa-regular');
            btn.querySelector('i').classList.toggle('fa-solid');

            console.log('Toggle wishlist for product ' + productId);
        }

        function addToCart(productId) {
            const qty = 1;

            console.log(
                'Add product ' + productId + ' to cart (qty: ' + qty + ')'
            );

            alert('Product added to cart!');
        }
    </script>

</x-frontend-layout>
