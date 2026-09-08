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

                <x-user-dashboard.welcome-card :user="$user" />

                <x-user-dashboard.stats
                    :total-orders="$totalOrders"
                    :in-progress="$inProgress"
                    :wishlist-count="$wishlistCount"
                    :total-spent="$totalSpent"
                />

                {{-- ✅ Coin / Reward summary (ADD THIS) --}}
                <x-user-dashboard.coin-summary
                    :coin-summary="$coinSummary"
                    :recent-transactions="$recentTransactions"
                />

                <div class="grid grid-cols-3 gap-6">

                    <div class="col-span-2">
                        <x-user-dashboard.recent-orders :recent-orders="$recentOrders" />
                    </div>

                    <div>
                        <x-user-dashboard.saved-addresses :addresses="$addresses" />
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