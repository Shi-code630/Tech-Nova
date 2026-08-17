<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between w-full">
                <span>Customers by Location</span>
                <!-- Optional: Add filter dropdown here if needed -->
            </div>
        </x-slot>

        @php
            $locations = $this->getLocationData();
            $totalCustomers = $locations->sum('total');
        @endphp

        @if($locations->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                            <th class="pb-3 font-medium text-xs uppercase tracking-wider">Location</th>
                            <th class="pb-3 font-medium text-xs uppercase tracking-wider text-center">Value</th>
                            <th class="pb-3 font-medium text-xs uppercase tracking-wider text-right">Percentage (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locations as $index => $location)
                            <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br {{ $location->color }} flex items-center justify-center text-white font-semibold text-xs shadow-sm">
                                            {{ substr($location->location, 0, 2) }}
                                        </div>
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            {{ $location->location }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($location->total) }}
                                    </span>
                                </td>
                                <td class="py-3 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <!-- Progress Bar -->
                                        <div class="w-24 h-2.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div
                                                class="h-full rounded-full transition-all duration-700 ease-out"
                                                style="width: {{ $location->percentage }}%; background: linear-gradient(90deg, #6366f1, #818cf8);"
                                            ></div>
                                        </div>
                                        <span class="font-semibold text-gray-900 dark:text-white min-w-[60px] text-right">
                                            {{ $location->percentage }}%
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gray-200 dark:border-gray-700">
                            <td class="py-3 font-semibold text-gray-900 dark:text-white">Total</td>
                            <td class="py-3 text-center font-semibold text-gray-900 dark:text-white">
                                {{ number_format($totalCustomers) }}
                            </td>
                            <td class="py-3 text-right font-semibold text-gray-900 dark:text-white">
                                100%
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Optional: Show summary stats below table -->
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 grid grid-cols-3 gap-4 text-center">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total Locations</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $locations->count() }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total Customers</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($totalCustomers) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Top Location</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $locations->first()->location ?? 'N/A' }}</p>
                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-8 text-center">
                <div class="text-5xl mb-3">📍</div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">No Location Data</h4>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">No customer location data available for the selected period.</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
