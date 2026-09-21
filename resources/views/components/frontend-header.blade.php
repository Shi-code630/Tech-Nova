<header class="sticky top-0 z-50">

    {{-- =========================================================
        TOP BAR
    ========================================================== --}}
    <div class="bg-[#0959e8] text-white text-xs">
        <div class="Container mx-auto px-4">

            <div class="flex items-center justify-between py-0.5">

                {{-- Left --}}
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1">
                        <i class="fa-solid fa-location-dot"></i>
                        Kathmandu
                    </span>
                    <span class="text-white/70">|</span>
                    <span class="hidden sm:inline">
                        Free Delivery On All Orders Above Rs.500
                    </span>
                </div>

                {{-- Right --}}
                <div class="flex items-center gap-3">
                    <a href="#" class="hover:text-gray-200 transition">
                        Track Order
                    </a>

                    <span class="text-white/70">|</span>

                    <a href="#" class="hover:text-gray-200 transition">
                        Help
                    </a>

                    <span class="text-white/70">|</span>

                    <a class="hidden sm:inline hover:text-gray-200 transition">
                        English
                    </a>
                </div>

            </div>

        </div>
    </div>



    {{-- =========================================================
    MAIN HEADER
========================================================= --}}
    <div class="bg-white border-b border-gray-100">

        <div class="Container mx-auto px-4">

            <div class="flex items-center justify-between gap-4 py-2">

                {{-- =====================================================
                LOGO
            ====================================================== --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="block">
                        <img src="{{ asset('image/logo.png') }}" alt="TechNova" class="h-8 md:h-8 w-auto object-contain"
                            onerror="this.style.display='none'">
                    </a>
                </div>


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


                        {{-- CART COUNT --}}
                        @auth

                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                            @endphp

                            @if ($cartCount > 0)
                                <span
                                    class="absolute
                                       -top-1
                                       -right-1
                                       min-w-[19px]
                                       h-[19px]
                                       px-1
                                       rounded-full
                                       bg-red-500
                                       text-white
                                       text-[10px]
                                       font-bold
                                       flex items-center
                                       justify-center
                                       border-2
                                       border-white">
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

                </form>

            </div>

        </div>

    </div>


    {{-- =========================================================
        CATEGORY NAVIGATION
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

</header>
