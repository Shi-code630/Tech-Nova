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
                    {{-- FIXED: Use getFilterOptions() instead of getFiltersOptions() --}}
                    {{ $this->getFilterOptions()[$this->filter] ?? 'This Month' }}
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
                        {{-- FIXED: Use getFilterOptions() instead of getFiltersOptions() --}}
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
            $data = $this->getPaymentMethodData();
            $hasData = !empty($data['payment_methods']) && $data['total_sales'] > 0;
        @endphp

        @if($hasData)
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
                <!-- Chart Column -->
                <div class="lg:col-span-2">
                    <div class="h-[300px]">
                        <canvas id="paymentMethodChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Payment Methods List Column -->
                <div class="lg:col-span-3">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                    <th class="pb-3 font-medium text-xs uppercase tracking-wider">Payment Method</th>
                                    <th class="pb-3 font-medium text-xs uppercase tracking-wider text-right">Sales (Rs.)</th>
                                    <th class="pb-3 font-medium text-xs uppercase tracking-wider text-right">Percentage (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['payment_methods'] as $method)
                                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="py-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full {{ $method['bg_color'] }} flex items-center justify-center {{ $method['text_color'] }}">
                                                    <x-filament::icon
                                                        :icon="$method['icon']"
                                                        class="w-4 h-4"
                                                    />
                                                </div>
                                                <span class="font-medium text-gray-900 dark:text-white">
                                                    {{ $method['method'] }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3 text-right font-semibold text-gray-900 dark:text-white">
                                            {{ $method['formatted_sales'] }}
                                        </td>
                                        <td class="py-3 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <div class="w-24 h-2.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                                    <div
                                                        class="h-full rounded-full transition-all duration-700 ease-out"
                                                        style="width: {{ $method['percentage'] }}%; background-color: {{ $method['color'] }};"
                                                    ></div>
                                                </div>
                                                <span class="font-semibold text-gray-900 dark:text-white min-w-[60px] text-right">
                                                    {{ $method['percentage'] }}%
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-gray-200 dark:border-gray-700">
                                    <td class="py-3 font-semibold text-gray-900 dark:text-white">Total</td>
                                    <td class="py-3 text-right font-semibold text-gray-900 dark:text-white">
                                        Rs. {{ number_format($data['total_sales'], 2) }}
                                    </td>
                                    <td class="py-3 text-right font-semibold text-gray-900 dark:text-white">
                                        100%
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="text-6xl mb-4">💳</div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">No Payment Data</h4>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">No payment data found for the selected period.</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($hasData)
            const ctx = document.getElementById('paymentMethodChart').getContext('2d');

            const chartData = {
                labels: @json($data['labels']),
                datasets: [{
                    data: @json($data['data']),
                    backgroundColor: @json($data['colors']),
                    borderColor: @json($data['colors']),
                    borderWidth: 2,
                    borderRadius: 4,
                }]
            };

            new Chart(ctx, {
                type: 'doughnut',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: {
                                    size: 12,
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed || 0;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return label + ': Rs. ' + value.toLocaleString('en-IN', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }) + ' (' + percentage + '%)';
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        @endif
    });
</script>
@endpush
