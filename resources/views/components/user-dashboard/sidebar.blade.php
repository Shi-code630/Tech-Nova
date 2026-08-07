<div class="bg-gradient-to-b from-[#2563EB] to-[#1E40AF] rounded-3xl shadow-2xl overflow-hidden sticky top-6">

    <!-- Profile -->
    <div class="px-8 py-10 text-center border-b border-blue-400/30">

        <div class="w-24 h-24 rounded-full bg-white mx-auto flex items-center justify-center shadow-xl">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-12 h-12 text-blue-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5.121 17.804A9 9 0 1118.88 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>

            </svg>

        </div>

        <h2 class="text-white font-bold text-xl mt-5">
            John Doe
        </h2>

        <p class="text-blue-100 text-sm">
            johndoe@gmail.com
        </p>

    </div>

    <!-- Menu -->

    <div class="py-6">

        <a href="{{ route('user.dashboard') }}"
           class="flex items-center gap-4 px-8 py-4 bg-white text-blue-700 font-semibold">

            🏠 Dashboard

        </a>

        <a href="#"
           class="flex items-center gap-4 px-8 py-4 text-white hover:bg-white/10 transition">

            📦 My Orders

        </a>

        <a href="#"
           class="flex items-center gap-4 px-8 py-4 text-white hover:bg-white/10 transition">

            ❤️ Wishlist

        </a>

        <a href="#"
           class="flex items-center gap-4 px-8 py-4 text-white hover:bg-white/10 transition">

            🛒 Cart

        </a>

        <a href="#"
           class="flex items-center gap-4 px-8 py-4 text-white hover:bg-white/10 transition">

            📍 Address

        </a>

        <a href="#"
           class="flex items-center gap-4 px-8 py-4 text-white hover:bg-white/10 transition">

            ⭐ Reviews

        </a>

        <a href="#"
           class="flex items-center gap-4 px-8 py-4 text-white hover:bg-white/10 transition">

            🎁 Coupons

        </a>

        <a href="#"
           class="flex items-center gap-4 px-8 py-4 text-white hover:bg-white/10 transition">

            ⚙ Settings

        </a>

    </div>

    <div class="p-6">

        <button
            class="w-full bg-red-500 hover:bg-red-600 transition rounded-xl py-3 text-white font-semibold">

            Logout

        </button>

    </div>

</div>
