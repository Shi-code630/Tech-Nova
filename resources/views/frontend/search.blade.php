<x-frontend-layout>
    <div class="container mx-auto px-4 py-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                Search Results
                @if (!empty($query))
                    for “<span class="text-blue-600">{{ $query }}</span>”
                @endif
            </h1>

            @if ($products->total() > 0)
                <p class="text-gray-500 text-sm">
                    {{ $products->total() }} product(s) found
                </p>
            @endif
        </div>

        @if ($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">

                @foreach ($products as $product)
                    @php
                        $originalPrice = (float) ($product->price ?? 0);
                        $discountPrice = $product->discount_price !== null ? (float) $product->discount_price : null;

                        $discountPercent = 0;
                        if ($discountPrice !== null && $originalPrice > 0 && $discountPrice < $originalPrice) {
                            $discountPercent = round((1 - $discountPrice / $originalPrice) * 100);
                        }

                        $finalPrice =
                            $discountPrice !== null && $discountPrice < $originalPrice
                                ? $discountPrice
                                : $originalPrice;
                    @endphp

                    <div
                        class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col">

                        {{-- Image --}}
                        <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                            class="block relative bg-gray-50 aspect-square overflow-hidden">

                            @if (!empty($product->thumbnails))
                                <img src="{{ asset('storage/' . $product->thumbnails[0]) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-contain p-4 group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-sm">
                                    No image
                                </div>
                            @endif

                            @if ($discountPercent > 0)
                                <span
                                    class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                                    -{{ $discountPercent }}%
                                </span>
                            @endif
                        </a>

                        {{-- Info --}}
                        <div class="p-4 flex flex-col flex-1">

                            @if ($product->category)
                                <p class="text-xs text-blue-600 font-semibold mb-1">
                                    {{ $product->category->name }}
                                </p>
                            @endif

                            <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                class="text-sm font-bold text-gray-800 leading-snug mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                {{ $product->name }}
                            </a>

                            {{-- Price --}}
                            <div class="flex items-center gap-2 mb-4">
                                @if ($discountPrice !== null && $discountPrice < $originalPrice)
                                    <span class="text-xl font-bold text-gray-900">
                                        Rs. {{ number_format($finalPrice, 2) }}
                                    </span>
                                    <span class="text-sm text-gray-400 line-through">
                                        Rs. {{ number_format($originalPrice, 2) }}
                                    </span>
                                @else
                                    <span class="text-xl font-bold text-gray-900">
                                        Rs. {{ number_format($originalPrice, 2) }}
                                    </span>
                                @endif
                            </div>

                            {{-- Buttons --}}
                            <div class="flex items-center gap-2 mt-auto">
                                <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                    class="flex-1 text-center bg-gray-900 hover:bg-blue-600 text-white py-2 rounded-xl text-sm font-semibold transition">
                                    View Product
                                </a>

                                @if ((int) $product->stock > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">

                                        <button type="submit"
                                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-1">
                                            <i class="fa-solid fa-cart-plus"></i>
                                            Add
                                        </button>
                                    </form>
                                @else
                                    <button type="button" disabled
                                        class="flex-1 bg-gray-300 text-gray-500 py-2 rounded-xl text-sm font-semibold cursor-not-allowed flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-cart-plus"></i>
                                        Out
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- Pagination --}}
            <div class="mt-10 flex justify-center">
                {{ $products->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="inline-block bg-blue-50 border border-blue-100 rounded-2xl px-8 py-10">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">No products found</h3>
                    <p class="text-gray-500 mb-6">
                        @if (!empty($query))
                            We couldn’t find any products matching “<strong>{{ $query }}</strong>”.
                        @else
                            Please enter a keyword to search.
                        @endif
                    </p>
                    <a href="{{ route('home') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-xl transition">
                        Back to Home
                    </a>
                </div>
            </div>
        @endif

    </div>
</x-frontend-layout>
