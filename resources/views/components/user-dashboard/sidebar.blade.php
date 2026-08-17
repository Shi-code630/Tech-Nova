<!-- Sidebar -->
<aside  class="w-72 sticky top-4
           h-[calc(100vh-2rem)]
           max-h-[calc(100vh-2rem)]
           overflow-y-auto
           self-start
           flex-shrink-0
           bg-gradient-to-b from-[#2563EB] to-[#1E40AF]
           text-white
           rounded-3xl
           shadow-xl
           flex flex-col
           scrollbar-thin
           scrollbar-thumb-blue-300
           scrollbar-track-transparent"
>
    <!-- User Profile -->
    <div class="px-6 py-8 text-center border-b border-white/20">

        <!-- Avatar -->
        <div class="w-20 h-20 mx-auto mb-3 rounded-full bg-white flex items-center justify-center shadow-lg">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-white text-2xl font-bold">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
        </div>

        <h2 class="text-lg font-bold">
            {{ auth()->user()->name ?? 'User' }}
        </h2>

        <p class="text-sm text-blue-100">
            {{ auth()->user()->email ?? 'user@example.com' }}
        </p>
    </div>


    <!-- Navigation -->
    <nav class="flex-1 py-5 px-3">

        <!-- Dashboard -->
        <a href="{{ route('user.dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1
           {{ request()->routeIs('user.dashboard')
                ? 'bg-white/20 font-semibold shadow-sm'
                : 'hover:bg-white/10' }}
           transition-all duration-200">

            <span class="text-lg">🏠</span>
            <span>Dashboard</span>
        </a>


        <!-- Profile -->
        <a href="{{ route('user.profile') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
            {{ request()->routeIs('user.profile')
            ? 'bg-white/20 text-white'
            : 'text-white/80 hover:bg-white/10 hover:text-white' }}">

                {{-- profile icon --}}

            <span>My Profile</span>
        </a>


        <!-- My Orders -->
        <a href="{{ route('user.orders') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1
           {{ request()->routeIs('user.orders', 'user.order.view')
                ? 'bg-white/20 font-semibold shadow-sm'
                : 'hover:bg-white/10' }}
           transition-all duration-200">

            <span class="text-lg">📦</span>
            <span>My Orders</span>
        </a>


        <!-- Wishlist -->
        <a href="{{ route('user.wishlist') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition-all duration-200">

            ❤️
            <span>Wishlist</span>

        </a>


        <!-- Cart -->
        <a href="{{ route('user.cart') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1 hover:bg-white/10 transition-all duration-200">

            <span class="text-lg">🛒</span>
            <span>Cart</span>
        </a>


        <!-- Address -->
        <a href="{{ route('user.addresses') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1 hover:bg-white/10 transition-all duration-200">

            <span class="text-lg">📍</span>
            <span>Address</span>
        </a>


        <!-- Reviews -->
        <a href="{{ route('user.reviews') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1 hover:bg-white/10 transition-all duration-200">

            <span class="text-lg">⭐</span>
            <span>Reviews</span>
        </a>


        <!-- Coupons -->
        <a href="{{ route('user.coupons') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1 hover:bg-white/10 transition-all duration-200">

            <span class="text-lg">🎁</span>
            <span>Coupons</span>
        </a>


        <!-- Settings -->
        <a href="{{ route('user.settings') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1 hover:bg-white/10 transition-all duration-200">

            <span class="text-lg">⚙️</span>
            <span>Settings</span>
        </a>

    </nav>


    <!-- Logout -->
    <div class="p-5">

        <form method="POST" action="#">
            @csrf

            <button type="submit"
                    class="w-full bg-[#EF4444] hover:bg-red-600 text-white font-semibold py-3 rounded-xl transition-all duration-200 shadow-lg">

                <span class="mr-2">↪</span>
                Logout

            </button>
        </form>

    </div>

</aside>
