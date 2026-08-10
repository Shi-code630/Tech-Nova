<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Date Range Filter - Like your image --}}
        <div class="flex flex-wrap items-center gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From</label>
                <div class="w-full sm:w-auto">
                    {{ $this->filtersForm }}
                </div>
            </div>
        </div>


        <x-filament-widgets::widgets :widgets="$this->getHeaderWidgets()" :columns="5" />


        <div class="bg-white dark:bg-gray-800 rounded-xl p-4">
            @livewire(\App\Filament\Widgets\Product\TopSellingProducts::class, ['filters' => $filters ?? []])
        </div>


        <div class="bg-white dark:bg-gray-800 rounded-xl p-4">
            @livewire(\App\Filament\Widgets\Product\SalesByCategory::class, ['filters' => $filters ?? []])
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-4">
            @livewire(\App\Filament\Widgets\Product\LowStockProducts::class)
        </div>
    </div>
</x-filament-panels::page>
