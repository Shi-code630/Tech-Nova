<<<<<<< HEAD
<header class="shadow-md">
    {{-- Top Header (Blue) --}}
    <div class="bg-[#2563EB]">
        <div class="Container mx-auto px-4">
            <div class="flex items-center justify-between py-2">

                {{-- Logo --}}
=======
<header class="sticky top-0 ">
    <div class="w-full shadow-md ">

        <!-- Top Header -->
        <div class="bg-[#2563EB] p-2 ">
            <div class="flex items-center justify-between container mx-auto">

                <!-- Logo -->
>>>>>>> dd79b8318b514c5a7f6698fe2558f3f2792f407f
                <a href="{{ route('home') }}" class="flex-shrink-0">
                    <img src="{{ asset('image/logo.png') }}" alt="logo" class="w-auto h-11 drop-shadow-sm">
                </a>

<<<<<<< HEAD
                {{-- Search --}}
                <div class="flex-1 max-w-xl mx-8 relative">
                    <input type="text" placeholder="Search products..."
                        class="w-full h-9 rounded-full outline-none pl-5 pr-14 text-sm border-2 border-white/30 bg-white/90 backdrop-blur-sm focus:bg-white focus:border-[#F59E0B] transition-all duration-300 shadow-inner text-[#111827]">
                    <button
=======
                <!-- Search -->
                <form action="{{ route('search') }}" method="GET" class="flex-1 max-w-xl mx-8 relative">
                    <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}"
                        class="w-full h-9 rounded-full outline-none pl-5 pr-14 text-sm border-2 border-white/30 bg-white/90 backdrop-blur-sm focus:bg-white focus:border-[#F59E0B] transition-all duration-300 shadow-inner text-[#111827]">
                    <button type="submit"
>>>>>>> dd79b8318b514c5a7f6698fe2558f3f2792f407f
                        class="absolute right-1 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] flex items-center justify-center hover:scale-105 hover:shadow-[0_0_15px_rgba(37,99,235,0.4)] transition-all duration-200 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-5.2-5.2m2.2-5.3a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>

                {{-- Right Icons --}}
                <div class="flex items-center gap-5">
                    {{-- Coin / Price --}}
                    <a href="#" class="relative group cursor-pointer">
                        <div
                            class="bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-all duration-300 rounded-full px-3 py-0.5 flex items-center gap-2 border border-white/30 shadow-lg">
                            <span class="text-white font-bold text-lg tracking-tight">01</span>
                            <span
                                class="w-6 h-6 rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-xs shadow-md animate-pulse">💰</span>
                            <span class="text-white/60 text-xs font-medium hidden sm:inline">Coins</span>
                        </div>
                        <div
                            class="absolute -bottom-10 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                            <span class="text-[10px] bg-[#111827] text-white px-2 py-0.5 rounded whitespace-nowrap">Your
                                balance</span>
                        </div>
                    </a>

<<<<<<< HEAD
                    {{-- Cart --}}
                    <a href="{{ route('user.cart') }}" class="relative group">
                        <div class="bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-all duration-300 rounded-full p-2.5 border border-white/30 shadow-lg group-hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 text-white">
=======

                    <!-- Cart -->
                    <a href="{{ route('user.cart') }}" class="relative group">
                        <div
                            class="bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-all duration-300 rounded-full p-2.5 border border-white/30 shadow-lg group-hover:scale-105 relative">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="w-4 h-4 text-white">
>>>>>>> dd79b8318b514c5a7f6698fe2558f3f2792f407f
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                            @endphp
                            @if ($cartCount > 0)
                                <span
                                    class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center shadow-md">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </div>
                        <span
                            class="absolute -bottom-7 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-[10px] bg-[#111827] text-white px-2 py-0.5 rounded whitespace-nowrap pointer-events-none">Cart</span>
                    </a>

                    {{-- Wishlist --}}
                    <a href="{{ route('user.wishlist') }}" class="relative group">
<<<<<<< HEAD
                        <div class="bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-all duration-300 rounded-full p-2.5 border border-white/30 shadow-lg group-hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
=======
                        <div
                            class="bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-all duration-300 rounded-full p-2.5 border border-white/30 shadow-lg group-hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor"
>>>>>>> dd79b8318b514c5a7f6698fe2558f3f2792f407f
                                class="w-4 h-4 text-white group-hover:text-[#F59E0B] transition-colors duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z" />
                            </svg>
                        </div>
                        <span
                            class="absolute -bottom-7 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-[10px] bg-[#111827] text-white px-2 py-0.5 rounded whitespace-nowrap pointer-events-none">Wishlist</span>
                    </a>

<<<<<<< HEAD
                    {{-- Profile / Account --}}
                    <div class="relative group">
                        <a href="{{ route('user.dashboard') }}"
                            class="flex items-center gap-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-all duration-300 rounded-full pl-2 pr-3 py-1 border border-white/30 shadow-lg group-hover:scale-105">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-white font-bold text-sm shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
=======
                    <!-- Profile / Account -->
                    <div class="relative group">

                        <!-- Account -->
                        <a href="{{ route('user.dashboard') }}"
                            class="flex items-center gap-2 bg-white/20 backdrop-blur-sm
                                    hover:bg-white/30 transition-all duration-300
                                    rounded-full pl-2 pr-3 py-1
                                    border border-white/30 shadow-lg
                                    group-hover:scale-105">

                            <!-- Icon -->
                            <div
                                class="w-8 h-8 rounded-full
                                            bg-gradient-to-br from-[#F59E0B] to-[#D97706]
                                            flex items-center justify-center
                                            text-white font-bold text-sm shadow-inner">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" class="w-4 h-4">

>>>>>>> dd79b8318b514c5a7f6698fe2558f3f2792f407f
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M5.121 17.804A9 9 0 1118.88 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="text-white text-sm font-medium hidden sm:inline">Account</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-3 h-3 text-white/70 hidden sm:block transition-transform duration-300 group-hover:rotate-180"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>

<<<<<<< HEAD
                        {{-- Dropdown --}}
                        <div class="absolute right-0 top-full mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-[9999] transform translate-y-1 group-hover:translate-y-0">
                            <div class="px-1 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-[#111827]">
                                    {{ auth()->user()->name ?? 'User' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ auth()->user()->email ?? 'user@example.com' }}
                                </p>
=======
                            </div>

                            <!-- Account -->
                            <span class="text-white text-sm font-medium hidden sm:inline">
                                Account
                            </span>

                            <!-- Arrow -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-3 h-3 text-white/70 hidden sm:block
                                            transition-transform duration-300
                                            group-hover:rotate-180"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />

                            </svg>

                        </a>


                        <!-- Dropdown -->
                        <div
                            class="absolute right-0 top-full mt-2 w-56
                                        bg-white rounded-xl shadow-2xl
                                        border border-gray-100
                                        opacity-0 invisible
                                        group-hover:opacity-100
                                        group-hover:visible
                                        transition-all duration-200
                                        z-[9999]
                                        transform translate-y-1
                                        group-hover:translate-y-0">

                            <!-- User -->
                            <div class="px-4 py-3 border-b border-gray-100">

                                <p class="text-sm font-semibold text-[#111827]">
                                    {{ auth()->user()->name ?? 'User' }}

                                </p>

                                <p class="text-xs text-gray-500">
                                    {{ auth()->user()->email ?? 'user@example.com' }}
                                </p>

                            </div>




                            <!-- My Orders -->
                            <a href="{{ route('user.orders') }}"
                                class="flex items-center gap-3 px-4 py-2.5
                                        hover:bg-blue-50 hover:text-[#2563EB]
                                        transition-colors text-sm text-[#111827]">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />

                                </svg>

                                My Orders

                            </a>


                            <!-- Wishlist -->
                            <a href="{{ route('user.wishlist') }}"
                                class="flex items-center gap-3 px-4 py-2.5
                                        hover:bg-blue-50 hover:text-[#2563EB]
                                        transition-colors text-sm text-[#111827]">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z" />

                                </svg>

                                Wishlist

                            </a>


                            <!-- Logout -->
                            <div class="border-t border-gray-100 mt-1 pt-1">

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2.5
                                                hover:bg-red-50 hover:text-red-600
                                                transition-colors text-sm text-[#111827] text-left">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />

                                        </svg>

                                        Logout

                                    </button>
                                </form>

>>>>>>> dd79b8318b514c5a7f6698fe2558f3f2792f407f
                            </div>

                            <a href="{{ route('user.orders') }}"
                                class="flex items-center gap-3 px-4 py-2.5 hover:bg-blue-50 hover:text-[#2563EB] transition-colors text-sm text-[#111827]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                My Orders
                            </a>

<<<<<<< HEAD
                            <a href="{{ route('user.wishlist') }}"
                                class="flex items-center gap-3 px-4 py-2.5 hover:bg-blue-50 hover:text-[#2563EB] transition-colors text-sm text-[#111827]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z" />
                                </svg>
                                Wishlist
                            </a>

                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 hover:text-red-600 transition-colors text-sm text-[#111827] text-left">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Categories Bar --}}
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

    <div class="bg-gradient-to-r from-[#EAF8FF] to-[#D6EEFF] border-t border-blue-100/60 shadow-inner">
        <div class="Container mx-auto px-4">
            <ul class="flex items-center gap-5 h-11 text-[14px] font-semibold text-[#111827]">
                @foreach ($parentCategories as $parent)
                    <li class="relative group">
                        <a href="{{ $parent->slug === 'today-deals' ? route('today-deals') : route('category.show', ['slug' => $parent->slug]) }}"
                            class="flex items-center gap-1 hover:text-[#2563EB] py-3 px-3 rounded-lg hover:bg-white/50 transition-all duration-200 whitespace-nowrap">
                            {{ $parent->name }}

                            @if ($parent->children->count())
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3.5 h-3.5 transition-transform duration-300 group-hover:rotate-180"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            @endif
                        </a>

                        @if ($parent->children->count())
                            <div class="absolute left-0 top-full hidden group-hover:block w-72 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                                <div class="px-5 py-3 bg-gray-50 border-b">
                                    <a href="{{ $parent->slug === 'today-deals' ? route('today-deals') : route('category.show', ['slug' => $parent->slug]) }}"
                                        class="flex items-center justify-between font-semibold text-gray-800 hover:text-blue-600">
                                        <span>All {{ $parent->name }}</span>
                                        <span>→</span>
                                    </a>
                                </div>

                                <ul class="py-2">
                                    @foreach ($parent->children as $child)
                                        <li>
                                            <a href="{{ route('category.show', ['slug' => $child->slug]) }}"
                                                class="flex items-center justify-between px-5 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
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
=======
                    </div>

                </div>
            </div>
        </div>

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


        <div class="bg-gradient-to-r from-[#EAF8FF] to-[#D6EEFF] border-t border-blue-100/60 shadow-inner">

            <div class="max-w-7xl mx-auto px-2">

                <ul class="flex items-center gap-5 h-11 text-[14px] font-semibold text-[#111827]">

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

                                @if ($parent->children->count())
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-3.5 h-3.5 transition-transform duration-300 group-hover:rotate-180"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                @endif
                            </a>


                            {{-- Child Categories --}}
                            @if ($parent->children->count())
                                <div
                                    class="absolute left-0 top-full
                                   hidden group-hover:block
                                   w-72
                                   bg-white
                                   rounded-xl
                                   shadow-2xl
                                   border border-gray-100
                                   z-50
                                   overflow-hidden">

                                    {{-- All Parent --}}
                                    <div class="px-5 py-3 bg-gray-50 border-b">

                                        <a href="{{ $parent->slug === 'today-deals' ? route('today-deals') : route('category.show', ['slug' => $parent->slug]) }}"
                                            class="flex items-center justify-between
               font-semibold
               text-gray-800
               hover:text-blue-600">

                                            <span>
                                                All {{ $parent->name }}
                                            </span>

                                            <span>→</span>

                                        </a>

                                    </div>


                                    {{-- Child Categories --}}
                                    <ul class="py-2">

                                        @foreach ($parent->children as $child)
                                            <li>

                                                <a href="{{ route('category.show', ['slug' => $child->slug]) }}"
                                                    class="flex items-center justify-between
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
>>>>>>> dd79b8318b514c5a7f6698fe2558f3f2792f407f
</header>
