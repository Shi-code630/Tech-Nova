<div class="filament-widgets-chart-widget relative h-[460px] flex">
    <div class="h-full w-full flex flex-col bg-slate-900 rounded-xl border border-slate-800 p-6 hover:border-slate-700 transition-all duration-300 shadow-xl">

        <!-- Header with Dynamic Metrics -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4 3 3m0 0l3 3m-3-3v3m-3 3h3m-3 3h3m-3-3h3"/>
                    </svg>
                    Sales Overview
                </h3>

                <div class="flex flex-wrap items-center gap-3 text-sm">
                    <span class="text-slate-400">Today's Sales</span>
                    <span class="font-semibold text-blue-400 text-lg">
                        Rs. {{ number_format($todaySales ?? 0) }}
                    </span>
                    <span class="text-xs text-slate-500">{{ $todayDate ?? now()->format('d M, Y') }}</span>

                    @if(isset($salesGrowth))
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium
                            {{ $salesGrowth['trend'] === 'up' ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $salesGrowth['trend'] === 'up' ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"/>
                            </svg>
                            {{ $salesGrowth['percentage'] }}%
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <!-- Total Orders -->
                <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-800 text-slate-300 text-sm font-medium border border-slate-700">
                    <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    {{ number_format($totalOrders ?? 0) }} Orders
                </span>

                <!-- Peak Sales -->
                @if(isset($peakSales) && $peakSales > 0)
                <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-800 text-slate-300 text-sm font-medium border border-slate-700">
                    <svg class="w-4 h-4 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    Peak: Rs. {{ number_format($peakSales) }}
                </span>
                @endif
            </div>
        </div>

        <!-- Chart (fills remaining space so card height matches OrdersByStatusChart) -->
        <div class="relative flex-1 min-h-0">
            <div class="h-full w-full">
                <canvas
                    x-ref="canvas"
                    x-data="{
                        chart: null,
                        init() {
                            this.chart = new Chart(this.$refs.canvas, {
                                type: 'line',
                                data: @js($chartData),
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: {{ $filter === 'year' ? 'true' : 'false' }},
                                            labels: {
                                                color: '#94a3b8',
                                                font: { size: 12, weight: '500' },
                                                usePointStyle: true,
                                                pointStyle: 'circle'
                                            }
                                        },
                                        tooltip: {
                                            backgroundColor: '#1e293b',
                                            titleColor: '#94a3b8',
                                            bodyColor: '#f1f5f9',
                                            borderColor: '#334155',
                                            borderWidth: 1,
                                            padding: 12,
                                            cornerRadius: 8,
                                            displayColors: false,
                                            callbacks: {
                                                label: function(context) {
                                                    if (context.parsed.y === 0) return 'No sales';
                                                    const label = context.dataset.label || 'Sales';
                                                    return label + ': Rs. ' + context.parsed.y.toLocaleString();
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            grid: { display: false },
                                            ticks: {
                                                color: '#94a3b8',
                                                font: { size: 12, weight: '500' },
                                                maxTicksLimit: {{ $this->getMaxTicksLimit() }}
                                            }
                                        },
                                        y: {
                                            beginAtZero: true,
                                            grid: { color: 'rgba(148, 163, 184, 0.08)' },
                                            ticks: {
                                                color: '#94a3b8',
                                                font: { size: 12, weight: '500' },
                                                stepSize: {{ $this->getDynamicStepSize() }},
                                                callback: function(value) {
                                                    if (value === 0) return 'Rs. 0';
                                                    if (value >= 10000000) return 'Rs. ' + (value/10000000) + 'Cr';
                                                    if (value >= 1000000) return 'Rs. ' + (value/1000000) + 'M';
                                                    if (value >= 1000) return 'Rs. ' + (value/1000) + 'K';
                                                    return 'Rs. ' + value;
                                                }
                                            }
                                        }
                                    },
                                    interaction: {
                                        intersect: false,
                                        mode: 'index'
                                    },
                                    animation: {
                                        duration: 750,
                                        easing: 'easeInOutQuart'
                                    }
                                }
                            });
                        }
                    }"
                ></canvas>
            </div>
        </div>

        <!-- Footer with Filter Buttons -->
        <div class="flex flex-wrap items-center justify-between mt-4 pt-4 border-t border-slate-800 gap-2">
            <div class="flex flex-wrap items-center gap-2">
                @php
                    $filters = [
                        'today' => 'Today',
                        'week' => 'Week',
                        'month' => 'Month',
                        'last_month' => 'Last Month',
                        'year' => 'Year',
                    ];
                @endphp

                @foreach($filters as $key => $label)
                    <button
                        wire:click="setFilter('{{ $key }}')"
                        class="px-3 py-1.5 text-xs font-medium rounded-lg transition-all duration-200
                            @if($this->filter === $key)
                                bg-blue-500/20 text-blue-400 border border-blue-500/30
                            @else
                                bg-slate-800 text-slate-400 hover:bg-slate-700 hover:text-slate-200 border border-transparent
                            @endif
                        "
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <div class="flex items-center gap-2 text-xs text-slate-500">
                <span>Updated: {{ now()->format('h:i A') }}</span>
                <button
                    wire:click="$refresh"
                    class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 transition-colors"
                >
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
