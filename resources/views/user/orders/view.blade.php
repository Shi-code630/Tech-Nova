<x-frontend-layout>

    <div class="max-w-6xl mx-auto px-4 py-10">

        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            Order Details
        </h1>

        <div class="bg-white rounded-xl shadow border border-gray-200 p-6">

            <div class="flex justify-between mb-6">
                <div>
                    <p class="text-sm text-gray-500">Order ID</p>
                    <p class="font-semibold">
                        #{{ $order->id }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-semibold">
                        {{ ucfirst($order->order_status) }}
                    </p>
                </div>
            </div>

            <h2 class="text-lg font-semibold mb-4">
                Products
            </h2>

            @foreach($items as $item)

                <div class="flex items-center gap-4 border-b py-4">

                    <div>
                        @if($item->product && $item->product->image)
                            <img
                                src="{{ asset('storage/' . $item->product->image) }}"
                                class="w-20 h-20 object-contain"
                            >
                        @endif
                    </div>

                    <div class="flex-1">
                        <h3 class="font-semibold">
                            {{ $item->product->name ?? 'Product' }}
                        </h3>

                        <p class="text-sm text-gray-500">
                            Quantity: {{ $item->quantity }}
                        </p>
                    </div>

                </div>

            @endforeach

        </div>

    </div>

</x-frontend-layout>
