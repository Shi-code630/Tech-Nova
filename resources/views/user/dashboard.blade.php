<x-frontend-layout title="Dashboard">

    <section class="bg-slate-100 w-full min-h-screen py-6 sm:py-8">

        <div class="Container mx-auto px-3 sm:px-4">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6">

                <!-- Sidebar -->
                <aside class="lg:col-span-3">
                    <x-user-dashboard.sidebar />
                </aside>


                <!-- Main Content -->
                <main class="lg:col-span-9 space-y-4 sm:space-y-6 min-w-0">

                    {{-- Welcome Card --}}
                    <x-user-dashboard.welcome-card :user="$user" />


                    {{-- Stats --}}
                    <x-user-dashboard.stats :total-orders="$totalOrders" :in-progress="$inProgress" :wishlist-count="$wishlistCount" :total-spent="$totalSpent" />


                    {{-- Coin Summary --}}
                    <x-user-dashboard.coin-summary :coin-summary="$coinSummary" :recent-transactions="$recentTransactions" />


                    {{-- Recent Orders --}}
                    <div class="grid grid-cols-1 gap-4 sm:gap-6">

                        <div>
                            <x-user-dashboard.recent-orders :recent-orders="$recentOrders" />
                        </div>

                    </div>


                    {{-- Recently Viewed + Recommended --}}
                    <div class="grid grid-cols-1 gap-4 sm:gap-6">

                       <x-user-dashboard.recently-viewed
    :recently-viewed-products="$recentlyViewedProducts"
/>

                        <x-user-dashboard.recommended-products />

                    </div>

                </main>

            </div>

        </div>

    </section>


    {{-- =============================================================
        AUTO-REFRESH SCRIPT (unchanged)
    ============================================================== --}}
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
                        value: document.getElementById('coin-value'),
                        totalEarned: document.getElementById('coin-total-earned'),
                        totalRedeemed: document.getElementById('coin-total-redeemed'),
                    };

                    if (els.available) els.available.textContent = Number(s.available).toLocaleString();
                    if (els.value) els.value.textContent = Number(s.value).toFixed(2);
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
