<aside
    class="hidden lg:flex
           w-64
           sticky top-4
           h-[calc(115vh-2rem)]
           flex-shrink-0
           bg-gradient-to-b from-[#2563EB] to-[#1E40AF]
           text-white
           rounded-3xl
           shadow-xl
           flex-col">

    <!-- =========================
         USER PROFILE
    ========================== -->
    <div class="px-6 py-5 text-center border-b border-white/20">

        <!-- Avatar -->
        <div
            class="w-20 h-20 mx-auto mb-3 rounded-full bg-white
                    flex items-center justify-center shadow-lg">

            @php
                $user = auth()->user();
            @endphp

            @if ($user->image)
                <img src="{{ $user->image }}" alt="{{ $user->name }}"
                    class="w-16 h-16 rounded-full object-cover border-2 border-white shadow"
                    onerror="this.style.display='none'; this.parentElement.innerHTML = `<div class='w-16 h-16 rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-white text-2xl font-bold'>{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>`;">
            @else
                <div
                    class="w-16 h-16 rounded-full
                            bg-gradient-to-br from-[#F59E0B] to-[#D97706]
                            flex items-center justify-center
                            text-white text-2xl font-bold">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </div>
            @endif

        </div>

        <!-- Name -->
        <h2 class="text-lg font-bold truncate">
            {{ auth()->user()->name ?? 'User' }}
        </h2>

        <!-- Email -->
        <p class="text-[14px] text-blue-100 truncate">
            {{ auth()->user()->email ?? 'user@example.com' }}
        </p>

    </div>


    <!-- =========================
         NAVIGATION
    ========================== -->
    <nav class="flex-1 py-5 px-3 overflow-y-auto">

        <!-- Dashboard -->
        <a href="{{ route('user.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.dashboard')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg w-6 text-center">🏠</span>
            <span>Dashboard</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('user.profile') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.profile')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg w-6 text-center">👤</span>
            <span>My Profile</span>
        </a>

        <!-- My Orders -->
        <a href="{{ route('user.orders') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.orders', 'user.order.view')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg w-6 text-center">📦</span>
            <span>My Orders</span>
        </a>

        <!-- Wishlist -->
        <a href="{{ route('user.wishlist') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.wishlist')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg w-6 text-center">❤️</span>
            <span>Wishlist</span>
        </a>

        <!-- Cart -->
        <a href="{{ route('user.cart') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.cart')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg w-6 text-center">🛒</span>
            <span>Cart</span>
        </a>

        <!-- Address -->
        <a href="{{ route('checkout.addresses') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('checkout.addresses')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg w-6 text-center">📍</span>
            <span>Address</span>
        </a>

        <!-- Reviews -->
        <a href="{{ route('user.reviews') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.reviews')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg w-6 text-center">⭐</span>
            <span>Reviews</span>
        </a>

        <!-- Coupons -->
        <a href="{{ route('user.coupons') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.coupons')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg w-6 text-center">🎁</span>
            <span>Coupons</span>
        </a>

        <!-- Settings -->
        <a href="{{ route('user.settings') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.settings')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg w-6 text-center">⚙️</span>
            <span>Settings</span>
        </a>

        <!-- =========================
             LOGOUT
        ========================== -->
        <div class="mt-4 pt-4 border-t border-white/20">

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="w-full bg-[#EF4444] hover:bg-[#DC2626] text-white
                           font-semibold py-2.5 rounded-xl
                           transition-all duration-200 shadow-lg
                           flex items-center justify-center gap-2">
                    <span class="text-lg">↪</span>
                    <span>Logout</span>
                </button>

            </form>

        </div>

    </nav>

</aside>


{{-- =====================================================
     MOBILE TOP NAVIGATION (Dropdown)
====================================================== --}}
<div class="lg:hidden mb-4">

    {{-- Mobile User Profile Card --}}
    <div class="bg-gradient-to-r from-[#2563EB] to-[#1E40AF]
                text-white rounded-2xl shadow-lg p-4 mb-3">

        <div class="flex items-center gap-3">

            {{-- Avatar --}}
            <div
                class="w-12 h-12 rounded-full bg-white
                        flex items-center justify-center shadow-lg flex-shrink-0">

                @php $user = auth()->user(); @endphp

                @if ($user->image)
                    <img src="{{ $user->image }}" alt="{{ $user->name }}"
                        class="w-10 h-10 rounded-full object-cover border-2 border-white"
                        onerror="this.style.display='none'; this.parentElement.innerHTML = `<div class='w-10 h-10 rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-white text-lg font-bold'>{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>`;">
                @else
                    <div
                        class="w-10 h-10 rounded-full
                                bg-gradient-to-br from-[#F59E0B] to-[#D97706]
                                flex items-center justify-center
                                text-white text-lg font-bold">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </div>
                @endif

            </div>

            {{-- Name + Email --}}
            <div class="min-w-0 flex-1">
                <h2 class="text-sm font-bold truncate">
                    {{ auth()->user()->name ?? 'User' }}
                </h2>
                <p class="text-[11px] text-blue-100 truncate">
                    {{ auth()->user()->email ?? 'user@example.com' }}
                </p>
            </div>

            {{-- Toggle Button --}}
            <button type="button" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')"
                class="w-9 h-9 rounded-lg bg-white/20 hover:bg-white/30
                       flex items-center justify-center transition flex-shrink-0">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>

            </button>

        </div>

    </div>


    {{-- Mobile Menu (Collapsible) --}}
    <div id="mobileMenu" class="hidden bg-white rounded-2xl shadow-lg border border-gray-100 p-3">

        <nav class="grid grid-cols-2 gap-2">

            <a href="{{ route('user.dashboard') }}"
                class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-medium transition
                       {{ request()->routeIs('user.dashboard')
                           ? 'bg-blue-50 text-[#2563EB] font-semibold'
                           : 'text-gray-700 hover:bg-gray-50' }}">
                <span>🏠</span> Dashboard
            </a>

            <a href="{{ route('user.profile') }}"
                class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-medium transition
                       {{ request()->routeIs('user.profile')
                           ? 'bg-blue-50 text-[#2563EB] font-semibold'
                           : 'text-gray-700 hover:bg-gray-50' }}">
                <span>👤</span> Profile
            </a>

            <a href="{{ route('user.orders') }}"
                class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-medium transition
                       {{ request()->routeIs('user.orders', 'user.order.view')
                           ? 'bg-blue-50 text-[#2563EB] font-semibold'
                           : 'text-gray-700 hover:bg-gray-50' }}">
                <span>📦</span> Orders
            </a>

            <a href="{{ route('user.wishlist') }}"
                class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-medium transition
                       {{ request()->routeIs('user.wishlist')
                           ? 'bg-blue-50 text-[#2563EB] font-semibold'
                           : 'text-gray-700 hover:bg-gray-50' }}">
                <span>❤️</span> Wishlist
            </a>

            <a href="{{ route('user.cart') }}"
                class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-medium transition
                       {{ request()->routeIs('user.cart')
                           ? 'bg-blue-50 text-[#2563EB] font-semibold'
                           : 'text-gray-700 hover:bg-gray-50' }}">
                <span>🛒</span> Cart
            </a>

            <a href="{{ route('checkout.addresses') }}"
                class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-medium transition
                       {{ request()->routeIs('checkout.addresses')
                           ? 'bg-blue-50 text-[#2563EB] font-semibold'
                           : 'text-gray-700 hover:bg-gray-50' }}">
                <span>📍</span> Address
            </a>

            <a href="{{ route('user.reviews') }}"
                class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-medium transition
                       {{ request()->routeIs('user.reviews')
                           ? 'bg-blue-50 text-[#2563EB] font-semibold'
                           : 'text-gray-700 hover:bg-gray-50' }}">
                <span>⭐</span> Reviews
            </a>

            <a href="{{ route('user.coupons') }}"
                class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-medium transition
                       {{ request()->routeIs('user.coupons')
                           ? 'bg-blue-50 text-[#2563EB] font-semibold'
                           : 'text-gray-700 hover:bg-gray-50' }}">
                <span>🎁</span> Coupons
            </a>

            <a href="{{ route('user.settings') }}"
                class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-medium transition
                       {{ request()->routeIs('user.settings')
                           ? 'bg-blue-50 text-[#2563EB] font-semibold'
                           : 'text-gray-700 hover:bg-gray-50' }}">
                <span>⚙️</span> Settings
            </a>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="col-span-2">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2
                           px-3 py-2.5 rounded-xl text-xs font-semibold
                           bg-red-50 text-red-600 hover:bg-red-100 transition">
                    <span>↪</span> Logout
                </button>
            </form>

        </nav>

    </div>

</div>
