<x-frontend-layout>

    <div class="bg-gray-100 w-full py-6 sm:py-8">

        <div class="Container mx-auto px-3 sm:px-4">

            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100
                        p-4 sm:p-6 mb-4 sm:mb-6">

                <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900">
                    Review Your Order
                </h1>

                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Order #{{ $order->order_number }}
                </p>

            </div>


            {{-- Success Message --}}
            @if (session('success'))
                <div
                    class="mb-4 sm:mb-6 rounded-xl bg-green-50 border border-green-200
                            p-3 sm:p-4">

                    <p class="text-xs sm:text-sm text-green-700 font-medium">
                        {{ session('success') }}
                    </p>

                </div>
            @endif


            {{-- Error Message --}}
            @if (session('error'))
                <div
                    class="mb-4 sm:mb-6 rounded-xl bg-red-50 border border-red-200
                            p-3 sm:p-4">

                    <p class="text-xs sm:text-sm text-red-700 font-medium">
                        {{ session('error') }}
                    </p>

                </div>
            @endif


            {{-- Validation Errors --}}
            @if ($errors->any())
                <div
                    class="mb-4 sm:mb-6 rounded-xl bg-red-50 border border-red-200
                            p-3 sm:p-4">

                    <ul class="list-disc list-inside text-xs sm:text-sm text-red-600 space-y-1">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>
            @endif


            {{-- =====================================================
                PRODUCTS
            ====================================================== --}}
            @forelse($order->items as $item)
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100
                            p-4 sm:p-6 mb-4 sm:mb-5">

                    {{-- ============================= --}}
                    {{-- PRODUCT INFO                   --}}
                    {{-- ============================= --}}
                    <div class="flex items-start sm:items-center gap-3 sm:gap-4">

                        {{-- Product Image --}}
                        <div
                            class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-gray-100
                                    overflow-hidden flex-shrink-0">

                            @if ($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                    alt="{{ $item->product->name }}" loading="lazy" class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center
                                            text-gray-400 text-[10px] sm:text-xs">
                                    No Image
                                </div>
                            @endif

                        </div>


                        {{-- Product Details --}}
                        <div class="flex-1 min-w-0">

                            <h2 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 break-words">
                                {{ $item->product->name ?? 'Product' }}
                            </h2>

                            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                Quantity: {{ $item->quantity }}
                            </p>

                            <p class="text-xs sm:text-sm text-gray-500">
                                Price: Rs. {{ number_format($item->price, 2) }}
                            </p>

                        </div>

                    </div>


                    {{-- ============================= --}}
                    {{-- REVIEW FORM                    --}}
                    {{-- ============================= --}}
                    <form action="{{ route('orders.review.submit', $order) }}" method="POST" class="mt-4 sm:mt-6">

                        @csrf

                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">


                        {{-- Rating --}}
                        <div class="mb-4 sm:mb-5">

                            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                                Your Rating
                            </label>

                            <select name="rating" required
                                class="w-full rounded-xl border border-gray-300
                                       px-3 sm:px-4 py-2.5 sm:py-3
                                       text-sm sm:text-base
                                       focus:border-blue-500 focus:ring-blue-500">

                                <option value="">Select Rating</option>

                                <option value="5">★★★★★ — Excellent</option>
                                <option value="4">★★★★☆ — Very Good</option>
                                <option value="3">★★★☆☆ — Good</option>
                                <option value="2">★★☆☆☆ — Fair</option>
                                <option value="1">★☆☆☆☆ — Poor</option>

                            </select>

                        </div>


                        {{-- Review --}}
                        <div class="mb-4 sm:mb-5">

                            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                                Your Review
                            </label>

                            <textarea name="review" rows="4"
                                class="w-full rounded-xl border border-gray-300
                                       px-3 sm:px-4 py-2.5 sm:py-3
                                       text-sm sm:text-base
                                       focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Write your review...">{{ old('review') }}</textarea>

                        </div>


                        {{-- Submit Button --}}
                        <button type="submit"
                            class="w-full sm:w-auto
                                   px-5 sm:px-6 py-2.5 sm:py-3
                                   rounded-xl bg-blue-600 hover:bg-blue-700
                                   text-white font-semibold
                                   text-sm sm:text-base
                                   transition">

                            Submit Review

                        </button>

                    </form>

                </div>

            @empty

                {{-- =====================================================
                    EMPTY STATE
                ====================================================== --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-10 text-center">

                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">
                        No Products Found
                    </h2>

                    <p class="text-xs sm:text-sm text-gray-500 mt-2">
                        No products are available for review.
                    </p>

                </div>
            @endforelse

        </div>

    </div>

</x-frontend-layout>
