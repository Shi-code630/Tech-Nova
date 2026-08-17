<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold text-gray-700">
                {{ $this->getHeading() }}
            </h3>
            <a href="{{ OrdersResource::getUrl('index') }}"
               class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                View All →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 text-[11px] uppercase tracking-wider">
                        <th class="pb-3 font-medium">Product</th>
                        <th class="pb-3 font-medium text-center">Sold</th>
                        <th class="pb-3 font-medium text-right">Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($this->getTable()->getRecords() as $product)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-3 flex items-center gap-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         class="w-8 h-8 rounded-full object-cover"
                                         alt="{{ $product->name }}">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <span class="font-medium text-gray-700">{{ $product->name }}</span>
                            </td>
                            <td class="text-center text-gray-600">
                                {{ $product->sold_count ?? 0 }}
                            </td>
                            <td class="text-right font-medium text-gray-800">
                                Rs. {{ number_format($product->revenue ?? 0, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($this->getTable()->getRecords()->count() == 0)
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                <p class="mt-1 text-sm text-gray-500">Start adding products to see sales data.</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
