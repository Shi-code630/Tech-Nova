<x-frontend-layout>
    <div class="container">
        @php
            $category = $product->category;
            $ancestors = $category ? $category->getAncestors() : collect();
        @endphp

        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6 mt-6">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Home</a>

            @foreach($ancestors as $ancestor)
                <span>/</span>
                <a href="{{ route('category.show', ['slug' => $ancestor->slug]) }}" class="hover:text-blue-600 transition">
                    {{ $ancestor->name }}
                </a>
            @endforeach

            @if($category)
                <span>/</span>
                <a href="{{ route('category.show', ['slug' => $category->slug]) }}" class="hover:text-blue-600 transition">
                    {{ $category->name }}
                </a>
            @endif

            <span>/</span>
            <span class="text-gray-800 font-medium">{{ $product->name }}</span>
        </nav>

        {{-- ========================================= --}}
        {{-- Main Product Section --}}
        {{-- ========================================= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-10">

                {{-- =========================== --}}
                {{-- Image Gallery (small images) --}}
                {{-- =========================== --}}
                <div>
                    {{-- Main Image --}}
                    <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-center min-h-[300px] border border-gray-200">
                        @php
                            $images = $product->thumbnails ?? [];
                            $mainImage = $images[0] ?? null;
                        @endphp
                        @if($mainImage)
                            <img id="mainProductImage"
                                 src="{{ asset('storage/' . $mainImage) }}"
                                 alt="{{ $product->name }}"
                                 class="max-h-[300px] w-auto object-contain transition duration-300">
                        @else
                            <div class="text-gray-400 text-sm">No image available</div>
                        @endif
                    </div>

                    {{-- Thumbnails --}}
                    @if(count($images) > 1)
                        <div class="flex gap-3 mt-4 overflow-x-auto pb-2">
                            @foreach($images as $index => $image)
                                <button type="button"
                                        onclick="changeProductImage('{{ asset('storage/' . $image) }}', this)"
                                        class="flex-shrink-0 w-16 h-16 rounded-lg border-2 border-gray-200 hover:border-blue-500 transition focus:outline-none focus:ring-2 focus:ring-blue-400 {{ $index === 0 ? 'border-blue-500' : '' }}">
                                    <img src="{{ asset('storage/' . $image) }}"
                                         alt="Thumbnail {{ $index + 1 }}"
                                         class="w-full h-full object-cover rounded-lg">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- =========================== --}}
                {{-- Product Details --}}
                {{-- =========================== --}}
                <div>
                    {{-- Product Name --}}
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                        {{ $product->name }}
                    </h1>

                    {{-- Brand & Category --}}
                    <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-gray-500">
                        @if($product->brand)
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                {{ $product->brand->name }}
                            </span>
                        @endif

                        @if($product->category)
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <a href="{{ route('category.show', ['slug' => $product->category->slug]) }}" class="text-blue-600 hover:underline">
                                    {{ $product->category->name }}
                                </a>
                            </span>
                        @endif

                        @if($product->sku)
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                SKU: {{ $product->sku }}
                            </span>
                        @endif
                    </div>

                    {{-- Price --}}
                    <div class="mt-4">
                        @if($product->discount_price)
                            <span class="text-3xl font-bold text-gray-900">Rs. {{ number_format($product->discount_price) }}</span>
                            <span class="ml-3 text-lg text-gray-400 line-through">Rs. {{ number_format($product->price) }}</span>
                            <span class="ml-2 inline-block bg-red-100 text-red-700 text-xs font-semibold px-2 py-0.5 rounded-full">
                                -{{ round((1 - $product->discount_price / $product->price) * 100) }}%
                            </span>
                        @else
                            <span class="text-3xl font-bold text-gray-900">Rs. {{ number_format($product->price) }}</span>
                        @endif
                    </div>

                    {{-- Stock & Availability --}}
                    <div class="mt-3 flex items-center gap-3">
                        @if($product->stock > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-medium">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                In Stock ({{ $product->stock }})
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-medium">
                                <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                                Out of Stock
                            </span>
                        @endif
                    </div>

                    {{-- Quantity + Actions --}}
                    @if($product->stock > 0)

                        <form method="POST" action="{{ route('cart.add', $product->id) }}">
                            @csrf

                            <div class="mt-6 flex flex-wrap items-center gap-4">

                                {{-- Quantity --}}
                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">

                                    <button
                                        type="button"
                                        onclick="changeQty(-1)"
                                        class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition focus:outline-none">
                                        −
                                    </button>

                                    <input
                                        type="number"
                                        id="quantity"
                                        name="quantity"
                                        value="1"
                                        min="1"
                                        max="{{ $product->stock }}"
                                        class="w-14 text-center border-0 focus:ring-0 focus:outline-none text-gray-700 font-medium">

                                    <button
                                        type="button"
                                        onclick="changeQty(1)"
                                        class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition focus:outline-none">
                                        +
                                    </button>

                                </div>

                                {{-- Add to Cart --}}
                                <button
                                    type="submit"
                                    class="flex-1 min-w-[180px] py-3 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white font-semibold transition">

                                    Add to Cart

                                </button>

                            </div>

                        </form>

                        {{-- Buy Now --}}
                        <button
                            type="button"
                            onclick="buyNow({{ $product->id }})"
                            class="mt-3 w-full px-6 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition shadow-sm">

                            Buy Now

                        </button>

                        {{-- Wishlist --}}
                        <div class="mt-4">

                            <button
                                type="button"
                                onclick="addToWishlist({{ $product->id }})"
                                class="text-sm text-gray-500 hover:text-red-500 transition flex items-center gap-1">

                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>

                                </svg>

                                Add to Wishlist

                            </button>

                        </div>

                    @endif

            {{-- ========================================= --}}
            {{-- Description / Tabs --}}
            {{-- ========================================= --}}
            <div class="border-t border-gray-100 p-6 md:p-10">
                <div class="flex border-b border-gray-200" x-data="{ activeTab: 'description' }">
                    <button @click="activeTab = 'description'"
                            :class="{ 'border-b-2 border-blue-600 text-blue-600': activeTab === 'description' }"
                            class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition focus:outline-none">
                        Description
                    </button>
                    <button @click="activeTab = 'reviews'"
                            :class="{ 'border-b-2 border-blue-600 text-blue-600': activeTab === 'reviews' }"
                            class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition focus:outline-none">
                        Reviews ({{ $product->reviews_count ?? 0 }})
                    </button>
                    <button @click="activeTab = 'shipping'"
                            :class="{ 'border-b-2 border-blue-600 text-blue-600': activeTab === 'shipping' }"
                            class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition focus:outline-none">
                        Shipping
                    </button>
                </div>

                <div class="mt-6">
                    {{-- Description --}}
                    <div x-show="activeTab === 'description'" x-transition>
                        @if($product->description)
                            <div class="text-gray-600 leading-7 whitespace-pre-line">
                                {{ $product->description }}
                            </div>
                        @else
                            <p class="text-gray-400">No description provided.</p>
                        @endif
                    </div>

                    {{-- Reviews (placeholder) --}}
                    <div x-show="activeTab === 'reviews'" x-transition>
                        <p class="text-gray-500">Reviews will appear here.</p>
                    </div>

                    {{-- Shipping --}}
                    <div x-show="activeTab === 'shipping'" x-transition>
                        <p class="text-gray-500">Shipping information will be displayed here.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================= --}}
        {{-- Related Products (updated with discount badge & two buttons) --}}
        {{-- ========================================= --}}
        @if(isset($relatedProducts) && $relatedProducts->count())
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">You may also like</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
                    @foreach($relatedProducts as $related)
                        @php
                            $discountPercent = 0;
                            if ($related->discount_price && $related->discount_price < $related->price) {
                                $discountPercent = round((1 - $related->discount_price / $related->price) * 100);
                            }
                        @endphp
                        <div class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col">
                            {{-- Image with discount badge --}}
                            <a href="{{ route('product.show', ['slug' => $related->slug]) }}" class="block relative bg-gray-50 aspect-square overflow-hidden">
                                @if(!empty($related->thumbnails))
                                    <img src="{{ asset('storage/' . $related->thumbnails[0]) }}"
                                         alt="{{ $related->name }}"
                                         class="w-full h-full object-contain p-4 group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 text-sm">No image</div>
                                @endif

                                {{-- Discount badge (replaces 'New') --}}
                                @if($discountPercent > 0)
                                    <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                                        -{{ $discountPercent }}%
                                    </span>
                                @endif
                            </a>

                            {{-- Product info --}}
                            <div class="p-4 flex flex-col flex-1">
                                {{-- Category (if needed) --}}
                                @if($related->category)
                                    <p class="text-xs text-blue-600 font-semibold mb-1">
                                        {{ $related->category->name }}
                                    </p>
                                @endif

                                {{-- Product name --}}
                                <a href="{{ route('product.show', ['slug' => $related->slug]) }}"
                                   class="text-sm font-bold text-gray-800 leading-snug mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                    {{ $related->name }}
                                </a>

                                {{-- Price --}}
                                <div class="flex items-center gap-2 mb-4">
                                    @if($related->discount_price)
                                        <span class="text-xl font-bold text-gray-900">Rs. {{ number_format($related->discount_price) }}</span>
                                        <span class="text-sm text-gray-400 line-through">Rs. {{ number_format($related->price) }}</span>
                                    @else
                                        <span class="text-xl font-bold text-gray-900">Rs. {{ number_format($related->price) }}</span>
                                    @endif
                                </div>

                                {{-- Two buttons: View Product & Add to Cart --}}
                                <div class="flex items-center gap-2 mt-auto">
                                    <a href="{{ route('product.show', ['slug' => $related->slug]) }}"
                                       class="flex-1 text-center bg-gray-900 hover:bg-blue-600 text-white py-2 rounded-xl text-sm font-semibold transition">
                                        View Product
                                    </a>
                                    @if($related->stock > 0)
                                        <button onclick="addToCart({{ $related->id }}, 1)"
                                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-1">
                                            <i class="fa-solid fa-cart-plus"></i>
                                            Add
                                        </button>
                                    @else
                                        <button disabled
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
            </div>
        @endif

    </div>

    {{-- ========================================= --}}
    {{-- Scripts (for interactive elements) --}}
    {{-- ========================================= --}}
    <script>
        // Change main image when thumbnail is clicked
        function changeProductImage(src, btn) {
            document.getElementById('mainProductImage').src = src;
            // update active border on thumbnails
            document.querySelectorAll('.thumb-btn').forEach(el => el.classList.remove('border-blue-500'));
            if (btn) btn.classList.add('border-blue-500');
        }

        // Quantity controls
        function changeQty(delta) {
            const input = document.getElementById('quantity');
            let val = parseInt(input.value) + delta;
            const min = parseInt(input.min) || 1;
            const max = parseInt(input.max) || 999;
            if (val < min) val = min;
            if (val > max) val = max;
            input.value = val;
        }


        // Buy Now
        function buyNow(productId) {
            const qty = document.getElementById('quantity').value;
            alert('Buy product ID ' + productId + ' (quantity: ' + qty + ') now');
            // Redirect to checkout or add to cart and go to checkout.
        }

        // Wishlist
        function addToWishlist(productId) {
            alert('Add product ID ' + productId + ' to wishlist');
        }
    </script>

</x-frontend-layout>
