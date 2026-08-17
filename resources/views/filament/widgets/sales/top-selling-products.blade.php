<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-950 dark:text-white">
                Top Selling Products
            </h2>

            @if (\Illuminate\Support\Facades\Route::has('filament.resources.products.index'))
                <a
                    href="{{ route('filament.resources.products.index') }}"
                    class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                >
                    View All
                </a>
            @endif
        </div>

        @php
            $products = $this->getProducts();
        @endphp

        <div class="mt-4 -mx-6 -mb-6 overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-white/10">
                        <th class="px-6 py-2 text-left font-medium text-gray-500 dark:text-gray-400">Product</th>
                        <th class="px-6 py-2 text-left font-medium text-gray-500 dark:text-gray-400">Sold</th>
                        <th class="px-6 py-2 text-right font-medium text-gray-500 dark:text-gray-400">Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($product->image)
                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="h-9 w-9 shrink-0 rounded-full object-cover"
                                        />
                                    @else
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-xs font-semibold text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                            {{ strtoupper(substr($product->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <span class="font-medium text-gray-950 dark:text-white">
                                        {{ $product->name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-gray-700 dark:text-gray-300">
                                {{ number_format($product->units_sold) }}
                            </td>
                            <td class="px-6 py-3 text-right font-medium text-gray-950 dark:text-white">
                                Rs{{ number_format($product->revenue, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                                No products sold in this date range.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
