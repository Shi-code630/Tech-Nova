<x-filament-panels::page>

    <div class="mb-6 flex justify-between gap-3">
        <div class="w-full sm:w-auto">
            {{ $this->filtersForm }}
        </div>
    </div>

    <x-filament-widgets::widgets :widgets="[\App\Filament\Widgets\Customer\CustomerStats::class]" :columns="5" />

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="h-full">
            @livewire(\App\Filament\Widgets\Customer\CustomerGrowthChart::class)
        </div>
        <div class="h-full">
            @livewire(\App\Filament\Widgets\Customer\CustomersByLocation::class)
        </div>
    </div>

    <div class="mt-6">
        @livewire(\App\Filament\Widgets\Customer\TopCustomers::class)
    </div>

</x-filament-panels::page>
