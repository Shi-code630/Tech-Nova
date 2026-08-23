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

</x-frontend-layout>
