<x-frontend-layout>

    <section class="bg-slate-100 w-full py-6 sm:py-8 min-h-screen">

        <div class="max-w-[1500px] mx-auto px-3 sm:px-4 md:px-6">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6">

                <!-- Sidebar -->
                <aside class="lg:col-span-3">
                    <x-user-dashboard.sidebar />
                </aside>


                <!-- Main Content -->
                <main class="lg:col-span-9 space-y-4 sm:space-y-6 min-w-0">

                    {{-- =====================================================
                        PAGE HEADER
                    ====================================================== --}}
                    <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">

                        <div class="flex items-center justify-between gap-3">

                            <div class="min-w-0">

                                <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-[#111827]">
                                    ⭐ My Coins
                                </h1>

                                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                    Track your reward points and transaction history
                                </p>

                            </div>

                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-yellow-50
                                        flex items-center justify-center flex-shrink-0">

                                <span class="text-2xl sm:text-3xl">⭐</span>

                            </div>

                        </div>

                    </div>


                    {{-- =====================================================
                        COIN SUMMARY CARDS
                    ====================================================== --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">

                        {{-- Available Coins --}}
                        <div
                            class="bg-gradient-to-r from-yellow-400 to-yellow-500
                                    rounded-xl shadow-sm p-4 text-white">

                            <p class="text-xs sm:text-sm font-medium text-yellow-100">
                                Available Coins
                            </p>

                            <p class="text-2xl sm:text-3xl font-bold" id="coin-available">
                                {{ number_format($coinSummary['available']) }}
                            </p>

                            <p class="text-[10px] sm:text-xs text-yellow-100 mt-1">
                                Value: Rs. {{ number_format($coinSummary['value'], 2) }}
                            </p>

                        </div>


                        {{-- Total Earned --}}
                        <div
                            class="bg-gradient-to-r from-green-400 to-green-500
                                    rounded-xl shadow-sm p-4 text-white">

                            <p class="text-xs sm:text-sm font-medium text-green-100">
                                Total Earned
                            </p>

                            <p class="text-2xl sm:text-3xl font-bold" id="coin-total-earned">
                                {{ number_format($coinSummary['total_earned']) }}
                            </p>

                            <p class="text-[10px] sm:text-xs text-green-100 mt-1">
                                Lifetime earnings
                            </p>

                        </div>


                        {{-- Total Redeemed --}}
                        <div
                            class="bg-gradient-to-r from-red-400 to-red-500
                                    rounded-xl shadow-sm p-4 text-white">

                            <p class="text-xs sm:text-sm font-medium text-red-100">
                                Total Redeemed
                            </p>

                            <p class="text-2xl sm:text-3xl font-bold" id="coin-total-redeemed">
                                {{ number_format($coinSummary['total_redeemed']) }}
                            </p>

                            <p class="text-[10px] sm:text-xs text-red-100 mt-1">
                                Coins used for discounts
                            </p>

                        </div>


                        {{-- Total Orders --}}
                        <div
                            class="bg-gradient-to-r from-blue-400 to-blue-500
                                    rounded-xl shadow-sm p-4 text-white">

                            <p class="text-xs sm:text-sm font-medium text-blue-100">
                                Total Orders
                            </p>

                            <p class="text-2xl sm:text-3xl font-bold">
                                {{ $totalOrders ?? 0 }}
                            </p>

                            <p class="text-[10px] sm:text-xs text-blue-100 mt-1">
                                Orders placed
                            </p>

                        </div>

                    </div>


                    {{-- =====================================================
                        RULES INFO
                    ====================================================== --}}
                    <div class="bg-white rounded-2xl shadow-sm p-3 sm:p-4 border border-gray-100">

                        <div
                            class="flex flex-wrap items-center justify-between gap-2
                                    text-xs sm:text-sm text-gray-600">

                            <span>
                                💰 <strong>Earn:</strong>
                                Rs.{{ $coinSummary['earn_rate'] ?? 100 }} = 1 Coin
                            </span>

                            <span>
                                🔄 <strong>Redeem:</strong>
                                {{ $coinSummary['redeem_rate'] ?? 20 }} Coins = Rs.1
                            </span>

                            <span>
                                📊 <strong>Max Discount:</strong>
                                {{ $coinSummary['max_discount_percent'] ?? 10 }}%
                            </span>

                        </div>

                    </div>


                    {{-- =====================================================
                        TRANSACTION HISTORY
                    ====================================================== --}}
                    <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">

                        <div class="flex items-center justify-between gap-2 mb-4">

                            <h2 class="text-base sm:text-lg font-semibold text-gray-800">
                                📋 Transaction History
                            </h2>

                            <span class="text-[10px] sm:text-xs text-gray-400 whitespace-nowrap">
                                {{ $transactions->total() }} transactions
                            </span>

                        </div>


                        @if ($transactions->count() > 0)

                            <div class="space-y-2">

                                @foreach ($transactions as $transaction)
                                    <div
                                        class="flex items-center justify-between gap-3
                                                p-3 rounded-lg border border-gray-100
                                                hover:bg-gray-50 transition">

                                        {{-- Left: Icon + Info --}}
                                        <div class="flex items-center gap-2 sm:gap-3 min-w-0">

                                            <span class="text-lg sm:text-xl flex-shrink-0">
                                                {{ $transaction->type === 'earned' ? '📈' : '📉' }}
                                            </span>

                                            <div class="min-w-0">

                                                <p class="text-xs sm:text-sm font-medium text-gray-800">
                                                    {{ $transaction->type === 'earned' ? 'Earned' : 'Redeemed' }}
                                                </p>

                                                <p class="text-[10px] sm:text-xs text-gray-500 truncate">
                                                    {{ $transaction->remarks ?? 'N/A' }}
                                                </p>

                                                @if ($transaction->order)
                                                    <p class="text-[10px] sm:text-xs text-gray-400 truncate">
                                                        Order: #{{ $transaction->order->order_number }}
                                                    </p>
                                                @endif

                                            </div>

                                        </div>


                                        {{-- Right: Points + Date --}}
                                        <div class="text-right flex-shrink-0">

                                            <p
                                                class="text-xs sm:text-sm font-bold
                                                      {{ $transaction->type === 'earned' ? 'text-green-600' : 'text-red-600' }}">

                                                {{ $transaction->type === 'earned' ? '+' : '-' }}{{ number_format($transaction->points) }}

                                            </p>

                                            <p class="text-[10px] sm:text-xs text-gray-400 whitespace-nowrap">
                                                {{ $transaction->created_at->format('d M Y, h:i A') }}
                                            </p>

                                        </div>

                                    </div>
                                @endforeach

                            </div>


                            {{-- Pagination --}}
                            <div class="mt-4 overflow-x-auto w-full">
                                {{ $transactions->links() }}
                            </div>
                        @else
                            <p class="text-sm text-gray-500 text-center py-6 sm:py-8">
                                No coin transactions yet.
                            </p>

                            <div class="text-center">
                                <a href="{{ route('home') }}" class="text-xs sm:text-sm text-blue-600 hover:underline">
                                    Start shopping to earn coins!
                                </a>
                            </div>

                        @endif

                    </div>

                </main>

            </div>

        </div>

    </section>


    {{-- =====================================================
        AUTO-REFRESH SCRIPT
    ====================================================== --}}
    <script>
        (function() {
            const POLL_INTERVAL_MS = 15000;

            async function refreshCoinSummary() {
                try {
                    const res = await fetch("{{ route('user.coins.live') }}", {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!res.ok) return;

                    const data = await res.json();
                    const s = data.coinSummary;

                    const els = {
                        available: document.getElementById('coin-available'),
                        totalEarned: document.getElementById('coin-total-earned'),
                        totalRedeemed: document.getElementById('coin-total-redeemed'),
                    };

                    if (els.available) els.available.textContent = Number(s.available).toLocaleString();
                    if (els.totalEarned) els.totalEarned.textContent = Number(s.total_earned).toLocaleString();
                    if (els.totalRedeemed) els.totalRedeemed.textContent = Number(s.total_redeemed)
                .toLocaleString();

                } catch (e) {
                    console.warn('Coin summary refresh failed', e);
                }
            }

            setInterval(refreshCoinSummary, POLL_INTERVAL_MS);
        })();
    </script>

</x-frontend-layout>
