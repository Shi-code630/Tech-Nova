@php
    $data = $this->getStatusData();
    $total = $data['total'];
    $statuses = $data['statuses'];
@endphp

<x-filament-widgets::widget>
    <div
        class="h-[460px] flex flex-col rounded-2xl bg-white dark:bg-gray-900 p-6 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10"
        x-data="ordersByStatusChart({{ Illuminate\Support\Js::from($statuses) }}, {{ $total }})"
        x-init="init()"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                Orders by Status
            </h3>

            <div class="relative" x-data="{ open: false }">
                <button
                    type="button"
                    @click="open = !open"
                    @click.outside="open = false"
                    class="inline-flex items-center gap-1 rounded-lg border border-gray-200 dark:border-gray-700 px-3 py-1.5 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800"
                >
                    This Month
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div
                    x-show="open"
                    x-cloak
                    class="absolute right-0 z-10 mt-2 w-36 rounded-lg bg-white dark:bg-gray-800 shadow-lg ring-1 ring-gray-950/5 dark:ring-white/10 py-1"
                >
                    <button type="button" class="block w-full px-3 py-1.5 text-left text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">This Week</button>
                    <button type="button" class="block w-full px-3 py-1.5 text-left text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">This Month</button>
                    <button type="button" class="block w-full px-3 py-1.5 text-left text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">This Year</button>
                </div>
            </div>
        </div>

        {{-- Body: chart + legend (fills remaining space so card height matches SalesOverviewChart) --}}
        <div class="flex-1 flex items-center justify-between gap-6">
           
            <div class="relative w-40 h-40 shrink-0">
                <canvas x-ref="canvas"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($total) }}
                    </span>
                    <span class="text-xs text-gray-400 dark:text-gray-500">
                        Total Orders
                    </span>
                </div>
            </div>

            {{-- Legend --}}
            <ul class="flex-1 space-y-3">
                @foreach ($statuses as $status)
                    <li class="flex items-center gap-2 text-sm">
                        <span
                            class="w-2.5 h-2.5 rounded-full shrink-0"
                            style="background-color: {{ $status['color'] }}"
                        ></span>
                        <span class="text-gray-500 dark:text-gray-400 flex-1">
                            {{ $status['label'] }}
                        </span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ $status['percent'] }}%
                        </span>
                        <span class="text-gray-400 dark:text-gray-500">
                            ({{ $status['count'] }})
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @once
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
            <script>
                function ordersByStatusChart(statuses, total) {
                    return {
                        chart: null,
                        init() {
                            const ctx = this.$refs.canvas.getContext('2d');

                            this.chart = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: statuses.map(s => s.label),
                                    datasets: [{
                                        data: statuses.map(s => s.count),
                                        backgroundColor: statuses.map(s => s.color),
                                        borderWidth: 0,
                                        hoverOffset: 4,
                                    }],
                                },
                                options: {
                                    cutout: '72%',
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: { display: false },
                                        tooltip: {
                                            callbacks: {
                                                label: (item) => {
                                                    const pct = total > 0 ? Math.round((item.raw / total) * 100) : 0;
                                                    return ` ${item.label}: ${item.raw} (${pct}%)`;
                                                },
                                            },
                                        },
                                    },
                                },
                            });
                        },
                    };
                }
            </script>
        @endpush
    @endonce
</x-filament-widgets::widget>
