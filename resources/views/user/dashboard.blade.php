<x-frontend-layout>
    <section class="bg-slate-100 min-h-screen py-8">
        <div class="Container mx-auto">

            {{-- ✅ FIX: was `flex flex-col lg:flex-row`, but the aside/main
                 below use `col-span-3` / `col-span-9` — those utilities only
                 work inside a `grid` container, not a `flex` one. Switched
                 back to `grid grid-cols-12` so the sidebar/main split
                 actually applies (matches the rest of the dashboard). --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Sidebar -->
                <aside class="lg:col-span-3">
                    <x-user-dashboard.sidebar />
                </aside>

                <!-- Main Content -->
                <main class="lg:col-span-9 space-y-6">

                    <x-user-dashboard.welcome-card :user="$user" />

                    <x-user-dashboard.stats
                        :total-orders="$totalOrders"
                        :in-progress="$inProgress"
                        :wishlist-count="$wishlistCount"
                        :total-spent="$totalSpent"
                    />


                    <x-user-dashboard.coin-summary
                        :coin-summary="$coinSummary"
                        :recent-transactions="$recentTransactions"
                    />

                    <div class="grid grid-cols-1 md:grid-cols- gap-6">

                        <div class="md:col-span-2">
                            <x-user-dashboard.recent-orders :recent-orders="$recentOrders" />
                        </div>



                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <x-user-dashboard.recently-viewed />
                        <x-user-dashboard.recommended-products />
                    </div>

                </main>

            </div>

        </div>
    </section>

    {{-- Auto-refresh coin summary every 15 seconds --}}
    <script>
        (function () {
            const POLL_INTERVAL_MS = 15000;

            async function refreshCoinSummary() {
                try {
                    const res = await fetch("{{ route('user.coins.live') }}", {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (!res.ok) return;

                    const data = await res.json();
                    const s = data.coinSummary;

                    const els = {
                        available: document.getElementById('coin-available'),
                        value: document.getElementById('coin-value'),
                        totalEarned: document.getElementById('coin-total-earned'),
                        totalRedeemed: document.getElementById('coin-total-redeemed'),
                    };

                    if (els.available) els.available.textContent = Number(s.available).toLocaleString();
                    if (els.value) els.value.textContent = Number(s.value).toFixed(2);
                    if (els.totalEarned) els.totalEarned.textContent = Number(s.total_earned).toLocaleString();
                    if (els.totalRedeemed) els.totalRedeemed.textContent = Number(s.total_redeemed).toLocaleString();
                } catch (e) {
                    console.warn('Coin summary refresh failed', e);
                }
            }

            setInterval(refreshCoinSummary, POLL_INTERVAL_MS);
        })();
    </script>
</x-frontend-layout>
