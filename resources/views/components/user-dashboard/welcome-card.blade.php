<div class="bg-white rounded-3xl shadow-md p-6 flex items-center justify-between">

    {{-- Left Side --}}
    <div class="flex items-center gap-5">

        {{-- Avatar --}}
        <div
            class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white text-4xl font-bold shadow-lg">

           {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}

        </div>

        {{-- Welcome Text --}}
        <div>

            <h2 class="text-3xl font-bold text-gray-800">
                👋 Welcome back,
                {{ $user->name ?? 'Guest' }}
            </h2>

            <p class="text-gray-500 mt-1">
                Here's what's happening with your account today.
            </p>

        </div>

    </div>

    {{-- Right Side --}}
    <div
        class="bg-orange-50 border border-orange-200 rounded-2xl px-6 py-4 flex items-center gap-4 shadow-sm">

        <div
            class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center text-3xl">

            🪙

        </div>

        <div>

            <h3 class="text-2xl font-bold text-orange-600">
                0
            </h3>

            <p class="text-sm text-gray-500">
                Coins Available
            </p>

        </div>

    </div>

</div>
