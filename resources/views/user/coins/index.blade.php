<x-frontend-layout>

    <section class="bg-slate-100 py-8 min-h-screen">

        <div class="max-w-[1500px] mx-auto px-6">

            <div class="grid grid-cols-12 gap-6">

                <!-- Sidebar -->
                <aside class="col-span-3">
                    <x-user-dashboard.sidebar />
                </aside>

                <!-- Main Content -->
                <main class="col-span-9 space-y-6">

                    {{-- Page Header --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-[#111827]">⭐ My Coins</h1>
                                <p class="text-sm text-gray-500 mt-1">
                                    Track your reward points and transaction history
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center">
                                <span class="text-3xl">⭐</span>
                            </div>
                        </div>
                    </div>

                    {{-- Coin Summary Cards --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-xl shadow-sm p-4 text-white">
                            <p class="text-sm font-medium text-yellow-100">Available Coins</p>
                            <p class="text-3xl font-bold" id="coin-available">
                                {{ number_format($coinSummary['available']) }}</p>
                            <p class="text-xs text-yellow-100 mt-1">Value: Rs.
                                {{ number_format($coinSummary['value'], 2) }}</p>
                        </div>

                        <div class="bg-gradient-to-r from-green-400 to-green-500 rounded-xl shadow-sm p-4 text-white">
                            <p class="text-sm font-medium text-green-100">Total Earned</p>
                            <p class="text-3xl font-bold" id="coin-total-earned">
                                {{ number_format($coinSummary['total_earned']) }}</p>
                            <p class="text-xs text-green-100 mt-1">Lifetime earnings</p>
                        </div>



                        <div class="bg-gradient-to-r from-red-400 to-red-500 rounded-xl shadow-sm p-4 text-white">
                            <p class="text-sm font-medium text-red-100">Total Redeemed</p>
                            <p class="text-3xl font-bold" id="coin-total-redeemed">
                                {{ number_format($coinSummary['total_redeemed']) }}</p>
                            <p class="text-xs text-red-100 mt-1">Coins used for discounts</p>
                        </div>

                        <div class="bg-gradient-to-r from-blue-400 to-blue-500 rounded-xl shadow-sm p-4 text-white">
                            <p class="text-sm font-medium text-blue-100">Total Orders</p>
                            <p class="text-3xl font-bold">{{ $totalOrders ?? 0 }}</p>
                            <p class="text-xs text-blue-100 mt-1">Orders placed</p>
                        </div>
                    </div>

                    {{-- Rules Info --}}
                    <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100">
                        <div class="flex flex-wrap items-center justify-between gap-2 text-sm text-gray-600">
                            <span>💰 <strong>Earn:</strong> Rs.{{ $coinSummary['earn_rate'] ?? 100 }} = 1 Coin</span>
                            <span>🔄 <strong>Redeem:</strong> {{ $coinSummary['redeem_rate'] ?? 20 }} Coins =
                                Rs.1</span>
                            <span>📊 <strong>Max Discount:</strong>
                                {{ $coinSummary['max_discount_percent'] ?? 10 }}%</span>
                        </div>
                    </div>

                    {{-- Transaction History --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">📋 Transaction History</h2>
                            <span class="text-xs text-gray-400">{{ $transactions->total() }} transactions</span>
                        </div>

                        @if ($transactions->count() > 0)
                            <div class="space-y-2">
                                @foreach ($transactions as $transaction)
                                    <div
                                        class="flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition">
                                        <div class="flex items-center gap-3">
                                            <span class="text-xl">
                                                {{ $transaction->type === 'earned' ? '📈' : '📉' }}
                                            </span>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">
                                                    {{ $transaction->type === 'earned' ? 'Earned' : 'Redeemed' }}
                                                </p>
                                                <p class="text-xs text-gray-500">{{ $transaction->remarks ?? 'N/A' }}
                                                </p>
                                                @if ($transaction->order)
                                                    <p class="text-xs text-gray-400">Order:
                                                        #{{ $transaction->order->order_number }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p
                                                class="text-sm font-bold {{ $transaction->type === 'earned' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $transaction->type === 'earned' ? '+' : '-' }}{{ number_format($transaction->points) }}
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                {{ $transaction->created_at->format('d M Y, h:i A') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Pagination --}}
                            <div class="mt-4">
                                {{ $transactions->links() }}
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">No coin transactions yet.</p>
                            <div class="text-center">
                                <a href="{{ route('home') }}" class="text-blue-600 hover:underline text-sm">
                                    Start shopping to earn coins!
                                </a>
                            </div>
                        @endif
                    </div>

                </main>

            </div>

        </div>

    </section>

    {{-- Auto-refresh coin summary every 15 seconds --}}
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
