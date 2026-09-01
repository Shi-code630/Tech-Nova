<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order - Tech Nova</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-5">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg">

        <div class="text-center border-b-2 border-green-500 pb-5">
            <h1 class="text-2xl font-bold text-green-500">🛒 Tech Nova</h1>
            <p class="text-lg text-gray-600">Order Tracking</p>
        </div>

        <div class="bg-gray-50 p-5 rounded-lg my-5 space-y-1">
            <p><span class="font-semibold">Order ID:</span> #{{ $order->order_number ?? $order->id }}</p>
            <p>
                <span class="font-semibold">Order Date:</span>
                @if($order->created_at)
                    {{ $order->created_at->format('d M Y, h:i A') }}
                @else
                    N/A
                @endif
            </p>
            <p><span class="font-semibold">Current Location:</span> <span class="text-blue-600 font-medium">📍 {{ $order->current_location ?? 'N/A' }}</span></p>
            <p>
                <span class="font-semibold">Status:</span>
                @php
                    $badgeColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'processing' => 'bg-blue-100 text-blue-800',
                        'shipped' => 'bg-indigo-100 text-indigo-800',
                        'delivered' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                    ];
                @endphp
                <span class="px-3 py-1 rounded-full text-sm {{ $badgeColors[$order->order_status] ?? 'bg-gray-100' }}">
                    {{ $order->status_label }}
                </span>
            </p>
            <p><span class="font-semibold">Grand Total:</span> Rs. {{ number_format($order->grand_total, 2) }}</p>
        </div>

        <!-- Timeline -->
        <div class="flex justify-between my-10 relative">
            <div class="absolute top-9 left-[10%] right-[10%] h-0.5 bg-gray-200 -z-0"></div>

            @php
                $steps = ['pending' => ['📦','Order Placed'], 'processing' => ['⚙️','Processing'], 'shipped' => ['🚚','Shipped'], 'delivered' => ['✅','Delivered']];
                $order_index = array_search($order->order_status, array_keys($steps));
            @endphp

            @foreach($steps as $key => [$icon, $label])
                @php
                    $stepIndex = array_search($key, array_keys($steps));
                    $isActive = $key === $order->order_status;
                    $isCompleted = $order->order_status !== 'cancelled' && $stepIndex < $order_index;
                @endphp
                <div class="flex-1 text-center relative z-10">
                    <div class="text-3xl inline-block rounded-full p-2 {{ ($isActive || $isCompleted) ? 'bg-green-500 text-white' : 'bg-white' }}">{{ $icon }}</div>
                    <div class="mt-2 text-sm font-bold {{ ($isActive || $isCompleted) ? 'text-green-600' : 'text-gray-500' }}">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        <!-- Location History -->
        <div class="bg-gray-50 p-5 rounded-lg my-5">
            <h3 class="font-semibold mb-3">📍 Tracking History</h3>
            @foreach($order->trackings as $track)
                <div class="border-l-2 {{ $loop->first ? 'border-green-500' : 'border-gray-200' }} pl-4 pb-4">
                    <p class="font-semibold text-sm">{{ $track->status_label ?? $track->status }}</p>
                    <p class="text-sm text-gray-600">{{ $track->location ?? 'N/A' }}</p>
                    @if($track->note)<p class="text-xs text-gray-400">{{ $track->note }}</p>@endif
                    <p class="text-xs text-gray-400">
                        @if($track->tracked_at)
                            {{ $track->tracked_at->format('d M Y, h:i A') }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            @endforeach
        </div>

        <!-- Order Items -->
        <div class="bg-gray-50 p-5 rounded-lg my-5">
            <h3 class="font-semibold mb-3">📦 Order Items</h3>
            @foreach($order->items as $item)
                <p class="text-sm py-1 border-b border-gray-100">{{ $item->product->name ?? 'Product' }} × {{ $item->quantity }} = Rs. {{ number_format($item->price * $item->quantity, 2) }}</p>
            @endforeach
        </div>

        <!-- ✅ Cancel Order Button -->
        @if(in_array($order->order_status, ['pending', 'processing']))
            <div class="text-center mt-4">
                <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to cancel this order?')">
                    @csrf
                    @method('PUT')
                    <button type="submit"
                            class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                        ❌ Cancel Order
                    </button>
                </form>
            </div>
        @endif

        <!-- Buttons -->
        <div class="text-center mt-4 flex justify-center gap-4">
            <a href="{{ url('/') }}" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                Continue Shopping
            </a>
        </div>

        <div class="text-center mt-8 pt-5 border-t text-gray-400 text-sm">
            © {{ date('Y') }} Tech Nova. All rights reserved.
        </div>
    </div>
</body>
</html>
