<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold text-gray-950 dark:text-white">
                {{ static::$heading }}
            </h2>

            <div x-data="{ open: false }" class="relative">
                <button
                    @click="open = !open"
                    @click.away="open = false"
                    type="button"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-600 bg-transparent border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-200 transition-colors"
                >
                    {{-- FIXED: Changed from getFiltersOptions to getFilterOptions --}}
                    {{ $this->getFilterOptions()[$this->filter] ?? 'Daily' }}
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50"
                    style="display: none;"
                >
                    <div class="py-1">
                        {{-- FIXED: Changed from getFiltersOptions to getFilterOptions --}}
                        @foreach ($this->getFilterOptions() as $value => $label)
                            <button
                                type="button"
                                wire:click="$set('filter', '{{ $value }}')"
                                @click="open = false"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ $this->filter === $value ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            >
                                @if ($this->filter === $value)
                                    <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <span class="w-4 h-4 mr-2"></span>
                                @endif
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @php
            $chartData = $this->getChartData();
            $hasData = isset($chartData['data']) && count($chartData['data']) > 0 && max($chartData['data']) > 0;
        @endphp

        @if($hasData)
            <div class="h-72">
                <canvas id="salesOverviewChart"></canvas>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="text-6xl mb-4">📊</div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">No Sales Data</h4>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">No sales data found for the selected period.</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($hasData)
            const ctx = document.getElementById('salesOverviewChart').getContext('2d');

            const chartData = @json($chartData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Sales',
                        data: chartData.data,
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rs. ' + context.parsed.y.toLocaleString('en-IN', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: chartData.max_value || 10000,
                            ticks: {
                                callback: function(value) {
                                    return 'Rs. ' + value.toLocaleString('en-IN');
                                }
                            }
                        }
                    }
                }
            });
        @endif
    });
</script>
@endpush
