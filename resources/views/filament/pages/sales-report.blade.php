<x-filament-panels::page>
    <div class="mb-6 flex justify-between gap-3">
        <div class="w-full sm:w-auto">
            {{ $this->filtersForm }}
        </div>
    </div>

    <x-filament-widgets::widgets
        :widgets="[\App\Filament\Widgets\Sales\SalesStats::class]"
        :columns="4"
    />

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            @livewire(\App\Filament\Widgets\Sales\SalesOverviewChart::class)
        </div>
        <div>

            @livewire(\App\Filament\Widgets\Sales\SalesByPaymentMethod::class)
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div>
            @livewire(\App\Filament\Widgets\Sales\TopSellingProducts::class)
        </div>
        <div>
            @livewire(\App\Filament\Widgets\Sales\SalesByCategory::class)
        </div>
    </div>
</x-filament-panels::page>
