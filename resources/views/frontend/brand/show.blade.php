<x-frontend-layout>

    <div class="max-w-7xl mx-auto px-4 py-6 sm:py-8">

        {{-- Breadcrumb --}}
        <div class="mb-4 sm:mb-6 text-xs sm:text-sm text-gray-500">


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
        <div class="mb-6 sm:mb-8">

            <h1 class="text-2xl sm:text-3xl font-bold">
                {{ $brand->name }}
            </h1>

            <p class="text-sm sm:text-base text-gray-500 mt-2">
                Products by {{ $brand->name }}
            </p>

        </div>


        {{-- Products --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">

            @forelse($products as $product)

                <div class="border rounded-xl overflow-hidden bg-white">

                    <a href="{{ route('product.show', $product->slug) }}">

                        <div class="h-32 sm:h-56 flex items-center justify-center p-2 sm:p-4">

                            @if($product->image)

                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-contain"
                                >

                            @else

                                <span class="text-gray-400 text-sm">
                                    No Image
                                </span>

                            @endif

                        </div>

                    </a>


                    <div class="p-2.5 sm:p-4">


                            href="{{ route('product.show', $product->slug) }}"
                            class="font-semibold hover:text-blue-600 text-sm sm:text-base line-clamp-2"
                        >
                            {{ $product->name }}
                        </a>


                        <p class="mt-2 font-bold text-sm sm:text-base">
                            Rs. {{ number_format($product->price) }}
                        </p>



                            href="{{ route('product.show', $product->slug) }}"
                            class="block mt-3 sm:mt-4 text-center
                                   bg-blue-600 text-white
                                   py-1.5 sm:py-2 rounded-lg
                                   text-sm sm:text-base
                                   hover:bg-blue-700"
                        >
                            View Product
                        </a>

                    </div>

                </div>

            @empty

                <div class="col-span-full text-center py-12 sm:py-16">

                    <h3 class="text-lg sm:text-xl font-semibold">
                        No products found
                    </h3>

                    <p class="text-sm sm:text-base text-gray-500 mt-2">
                        No products are available for this brand.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        @if($products->hasPages())

            <div class="mt-8 sm:mt-10 overflow-x-auto">
                {{ $products->links() }}
            </div>

        @endif

    </div>

</x-frontend-layout>
