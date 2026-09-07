<x-frontend-layout>
    <div class="max-w-3xl mx-auto px-4 py-10">
        <div class="mb-6">
            <a href="{{ route('user.order.view', $order) }}"
                class="text-sm font-medium text-blue-600 hover:text-blue-700">
                ← Back to order details
            </a>

            <h1 class="mt-3 text-2xl font-bold text-gray-900">
                Request Return or Exchange
            </h1>

            <p class="mt-2 text-sm text-gray-600">
                Order #{{ $order->order_number }} · Requests are accepted within 7 days of delivery.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
            action="{{ route('return-requests.store', $order) }}"
            enctype="multipart/form-data"
            class="space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            @csrf

            <div>
                <label for="order_item_id" class="mb-2 block text-sm font-semibold text-gray-700">
                    Select product
                </label>

                <select id="order_item_id"
                    name="order_item_id"
                    onchange="updateRequestForm()"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    required>

                    <option value="">Choose a product</option>

                    @foreach ($order->items as $item)
                        <option value="{{ $item->id }}"
                            data-quantity="{{ $item->quantity }}"
                            @selected(old('order_item_id') == $item->id)>

                            {{ $item->product?->name ?? 'Product' }}
                            @if ($item->variant)
                                — {{ $item->variant->color }} {{ $item->variant->size }}
                            @endif
                            (Purchased: {{ $item->quantity }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <p class="mb-2 text-sm font-semibold text-gray-700">
                    Request type
                </p>

                <div class="flex gap-5">
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="radio"
                            name="request_type"
                            value="return"
                            onchange="toggleExchangeFields()"
                            @checked(old('request_type', 'return') === 'return')>
                        Return
                    </label>

                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="radio"
                            name="request_type"
                            value="exchange"
                            onchange="toggleExchangeFields()"
                            @checked(old('request_type') === 'exchange')>
                        Exchange
                    </label>
                </div>
            </div>

            <div id="exchange-fields" class="hidden">
                <label for="exchange_variant_id" class="mb-2 block text-sm font-semibold text-gray-700">
                    Replacement variant
                </label>

                <select id="exchange_variant_id"
                    name="exchange_variant_id"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                    <option value="">Choose a replacement color / size</option>

                    @foreach ($order->items as $item)
                        @foreach ($item->product?->variants ?? [] as $variant)
                            @if ($variant->status && $variant->stock > 0)
                                <option value="{{ $variant->id }}"
                                    data-order-item="{{ $item->id }}"
                                    @selected(old('exchange_variant_id') == $variant->id)>

                                    {{ $item->product->name }} —
                                    {{ $variant->color ?: 'Default color' }}
                                    {{ $variant->size ?: '' }}
                                    (Stock: {{ $variant->stock }})
                                </option>
                            @endif
                        @endforeach
                    @endforeach
                </select>

                <p class="mt-1 text-xs text-gray-500">
                    Only available variants of the selected product are shown.
                </p>
            </div>

            <div>
                <label for="quantity" class="mb-2 block text-sm font-semibold text-gray-700">
                    Quantity
                </label>

                <input id="quantity"
                    type="number"
                    name="quantity"
                    value="{{ old('quantity', 1) }}"
                    min="1"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    required>
            </div>

            <div>
                <label for="reason" class="mb-2 block text-sm font-semibold text-gray-700">
                    Reason
                </label>

                <textarea id="reason"
                    name="reason"
                    rows="5"
                    maxlength="2000"
                    placeholder="Explain why you want to return or exchange this item."
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    required>{{ old('reason') }}</textarea>
            </div>

            <div>
                <label for="image" class="mb-2 block text-sm font-semibold text-gray-700">
                    Photo proof <span class="font-normal text-gray-500">(optional)</span>
                </label>

                <input id="image"
                    type="file"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    class="block w-full text-sm text-gray-600">

                <p class="mt-1 text-xs text-gray-500">
                    JPG, PNG, or WEBP only. Maximum size: 5 MB.
                </p>
            </div>

            <button type="submit"
                class="w-full rounded-lg bg-blue-600 px-4 py-3 font-semibold text-white transition hover:bg-blue-700">
                Submit Request
            </button>
        </form>
    </div>

    <script>
        function toggleExchangeFields() {
            const isExchange = document.querySelector(
                'input[name="request_type"]:checked'
            )?.value === 'exchange';

            const exchangeFields = document.getElementById('exchange-fields');
            const exchangeVariant = document.getElementById('exchange_variant_id');

            exchangeFields.classList.toggle('hidden', !isExchange);
            exchangeVariant.required = isExchange;
        }

        function updateRequestForm() {
            const orderItem = document.getElementById('order_item_id');
            const selectedOption = orderItem.options[orderItem.selectedIndex];
            const selectedItemId = orderItem.value;
            const quantityInput = document.getElementById('quantity');
            const exchangeVariant = document.getElementById('exchange_variant_id');

            quantityInput.max = selectedOption?.dataset.quantity || 1;

            if (Number(quantityInput.value) > Number(quantityInput.max)) {
                quantityInput.value = quantityInput.max;
            }

            Array.from(exchangeVariant.options).forEach(function (option) {
                if (!option.value) {
                    return;
                }

                option.hidden = option.dataset.orderItem !== selectedItemId;

                if (option.hidden && option.selected) {
                    exchangeVariant.value = '';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            toggleExchangeFields();
            updateRequestForm();
        });
    </script>
</x-frontend-layout>
