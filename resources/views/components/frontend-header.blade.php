<header class="sticky top-0 z-50">

    {{-- =========================================================
        TOP BAR
    ========================================================== --}}
    <div class="bg-[#0959e8] border-b border-white/10">
        <div class="Container mx-auto flex justify-between items-center py-1 px-2 gap-2">

            {{-- LEFT --}}
            <div class="flex items-center min-w-0">
                <span class="text-[#dbeafe] text-[10px] sm:text-[12px] truncate">
                    📍 Kathmandu, Nepal
                </span>
                <span class="hidden md:inline text-[#dbeafe] text-[12px] ml-6 lg:ml-8 truncate">
                    🚛 Free Delivery On All Orders Above Rs. 10000
                </span>
            </div>

            {{-- RIGHT --}}
            <div class="flex items-center gap-2 sm:gap-4 lg:gap-5 flex-shrink-0">
                <a href="{{ route('user.orders') }}"
                    class="text-[#dbeafe] text-[10px] sm:text-[12px] hover:text-white transition whitespace-nowrap">
                    Track Order
                </a>
                <span class="h-4 w-px bg-white/40"></span>
                <a href="#" class="text-[#dbeafe] text-[10px] sm:text-[12px] hover:text-white transition">
                    Help
                </a>
                <span class="hidden sm:block h-4 w-px bg-white/40"></span>
                <a href="#" class="hidden sm:inline text-[#dbeafe] text-[12px] hover:text-white transition">
                    English
                </a>
            </div>

        </div>
    </div>


    {{-- =========================================================
        MAIN HEADER
    ========================================================== --}}
    <div class="bg-[#fefefe] shadow-sm border-b border-gray-100">
        <div class="Container mx-auto flex items-center justify-between px-3 sm:px-4 py-2 gap-2 sm:gap-3">

            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="flex-shrink-0">
                <img src="{{ asset('image/logo.png') }}" alt="Logo"
                    class="w-auto h-8 sm:h-10 lg:h-11 drop-shadow-sm">
            </a>

            {{-- SEARCH — desktop only (≥1024px), tablet uses drawer search --}}
            <form action="{{ route('search') }}" method="GET"
                class="hidden lg:flex flex-1 max-w-xl mx-4 lg:mx-8 relative">
                <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}"
                    class="w-full h-9 rounded-full outline-none
                           pl-5 pr-14 text-sm
                           border-2 border-gray-200 bg-white
                           focus:border-[#2563EB]
                           transition-all duration-300
                           shadow-inner text-[#111827]">
                <button type="submit"
                    class="absolute right-1 top-1/2 -translate-y-1/2
                           w-8 h-8 rounded-full
                           bg-gradient-to-r from-[#2563EB] to-[#1D4ED8]
                           flex items-center justify-center
                           hover:scale-105
                           hover:shadow-[0_0_15px_rgba(37,99,235,0.4)]
                           transition-all duration-200 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M21 21l-5.2-5.2m2.2-5.3a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>

            {{-- RIGHT SIDE --}}
            <div class="flex items-center gap-1.5 sm:gap-3 lg:gap-5">

                {{-- COINS --}}
                @auth
                    <a href="{{ route('user.dashboard') }}" class="relative group cursor-pointer hidden sm:block">
                        <div
                            class="bg-[#0959e8] hover:bg-[#074dcc] transition-all duration-300
                                    rounded-full px-2 sm:px-3 py-1 flex items-center gap-1 sm:gap-2 shadow-md">
                            <span class="text-white font-bold text-[11px] sm:text-sm">
                                {{ number_format(auth()->user()->reward_points ?? 0) }}
                            </span>
                            <span
                                class="w-5 h-4 sm:w-6 sm:h-4 rounded-full
                                         bg-gradient-to-br from-[#F59E0B] to-[#D97706]
                                         flex items-center justify-center text-[10px] sm:text-xs shadow-md">
                                💰
                            </span>
                        </div>
                        <div
                            class="absolute -bottom-10 left-1/2 -translate-x-1/2 opacity-0
                                    group-hover:opacity-100 transition-opacity pointer-events-none">
                            <span
                                class="text-[10px] bg-[#111827] text-white px-2 py-1
                                         rounded whitespace-nowrap">
                                Your balance
                            </span>
                        </div>
                    </a>
                @endauth

                {{-- CART --}}
                <a href="{{ route('user.cart') }}" class="relative group">
                    <div
                        class="bg-[#0959e8] hover:bg-[#074dcc] transition-all duration-300
                                rounded-full p-2 sm:p-2.5 shadow-md group-hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2 M7 13h10l4-8H5.4 M7 13L5.4 5
                                   M7 13l-2.293 2.293 c-.63.63-.184 1.707.707 1.707H17
                                   m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2
                                   a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>

                        @auth
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                            @endphp
                            @if ($cartCount > 0)
                                <span
                                    class="absolute -top-1 -right-1 bg-red-500 text-white
                                             text-[10px] font-bold w-4 h-4 sm:w-5 sm:h-5
                                             rounded-full flex items-center justify-center shadow-md">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        @endauth
                    </div>
                    <span
                        class="absolute -bottom-7 left-1/2 -translate-x-1/2 opacity-0
                                 group-hover:opacity-100 transition-opacity text-[10px]
                                 bg-[#111827] text-white px-2 py-1 rounded whitespace-nowrap
                                 pointer-events-none">
                        Cart
                    </span>
                </a>

                {{-- WISHLIST --}}
                <a href="{{ route('user.wishlist') }}" class="relative group">
                    <div
                        class="bg-[#0959e8] hover:bg-[#074dcc] transition-all duration-300
                                rounded-full p-2 sm:p-2.5 shadow-md group-hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white
                                   group-hover:text-[#F59E0B] transition-colors duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318 a4.5 4.5 0 016.364 0L12 7.636
                                   l1.318-1.318 a4.5 4.5 0 116.364 6.364L12 20.364
                                   4.318 12.682 a4.5 4.5 0 010-6.364z" />
                        </svg>
                    </div>
                    <span
                        class="absolute -bottom-7 left-1/2 -translate-x-1/2 opacity-0
                                 group-hover:opacity-100 transition-opacity text-[10px]
                                 bg-[#111827] text-white px-2 py-1 rounded whitespace-nowrap
                                 pointer-events-none">
                        Wishlist
                    </span>
                </a>

                {{-- ACCOUNT (Logged In) — Desktop only (≥1024px) --}}
                @auth
                    <div class="relative group hidden lg:block">
                        <a href="{{ route('user.dashboard') }}"
                            class="flex items-center gap-1.5 sm:gap-2
                                   bg-[#0959e8] hover:bg-[#074dcc]
                                   transition-all duration-300 rounded-full
                                   pl-1 pr-1.5 sm:pr-3 py-1 shadow-md group-hover:scale-105">
                            <div
                                class="w-7 h-7 sm:w-8 sm:h-8 rounded-full overflow-hidden
                                        bg-gradient-to-br from-[#F59E0B] to-[#D97706]
                                        flex items-center justify-center text-white font-bold shadow-inner">
                                @if (!empty(auth()->user()->image))
                                    <img src="{{ auth()->user()->image }}" alt="{{ auth()->user()->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M15 7a3 3 0 11-6 0 3 3 0 016 0z M4.5 20a7.5 7.5 0 0115 0" />
                                    </svg>
                                @endif
                            </div>
                            <span
                                class="text-white text-xs sm:text-sm font-medium
                                         hidden lg:inline max-w-[70px] truncate">
                                {{ auth()->user()->name }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-3 h-3 text-white/80 hidden lg:block
                                       transition-transform duration-300 group-hover:rotate-180"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>

                        {{-- Dropdown --}}
                        <div
                            class="absolute right-0 top-full mt-2 w-60 bg-white rounded-xl
                                    shadow-2xl border border-gray-100
                                    opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                    transition-all duration-200 z-[9999]
                                    transform translate-y-1 group-hover:translate-y-0">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full overflow-hidden
                                                bg-gradient-to-br from-[#F59E0B] to-[#D97706]
                                                flex items-center justify-center text-white shrink-0">
                                        @if (!empty(auth()->user()->image))
                                            <img src="{{ auth()->user()->image }}" alt="{{ auth()->user()->name }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M15 7a3 3 0 11-6 0 3 3 0 016 0z
                                                               M4.5 20a7.5 7.5 0 0115 0" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-[#111827] truncate">
                                            {{ auth()->user()->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">
                                            {{ auth()->user()->email }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('user.dashboard') }}"
                                class="flex items-center gap-3 px-4 py-2.5 hover:bg-blue-50
                                       hover:text-[#2563EB] transition-colors text-sm text-[#111827]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 12l9-9 9 9 M5 10v10h14V10 M9 20v-6h6v6" />
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('user.orders') }}"
                                class="flex items-center gap-3 px-4 py-2.5 hover:bg-blue-50
                                       hover:text-[#2563EB] transition-colors text-sm text-[#111827]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2 M7 13h10l4-8H5.4 M7 13L5.4 5
                                                   M7 13l-2.293 2.293 c-.63.63-.184 1.707.707 1.707H17
                                                   m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2
                                                   a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                My Orders
                            </a>
                            <a href="{{ route('user.wishlist') }}"
                                class="flex items-center gap-3 px-4 py-2.5 hover:bg-blue-50
                                       hover:text-[#2563EB] transition-colors text-sm text-[#111827]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318 a4.5 4.5 0 016.364 0L12 7.636
                                                   l1.318-1.318 a4.5 4.5 0 116.364 6.364L12 20.364
                                                   4.318 12.682 a4.5 4.5 0 010-6.364z" />
                                </svg>
                                Wishlist
                            </a>
                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2.5
                                               hover:bg-red-50 hover:text-red-600 transition-colors
                                               text-sm text-[#111827] text-left">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4 m4 4H7
                                                           m6 4v1a3 3 0 01-3 3H6
                                                           a3 3 0 01-3-3V7 a3 3 0 013-3h4
                                                           a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- GUEST — Desktop only (≥1024px) --}}
                    <a href="{{ route('login') }}"
                        class="hidden lg:flex items-center gap-1.5 sm:gap-2
                               bg-[#0959e8] hover:bg-[#074dcc]
                               transition-all duration-300 rounded-full
                               pl-1 pr-1.5 sm:pr-3 py-1 shadow-md hover:scale-105">
                        <div
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-full
                                    bg-gradient-to-br from-[#F59E0B] to-[#D97706]
                                    flex items-center justify-center text-white shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M15 7a3 3 0 11-6 0 3 3 0 016 0z M4.5 20a7.5 7.5 0 0115 0" />
                            </svg>
                        </div>
                        <span class="text-white text-xs sm:text-sm font-medium hidden lg:inline">
                            Account
                        </span>
                    </a>
                @endauth


                {{-- 🍔 HAMBURGER (Drawer Toggle) — mobile + tablet only (<1024px) --}}
                <button type="button" onclick="openDrawer()" aria-label="Open menu"
                    class="flex lg:hidden flex-col justify-center items-center gap-[5px]
                           w-9 h-9 rounded-lg
                           text-[#1e293b] hover:text-orange-500
                           hover:bg-orange-50
                           transition-all duration-200 flex-shrink-0">
                    <span class="block w-5 sm:w-6 h-[2.5px] bg-current rounded-full"></span>
                    <span class="block w-5 sm:w-6 h-[2.5px] bg-current rounded-full"></span>
                    <span class="block w-5 sm:w-6 h-[2.5px] bg-current rounded-full"></span>
                </button>

            </div>

        </div>
    </div>


    {{-- =========================================================
        CATEGORY NAVIGATION (Desktop only ≥1024px — mobile/tablet ma drawer ma)
    ========================================================== --}}
    @php
        $parentCategories = \App\Models\Category::whereNull('parent_id')
            ->where('status', true)
            ->with([
                'children' => function ($query) {
                    $query->where('status', true)->orderBy('name');
                },
            ])
            ->orderBy('name')
            ->get();
    @endphp

    <div class="bg-[#f3f8fe] shadow-md shadow-inner hidden lg:block">
        <div class="Container mx-auto px-2">
            <ul
                class="flex items-center gap-1 sm:gap-2 lg:gap-3
                       overflow-x-auto whitespace-nowrap scrollbar-hide
                       text-[11px] sm:text-[12px] font-semibold text-[#111827]">
                @foreach ($parentCategories as $parent)
                    <li class="relative group flex-shrink-0">
                        <a href="{{ $parent->slug === 'today-deals' ? route('today-deals') : route('category.show', ['slug' => $parent->slug]) }}"
                            class="flex items-center gap-1 hover:text-[#2563EB]
                                   py-2.5 sm:py-3 px-2 sm:px-3
                                   rounded-lg hover:bg-white/50
                                   transition-all duration-200 whitespace-nowrap">
                            {{ $parent->name }}
                            @if ($parent->children->count())
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3 h-3 sm:w-3.5 sm:h-3.5
                                           transition-transform duration-300 group-hover:rotate-180"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            @endif
                        </a>

                        @if ($parent->children->count())
                            <div
                                class="absolute left-0 top-full hidden group-hover:block
                                        w-60 sm:w-72 bg-white rounded-xl shadow-2xl
                                        border border-gray-100 z-[9999] overflow-hidden">
                                <div class="px-4 sm:px-5 py-3 bg-gray-50 border-b">
                                    <a href="{{ $parent->slug === 'today-deals' ? route('today-deals') : route('category.show', ['slug' => $parent->slug]) }}"
                                        class="flex items-center justify-between font-semibold
                                               text-gray-800 hover:text-blue-600 gap-1">
                                        <span>All {{ $parent->name }}</span>
                                        <span>→</span>
                                    </a>
                                </div>
                                <ul class="py-2">
                                    @foreach ($parent->children as $child)
                                        <li>
                                            <a href="{{ route('category.show', ['slug' => $child->slug]) }}"
                                                class="flex items-center justify-between
                                                       px-4 py-1 text-[12px] text-gray-700
                                                       hover:bg-blue-50 hover:text-blue-600 transition">
                                                <span>{{ $child->name }}</span>
                                                <span class="text-gray-400">→</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

</header>


{{-- =========================================================
     🎯 MOBILE + TABLET DRAWER (Left Side)
========================================================== --}}

{{-- OVERLAY — shows below lg (1024px) --}}
<div id="drawerOverlay" onclick="closeDrawer()"
    class="fixed inset-0 bg-black/50 z-[9998]
           opacity-0 invisible
           transition-opacity duration-300
           lg:hidden">
</div>


{{-- DRAWER PANEL — shows below lg (1024px) --}}
<aside id="mobileDrawer"
    class="fixed top-0 left-0 h-full w-[85%] max-w-[340px]
           bg-white z-[9999]
           -translate-x-full
           transition-transform duration-300 ease-out
           lg:hidden
           flex flex-col shadow-2xl">

    {{-- ===== DRAWER HEADER ===== --}}
    <div class="flex items-center justify-between px-4 py-3
                bg-[#0959e8] text-white flex-shrink-0">

        <a href="{{ route('home') }}" class="flex-shrink-0">
            <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-auto h-9 brightness-0 invert">
        </a>

        <button type="button" onclick="closeDrawer()" aria-label="Close menu"
            class="w-9 h-9 flex items-center justify-center
                   rounded-full hover:bg-white/20 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>


    {{-- ===== DRAWER BODY (Scrollable) ===== --}}
    <div class="flex-1 overflow-y-auto">

        {{-- USER INFO (Logged In) --}}
        @auth
            <div class="px-4 py-4 bg-gradient-to-r from-[#0959e8] to-[#074dcc] text-white">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-full overflow-hidden
                                bg-gradient-to-br from-[#F59E0B] to-[#D97706]
                                flex items-center justify-center text-white shrink-0
                                ring-2 ring-white/40">
                        @if (!empty(auth()->user()->image))
                            <img src="{{ auth()->user()->image }}" alt="{{ auth()->user()->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M15 7a3 3 0 11-6 0 3 3 0 016 0z M4.5 20a7.5 7.5 0 0115 0" />
                            </svg>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-white/70 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                {{-- Coins --}}
                <a href="{{ route('user.dashboard') }}"
                    class="mt-3 inline-flex items-center gap-2
                           bg-white/15 hover:bg-white/25
                           rounded-full px-3 py-1 transition">
                    <span class="text-white font-bold text-sm">
                        {{ number_format(auth()->user()->reward_points ?? 0) }}
                    </span>
                    <span
                        class="w-5 h-4 rounded-full
                                 bg-gradient-to-br from-[#F59E0B] to-[#D97706]
                                 flex items-center justify-center text-[10px]">
                        💰
                    </span>
                    <span class="text-[10px] text-white/70">Your balance</span>
                </a>
            </div>
        @else
            {{-- Guest --}}
            <div class="px-4 py-4 bg-gradient-to-r from-[#0959e8] to-[#074dcc] text-white">
                <p class="text-sm font-semibold mb-2">Welcome!</p>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2
                           bg-white text-[#0959e8]
                           text-sm font-semibold
                           px-4 py-1.5 rounded-full
                           hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a3 3 0 11-6 0 3 3 0 016 0z M4.5 20a7.5 7.5 0 0115 0" />
                    </svg>
                    Login / Signup
                </a>
            </div>
        @endauth


        {{-- ===== SEARCH (Mobile + Tablet) ===== --}}
        <div class="px-4 py-3 border-b border-gray-100">
            <form action="{{ route('search') }}" method="GET" class="relative">
                <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}"
                    class="w-full h-10 rounded-full outline-none
                           pl-4 pr-12 text-sm
                           border-2 border-gray-200 bg-white
                           focus:border-[#2563EB]
                           transition-all duration-300 text-[#111827]">
                <button type="submit"
                    class="absolute right-1 top-1/2 -translate-y-1/2
                           w-8 h-8 rounded-full
                           bg-gradient-to-r from-[#2563EB] to-[#1D4ED8]
                           flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M21 21l-5.2-5.2m2.2-5.3a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>


        {{-- ===== QUICK LINKS ===== --}}
        <div class="px-4 py-3 border-b border-gray-100">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                Quick Links
            </p>
            <div class="grid grid-cols-3 gap-2">

                <a href="{{ route('user.orders') }}"
                    class="flex flex-col items-center justify-center gap-1
                           py-3 rounded-lg bg-blue-50 hover:bg-blue-100
                           text-[#0959e8] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2 M7 13h10l4-8H5.4 M7 13L5.4 5
                               M7 13l-2.293 2.293 c-.63.63-.184 1.707.707 1.707H17
                               m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2
                               a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="text-[11px] font-semibold">Orders</span>
                </a>

                <a href="{{ route('user.cart') }}"
                    class="flex flex-col items-center justify-center gap-1
                           py-3 rounded-lg bg-blue-50 hover:bg-blue-100
                           text-[#0959e8] transition relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2 M7 13h10l4-8H5.4 M7 13L5.4 5
                               M7 13l-2.293 2.293 c-.63.63-.184 1.707.707 1.707H17
                               m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2
                               a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="text-[11px] font-semibold">Cart</span>
                    @auth
                        @php
                            $cartCountDrawer = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                        @endphp
                        @if ($cartCountDrawer > 0)
                            <span
                                class="absolute top-1 right-3 bg-red-500 text-white
                                         text-[9px] font-bold w-4 h-4
                                         rounded-full flex items-center justify-center">
                                {{ $cartCountDrawer }}
                            </span>
                        @endif
                    @endauth
                </a>

                <a href="{{ route('user.wishlist') }}"
                    class="flex flex-col items-center justify-center gap-1
                           py-3 rounded-lg bg-blue-50 hover:bg-blue-100
                           text-[#0959e8] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318 a4.5 4.5 0 016.364 0L12 7.636
                               l1.318-1.318 a4.5 4.5 0 116.364 6.364L12 20.364
                               4.318 12.682 a4.5 4.5 0 010-6.364z" />
                    </svg>
                    <span class="text-[11px] font-semibold">Wishlist</span>
                </a>

            </div>
        </div>


        {{-- ===== CATEGORIES ===== --}}
        <div class="px-4 py-3">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                Categories
            </p>

            <ul class="space-y-1">
                @foreach ($parentCategories as $parent)
                    <li>
                        @if ($parent->children->count())
                            <details class="group">
                                <summary
                                    class="flex items-center justify-between
                                           px-3 py-2.5 rounded-lg
                                           hover:bg-gray-50 cursor-pointer
                                           list-none transition">
                                    <span class="text-sm font-semibold text-[#111827]">
                                        {{ $parent->name }}
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-3.5 h-3.5 text-gray-400
                                               transition-transform duration-300
                                               group-open:rotate-180"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>

                                <ul class="mt-1 ml-3 pl-3 border-l-2 border-blue-100 space-y-0.5">
                                    <li>
                                        <a href="{{ $parent->slug === 'today-deals' ? route('today-deals') : route('category.show', ['slug' => $parent->slug]) }}"
                                            class="block px-3 py-1.5 text-[12px] font-semibold
                                                   text-[#0959e8] hover:bg-blue-50
                                                   rounded-md transition">
                                            All {{ $parent->name }} →
                                        </a>
                                    </li>
                                    @foreach ($parent->children as $child)
                                        <li>
                                            <a href="{{ route('category.show', ['slug' => $child->slug]) }}"
                                                class="block px-3 py-1.5 text-[12px]
                                                       text-gray-600 hover:bg-blue-50
                                                       hover:text-blue-600 rounded-md transition">
                                                {{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </details>
                        @else
                            {{-- Single link --}}
                            <a href="{{ $parent->slug === 'today-deals' ? route('today-deals') : route('category.show', ['slug' => $parent->slug]) }}"
                                class="flex items-center justify-between
                                       px-3 py-2.5 rounded-lg
                                       hover:bg-gray-50 transition">
                                <span class="text-sm font-semibold text-[#111827]">
                                    {{ $parent->name }}
                                </span>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>


        {{-- ===== SUPPORT ===== --}}
        <div class="px-4 pb-4">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                Support
            </p>
            <div class="space-y-1">
                <a href="{{ route('user.orders') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg
                           hover:bg-gray-50 transition text-sm text-[#111827]">
                    <span>📦</span> Track Order
                </a>
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg
                           hover:bg-gray-50 transition text-sm text-[#111827]">
                    <span>❓</span> Help
                </a>
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg
                           hover:bg-gray-50 transition text-sm text-[#111827]">
                    <span>🌐</span> English
                </a>

                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg
                                   hover:bg-red-50 hover:text-red-600 transition
                                   text-sm text-[#111827] text-left">
                            <span>🚪</span> Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>

    </div>

</aside>



<script>
    function openDrawer() {
        const drawer = document.getElementById('mobileDrawer');
        const overlay = document.getElementById('drawerOverlay');
        drawer.classList.remove('-translate-x-full');
        overlay.classList.remove('opacity-0', 'invisible');
        document.body.style.overflow = 'hidden'; // background scroll lock
    }

    function closeDrawer() {
        const drawer = document.getElementById('mobileDrawer');
        const overlay = document.getElementById('drawerOverlay');
        drawer.classList.add('-translate-x-full');
        overlay.classList.add('opacity-0', 'invisible');
        document.body.style.overflow = ''; // unlock scroll
    }


    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDrawer();
    });
</script>
