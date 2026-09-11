<div class="bg-white rounded-3xl shadow-md p-6">

    <div class="flex flex-col md:flex-row items-center justify-between gap-4">

<<<<<<< HEAD
        {{-- Left Side --}}
        <div class="flex items-center gap-5 w-full md:w-auto">

            {{-- Avatar --}}
            <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center shadow-lg flex-shrink-0">
                @php
                    $user = auth()->user();
                    $imagePath = $user->image ?? null;
                    $hasImage = $imagePath && file_exists(public_path('storage/' . $imagePath));
                @endphp

                @if($hasImage)
                    <img src="{{ asset('storage/' . $imagePath) }}"
                         alt="{{ $user->name }}"
                         class="w-16 h-16 rounded-full object-cover border-2 border-white shadow">
                @else
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </div>
                @endif
            </div>

            {{-- Welcome Text --}}
            <div>
                <h2 class="text-xl md:text-3xl font-bold text-gray-800">
                    👋 Welcome back, <span class="text-[#2563EB]">{{ $user->name ?? 'Guest' }}</span>
                </h2>
                <p class="text-gray-500 mt-1 text-sm md:text-base">
                    Here's what's happening with your account today.
                </p>
            </div>

        </div>

        {{-- Right Side - Coins Card --}}
        <a href="{{ route('user.coins') }}" class="w-full md:w-auto">
            <div class="bg-orange-50 border border-orange-200 rounded-2xl px-4 md:px-6 py-3 md:py-4 flex items-center gap-3 md:gap-4 shadow-sm hover:shadow-md transition-all duration-200 hover:bg-orange-100 cursor-pointer">

                <div class="w-10 h-10 md:w-14 md:h-14 rounded-full bg-orange-100 flex items-center justify-center text-2xl md:text-3xl">
                    🪙
                </div>

                <div>
                    @php
                        $coins = $user->reward_points ?? 0;
                        $redeemRate = \App\Helpers\RewardHelper::getRedeemRate() ?? 20;
                        $coinValue = $redeemRate > 0 ? $coins / $redeemRate : 0;
                    @endphp
                    <h3 class="text-xl md:text-2xl font-bold text-orange-600">
                        {{ number_format($coins) }}
                    </h3>
                    <p class="text-xs md:text-sm text-gray-500">
                        Coins · ≈ Rs. {{ number_format($coinValue, 2) }}
                    </p>
                </div>

            </div>
        </a>
=======
        {{-- Welcome Text --}}
        <div>

            <h2 class="text-2xl font-bold text-gray-800">
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
            class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-3xl">

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
>>>>>>> 20a0ea999459addac9ef04032d04154f02d58141

    </div>

</div>
