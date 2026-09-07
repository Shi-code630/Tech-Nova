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

            @if ($order->canRequestReturnExchange() && $hasReturnableItems)
                <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 p-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-semibold text-blue-900">
                                Need to return or exchange an item?
                            </p>

                            <p class="mt-1 text-sm text-blue-700">
                                You can submit a request within 7 days of delivery.
                            </p>
                        </div>

                        <a href="{{ route('return-requests.create', $order) }}"
                            class="inline-flex justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                            Request Return / Exchange
                        </a>
                    </div>
                </div>
            @endif

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

                        @if ($item->returnRequests->isNotEmpty())
                            <div class="mt-3 space-y-2">
                                @foreach ($item->returnRequests as $returnRequest)
                                    @php
                                        $statusClass = match ($returnRequest->status) {
                                            'requested' => 'bg-yellow-100 text-yellow-800',
                                            'approved' => 'bg-blue-100 text-blue-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'received' => 'bg-indigo-100 text-indigo-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp

                                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm">
                                        <div class="flex flex-wrap items-center justify-between gap-2">
                                            <span class="font-medium text-gray-800">
                                                {{ $returnRequest->request_type_label }} request
                                                · Qty: {{ $returnRequest->quantity }}
                                            </span>

                                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                                {{ $returnRequest->status_label }}
                                            </span>
                                        </div>

                                        @if ($returnRequest->request_type === 'exchange' && $returnRequest->exchangeVariant)
                                            <p class="mt-2 text-xs text-gray-600">
                                                Replacement:
                                                {{ $returnRequest->exchangeVariant->color ?: 'Default color' }}
                                                {{ $returnRequest->exchangeVariant->size ?: '' }}
                                            </p>
                                        @endif

                                        @if ($returnRequest->admin_note)
                                            <p class="mt-2 text-xs text-gray-600">
                                                <span class="font-semibold">TechNova note:</span>
                                                {{ $returnRequest->admin_note }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</x-frontend-layout>
