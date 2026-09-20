<x-frontend-layout>
    <div class="w-full max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-5">

        {{-- =========================================================
            HERO / BREADCRUMB
        ========================================================== --}}
        <div class="w-full mx-auto pb-4 sm:pb-5">

            {{-- Breadcrumb --}}
            <nav
                class="flex items-center gap-2 text-[11px] sm:text-[12px]
                       overflow-x-auto whitespace-nowrap scrollbar-hide">

                <a href="{{ route('home') }}"
                    class="text-slate-500 hover:text-blue-600 transition-colors duration-200 flex-shrink-0">
                    Home
                </a>

                <span class="text-gray-300 flex-shrink-0">/</span>

                <a href="{{ route('limited-time') }}" class="hover:text-red-600 transition flex-shrink-0">
                    Limited Time
                </a>

                <span class="text-gray-300 flex-shrink-0">/</span>

                <span class="text-gray-800 font-semibold truncate">
                    {{ $category->name }}
                </span>

            </nav>

        </div>


        {{-- =========================================================
            HERO SECTION
        ========================================================== --}}
        <section
            class="relative overflow-hidden
                   bg-gradient-to-r from-[#b91c1c] via-[#dc2626] to-[#f97316]
                   rounded-2xl sm:rounded-3xl">

            {{-- Background Decorations --}}
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute -top-24 -right-12 w-40 sm:w-56 h-40 sm:h-56 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-28 -left-16 w-48 sm:w-64 h-48 sm:h-64 rounded-full bg-black/10"></div>
                <div class="absolute top-8 left-[8%] w-2 h-2 rounded-full bg-white/20"></div>
                <div class="absolute bottom-8 right-[12%] w-2.5 h-2.5 rounded-full bg-white/15"></div>
            </div>

            <div class="relative w-full mx-auto px-3 sm:px-4 py-5 sm:py-6 md:py-7">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 lg:gap-6 items-center">

                    {{-- LEFT CONTENT --}}
                    <div class="lg:col-span-7 text-white">

                        {{-- Badge --}}
                        <div
                            class="inline-flex items-center gap-1.5 sm:gap-2
                                   bg-white/15 border border-white/20 backdrop-blur-md
                                   px-2.5 py-1 rounded-full
                                   text-[9px] md:text-[10px]
                                   font-bold uppercase tracking-widest">

                            <span
                                class="flex items-center justify-center
                                       w-4 h-4 rounded-full bg-white text-red-600 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-2.5 h-2.5">
                                    <path d="M13 2L3 14h7l-1 8 10-12h-7l1-8z" />
                                </svg>
                            </span>

                            Limited Time Special

                        </div>

                        {{-- Heading --}}
                        <h1
                            class="mt-2
                                   text-2xl sm:text-3xl lg:text-4xl
                                   font-black leading-[1.05] tracking-tight">
                            {{ $category->name }}
                            <span class="block text-yellow-300 mt-0.5">
                                Flash Deals
                            </span>
                        </h1>

                        {{-- Description --}}
                        <p
                            class="mt-2
                                   text-[11px] md:text-xs
                                   text-white/90 leading-relaxed max-w-lg">
                            Discover incredible prices on selected products.
                            These exclusive offers are available for a limited time,
                            so don't miss your chance to save big.
                        </p>

                        {{-- Feature Items --}}
                        <div class="mt-3 flex flex-wrap gap-1.5 sm:gap-2">

                            {{-- Feature 1 --}}
                            <div
                                class="inline-flex items-center gap-1.5
                                       bg-black/10 border border-white/15
                                       backdrop-blur-sm px-2 py-1
                                       rounded-lg">
                                <span
                                    class="w-5 h-5 rounded-md bg-white/15 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="w-2.5 h-2.5 text-yellow-300">
                                        <path d="M13 2L4 14h6l-1 8 9-12h-6l1-8z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-[7px] text-white/60 uppercase tracking-wide">Deal Type</p>
                                    <p class="text-[9px] font-bold">Flash Sale</p>
                                </div>
                            </div>

                            {{-- Feature 2 --}}
                            <div
                                class="inline-flex items-center gap-1.5
                                       bg-black/10 border border-white/15
                                       backdrop-blur-sm px-2 py-1
                                       rounded-lg">
                                <span
                                    class="w-5 h-5 rounded-md bg-white/15 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="w-2.5 h-2.5 text-yellow-300">
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <polyline points="12 7 12 12 15 14"></polyline>
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-[7px] text-white/60 uppercase tracking-wide">Duration</p>
                                    <p class="text-[9px] font-bold">24 Hours</p>
                                </div>
                            </div>

                            {{-- Feature 3 --}}
                            <div
                                class="inline-flex items-center gap-1.5
                                       bg-black/10 border border-white/15
                                       backdrop-blur-sm px-2 py-1
                                       rounded-lg">
                                <span
                                    class="w-5 h-5 rounded-md bg-white/15 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="w-2.5 h-2.5 text-yellow-300">
                                        <path
                                            d="M20.59 13.41L11 3H4v7l10.59 10.59a2 2 0 0 0 2.82 0l3.18-3.18a2 2 0 0 0 0-2.82z">
                                        </path>
                                        <circle cx="7.5" cy="7.5" r="1"></circle>
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-[7px] text-white/60 uppercase tracking-wide">Offers</p>
                                    <p class="text-[9px] font-bold">Special Prices</p>
                                </div>
                            </div>

                        </div>

                    </div>


                    {{-- RIGHT COUNTDOWN --}}
                    <div class="lg:col-span-5 w-full">

                        <div class="relative max-w-md mx-auto lg:mx-0 lg:ml-auto">

                            {{-- Glow --}}
                            <div class="absolute inset-2 bg-white/20 blur-xl rounded-2xl"></div>

                            {{-- Card --}}
                            <div
                                class="relative bg-white rounded-xl
                                       p-3 sm:p-4 shadow-xl border border-white/50">

                                {{-- Header --}}
                                <div class="flex items-center justify-between mb-2">

                                    <div class="min-w-0">
                                        <div class="flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                                            <span class="text-[8px] font-bold text-red-600 uppercase tracking-widest">
                                                Hurry Up
                                            </span>
                                        </div>

                                        <h2 class="mt-0.5 text-sm md:text-base font-extrabold text-gray-900">
                                            Deal Ends Today
                                        </h2>
                                    </div>

                                    <div
                                        class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center flex-shrink-0">
                                        <span class="text-red-600 text-sm">⌛</span>
                                    </div>

                                </div>

                                {{-- Countdown --}}
                                @php
                                    $heroOfferEnd = now()->copy()->endOfDay();
                                    $heroOfferTimestamp = $heroOfferEnd->timestamp * 1000;
                                @endphp

                                <div id="hero-countdown" data-end="{{ $heroOfferTimestamp }}"
                                    class="grid grid-cols-3 gap-1.5">

                                    {{-- Hours --}}
                                    <div class="bg-gray-50 border border-gray-100 rounded-lg py-2 text-center">
                                        <div class="hero-hours text-lg md:text-xl font-black text-gray-900">00</div>
                                        <div class="mt-0.5 text-[7px] font-bold tracking-widest text-gray-400">
                                            HOURS
                                        </div>
                                    </div>

                                    {{-- Minutes --}}
                                    <div class="bg-gray-50 border border-gray-100 rounded-lg py-2 text-center">
                                        <div class="hero-minutes text-lg md:text-xl font-black text-gray-900">00</div>
                                        <div class="mt-0.5 text-[7px] font-bold tracking-widest text-gray-400">
                                            MINUTES
                                        </div>
                                    </div>

                                    {{-- Seconds --}}
                                    <div class="bg-red-50 border border-red-100 rounded-lg py-2 text-center">
                                        <div class="hero-seconds text-lg md:text-xl font-black text-red-600">00</div>
                                        <div class="mt-0.5 text-[7px] font-bold tracking-widest text-red-400">
                                            SECONDS
                                        </div>
                                    </div>

                                </div>

                                {{-- Progress --}}
                                <div class="mt-2">
                                    <div
                                        class="flex items-center justify-between text-[7px] font-semibold text-gray-400 mb-1">
                                        <span>Limited availability</span>
                                        <span class="text-red-600">Don't miss out</span>
                                    </div>

                                    <div class="h-1 bg-gray-100 rounded-full overflow-hidden">
                                        <div
                                            class="h-full w-[78%] bg-gradient-to-r from-red-500 to-orange-500 rounded-full">
                                        </div>
                                    </div>
                                </div>

                                {{-- Bottom Message --}}
                                <div class="mt-2 flex items-center gap-2 bg-gray-50 rounded-lg px-2.5 py-2">

                                    <div
                                        class="w-6 h-6 rounded-md bg-yellow-100 flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs">🔥</span>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-[9px] font-bold text-gray-800">
                                            Hot deals are waiting!
                                        </p>
                                        <p class="text-[7px] text-gray-400 mt-0.5">
                                            Shop now before the timer reaches zero.
                                        </p>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
            HERO COUNTDOWN SCRIPT
        ========================================================== --}}
        <script>
            function updateHeroCountdown() {
                const timer = document.getElementById('hero-countdown');
                if (!timer) return;

                const endTime = parseInt(timer.dataset.end);
                const now = new Date().getTime();
                const diff = endTime - now;

                const hoursEl = timer.querySelector('.hero-hours');
                const minutesEl = timer.querySelector('.hero-minutes');
                const secondsEl = timer.querySelector('.hero-seconds');

                if (!hoursEl || !minutesEl || !secondsEl) return;

                if (diff <= 0) {
                    hoursEl.textContent = '00';
                    minutesEl.textContent = '00';
                    secondsEl.textContent = '00';
                    return;
                }

                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                hoursEl.textContent = String(hours).padStart(2, '0');
                minutesEl.textContent = String(minutes).padStart(2, '0');
                secondsEl.textContent = String(seconds).padStart(2, '0');
            }

            document.addEventListener('DOMContentLoaded', function() {
                updateHeroCountdown();
                setInterval(updateHeroCountdown, 1000);
            });
        </script>


        {{-- =========================================================
            SUB CATEGORIES
        ========================================================== --}}
        @if ($category->children->count())

            <div class="bg-white border-b border-gray-100 mt-4 sm:mt-5 rounded-xl">

                <div class="w-full mx-auto px-3 sm:px-4 py-3 sm:py-4">

                    <div class="flex items-center gap-2 sm:gap-3 overflow-x-auto pb-1 scrollbar-hide">

                        {{-- All --}}
                        <a href="{{ route('limited-time') }}"
                            class="flex-shrink-0 px-3 sm:px-5 py-2 sm:py-2.5 rounded-full
                                   bg-red-600 text-white font-semibold text-xs sm:text-sm
                                   shadow-sm hover:bg-red-700 transition">
                            All Limited Deals
                        </a>

                        {{-- Children --}}
                        @foreach ($category->children as $child)
                            <a href="{{ route('category.show', ['slug' => $child->slug]) }}"
                                class="flex-shrink-0 px-3 sm:px-5 py-2 sm:py-2.5 rounded-full
                                       bg-gray-100 text-gray-700 font-medium text-xs sm:text-sm
                                       border border-gray-200
                                       hover:bg-red-50 hover:text-red-600
                                       hover:border-red-200 transition">
                                {{ $child->name }}
                            </a>
                        @endforeach

                    </div>

                </div>

            </div>

        @endif


        {{-- =========================================================
            MAIN CONTENT
        ========================================================== --}}
        <div class="w-full mx-auto py-6 sm:py-8 md:py-10">

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                <div class="flex flex-col lg:flex-row">

                    {{-- PRODUCTS AREA --}}
                    <main class="flex-1 min-w-0">

                        <div class="p-3 sm:p-4 lg:p-5">

                            {{-- PRODUCTS HEADER --}}
                            <div
                                class="flex flex-col sm:flex-row
                                       sm:items-center sm:justify-between
                                       gap-2 sm:gap-3 mb-4 sm:mb-5">

                                <div>
                                    <h2 class="text-base sm:text-lg md:text-xl font-bold text-gray-900">
                                        Limited Time Offers
                                    </h2>
                                    <p class="text-[10px] md:text-xs text-gray-400 mt-0.5">
                                        Special deals available for a limited time
                                    </p>
                                </div>

                                {{-- Product Count --}}
                                <div class="flex items-center gap-1.5 text-xs text-gray-500 self-start sm:self-auto">
                                    <span class="font-bold text-gray-800">{{ $products->total() }}</span>
                                    <span>Products</span>
                                </div>

                            </div>


                            {{-- PRODUCT GRID --}}
                            @if ($products->count())

                                <div
                                    class="grid grid-cols-2
                                           sm:grid-cols-2
                                           md:grid-cols-3
                                           lg:grid-cols-4
                                           xl:grid-cols-5
                                           gap-2.5 sm:gap-3 md:gap-4">

                                    @foreach ($products as $product)
                                        @php
                                            $thumb = !empty($product->thumbnails)
                                                ? asset('storage/' . $product->thumbnails[0])
                                                : null;

                                            $discountPercent =
                                                $product->discount_price && $product->price > 0
                                                    ? round((1 - $product->discount_price / $product->price) * 100)
                                                    : null;

                                            $offerEnd = now()->copy()->endOfDay();
                                            $offerEndTimestamp = $offerEnd->timestamp * 1000;
                                        @endphp


                                        {{-- PRODUCT CARD --}}
                                        <div
                                            class="group bg-white rounded-xl overflow-hidden
                                                   border border-gray-100 shadow-sm
                                                   hover:shadow-md transition-all duration-300
                                                   hover:-translate-y-0.5 flex flex-col">

                                            {{-- CLICKABLE CONTENT --}}
                                            <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                                class="block flex-1">

                                                {{-- IMAGE --}}
                                                <div class="relative overflow-hidden bg-gray-50 aspect-square">

                                                    @if ($thumb)
                                                        <img src="{{ $thumb }}" alt="{{ $product->name }}"
                                                            loading="lazy"
                                                            class="w-full h-full object-contain p-2
                                                                   group-hover:scale-105 transition-transform duration-500">
                                                    @else
                                                        <div
                                                            class="w-full h-full flex items-center justify-center
                                                                    text-gray-300 text-[10px]">
                                                            No image
                                                        </div>
                                                    @endif

                                                    {{-- Discount --}}
                                                    @if ($discountPercent)
                                                        <span
                                                            class="absolute top-1.5 sm:top-2 left-1.5 sm:left-2
                                                                   bg-red-600 text-white
                                                                   text-[7px] sm:text-[8px] font-bold
                                                                   px-1.5 py-0.5 rounded-full shadow">
                                                            -{{ $discountPercent }}%
                                                        </span>
                                                    @else
                                                        <span
                                                            class="absolute top-1.5 sm:top-2 left-1.5 sm:left-2
                                                                   bg-red-600 text-white
                                                                   text-[7px] sm:text-[8px] font-bold
                                                                   px-1.5 py-0.5 rounded-full shadow">
                                                            24H
                                                        </span>
                                                    @endif

                                                    {{-- Limited Badge --}}
                                                    <span
                                                        class="absolute bottom-1.5 sm:bottom-2 left-1.5 sm:left-2
                                                               bg-yellow-500 text-white
                                                               text-[6px] sm:text-[7px] font-bold
                                                               px-1.5 py-0.5 rounded-full shadow">
                                                        <i class="fa-solid fa-clock mr-0.5"></i>
                                                        Limited
                                                    </span>

                                                </div>


                                                {{-- PRODUCT INFO --}}
                                                <div class="p-2 sm:p-2.5">

                                                    {{-- Category --}}
                                                    @if ($product->category)
                                                        <p
                                                            class="text-[7px] sm:text-[8px] text-blue-600
                                                                  font-semibold uppercase tracking-wide
                                                                  mb-0.5 truncate">
                                                            {{ $product->category->name }}
                                                        </p>
                                                    @endif

                                                    {{-- Product Name --}}
                                                    <div
                                                        class="text-[10px] sm:text-[11px] md:text-xs
                                                               font-bold text-gray-800 leading-snug
                                                               line-clamp-2
                                                               group-hover:text-red-600 transition">
                                                        {{ $product->name }}
                                                    </div>

                                                    {{-- Rating --}}
                                                    <div class="flex items-center gap-1 mt-1.5">
                                                        <div class="flex text-yellow-400 text-[9px] sm:text-[10px]">
                                                            ★★★★★
                                                        </div>
                                                        <span class="text-gray-400 text-[9px] sm:text-[10px]">
                                                            (0)
                                                        </span>
                                                    </div>

                                                    {{-- Price --}}
                                                    <div class="flex items-center flex-wrap gap-1 sm:gap-1.5 mt-1.5">

                                                        @if ($product->discount_price)
                                                            <span
                                                                class="text-xs sm:text-sm font-extrabold text-gray-900">
                                                                Rs. {{ number_format($product->discount_price) }}
                                                            </span>
                                                            <span
                                                                class="text-[7px] sm:text-[8px] text-gray-400 line-through">
                                                                Rs. {{ number_format($product->price) }}
                                                            </span>
                                                        @else
                                                            <span
                                                                class="text-xs sm:text-sm font-extrabold text-gray-900">
                                                                Rs. {{ number_format($product->price) }}
                                                            </span>
                                                        @endif

                                                        @if ($product->stock > 0)
                                                            <span
                                                                class="inline-flex items-center gap-1
                                                                         text-[6px] sm:text-[7px]
                                                                         text-green-600 font-semibold
                                                                         bg-green-50 px-1.5 py-0.5 rounded-full">
                                                                <span class="w-1 h-1 bg-green-500 rounded-full"></span>
                                                                In Stock
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center gap-1
                                                                         text-[6px] sm:text-[7px]
                                                                         text-red-600 font-semibold
                                                                         bg-red-50 px-1.5 py-0.5 rounded-full">
                                                                <span class="w-1 h-1 bg-red-500 rounded-full"></span>
                                                                Out of Stock
                                                            </span>
                                                        @endif

                                                    </div>

                                                    {{-- SMALL COUNTDOWN --}}
                                                    <div class="mt-2">
                                                        <div id="countdown-{{ $product->id }}"
                                                            data-end="{{ $offerEndTimestamp }}"
                                                            class="flex items-center justify-between
                                                                   bg-red-50 border border-red-100
                                                                   rounded-md px-1.5 py-1">

                                                            <div class="flex items-center gap-0.5">
                                                                <span
                                                                    class="hours text-[9px] sm:text-[10px] font-bold text-red-600">00</span>
                                                                <span
                                                                    class="text-[9px] sm:text-[10px] text-gray-400">H</span>
                                                            </div>

                                                            <span
                                                                class="text-[9px] sm:text-[10px] text-red-300">:</span>

                                                            <div class="flex items-center gap-0.5">
                                                                <span
                                                                    class="minutes text-[9px] sm:text-[10px] font-bold text-red-600">00</span>
                                                                <span
                                                                    class="text-[9px] sm:text-[10px] text-gray-400">M</span>
                                                            </div>

                                                            <span
                                                                class="text-[9px] sm:text-[10px] text-red-300">:</span>

                                                            <div class="flex items-center gap-0.5">
                                                                <span
                                                                    class="seconds text-[9px] sm:text-[10px] font-bold text-red-600">00</span>
                                                                <span
                                                                    class="text-[9px] sm:text-[10px] text-gray-400">S</span>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>

                                            </a>


                                            {{-- ACTION BUTTONS --}}
                                            <div class="px-2 sm:px-2.5 pb-2 sm:pb-2.5">

                                                <div class="flex items-center gap-1 sm:gap-1.5">

                                                    {{-- Wishlist --}}
                                                    <button type="button"
                                                        onclick="event.stopPropagation(); toggleWishlist(this, {{ $product->id }})"
                                                        aria-label="Add to wishlist"
                                                        class="wishlist-btn
                                                               w-7 h-7 sm:w-8 sm:h-8 flex-shrink-0
                                                               bg-gray-50 border border-gray-200
                                                               rounded-lg flex items-center justify-center
                                                               text-gray-500
                                                               hover:bg-red-50 hover:text-red-600 hover:border-red-200
                                                               transition-all duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" stroke-width="1.8"
                                                            class="w-3.5 h-3.5 sm:w-4 sm:h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z" />
                                                        </svg>
                                                    </button>

                                                    {{-- Add to Cart --}}
                                                    @if ($product->stock > 0)
                                                        <button type="button"
                                                            onclick="event.stopPropagation(); addToCart({{ $product->id }})"
                                                            class="flex-1 h-7 sm:h-8 bg-red-600 text-white
                                                                   text-[8px] sm:text-[9px] font-semibold
                                                                   rounded-lg hover:bg-red-700 transition
                                                                   flex items-center justify-center gap-1">
                                                            <i
                                                                class="fa-solid fa-cart-plus text-[8px] sm:text-[9px]"></i>
                                                            Add to Cart
                                                        </button>
                                                    @else
                                                        <button type="button" disabled
                                                            class="flex-1 h-7 sm:h-8 bg-gray-200 text-gray-400
                                                                   text-[8px] sm:text-[9px] font-semibold
                                                                   rounded-lg cursor-not-allowed
                                                                   flex items-center justify-center">
                                                            Out of Stock
                                                        </button>
                                                    @endif

                                                </div>

                                            </div>

                                        </div>
                                    @endforeach

                                </div>


                                {{-- PAGINATION --}}
                                @if ($products->hasPages())
                                    <div class="mt-5 sm:mt-6 pt-4 sm:pt-5 border-t border-gray-100 overflow-x-auto">
                                        {{ $products->links() }}
                                    </div>
                                @endif
                            @else
                                {{-- EMPTY STATE --}}
                                <div class="py-12 sm:py-16 text-center">

                                    <div
                                        class="w-14 h-14 sm:w-16 sm:h-16 mx-auto
                                                rounded-full bg-red-50
                                                flex items-center justify-center mb-4">
                                        <i class="fa-solid fa-clock text-xl sm:text-2xl text-red-500"></i>
                                    </div>

                                    <h3 class="text-base sm:text-lg font-bold text-gray-800">
                                        No Limited-Time Deals
                                    </h3>

                                    <p
                                        class="text-[11px] sm:text-xs text-gray-400 mt-2
                                              max-w-md mx-auto px-4">
                                        There are no flash deals available in this category right now.
                                        Please check back soon for new offers.
                                    </p>

                                    <a href="{{ route('limited-time') }}"
                                        class="inline-flex items-center gap-2 mt-5
                                               px-4 py-2 bg-red-600 text-white
                                               text-[11px] sm:text-xs font-semibold
                                               rounded-lg hover:bg-red-700 transition">
                                        <i class="fa-solid fa-bolt"></i>
                                        Browse All Deals
                                    </a>

                                </div>

                            @endif

                        </div>

                    </main>

                </div>

            </div>

        </div>


        {{-- =========================================================
            ABOUT SECTION
        ========================================================== --}}
        @if (!empty($category->description))
            <section class="mt-4 sm:mt-6">

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 sm:p-6 md:p-8">

                    <div class="flex items-center gap-3 mb-4">

                        <div
                            class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-blue-50
                                    flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                            </svg>
                        </div>

                        <h2 class="text-sm sm:text-base md:text-lg font-bold text-slate-900">
                            About {{ $category->name }}
                        </h2>

                    </div>

                    <div
                        class="text-xs sm:text-sm leading-6 sm:leading-7
                                text-slate-600 prose prose-sm max-w-none">
                        {!! nl2br(e($category->description)) !!}
                    </div>

                </div>

            </section>
        @endif

    </div>


    {{-- =============================================================
        COUNTDOWN SCRIPT
    ============================================================== --}}
    <script>
        function updateProductCountdowns() {
            document.querySelectorAll('[data-end]').forEach(function(timer) {
                const endTime = parseInt(timer.dataset.end);
                const now = new Date().getTime();
                let diff = endTime - now;

                const hoursEl = timer.querySelector('.hours');
                const minutesEl = timer.querySelector('.minutes');
                const secondsEl = timer.querySelector('.seconds');

                if (!hoursEl || !minutesEl || !secondsEl) return;

                if (diff <= 0) {
                    hoursEl.textContent = '00';
                    minutesEl.textContent = '00';
                    secondsEl.textContent = '00';
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


        async function toggleWishlist(btn, productId) {
            try {
                const response = await fetch("{{ route('user.wishlist.toggle') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || "Something went wrong.");
                }

                const icon = btn.querySelector("svg");

                if (data.wishlisted) {
                    btn.classList.remove("text-gray-500", "bg-gray-50", "border-gray-200");
                    btn.classList.add("text-red-500", "bg-red-50", "border-red-200");
                    if (icon) {
                        icon.setAttribute("fill", "currentColor");
                        icon.setAttribute("stroke", "currentColor");
                    }
                } else {
                    btn.classList.remove("text-red-500", "bg-red-50", "border-red-200");
                    btn.classList.add("text-gray-500", "bg-gray-50", "border-gray-200");
                    if (icon) {
                        icon.setAttribute("fill", "none");
                        icon.setAttribute("stroke", "currentColor");
                    }
                }

                console.log(data.message);

            } catch (error) {
                console.error("Wishlist Error:", error);
                alert("Please login first to use wishlist.");
            }
        }


        async function addToCart(productId) {
            try {
                const response = await fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        quantity: 1
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Unable to add product to cart.');
                }

                if (data.success) {
                    alert(data.message || 'Product added to cart!');

                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount && data.cart_count !== undefined) {
                        cartCount.textContent = data.cart_count;
                    }
                }

            } catch (error) {
                console.error('Cart Error:', error);
                alert(error.message || 'Something went wrong while adding to cart.');
            }
        }
    </script>


    {{-- =============================================================
        UTILITY STYLES
    ============================================================== --}}
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

</x-frontend-layout>
