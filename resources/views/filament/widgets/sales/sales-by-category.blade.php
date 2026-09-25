<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold text-gray-950 dark:text-white">
                {{ static::$heading }}
            </h2>

            <!-- Filter Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button
                    @click="open = !open"
                    @click.away="open = false"
                    type="button"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-600 bg-transparent border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-200 transition-colors"
                >
                    {{ $this->getFilters()[$this->filter] ?? 'This Month' }}
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
                    class="absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50"
                    style="display: none;"
                >
                    <div class="py-1">
                        @foreach ($this->getFilters() as $value => $label)
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
            $data = $this->getCategorySalesData();
            $hasData = !empty($data['categories']) && $data['total_sales'] > 0;
            $chartId = 'salesByCategoryChart-' . $this->getId();
        @endphp

        @if($hasData)
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
                <!-- Chart Column -->
                <div class="lg:col-span-3">
                    <div
                        wire:ignore
                        x-data="{
                            chart: null,
                            init() {
                                this.renderChart();
                                $wire.on('filterUpdated', () => {
                                    this.$nextTick(() => this.renderChart());
                                });
                            },
                            renderChart() {
                                const canvas = document.getElementById('{{ $chartId }}');
                                if (!canvas) return;

                                if (this.chart) {
                                    this.chart.destroy();
                                    this.chart = null;
                                }

                                const ctx = canvas.getContext('2d');

                                this.chart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: @js($data['labels']),
                                        datasets: [{
                                            label: 'Sales by Category',
                                            data: @js($data['data']),
                                            backgroundColor: @js($data['colors']),
                                            borderColor: @js($data['colors']),
                                            borderWidth: 1,
                                            borderRadius: 4,
                                            barThickness: 40,
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: { display: false },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        let label = context.dataset.label || '';
                                                        let value = context.parsed.y;
                                                        return label + ': Rs. ' + value.toLocaleString('en-IN', {
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
                                                ticks: {
                                                    callback: function(value) {
                                                        return 'Rs. ' + value.toLocaleString('en-IN');
                                                    },
                                                    font: { size: 10 }
                                                },
                                                grid: { color: 'rgba(0, 0, 0, 0.05)' }
                                            },
                                            x: {
                                                grid: { display: false },
                                                ticks: { font: { size: 10 } }
                                            }
                                        },
                                        animation: {
                                            duration: 1000,
                                            easing: 'easeOutQuart'
                                        }
                                    }
                                });
                            }
                        }"
                        x-init="init()"
                        class="h-[300px]"
                    >
                        <canvas id="{{ $chartId }}" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Categories List Column -->
                <div class="lg:col-span-2 space-y-2">
                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Categories
                    </div>
                    @foreach($data['categories'] as $category)
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $category['color'] }}"></div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $category['name'] }}
                                </span>
                            </div>
                            <div class="flex items-center gap-4 flex-shrink-0">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $category['formatted_sales'] }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 min-w-[45px] text-right">
                                    {{ $category['percentage'] }}%
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="text-6xl mb-4">📊</div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">No Sales Data</h4>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">No sales found for the selected period.</p>
            </div>
        @endif
    </x-filament::section>

    @script
    <script>
      
        if (typeof Chart === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
            script.onload = () => {
                window.dispatchEvent(new Event('chartjs-loaded'));
            };
            document.head.appendChild(script);
        } else {
            window.dispatchEvent(new Event('chartjs-loaded'));
        }
    </script>
    @endscript
</x-filament-widgets::widget>
