<header class="sticky top-0 z-50">
    <div class="bg-[#0959e8] sticky top-0 z-50">

        <div class="Container mx-auto flex justify-between py-1 ">

            {{-- LEFT --}}
            <div class="flex items-center">

                <span class="text-[#dbeafe] text-xs sm:text-sm">
                    📍 Kathmandu, Nepal
                </span>

                <span class="hidden sm:inline text-[#dbeafe] text-xs sm:text-sm ml-8">
                    🚛 Free Delivery On All Orders Above Rs. 500
                </span>

            </div>


            {{-- RIGHT --}}
            <div class="flex items-center gap-4 sm:gap-5">

                <a href="#" class="text-[#dbeafe] text-xs sm:text-sm hover:text-white transition">
                    Track Order
                </a>

                <span class="h-4 w-px bg-white/40"></span>

                <a href="#" class="text-[#dbeafe] text-xs sm:text-sm hover:text-white transition">
                    Help
                </a>

                <span class="h-4 w-px bg-white/40"></span>

                <a href="#" class="text-[#dbeafe] text-xs sm:text-sm hover:text-white transition">
                    English
                </a>

            </div>

        </div>

    </div>



    {{-- =========================================================
        MAIN HEADER
    ========================================================== --}}
    <div class="bg-[#fefefe] shadow-md">

        <div class="Container mx-auto flex items-center justify-between  p-2">


            {{-- =================================================
                LOGO
            ================================================== --}}
            <a href="{{ route('home') }}" class="flex-shrink-0">

                <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-auto h-11 drop-shadow-sm">

            </a>



            {{-- =================================================
                SEARCH
            ================================================== --}}
            <form action="{{ route('search') }}" method="GET"
                class="hidden md:flex flex-1 max-w-xl mx-6 lg:mx-8 relative">

                <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}"
                    class="w-full h-9 rounded-full outline-none
                           pl-5 pr-14 text-sm
                           border-2 border-gray-200
                           bg-white
                           focus:border-[#2563EB]
                           transition-all duration-300
                           shadow-inner
                           text-[#111827]">

                <button type="submit"
                    class="absolute right-1 top-1/2 -translate-y-1/2
                           w-8 h-8 rounded-full
                           bg-gradient-to-r from-[#2563EB] to-[#1D4ED8]
                           flex items-center justify-center
                           hover:scale-105
                           hover:shadow-[0_0_15px_rgba(37,99,235,0.4)]
                           transition-all duration-200
                           shadow-md">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M21 21l-5.2-5.2m2.2-5.3a7 7 0 11-14 0 7 7 0 0114 0z" />

                    </svg>

                </button>

            </form>



            {{-- =================================================
                RIGHT SIDE
            ================================================== --}}
            <div class="flex items-center gap-3 sm:gap-5">


                {{-- =================================================
                    COINS
                ================================================== --}}
                {{-- ✅ Coin link — click garda coins page ma jane --}}
                <a href="{{ route('user.dashboard') }}" class="relative group cursor-pointer hidden sm:block">

                    <div
                        class="bg-[#0959e8] hover:bg-[#074dcc] transition-all duration-300 rounded-full px-3 py-1 flex items-center gap-2 shadow-md">

                        <span class="text-white font-bold text-sm">
                            {{ auth()->user()->reward_points ?? 0 }}
                        </span>

                        <span
                            class="w-6 h-6 rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-xs shadow-md">
                            💰
                        </span>

                        <span class="text-white text-xs font-medium hidden lg:inline">
                            Coins
                        </span>

                    </div>

                </a>


                {{-- Tooltip --}}
                <div
                    class="absolute -bottom-10 left-1/2
                                -translate-x-1/2
                                opacity-0
                                group-hover:opacity-100
                                transition-opacity
                                pointer-events-none">

                    <span
                        class="text-[10px]
                                     bg-[#111827]
                                     text-white
                                     px-2 py-1
                                     rounded
                                     whitespace-nowrap">

                        Your balance

                    </span>

                </div>

                </a>



                {{-- =================================================
                    CART
                ================================================== --}}
                <a href="{{ route('user.cart') }}" class="relative group">

                    <div
                        class="bg-[#0959e8]
                                hover:bg-[#074dcc]
                                transition-all duration-300
                                rounded-full
                                p-2.5
                                shadow-md
                                group-hover:scale-105">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-4 h-4 text-white">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2
                                   M7 13h10l4-8H5.4
                                   M7 13L5.4 5
                                   M7 13l-2.293 2.293
                                   c-.63.63-.184 1.707.707 1.707H17
                                   m0 0a2 2 0 100 4
                                   2 2 0 000-4zm-8 2
                                   a2 2 0 11-4 0
                                   2 2 0 014 0z" />

                        </svg>


                        {{-- Cart Count --}}
                        @auth

                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                            @endphp

                            @if ($cartCount > 0)
                                <span
                                    class="absolute -top-1 -right-1
                                             bg-red-500
                                             text-white
                                             text-[10px]
                                             font-bold
                                             w-5 h-5
                                             rounded-full
                                             flex items-center justify-center
                                             shadow-md">

                                    {{ $cartCount }}

                                </span>
                            @endif

                        @endauth

                    </div>


                    {{-- Tooltip --}}
                    <span
                        class="absolute -bottom-7 left-1/2
                                 -translate-x-1/2
                                 opacity-0
                                 group-hover:opacity-100
                                 transition-opacity
                                 text-[10px]
                                 bg-[#111827]
                                 text-white
                                 px-2 py-1
                                 rounded
                                 whitespace-nowrap
                                 pointer-events-none">

                        Cart

                    </span>

                </a>



                {{-- =================================================
                    WISHLIST
                ================================================== --}}
                <a href="{{ route('user.wishlist') }}" class="relative group">

                    <div
                        class="bg-[#0959e8]
                                hover:bg-[#074dcc]
                                transition-all duration-300
                                rounded-full
                                p-2.5
                                shadow-md
                                group-hover:scale-105">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-4 h-4 text-white
                                   group-hover:text-[#F59E0B]
                                   transition-colors duration-300">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318
                                   a4.5 4.5 0 016.364 0L12 7.636
                                   l1.318-1.318
                                   a4.5 4.5 0 116.364 6.364L12 20.364
                                   4.318 12.682
                                   a4.5 4.5 0 010-6.364z" />

                        </svg>

                    </div>


                    {{-- Tooltip --}}
                    <span
                        class="absolute -bottom-7 left-1/2
                                 -translate-x-1/2
                                 opacity-0
                                 group-hover:opacity-100
                                 transition-opacity
                                 text-[10px]
                                 bg-[#111827]
                                 text-white
                                 px-2 py-1
                                 rounded
                                 whitespace-nowrap
                                 pointer-events-none">

                        Wishlist

                    </span>

                </a>



                {{-- =================================================
                    ACCOUNT
                ================================================== --}}
                @auth

                    {{-- ================= LOGGED IN ================= --}}
                    <div class="relative group">

                        {{-- Account Button --}}
                        <a href="{{ route('user.dashboard') }}"
                            class="flex items-center gap-2
                                   bg-[#0959e8]
                                   hover:bg-[#074dcc]
                                   transition-all duration-300
                                   rounded-full
                                   pl-1 pr-2 sm:pr-3 py-1
                                   shadow-md
                                   group-hover:scale-105">


                            {{-- Profile Image --}}
                            <div
                                class="w-8 h-8 rounded-full
                                        overflow-hidden
                                        bg-gradient-to-br
                                        from-[#F59E0B] to-[#D97706]
                                        flex items-center justify-center
                                        text-white
                                        font-bold
                                        shadow-inner">

                                @if (!empty(auth()->user()->image))
                                    <img src="{{ asset('storage/' . auth()->user()->image) }}"
                                        alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                @else
                                    {{-- Default User Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="w-5 h-5">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a3 3 0 11-6 0
                                                       3 3 0 016 0z
                                                       M4.5 20a7.5 7.5 0 0115 0" />

                                    </svg>
                                @endif

                            </div>


                            {{-- User Name --}}
                            <span
                                class="text-white
                                         text-sm
                                         font-medium
                                         hidden sm:inline
                                         max-w-[100px]
                                         truncate">

                                {{ auth()->user()->name }}

                            </span>


                            {{-- Arrow --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-3 h-3
                                       text-white/80
                                       hidden sm:block
                                       transition-transform
                                       duration-300
                                       group-hover:rotate-180"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />

                            </svg>

                        </a>



                        {{-- =================================================
                            ACCOUNT DROPDOWN
                        ================================================== --}}
                        <div
                            class="absolute right-0 top-full mt-2
                                    w-60
                                    bg-white
                                    rounded-xl
                                    shadow-2xl
                                    border border-gray-100
                                    opacity-0 invisible
                                    group-hover:opacity-100
                                    group-hover:visible
                                    transition-all duration-200
                                    z-[9999]
                                    transform translate-y-1
                                    group-hover:translate-y-0">


                            {{-- User Information --}}
                            <div class="px-4 py-3
                                        border-b border-gray-100">

                                <div class="flex items-center gap-3">


                                    {{-- Profile Image --}}
                                    <div
                                        class="w-10 h-10
                                                rounded-full
                                                overflow-hidden
                                                bg-gradient-to-br
                                                from-[#F59E0B] to-[#D97706]
                                                flex items-center justify-center
                                                text-white
                                                shrink-0">

                                        @if (!empty(auth()->user()->image))
                                            <img src="{{ asset('storage/' . auth()->user()->image) }}"
                                                alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{-- Default Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" class="w-5 h-5">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M15 7a3 3 0 11-6 0
                                                               3 3 0 016 0z
                                                               M4.5 20a7.5 7.5 0 0115 0" />

                                            </svg>
                                        @endif

                                    </div>


                                    {{-- Name & Email --}}
                                    <div class="min-w-0">

                                        <p
                                            class="text-sm
                                                  font-semibold
                                                  text-[#111827]
                                                  truncate">

                                            {{ auth()->user()->name }}

                                        </p>

                                        <p
                                            class="text-xs
                                                  text-gray-500
                                                  truncate">

                                            {{ auth()->user()->email }}

                                        </p>

                                    </div>

                                </div>

                            </div>



                            {{-- Dashboard --}}
                            <a href="{{ route('user.dashboard') }}"
                                class="flex items-center gap-3
                                       px-4 py-2.5
                                       hover:bg-blue-50
                                       hover:text-[#2563EB]
                                       transition-colors
                                       text-sm
                                       text-[#111827]">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l9-9 9 9
                                                   M5 10v10h14V10
                                                   M9 20v-6h6v6" />

                                </svg>

                                Dashboard

                            </a>



                            {{-- My Orders --}}
                            <a href="{{ route('user.orders') }}"
                                class="flex items-center gap-3
                                       px-4 py-2.5
                                       hover:bg-blue-50
                                       hover:text-[#2563EB]
                                       transition-colors
                                       text-sm
                                       text-[#111827]">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2
                                                   M7 13h10l4-8H5.4
                                                   M7 13L5.4 5
                                                   M7 13l-2.293 2.293
                                                   c-.63.63-.184 1.707.707 1.707H17
                                                   m0 0a2 2 0 100 4
                                                   2 2 0 000-4zm-8 2
                                                   a2 2 0 11-4 0
                                                   2 2 0 014 0z" />

                                </svg>

                                My Orders

                            </a>



                            {{-- Wishlist --}}
                            <a href="{{ route('user.wishlist') }}"
                                class="flex items-center gap-3
                                       px-4 py-2.5
                                       hover:bg-blue-50
                                       hover:text-[#2563EB]
                                       transition-colors
                                       text-sm
                                       text-[#111827]">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318
                                                   a4.5 4.5 0 016.364 0L12 7.636
                                                   l1.318-1.318
                                                   a4.5 4.5 0 116.364 6.364L12 20.364
                                                   4.318 12.682
                                                   a4.5 4.5 0 010-6.364z" />

                                </svg>

                                Wishlist

                            </a>



                            {{-- Logout --}}
                            <div
                                class="border-t
                                        border-gray-100
                                        mt-1 pt-1">

                                <form method="POST" action="{{ route('logout') }}">

                                    @csrf

                                    <button type="submit"
                                        class="w-full
                                               flex items-center gap-3
                                               px-4 py-2.5
                                               hover:bg-red-50
                                               hover:text-red-600
                                               transition-colors
                                               text-sm
                                               text-[#111827]
                                               text-left">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4
                                                           m4 4H7
                                                           m6 4v1a3 3 0 01-3 3H6
                                                           a3 3 0 01-3-3V7
                                                           a3 3 0 013-3h4
                                                           a3 3 0 013 3v1" />

                                        </svg>

                                        Logout

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>
                @else
                    {{-- =================================================
                        GUEST / NOT LOGGED IN
                    ================================================== --}}
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-2
                               bg-[#0959e8]
                               hover:bg-[#074dcc]
                               transition-all duration-300
                               rounded-full
                               pl-1 pr-2 sm:pr-3 py-1
                               shadow-md
                               hover:scale-105">


                        {{-- Default User Icon --}}
                        <div
                            class="w-8 h-8
                                    rounded-full
                                    bg-gradient-to-br
                                    from-[#F59E0B] to-[#D97706]
                                    flex items-center justify-center
                                    text-white
                                    shadow-inner">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="w-5 h-5">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a3 3 0 11-6 0
                                               3 3 0 016 0z
                                               M4.5 20a7.5 7.5 0 0115 0" />

                            </svg>

                        </div>


                        <span
                            class="text-white
                                     text-sm
                                     font-medium
                                     hidden sm:inline">

                            Account

                        </span>

                    </a>

                @endauth

            </div>

        </div>

    </div>



    {{-- =========================================================
        CATEGORY NAVIGATION
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


    {{-- Category Bar --}}
    <div class="
                bg-[#f3f8fe]
               shadow-md
                shadow-inner">

        <div class="Container mx-auto px-2">

            <ul
                class="flex items-center gap-5
                       h-11
                       text-[14px]
                       font-semibold
                       text-[#111827]">

                @foreach ($parentCategories as $parent)
                    <li class="relative group">


                        {{-- Parent Category --}}
                        <a href="{{ $parent->slug === 'today-deals' ? route('today-deals') : route('category.show', ['slug' => $parent->slug]) }}"
                            class="flex items-center gap-1
                                   hover:text-[#2563EB]
                                   py-3 px-3
                                   rounded-lg
                                   hover:bg-white/50
                                   transition-all duration-200
                                   whitespace-nowrap">

                            {{ $parent->name }}


                            {{-- Dropdown Arrow --}}
                            @if ($parent->children->count())
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3.5 h-3.5
                                           transition-transform
                                           duration-300
                                           group-hover:rotate-180"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 9l-7 7-7-7" />

                                </svg>
                            @endif

                        </a>



                        {{-- =================================================
                            CHILD CATEGORIES DROPDOWN
                        ================================================== --}}
                        @if ($parent->children->count())
                            <div
                                class="absolute left-0 top-full
                                        hidden group-hover:block
                                        w-72
                                        bg-white
                                        rounded-xl
                                        shadow-2xl
                                        border border-gray-100
                                        z-[9999]
                                        overflow-hidden">


                                {{-- All Parent --}}
                                <div
                                    class="px-5 py-3
                                            bg-gray-50
                                            border-b">

                                    <a href="{{ $parent->slug === 'today-deals' ? route('today-deals') : route('category.show', ['slug' => $parent->slug]) }}"
                                        class="flex items-center
                                               justify-between
                                               font-semibold
                                               text-gray-800
                                               hover:text-blue-600">

                                        <span>
                                            All {{ $parent->name }}
                                        </span>

                                        <span>
                                            →
                                        </span>

                                    </a>

                                </div>



                                {{-- Child Categories --}}
                                <ul class="py-2">

                                    @foreach ($parent->children as $child)
                                        <li>

                                            <a href="{{ route('category.show', ['slug' => $child->slug]) }}"
                                                class="flex items-center
                                                       justify-between
                                                       px-5 py-3
                                                       text-sm
                                                       text-gray-700
                                                       hover:bg-blue-50
                                                       hover:text-blue-600
                                                       transition">

                                                <span>
                                                    {{ $child->name }}
                                                </span>

                                                <span class="text-gray-400">
                                                    →
                                                </span>

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
