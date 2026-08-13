{{-- resources/views/filament/widgets/low-stock-alert-widget.blade.php --}}

@php
    $products = $this->getLowStockProducts();
    $totalLowStock = $this->getLowStockCount();
    $threshold = $this->getThreshold();
@endphp

<x-filament-widgets::widget>
    <div class="rounded-2xl bg-white dark:bg-gray-900 p-6 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <x-filament::icon
                    icon="heroicon-o-exclamation-circle"
                    class="w-5 h-5 text-red-500 dark:text-red-400"
                />
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    Low Stock Alert
                </h3>
                @if ($totalLowStock > 0)
                    <span class="inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1 rounded-full bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 text-xs font-semibold">
                        {{ $totalLowStock }}
                    </span>
                @endif
            </div>

            <a
                href="{{ $this->getViewAllUrl() }}"
                class="inline-flex items-center rounded-lg border border-gray-200 dark:border-gray-700 px-3 py-1.5 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200"
            >
                View All
            </a>
        </div>

        {{-- List --}}
        @if ($products->isEmpty())
            <div class="flex flex-col items-center justify-center py-10 text-center">
                <x-filament::icon
                    icon="heroicon-o-check-circle"
                    class="w-10 h-10 text-green-500 dark:text-green-400 mb-2"
                />
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Nothing running low — all products are above {{ $threshold }} units.
                </p>
            </div>
        @else
            <ul class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($products as $product)
                    <li class="flex items-center gap-3 py-3">
                        {{-- Thumbnail or Icon --}}
                        <div class="w-10 h-10 rounded-full overflow-hidden shrink-0 bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            @if ($product->thumbnail_url)
                                <img
                                    src="{{ $product->thumbnail_url }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover"
                                    loading="lazy"
                                />
                            @else
                                <x-filament::icon
                                    icon="{{ $this->getProductIcon($product) }}"
                                    class="w-5 h-5 text-gray-400 dark:text-gray-500"
                                />
                            @endif
                        </div>

                        {{-- Name and stock --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ $product->name }}
                            </p>
                            <div class="flex items-center gap-2">
                                <p class="text-xs {{ $product->stock <= 0 ? 'text-red-600 font-semibold' : 'text-red-500' }}">
                                    Stock: {{ $product->stock }}
                                </p>
                                @if($product->category_name)
                                    <span class="text-xs text-gray-400 dark:text-gray-500">
                                        • {{ $product->category_name }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Status Badge --}}
                        <span class="shrink-0 inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                            {{ $product->stock <= 0 ? 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-400' }}">
                            <x-filament::icon
                                icon="{{ $product->stock <= 0 ? 'heroicon-o-x-circle' : 'heroicon-o-exclamation-triangle' }}"
                                class="w-3 h-3 mr-1"
                            />
                            {{ $product->stock_status }}
                        </span>
                    </li>
                @endforeach
            </ul>

            @if ($totalLowStock > $this->limit)
                <div class="mt-4 text-center">
                    <a
                        href="{{ $this->getViewAllUrl() }}"
                        class="text-sm text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300"
                    >
                        View all {{ $totalLowStock }} low stock items →
                    </a>
                </div>
            @endif
        @endif
    </div>
</x-filament-widgets::widget>
