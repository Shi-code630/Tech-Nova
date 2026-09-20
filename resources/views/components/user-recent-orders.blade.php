<header>
    @if ($orders->count() > 0)
        <div class="overflow-x-auto -mx-2 px-2 sm:mx-0 sm:px-0">
            <table class="w-full min-w-[600px] text-xs sm:text-sm">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left font-semibold whitespace-nowrap">Order #</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left font-semibold whitespace-nowrap">Date</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left font-semibold whitespace-nowrap">Total</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left font-semibold whitespace-nowrap">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-2 sm:px-4 py-2 sm:py-3 whitespace-nowrap font-medium">
                                #{{ $order->id }}
                            </td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3 whitespace-nowrap text-gray-600">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3 whitespace-nowrap font-semibold">
                                Rs. {{ number_format($order->grand_total, 2) }}
                            </td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-[10px] sm:text-xs font-semibold rounded-full
                                             bg-{{ $order->order_status === 'delivered' ? 'green' : 'yellow' }}-100
                                             text-{{ $order->order_status === 'delivered' ? 'green' : 'yellow' }}-800">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-10">
            <p class="text-gray-500 text-sm">No orders found</p>
        </div>
    @endif
</header>
