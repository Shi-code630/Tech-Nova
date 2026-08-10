<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Sales by Category
        </x-slot>

        @php
            $categories = $this->getCategoryData();
        @endphp

        @if($categories->count() > 0)
            <div class="space-y-3">
                @foreach($categories as $category)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $category->name }}
                            </span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                ${{ number_format($category->revenue, 2) }}
                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">
                                    ({{ $category->percentage }}%)
                                </span>
                            </span>
                        </div>
                        <div class="w-full h-2.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div
                                class="h-full rounded-full transition-all duration-500"
                                style="width: {{ $category->percentage }}%; background-color: {{ $category->color }};"
                            ></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-8 text-center">
                <div class="text-5xl mb-3">📊</div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">No Data Available</h4>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">No sales in this period</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
