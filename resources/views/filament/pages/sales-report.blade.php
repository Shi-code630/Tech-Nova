<x-filament-panels::page>

    {{-- Date range filter, rendered above the widgets --}}
    <div class="mb-6 flex justify-between gap-3">
        <div class="w-full sm:w-auto">
            {{ $this->filtersForm }}
        </div>
    </div>

    {{-- Header widgets: the 4 stat cards --}}
    <x-filament-widgets::widgets
        :widgets="[\App\Filament\Widgets\Sales\SalesStats::class]"
        :columns="4"
    />

    {{-- Sales overview + payment method breakdown --}}
    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            @livewire(\App\Filament\Widgets\Sales\SalesOverviewChart::class)
        </div>
        <div>
            @livewire(\App\Filament\Widgets\Sales\PaymentMethodChart::class)
        </div>
    </div>

    {{-- Top selling products + sales by category --}}
    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div>
            @livewire(\App\Filament\Widgets\Sales\TopSellingProducts::class)
        </div>
        <div>
            @livewire(\App\Filament\Widgets\Sales\SalesByCategory::class)
        </div>
    </div>

</x-filament-panels::page>
