<x-frontend-layout>

    <div class="bg-gray-100 py-8">

        <div class="Container mx-auto px-4">

            {{-- Header --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

                <h1 class="text-2xl font-bold text-gray-900">
                    Review Your Order
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Order #{{ $order->order_number }}
                </p>

            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl bg-green-50 border border-green-200 p-4">
                    <p class="text-green-700 text-sm font-medium">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">
                    <p class="text-red-700 text-sm font-medium">
                        {{ session('error') }}
                    </p>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">

                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>
            @endif

            {{-- Products --}}
            @forelse($order->items as $item)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-5">

                    <div class="flex items-center gap-4">

                        {{-- Product Image --}}
                        <div class="w-20 h-20 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0">

                            @if ($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                    alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">
                                    No Image
                                </div>
                            @endif

                        </div>

                        {{-- Product Info --}}
                        <div class="flex-1">

                            <h2 class="text-lg font-bold text-gray-900">
                                {{ $item->product->name ?? 'Product' }}
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Quantity: {{ $item->quantity }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Price: Rs. {{ number_format($item->price, 2) }}
                            </p>

                        </div>

                    </div>

                    {{-- Review Form --}}
                    <form
    action="{{ route('orders.review.submit', $order) }}"
    method="POST"
    class="mt-6"
>
    @csrf

    <input
        type="hidden"
        name="product_id"
        value="{{ $item->product_id }}"
    >

    {{-- Rating --}}
    <div class="mb-5">

        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Your Rating
        </label>

        <select
            name="rating"
            required
            class="w-full rounded-xl border border-gray-300 px-4 py-3
                   focus:border-blue-500 focus:ring-blue-500"
        >
            <option value="">Select Rating</option>

            <option value="5">★★★★★ — Excellent</option>
            <option value="4">★★★★☆ — Very Good</option>
            <option value="3">★★★☆☆ — Good</option>
            <option value="2">★★☆☆☆ — Fair</option>
            <option value="1">★☆☆☆☆ — Poor</option>
        </select>

    </div>

    {{-- Review --}}
    <div class="mb-5">

        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Your Review
        </label>

        <textarea
            name="review"
            rows="4"
            class="w-full rounded-xl border border-gray-300 px-4 py-3
                   focus:border-blue-500 focus:ring-blue-500"
            placeholder="Write your review..."
        >{{ old('review') }}</textarea>

    </div>

    <button
        type="submit"
        class="w-full sm:w-auto px-6 py-3 rounded-xl
               bg-blue-600 hover:bg-blue-700
               text-white font-semibold transition"
    >
        Submit Review
    </button>

</form>

                </div>

            @empty

                <div class="bg-white rounded-2xl shadow-sm p-10 text-center">

                    <h2 class="text-xl font-bold text-gray-900">
                        No Products Found
                    </h2>

                    <p class="text-gray-500 mt-2">
                        No products are available for review.
                    </p>

                </div>
            @endforelse

        </div>

    </div>

</x-frontend-layout>
