<!-- Sidebar -->
<aside
    class="w-72
       sticky top-4
       h-[calc(100vh-2rem)]
       flex-shrink-0
       bg-gradient-to-b from-[#2563EB] to-[#1E40AF]
       text-white
       rounded-3xl
       shadow-xl
       flex flex-col
       ">

    <!-- =========================
         USER PROFILE
    ========================== -->
    <div class="px-6 py-8 text-center border-b border-white/20">

        <!-- Avatar -->
        <div class="w-20 h-20 mx-auto mb-3 rounded-full bg-white
            flex items-center justify-center shadow-lg">

            @php
                $user = auth()->user();
                $imagePath = $user->image ?? null;
                $hasImage = $imagePath && file_exists(public_path('storage/' . $imagePath));
            @endphp

            @if($hasImage)
                <img src="{{ asset('storage/' . $imagePath) }}"
                     alt="{{ $user->name }}"
                     class="w-16 h-16 rounded-full object-cover border-2 border-white shadow"
                     onerror="this.style.display='none'; this.parentElement.innerHTML = `<div class='w-16 h-16 rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-white text-2xl font-bold'>{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>`;">
            @else
                <div class="w-16 h-16 rounded-full
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
        <p class="text-sm text-blue-100 truncate mt-1">
            {{ auth()->user()->email ?? 'user@example.com' }}
        </p>

    </div>

    <!-- =========================
         NAVIGATION
    ========================== -->
    <nav class="flex-1 py-5 px-3 overflow-y-auto">

        <!-- Dashboard -->
        <a href="{{ route('user.dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.dashboard')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">

            <span class="text-lg w-6 text-center">
                🏠
            </span>

            <span>
                Dashboard
            </span>

        </a>

        <!-- Profile -->
        <a href="{{ route('user.profile') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.profile')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">

            <span class="text-lg w-6 text-center">
                👤
            </span>

            <span>
                My Profile
            </span>

        </a>

        <!-- My Orders -->
        <a href="{{ route('user.orders') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.orders', 'user.order.view')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">

            <span class="text-lg w-6 text-center">
                📦
            </span>

            <span>
                My Orders
            </span>

        </a>

        <!-- Wishlist -->
        <a href="{{ route('user.wishlist') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.wishlist')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">

            <span class="text-lg w-6 text-center">
                ❤️
            </span>

            <span>
                Wishlist
            </span>

        </a>

        <!-- Cart -->
        <a href="{{ route('user.cart') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.cart')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">

            <span class="text-lg w-6 text-center">
                🛒
            </span>

            <span>
                Cart
            </span>

        </a>

        <!-- Address -->
        <a href="{{ route('user.addresses') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.addresses')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">

            <span class="text-lg w-6 text-center">
                📍
            </span>

            <span>
                Address
            </span>

        </a>

        <!-- Reviews -->
        <a href="{{ route('user.reviews') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.reviews')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">

            <span class="text-lg w-6 text-center">
                ⭐
            </span>

            <span>
                Reviews
            </span>

        </a>

        <!-- Coupons -->
        <a href="{{ route('user.coupons') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.coupons')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">

            <span class="text-lg w-6 text-center">
                🎁
            </span>

            <span>
                Coupons
            </span>

        </a>

        <!-- Settings -->
        <a href="{{ route('user.settings') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                   transition-all duration-200
                   {{ request()->routeIs('user.settings')
                       ? 'bg-white/20 font-semibold shadow-sm'
                       : 'text-white/90 hover:bg-white/10 hover:text-white' }}">

            <span class="text-lg w-6 text-center">
                ⚙️
            </span>

            <span>
                Settings
            </span>

        </a>

        <!-- =========================
             LOGOUT
        ========================== -->
        <div class="mt-4 pt-4 border-t border-white/20">

            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                    class="w-full
                       bg-[#EF4444]
                       hover:bg-[#DC2626]
                       text-white
                       font-semibold
                       py-2.5
                       rounded-xl
                       transition-all
                       duration-200
                       shadow-lg
                       flex
                       items-center
                       justify-center
                       gap-2">

                    <span class="text-lg">
                        ↪
                    </span>

                    <span>
                        Logout
                    </span>

                </button>

            </form>

        </div>

    </nav>

</aside>
