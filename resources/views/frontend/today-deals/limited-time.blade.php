<x-frontend-layout title="Today's deals | TechNova Nepal" description="Limited-time laptop and gadget deals at TechNova Nepal, Kathmandu." :canonical="route('today-deals')">    <div class="bg-[#ebf4fa] full py-2">

        <div class="Container mx-auto px-4 mb-6 mt-6">
            {{-- Breadcrumb --}}
            <nav class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-gray-500 mb-6 mt-6">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Home</a>
                <span>/</span>
                <a href="{{ route('category.show', ['slug' => 'limited-time']) }}"
                    class="hover:text-blue-600 transition">Limited Time</a>
                <span>/</span>
                <span class="text-gray-800 font-medium">{{ $category->name }}</span>
            </nav>

            {{-- Header --}}
            <div class="mb-8 sm:mb-12 text-center px-2">
                <div
                    class="inline-block bg-red-600 text-white px-4 sm:px-6 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-bold uppercase tracking-wider mb-3 sm:mb-4">
                    ⏳ 24‑Hour Flash Deals
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 break-words">
                    {{ $category->name }}
                </h1>
                <p class="mt-2 sm:mt-3 text-sm sm:text-base text-gray-500 max-w-2xl mx-auto">
                    Hurry! These deals expire in 24 hours – grab them before they're gone.
                </p>
            </div>

        </div>
        {{-- Sub‑Categories --}}
        @if ($category->children->count())
            <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-8 sm:mb-10 px-4">
                <a href="{{ route('category.show', ['slug' => $category->slug]) }}"
                    class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-full bg-red-600 text-white font-semibold text-xs sm:text-sm shadow-md hover:bg-red-700 transition">
                    All Limited Deals
                </a>
                @foreach ($category->children as $child)
                    <a href="{{ route('category.show', ['slug' => $child->slug]) }}"
                        class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-full bg-gray-100 text-gray-700 font-medium text-xs sm:text-sm hover:bg-red-100 hover:text-red-600 transition border border-transparent hover:border-red-300">
                        {{ $child->name }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Main Content with Sidebar --}}
        <div class="bg-white Container mx-auto rounded-xl shadow-sm border border-gray-100 p-3 sm:p-6 lg:p-8 mb-10">
            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
                <aside class="w-full lg:w-64 flex-shrink-0">
                    <div class="space-y-6 lg:sticky lg:top-24">

                        {{-- Brand Filter --}}
                        @if ($brands->count())
                            <div>
                                <h3 class="font-semibold text-gray-800 text-base sm:text-lg mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-500 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    Brands
                                </h3>
                                <div class="space-y-1 max-h-64 lg:max-h-none overflow-y-auto lg:overflow-visible">
                                    @php
                                        $activeBrand = request()->query('brand');
                                        $queryWithoutBrand = request()->except('brand', 'page');
                                    @endphp
                                    <a href="{{ route('category.show', array_merge(['slug' => $category->slug], $queryWithoutBrand)) }}"
                                        class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition {{ !$activeBrand ? 'bg-red-50 text-red-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <span>All Brands</span>
                                        <span
                                            class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full">{{ $products->total() }}</span>
                                    </a>
                                    @foreach ($brands as $brand)
                                        @php
                                            $isActive = $activeBrand == $brand->slug;
                                            $queryWithBrand = array_merge($queryWithoutBrand, [
                                                'brand' => $brand->slug,
                                            ]);
                                        @endphp
                                        <a href="{{ route('category.show', array_merge(['slug' => $category->slug], $queryWithBrand)) }}"
                                            class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition {{ $isActive ? 'bg-red-50 text-red-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                            <span class="truncate pr-2">{{ $brand->name }}</span>
                                            <span
                                                class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full flex-shrink-0">{{ $brand->products_count }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Price Filter --}}
                        <div>
                            <h3 class="font-semibold text-gray-800 text-base sm:text-lg mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-500 flex-shrink-0" fill="none"
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
                                        class="w-full min-w-0 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                                    <span class="text-gray-400 flex-shrink-0">—</span>
                                    <input type="number" name="max_price" placeholder="Max"
                                        value="{{ request('max_price') }}"
                                        class="w-full min-w-0 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit"
                                        class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition">
                                        Apply
                                    </button>
                                    @if (request()->has('min_price') || request()->has('max_price'))
                                        <a href="{{ route('category.show', array_merge(['slug' => $category->slug], request()->except('min_price', 'max_price', 'page'))) }}"
                                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition whitespace-nowrap">
                                            Clear
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        {{-- Active filters summary --}}
                        @if (request()->has('brand') || request()->has('min_price') || request()->has('max_price'))
                            <div class="pt-4 border-t border-gray-200">
                                <p class="text-xs text-gray-500 mb-2">Active filters:</p>
                                <div class="flex flex-wrap gap-2">
                                    @if (request()->has('brand'))
                                        @php
                                            $brandName =
                                                $brands->firstWhere('slug', request('brand'))?->name ??
                                                request('brand');
                                        @endphp
                                        <span
                                            class="inline-flex items-center bg-red-50 text-red-700 text-xs px-2.5 py-1 rounded-full">
                                            {{ $brandName }}
                                            <a href="{{ route('category.show', array_merge(['slug' => $category->slug], request()->except('brand', 'page'))) }}"
                                                class="ml-1 hover:text-red-900">✕</a>
                                        </span>
                                    @endif
                                    @if (request()->has('min_price') || request()->has('max_price'))
                                        <span
                                            class="inline-flex items-center bg-red-50 text-red-700 text-xs px-2.5 py-1 rounded-full">
                                            {{ request('min_price') ? 'Rs. ' . number_format(request('min_price')) : '' }}
                                            {{ request('min_price') && request('max_price') ? ' — ' : '' }}
                                            {{ request('max_price') ? 'Rs. ' . number_format(request('max_price')) : '' }}
                                            <a href="{{ route('category.show', array_merge(['slug' => $category->slug], request()->except('min_price', 'max_price', 'page'))) }}"
                                                class="ml-1 hover:text-red-900">✕</a>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </aside>

                {{-- Product Grid with Countdown --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-semibold text-gray-800">
                            Limited Time Offers
                            <span
                                class="ml-2 text-xs sm:text-sm font-normal text-gray-400">({{ $products->total() }})</span>
                        </h2>
                    </div>
                    @if ($products->count())
                        <div
                            class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4 lg:gap-5">
                            @foreach ($products as $product)
                                @php
                                    $thumb = !empty($product->thumbnails)
                                        ? asset('storage/' . $product->thumbnails[0])
                                        : null;
                                    $discountPercent =
                                        $product->discount_price && $product->price > 0
                                            ? round((1 - $product->discount_price / $product->price) * 100)
                                            : null;
                                    $offerEnd = $product->created_at->copy()->addHours(24);
                                    $offerEndTimestamp = $offerEnd->timestamp * 1000;
                                @endphp
                                <div
                                    class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col">
                                    <div class="relative overflow-hidden bg-gray-50 aspect-square">
                                        <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                            class="block w-full h-full">
                                            @if ($thumb)
                                                <img src="{{ $thumb }}" alt="{{ $product->name }}"
                                                    class="w-full h-full object-contain p-3 sm:p-4 group-hover:scale-110 transition duration-500">
                                            @else
                                                <div
                                                    class="w-full h-full flex items-center justify-center text-gray-300 text-sm">
                                                    No image</div>
                                            @endif
                                        </a>
                                        @if ($discountPercent)
                                            <span
                                                class="absolute top-2 sm:top-3 left-2 sm:left-3 bg-red-500 text-white text-[10px] sm:text-xs font-bold px-2 sm:px-3 py-0.5 sm:py-1 rounded-full shadow-md">-{{ $discountPercent }}%</span>
                                        @else
                                            <span
                                                class="absolute top-2 sm:top-3 left-2 sm:left-3 bg-red-600 text-white text-[10px] sm:text-xs font-bold px-2 sm:px-3 py-0.5 sm:py-1 rounded-full shadow-md">24H
                                                DEAL</span>
                                        @endif
                                        <span
                                            class="absolute bottom-2 sm:bottom-3 left-2 sm:left-3 bg-yellow-500 text-white text-[9px] sm:text-[10px] font-bold px-1.5 sm:px-2 py-0.5 rounded-full shadow-md">⏳
                                            Limited</span>
                                        <button onclick="toggleWishlist(this, {{ $product->id }})"
                                            class="absolute top-2 sm:top-3 right-2 sm:right-3 w-8 h-8 sm:w-9 sm:h-9 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-600 hover:bg-red-500 hover:text-white transition shadow-sm">
                                            <i class="fa-regular fa-heart text-xs sm:text-sm"></i>
                                        </button>
                                    </div>
                                    <div class="p-3 sm:p-4 flex flex-col flex-1">
                                        @if ($product->category)
                                            <p class="text-[11px] sm:text-xs text-blue-600 font-semibold mb-1 truncate">
                                                {{ $product->category->name }}</p>
                                        @endif
                                        <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                            class="text-xs sm:text-sm font-bold text-gray-800 leading-snug mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                            {{ $product->name }}
                                        </a>
                                        <div class="flex items-center gap-1 mb-2 sm:mb-3">
                                            <div class="flex text-yellow-400 text-xs sm:text-sm">★★★★★</div>
                                            <span class="text-gray-500 text-[10px] sm:text-xs">(0)</span>
                                        </div>
                                        <div class="flex flex-wrap items-baseline gap-x-2 gap-y-0.5 mb-2 sm:mb-3">
                                            @if ($product->discount_price)
                                                <span class="text-base sm:text-xl font-bold text-gray-900">Rs.
                                                    {{ number_format($product->discount_price) }}</span>
                                                <span class="text-xs sm:text-sm text-gray-400 line-through">Rs.
                                                    {{ number_format($product->price) }}</span>
                                            @else
                                                <span class="text-base sm:text-xl font-bold text-gray-900">Rs.
                                                    {{ number_format($product->price) }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-2 sm:mb-3">
                                            @if ($product->stock > 0)
                                                <span
                                                    class="text-[10px] sm:text-xs text-green-600 font-medium bg-green-50 px-2 py-0.5 rounded-full">In
                                                    Stock</span>
                                            @else
                                                <span
                                                    class="text-[10px] sm:text-xs text-red-600 font-medium bg-red-50 px-2 py-0.5 rounded-full">Out
                                                    of Stock</span>
                                            @endif
                                        </div>
                                        {{-- Countdown --}}
                                        <div class="mb-3">
                                            <p
                                                class="text-[9px] sm:text-[10px] text-gray-400 uppercase tracking-wider mb-1">
                                                Offer
                                                ends in</p>
                                            <div id="countdown-{{ $product->id }}"
                                                data-end="{{ $offerEndTimestamp }}"
                                                class="grid grid-cols-3 gap-1 text-center">
                                                <div class="bg-red-50 rounded-lg py-1">
                                                    <div class="hours text-xs sm:text-sm font-bold text-red-600">00
                                                    </div>
                                                    <div class="text-[8px] sm:text-[9px] text-gray-500">HRS</div>
                                                </div>
                                                <div class="bg-red-50 rounded-lg py-1">
                                                    <div class="minutes text-xs sm:text-sm font-bold text-red-600">00
                                                    </div>
                                                    <div class="text-[8px] sm:text-[9px] text-gray-500">MIN</div>
                                                </div>
                                                <div class="bg-red-50 rounded-lg py-1">
                                                    <div class="seconds text-xs sm:text-sm font-bold text-red-600">00
                                                    </div>
                                                    <div class="text-[8px] sm:text-[9px] text-gray-500">SEC</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col sm:flex-row gap-2 mt-auto">
                                            <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                                class="flex-1 text-center px-2 sm:px-3 py-2 border border-gray-300 text-gray-700 text-xs sm:text-sm font-medium rounded-xl hover:bg-gray-50 hover:border-gray-400 transition whitespace-nowrap">
                                                View Deal
                                            </a>
                                            @if ($product->stock > 0)
                                                <button onclick="addToCart({{ $product->id }})"
                                                    class="flex-1 px-2 sm:px-3 py-2 bg-red-600 text-white text-xs sm:text-sm font-medium rounded-xl hover:bg-red-700 transition flex items-center justify-center gap-1 whitespace-nowrap">
                                                    <i class="fa-solid fa-cart-plus"></i> Add
                                                </button>
                                            @else
                                                <button disabled
                                                    class="flex-1 px-2 sm:px-3 py-2 bg-gray-300 text-gray-500 text-xs sm:text-sm font-medium rounded-xl cursor-not-allowed flex items-center justify-center gap-1 whitespace-nowrap">
                                                    <i class="fa-solid fa-cart-plus"></i> Out
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8 sm:mt-10 overflow-x-auto">{{ $products->links() }}</div>
                    @else
                        <div class="text-center py-12 sm:py-16 bg-white rounded-xl border border-gray-200 px-4">
                            <div class="text-4xl sm:text-5xl mb-4">⏰</div>
                            <h3 class="text-lg sm:text-xl font-semibold text-gray-700">No limited‑time deals</h3>
                            <p class="text-gray-400 mt-2 text-sm sm:text-base">Check back soon for flash offers.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Countdown Script --}}
    <script>
        // Per‑Product Countdown
        function updateProductCountdowns() {
            document.querySelectorAll('[data-end]').forEach(function(timer) {
                const endTime = parseInt(timer.dataset.end);
                const now = new Date().getTime();
                let diff = endTime - now;

                const hoursEl = timer.querySelector('.hours');
                const minutesEl = timer.querySelector('.minutes');
                const secondsEl = timer.querySelector('.seconds');

                if (diff <= 0) {
                    hoursEl.textContent = '00';
                    minutesEl.textContent = '00';
                    secondsEl.textContent = '00';
                    const card = timer.closest('.group');
                    if (card) card.classList.add('opacity-50');
                    return;
                }

                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                hoursEl.textContent = String(hours).padStart(2, '0');
                minutesEl.textContent = String(minutes).padStart(2, '0');
                secondsEl.textContent = String(seconds).padStart(2, '0');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateProductCountdowns();
            setInterval(updateProductCountdowns, 1000);
        });

        function toggleWishlist(btn, productId) {
            btn.classList.toggle('text-red-500');
            btn.querySelector('i').classList.toggle('fa-regular');
            btn.querySelector('i').classList.toggle('fa-solid');
            console.log('Toggle wishlist for product ' + productId);
        }

        function addToCart(productId) {
            const qty = 1;
            console.log('Add product ' + productId + ' to cart (qty: ' + qty + ')');
            alert('Product added to cart!');
        }
    </script>
</x-frontend-layout>
