<header>
    @if ($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="px-2 py-2 text-left">Order #</th>
                        <th class="px-2 py-2 text-left">Date</th>
                        <th class="px-2 py-2 text-left">Total</th>
                        <th class="px-2 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-2 py-2">#{{ $order->id }}</td>
                            <td class="px-2 py-2">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-2 py-2">Rs. {{ number_format($order->grand_total, 2) }}</td>
                            <td class="px-2 py-2">
                                <span
                                    class="px-2 py-1 text-xs rounded-full bg-{{ $order->order_status === 'delivered' ? 'green' : 'yellow' }}-100 text-{{ $order->order_status === 'delivered' ? 'green' : 'yellow' }}-800">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">No orders found</p>
    @endif
</header>
