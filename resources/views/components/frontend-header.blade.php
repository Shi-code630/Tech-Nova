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


                {{-- =====================================================
                SEARCH
            ====================================================== --}}
                <div class="hidden md:flex flex-1 max-w-2xl">

                    <form action="{{ route('search') }}" method="GET" class="w-full">

                        <div class="relative">

                            <input type="search" name="search" value="{{ request('search') }}"
                                placeholder="Search products..." autocomplete="off"
                                class="w-full h-10
                       pl-5 pr-12
                       rounded-full
                       border border-gray-200
                       bg-gray-50
                       text-sm text-gray-800
                       placeholder:text-gray-400
                       focus:outline-none
                       focus:bg-white
                       focus:border-[#0959e8]
                       focus:ring-2 focus:ring-blue-100
                       transition">

                            <button type="submit"
                                class="absolute right-1 top-1
                       w-8 h-8
                       rounded-full
                       bg-[#0959e8]
                       text-white
                       flex items-center justify-center
                       hover:bg-blue-700
                       transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35
                           m2.35-5.65
                           a8 8 0 1 1-16 0
                           8 8 0 0 1 16 0Z" />
                                </svg>
                            </button>

                        </div>

                    </form>

                </div>


                {{-- =====================================================
                HEADER ACTIONS
            ====================================================== --}}
                <div class="flex items-center gap-5">


                    {{-- =================================================
                    CART
                ================================================== --}}
                    <a href="{{ route('user.cart') }}"
                        class="relative flex items-center justify-center
                           w-10 h-10
                           text-gray-700
                           hover:text-[#0959e8]
                           transition"
                        title="Shopping Cart">

                        {{-- CART SVG --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.5 3h2l2.4 11.2a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 1.9-1.4L21 7H6" />

                            <circle cx="9" cy="20" r="1.3" fill="currentColor" stroke="none" />

                            <circle cx="18" cy="20" r="1.3" fill="currentColor" stroke="none" />
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

                    </a>


                    {{-- =================================================
                    WISHLIST
                ================================================== --}}
                    @auth

                        <a href="{{ route('user.wishlist') }}"
                            class="relative flex items-center justify-center
                               w-10 h-10
                               text-gray-700
                               hover:text-red-500
                               transition"
                            title="Wishlist">

                            {{-- HEART SVG --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.8 8.8
                                                       c0 5.5-8.8 10.2-8.8 10.2
                                                       S3.2 14.3 3.2 8.8
                                                       A4.8 4.8 0 0 1 12 6
                                                       a4.8 4.8 0 0 1 8.8 2.8Z" />
                            </svg>

                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="flex items-center justify-center
                               w-10 h-10
                               text-gray-700
                               hover:text-red-500
                               transition"
                            title="Wishlist">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.8 8.8
                                                       c0 5.5-8.8 10.2-8.8 10.2
                                                       S3.2 14.3 3.2 8.8
                                                       A4.8 4.8 0 0 1 12 6
                                                       a4.8 4.8 0 0 1 8.8 2.8Z" />
                            </svg>

                        </a>

                    @endauth


                    {{-- =================================================
                    ACCOUNT
                        ================================================== --}}
                    @auth

                        <a href="{{ route('user.dashboard') }}"
                            class="hidden sm:flex items-center gap-2
                                px-2 py-0.5
                                rounded-lg
                                border border-gray-200
                                bg-white
                                hover:border-[#0959e8]
                                hover:bg-blue-50/40
                                transition-all duration-200">

                            @if (auth()->user()->image)
                                @php
                                    $userImage = auth()->user()->image;

                                    if (
                                        str_starts_with($userImage, 'http://') ||
                                        str_starts_with($userImage, 'https://')
                                    ) {
                                        $userImageUrl = $userImage;
                                    } else {
                                        $userImageUrl = asset('storage/' . ltrim($userImage, '/'));
                                    }
                                @endphp

                                <img src="{{ $userImageUrl }}" alt="{{ auth()->user()->name }}"
                                    class="w-9 h-9 rounded-full object-cover
                       border border-gray-200"
                                    onerror="
                    this.onerror=null;
                    this.src='{{ asset('image/default-user.png') }}';
                ">
                            @else
                                {{-- DEFAULT USER ICON --}}
                                <div
                                    class="w-9 h-9 rounded-full
                       bg-blue-50
                       text-[#0959e8]
                       flex items-center justify-center
                       border border-blue-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5
                                           a3.75 3.75 0 1 1-7.5 0
                                           3.75 3.75 0 0 1 7.5 0ZM4.5 21
                                           a7.5 7.5 0 0 1 15 0" />
                                    </svg>
                                </div>
                            @endif


                            <div class="hidden lg:block pr-1">

                                <p class="text-[10px] text-gray-500 leading-none">
                                    Account
                                </p>

                                <p
                                    class="text-sm font-semibold
                       text-gray-800
                       max-w-[100px]
                       truncate
                       mt-1">
                                    {{ auth()->user()->name }}
                                </p>

                            </div>

                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="hidden sm:flex items-center gap-2
               px-2 py-1.5
               rounded-lg
               border border-gray-200
               bg-white
               text-gray-700
               hover:border-[#0959e8]
               hover:bg-blue-50/40
               hover:text-[#0959e8]
               transition-all duration-200">

                            <div
                                class="w-9 h-9 rounded-full
                   bg-gray-50
                   flex items-center justify-center
                   border border-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5
                                       a3.75 3.75 0 1 1-7.5 0
                                       3.75 3.75 0 0 1 7.5 0ZM4.5 21
                                       a7.5 7.5 0 0 1 15 0" />
                                </svg>
                            </div>

                            <span class="hidden lg:block text-sm font-medium pr-1">
                                Login
                            </span>

                        </a>

                    @endauth


                    {{-- NO HAMBURGER ICON HERE --}}

                </div>

            </div>


            {{-- =========================================================
            MOBILE SEARCH
        ========================================================== --}}
            <div class="md:hidden pb-4">

                <form action="{{ route('search') }}" method="GET">

                    <div class="relative">

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search products..."
                            class="w-full h-10 pl-4 pr-11
                               rounded-full
                               border border-gray-200
                               bg-gray-50
                               text-sm
                               focus:outline-none
                               focus:ring-2
                               focus:ring-blue-500">

                        <button type="submit"
                            class="absolute right-1 top-1
                               w-8 h-8
                               rounded-full
                               bg-[#0959e8]
                               text-white
                               flex items-center justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />
                            </svg>

                        </button>

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
    <div class="hidden md:block bg-[#f3f8fe] border-b border-blue-100">
        <div class="Container mx-auto px-4">
            <nav>
                <ul class="flex items-center gap-0.5">

                    @foreach ($parentCategories as $parent)
                        <li class="relative group">

                            {{-- PARENT CATEGORY --}}
                            @if (in_array($parent->slug, ['todays-deals', 'today-deals']))
                                <a href="{{ route('today-deals') }}"
                                    class="flex items-center gap-1 px-3 py-2 text-xs font-medium whitespace-nowrap transition-all duration-200 text-red-600 font-semibold hover:text-red-700 hover:bg-red-50 rounded-lg">

                                    <i class="fa-solid fa-bolt text-[10px]"></i>

                                    {{ $parent->name }}

                                    @if ($parent->children->count())
                                        <i class="fa-solid fa-chevron-down text-[8px] ml-0.5"></i>
                                    @endif
                                </a>
                            @else
                                <a href="{{ route('category.show', ['slug' => $parent->slug]) }}"
                                    class="flex items-center gap-1 px-3 py-2 text-xs font-medium whitespace-nowrap transition-all duration-200 text-gray-700 hover:text-[#0959e8] hover:bg-white rounded-lg">

                                    {{ $parent->name }}

                                    @if ($parent->children->count())
                                        <i class="fa-solid fa-chevron-down text-[8px] ml-0.5"></i>
                                    @endif
                                </a>
                            @endif
                        </a>


                            {{-- DROPDOWN --}}
                            {{-- =========================================================
    DROPDOWN
========================================================= --}}
@if ($parent->children->count())

    <div class="absolute left-0 top-full z-[9999] hidden group-hover:block pt-1">

        <div class="w-60 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden">

            {{-- DROPDOWN HEADER --}}
            <div class="px-3 py-2.5 bg-gray-50 border-b border-gray-100">

                <p
                    class="text-xs font-semibold
                    {{ in_array($parent->slug, ['todays-deals', 'today-deals'])
                        ? 'text-red-600'
                        : 'text-gray-800' }}">

                    {{ $parent->name }}

                </p>

            </div>


            {{-- CHILD CATEGORIES --}}
            <div class="py-1">

                @foreach ($parent->children as $child)

                    @if ($child->status)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | Today's Deals Child Routing
                            |--------------------------------------------------------------------------
                            |
                            | limited-time-offer
                            |       -> dedicated limited-time page
                            |
                            | All other Today's Deals children
                            |       -> festive page
                            |
                            | Normal categories
                            |       -> category.show
                            |
                            */

                            if (
                                in_array($parent->slug, [
                                    'todays-deals',
                                    'today-deals'
                                ])
                            ) {

                                if ($child->slug === 'limited-time-offer') {

                                    $childUrl = route('limited-time');

                                } else {

                                    $childUrl = route(
                                        'frontend.today-deals.festive',
                                        [
                                            'slug' => $child->slug
                                        ]
                                    );
                                }

                            } else {

                                $childUrl = route(
                                    'category.show',
                                    [
                                        'slug' => $child->slug
                                    ]
                                );

                            }

                        @endphp


                        <a href="{{ $childUrl }}"
                            class="flex items-center justify-between px-3 py-2 text-xs text-gray-600 hover:bg-blue-50 hover:text-[#0959e8] transition-colors duration-150">

                            <span>
                                {{ $child->name }}
                            </span>

                            <i class="fa-solid fa-chevron-right text-[8px] text-gray-400"></i>

                        </a>

                    @endif

                @endforeach

            </div>

        </div>

    </div>

@endif

                        </li>
                    @endforeach

                </ul>
            </nav>
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
