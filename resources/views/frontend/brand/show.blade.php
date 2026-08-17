<x-frontend-layout>

    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- Breadcrumb --}}
        <div class="mb-6 text-sm text-gray-500">

            <a
                href="{{ route('home') }}"
                class="hover:text-blue-600"
            >
                Home
            </a>

            <span class="mx-2">/</span>

            <span class="text-gray-800">
                {{ $brand->name }}
            </span>

        </div>


        {{-- Brand Heading --}}
        <div class="mb-8">

            <h1 class="text-3xl font-bold">
                {{ $brand->name }}
            </h1>

            <p class="text-gray-500 mt-2">
                Products by {{ $brand->name }}
            </p>

        </div>


        {{-- Products --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">

            @forelse($products as $product)

                <div class="border rounded-xl overflow-hidden bg-white">

                    <a href="{{ route('product.show', $product->slug) }}">

                        <div class="h-56 flex items-center justify-center p-4">

                            @if($product->image)

                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-contain"
                                >

                            @else

                                <span class="text-gray-400">
                                    No Image
                                </span>

                            @endif

                        </div>

                    </a>


                    <div class="p-4">

                        <a
                            href="{{ route('product.show', $product->slug) }}"
                            class="font-semibold hover:text-blue-600"
                        >
                            {{ $product->name }}
                        </a>


                        <p class="mt-2 font-bold">
                            Rs. {{ number_format($product->price) }}
                        </p>


                        <a
                            href="{{ route('product.show', $product->slug) }}"
                            class="block mt-4 text-center
                                   bg-blue-600 text-white
                                   py-2 rounded-lg
                                   hover:bg-blue-700"
                        >
                            View Product
                        </a>

                    </div>

                </div>

            @empty

                <div class="col-span-full text-center py-16">

                    <h3 class="text-xl font-semibold">
                        No products found
                    </h3>

                    <p class="text-gray-500 mt-2">
                        No products are available for this brand.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        @if($products->hasPages())

            <div class="mt-10">
                {{ $products->links() }}
            </div>

        @endif

    </div>

</x-frontend-layout>
