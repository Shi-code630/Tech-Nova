<div class="bg-white rounded-3xl shadow-md p-6">

    <div class="flex flex-col md:flex-row items-center justify-between gap-4">

        {{-- Left Side --}}
        <div class="flex items-center gap-5 w-full md:w-auto">

            {{-- Avatar --}}
            <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center shadow-lg flex-shrink-0">
                @php
                    $user = auth()->user();
                @endphp

                @if ($user->image)
                    <img src="{{ $user->image }}" alt="{{ $user->name }}"
                        class="w-16 h-16 rounded-full object-cover border-2 border-white shadow"
                        onerror="this.style.display='none'; this.parentElement.innerHTML = `<div class='w-16 h-16 rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-white text-2xl font-bold'>{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>`;">
                @else
                    <div
                        class="w-16 h-16 rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-white text-2xl font-bold">
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
            <div
                class="bg-orange-50 border border-orange-200 rounded-2xl px-4 md:px-6 py-3 md:py-4 flex items-center gap-3 md:gap-4 shadow-sm hover:shadow-md transition-all duration-200 hover:bg-orange-100 cursor-pointer">

                <div
                    class="w-10 h-10 md:w-14 md:h-14 rounded-full bg-orange-100 flex items-center justify-center text-2xl md:text-3xl">
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

    </div>

</div>







