<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Date Range Filter --}}
        <div >
            <div class="flex flex-wrap items-center gap-6">
                <div class="mb-6 flex justify-between gap-3">
                    <div class="w-full sm:w-auto">
                        {{ $this->filtersForm }}
                    </div>
                </div>

                @php
                    $startDate = $filters['startDate'] ?? now()->subDays(30)->format('M d, Y');
                    $endDate = $filters['endDate'] ?? now()->format('M d, Y');
                @endphp

            </div>
        </div>


        <x-filament-widgets::widgets :widgets="$this->getHeaderWidgets()" :columns="5" />


        <div >
            @livewire(\App\Filament\Widgets\Product\TopSellingProducts::class, ['filters' => $filters ?? []])
        </div>


        <div class="bg-white dark:bg-[#1a1a1a] rounded-xl p-4">
            @livewire(\App\Filament\Widgets\Product\SalesByCategory::class, ['filters' => $filters ?? []])
        </div>


        <div >
            @livewire(\App\Filament\Widgets\Product\LowStockProducts::class)
        </div>
    </div>
</x-filament-panels::page>
