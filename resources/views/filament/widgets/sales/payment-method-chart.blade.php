<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Sales by Payment Method
        </x-slot>

        @php
            $breakdown = $this->getBreakdown();
        @endphp

        <div
            x-data="{
                chart: null,
                init() {
                    this.renderChart();
                    Livewire.hook('morph.updated', ({ component }) => {
                        if (component.id === {{ Js::from($this->getId()) }}) {
                            this.renderChart();
                        }
                    });
                },
                async renderChart() {
                    if (typeof window.Chart === 'undefined') {
                        await new Promise((resolve) => {
                            const script = document.createElement('script');
                            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js';
                            script.onload = resolve;
                            document.head.appendChild(script);
                        });
                    }

                    const data = {{ Js::from($breakdown->pluck('amount')->all()) }};
                    const colors = {{ Js::from($breakdown->pluck('color')->all()) }};
                    const labels = {{ Js::from($breakdown->pluck('label')->all()) }};

                    if (this.chart) {
                        this.chart.destroy();
                    }

                    this.chart = new window.Chart(this.$refs.canvas.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: data,
                                backgroundColor: colors,
                                borderWidth: 0,
                            }],
                        },
                        options: {
                            cutout: '68%',
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: (ctx) => ' ' + ctx.label + ': ' + ctx.formattedValue,
                                    },
                                },
                            },
                        },
                    });
                },
            }"
            wire:ignore
            class="flex flex-col items-center gap-6 sm:flex-row sm:items-center"
        >
            <div class="relative h-48 w-48 shrink-0">
                <canvas x-ref="canvas"></canvas>
            </div>

            <ul class="w-full space-y-4">
                @forelse ($breakdown as $item)
                    <li class="flex items-center gap-3">
                        <span
                            class="h-2.5 w-2.5 shrink-0 rounded-full"
                            style="background-color: {{ $item['color'] }}"
                        ></span>

                        <div class="flex flex-1 flex-col">
                            <span class="text-sm font-medium text-gray-950 dark:text-white">
                                {{ $item['label'] }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Rs{{ number_format($item['amount'], 2) }} ({{ $item['percentage'] }}%)
                            </span>
                        </div>
                    </li>
                @empty
                    <li class="text-sm text-gray-500 dark:text-gray-400">
                        No orders in this date range.
                    </li>
                @endforelse
            </ul>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
