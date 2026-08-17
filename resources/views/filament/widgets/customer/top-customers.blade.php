<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold text-gray-950 dark:text-white">
                {{ static::$heading }}
            </h2>

            
            @php $viewAllUrl = $this->getViewAllUrl(); @endphp

            @if ($viewAllUrl)
                <a
                    href="{{ $viewAllUrl }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-600 bg-transparent border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-200 transition-colors"
                >
                    View All
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span class="text-xs text-gray-400 dark:text-gray-500">
                    View All
                </span>
            @endif
        </div>

        @php
            $customers = $this->getCustomers();
            $avatarColors = [
                'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400',
                'bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400',
                'bg-green-50 text-green-600 dark:bg-green-500/10 dark:text-green-400',
                'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400',
                'bg-pink-50 text-pink-600 dark:bg-pink-500/10 dark:text-pink-400'
            ];
        @endphp

        <div class="-mx-6 -mb-6 overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-white/10">
                        <th class="px-6 py-2 text-left font-medium text-gray-500 dark:text-gray-400">Customer</th>
                        <th class="px-6 py-2 text-left font-medium text-gray-500 dark:text-gray-400">Orders</th>
                        <th class="px-6 py-2 text-right font-medium text-gray-500 dark:text-gray-400">Total Spent</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($customers as $index => $customer)
                        <tr>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-xs font-semibold {{ $avatarColors[$index % count($avatarColors)] }}">
                                        {{ $customer->initials ?? collect(explode(' ', $customer->name))->map(fn ($p) => strtoupper(substr($p, 0, 1)))->take(2)->implode('') }}
                                    </div>
                                    <span class="font-medium text-gray-950 dark:text-white">
                                        {{ $customer->name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-gray-700 dark:text-gray-300">
                                {{ number_format($customer->orders_count) }}
                            </td>
                            <td class="px-6 py-3 text-right font-medium text-gray-950 dark:text-white">
                                Rs{{ number_format($customer->total_spent ?? 0, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                                No customers with orders in this date range.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
