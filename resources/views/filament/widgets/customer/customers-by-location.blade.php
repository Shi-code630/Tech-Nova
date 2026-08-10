<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Customers by Location
        </x-slot>

        @php
            $locations = $this->getLocationData();
        @endphp

        @if($locations->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                            <th class="pb-3 font-medium text-xs uppercase tracking-wider">Location</th>
                            <th class="pb-3 font-medium text-xs uppercase tracking-wider text-center">Customers</th>
                            <th class="pb-3 font-medium text-xs uppercase tracking-wider text-right">Percentage</th>
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
                                    <span class="inline-flex items-center justify-center px-3 py-0.5 rounded-full text-sm font-medium bg-primary-50 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">
                                        {{ $location->total }}
                                    </span>
                                </td>
                                <td class="py-3 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <div class="w-24 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div
                                                class="h-full rounded-full transition-all duration-500"
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
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="py-3 font-semibold text-gray-900 dark:text-white">Total</td>
                            <td class="py-3 text-center font-semibold text-gray-900 dark:text-white">
                                {{ $locations->sum('total') }}
                            </td>
                            <td class="py-3 text-right font-semibold text-gray-900 dark:text-white">
                                100%
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-8 text-center">
                <div class="text-5xl mb-3">📍</div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">No Location Data</h4>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">No customer location data available.</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
