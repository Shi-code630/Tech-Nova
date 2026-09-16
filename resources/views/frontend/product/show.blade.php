<x-frontend-layout class="bg-[#eef7fd]">
    <div>
        @if (session('success'))
            <div class="Container mx-auto px-4 pt-5" x-data="{ show: true }" x-show="show" x-transition>
                <div class="flex items-center justify-between gap-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
                            <i class="fa-solid fa-check text-green-600"></i>
                        </div>
                        <span class="font-medium">
                            {{ session('success') }}
                        </span>
                    </div>
                    <button type="button" @click="show = false" class="text-green-600 hover:text-green-800">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="Container mx-auto px-4 pt-5" x-data="{ show: true }" x-show="show" x-transition>
                <div class="flex items-center justify-between gap-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100">
                            <i class="fa-solid fa-circle-exclamation text-red-600"></i>
                        </div>
                        <span class="font-medium">
                            {{ session('error') }}
                        </span>
                    </div>
                    <button type="button" @click="show = false" class="text-red-600 hover:text-red-800">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        @endif

        {{-- ========================================================= --}}
        {{-- Validation Errors --}}
        {{-- ========================================================= --}}
        @if ($errors->any())
            <div class="Container mx-auto px-4 pt-5" x-data="{ show: true }" x-show="show" x-transition>
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 font-semibold mb-2">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                Please check the following:
                            </div>
                            <ul class="list-disc ml-6 text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" @click="show = false" class="text-red-600 hover:text-red-800">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- ========================================================= --}}
        {{-- Main Container --}}
        {{-- ========================================================= --}}
        <div class="Container mx-auto px-4">

            @php
                $category = $product->category;
                $ancestors = $category ? $category->getAncestors() : collect();
                $images = $product->thumbnails ?? [];
                $mainImage = $images[0] ?? null;

                /*
                |--------------------------------------------------------------------------
                | Product Price
                |--------------------------------------------------------------------------
                */
                $originalPrice = (float) ($product->price ?? 0);

                $discountPrice =
                    $product->discount_price !== null && (float) $product->discount_price > 0
                        ? (float) $product->discount_price
                        : null;

                /*
                |--------------------------------------------------------------------------
                | Discount Percentage
                |--------------------------------------------------------------------------
                */
                $discountPercent = 0;

                if ($discountPrice !== null && $originalPrice > 0 && $discountPrice < $originalPrice) {
                    $discountPercent = round((1 - $discountPrice / $originalPrice) * 100);
                }

                /*
                |--------------------------------------------------------------------------
                | Final Product Price
                |--------------------------------------------------------------------------
                */
                $finalPrice =
                    $discountPrice !== null && $discountPrice < $originalPrice ? $discountPrice : $originalPrice;
                $productStock = (int) ($product->stock ?? 0);
            @endphp

            {{-- ========================================================= --}}
            {{-- Breadcrumb --}}
            {{-- ========================================================= --}}
            <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500 mb-6 mt-6">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition">
                    Home
                </a>

                @foreach ($ancestors as $ancestor)
                    <span>/</span>
                    <a href="{{ route('category.show', ['slug' => $ancestor->slug]) }}" class="hover:text-blue-600 transition">
                        {{ $ancestor->name }}
                    </a>
                @endforeach

                @if ($category)
                    <span>/</span>
                    <a href="{{ route('category.show', ['slug' => $category->slug]) }}" class="hover:text-blue-600 transition">
                        {{ $category->name }}
                    </a>
                @endif

                <span>/</span>
                <span class="text-gray-800 font-medium">
                    {{ $product->name }}
                </span>
            </nav>

            {{-- ========================================================= --}}
            {{-- Main Product Card --}}
            {{-- ========================================================= --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-10">

                    {{-- ================================================= --}}
                    {{-- Product Images --}}
                    {{-- ================================================= --}}
                    <div>
                        {{-- Main Image --}}
                        <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-center min-h-[300px] border border-gray-200">
                            @if ($mainImage)
                                <img id="mainProductImage" src="{{ asset('storage/' . $mainImage) }}"
                                    alt="{{ $product->name }}"
                                    class="max-h-[400px] w-auto object-contain transition duration-300">
                            @else
                                <div class="text-gray-400 text-sm">
                                    No image available
                                </div>
                            @endif
                        </div>

                        {{-- Thumbnails --}}
                        @if (count($images) > 1)
                            <div class="flex gap-3 mt-4 overflow-x-auto pb-2">
                                @foreach ($images as $index => $image)
                                    <button type="button"
                                        onclick="changeProductImage(@js(asset('storage/' . $image)), this)"
                                        class="thumb-btn flex-shrink-0 w-16 h-16 rounded-lg border-2 {{ $index === 0 ? 'border-blue-500' : 'border-gray-200' }} hover:border-blue-500 transition focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Thumbnail {{ $index + 1 }}"
                                            class="w-full h-full object-cover rounded-lg">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- ================================================= --}}
                    {{-- Product Details --}}
                    {{-- ================================================= --}}
                    <div>
                        {{-- Product Name --}}
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                            {{ $product->name }}
                        </h1>

                        {{-- Brand / Category / SKU --}}
                        <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-gray-500">
                            @if ($product->brand)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    {{ $product->brand->name }}
                                </span>
                            @endif

                            @if ($product->category)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <a href="{{ route('category.show', ['slug' => $product->category->slug]) }}" class="text-blue-600 hover:underline">
                                        {{ $product->category->name }}
                                    </a>
                                </span>
                            @endif

                            @if ($product->sku)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a3 3 0 006 0M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    SKU: {{ $product->sku }}
                                </span>
                            @endif
                        </div>

                        {{-- ================================================= --}}
                        {{-- Price --}}
                        {{-- ================================================= --}}
                        <div class="mt-5">
                            @if ($discountPrice !== null && $discountPrice < $originalPrice)
                                <span class="text-3xl font-bold text-gray-900">
                                    Rs. {{ number_format($discountPrice, 2) }}
                                </span>
                                <span class="ml-3 text-lg text-gray-400 line-through">
                                    Rs. {{ number_format($originalPrice, 2) }}
                                </span>
                                @if ($discountPercent > 0)
                                    <span class="ml-2 inline-block bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded-full">
                                        -{{ $discountPercent }}%
                                    </span>
                                @endif
                            @else
                                <span class="text-3xl font-bold text-gray-900">
                                    Rs. {{ number_format($originalPrice, 2) }}
                                </span>
                            @endif
                        </div>

                        {{-- ================================================= --}}
                        {{-- Stock --}}
                        {{-- ================================================= --}}
                        <div class="mt-4">
                            @if ($productStock > 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-medium">
                                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                    In Stock ({{ $productStock }})
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-medium">
                                    <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                                    Out of Stock
                                </span>
                            @endif
                        </div>

                        {{-- Quantity + Actions --}}
                        @if ($product->stock > 0)
                            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                @csrf
                                <div class="mt-6 flex flex-wrap items-center gap-4">
                                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                        <button type="button" onclick="changeQty(-1)" class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition focus:outline-none">
                                            −
                                        </button>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1"
                                            max="{{ $product->stock }}"
                                            class="w-14 text-center border-0 focus:ring-0 focus:outline-none text-gray-700 font-medium">
                                        <button type="button" onclick="changeQty(1)" class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition focus:outline-none">
                                            +
                                        </button>
                                    </div>

                                    <button type="submit" class="flex-1 min-w-[180px] py-3 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white font-semibold transition">
                                        Add to Cart
                                    </button>
                                </div>
                            </form>

                            {{-- Buy Now --}}
                            <button type="button" onclick="buyNow({{ $product->id }})"
                                class="mt-3 w-full px-6 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition shadow-sm">
                                Buy Now
                            </button>

                            {{-- Wishlist --}}
                            <div class="mt-4">
                                <button type="button" onclick="addToWishlist({{ $product->id }})"
                                    class="text-sm text-gray-500 hover:text-red-500 transition flex items-center gap-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    Add to Wishlist
                                </button>
                            </div>
                        @endif

                        {{-- ========================================================= --}}
                        {{-- Description / Reviews / Shipping --}}
                        {{-- ========================================================= --}}
                        <div class="border-t border-gray-100 mt-6 pt-6" x-data="{ activeTab: 'description' }">
                            {{-- Tabs --}}
                            <div class="flex flex-wrap border-b border-gray-200">
                                <button type="button" @click="activeTab = 'description'"
                                    :class="activeTab === 'description' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500'"
                                    class="px-4 py-2 text-sm font-medium hover:text-gray-700 transition focus:outline-none">
                                    Description
                                </button>

                                <button type="button" @click="activeTab = 'reviews'"
                                    :class="activeTab === 'reviews' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500'"
                                    class="px-4 py-2 text-sm font-medium hover:text-gray-700 transition focus:outline-none">
                                    Reviews ({{ $product->reviews_count ?? 0 }})
                                </button>

                                <button type="button" @click="activeTab = 'shipping'"
                                    :class="activeTab === 'shipping' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500'"
                                    class="px-4 py-2 text-sm font-medium hover:text-gray-700 transition focus:outline-none">
                                    Shipping
                                </button>
                            </div>

                            {{-- Tab Content --}}
                            <div class="mt-6">
                                <div x-show="activeTab === 'description'" x-transition>
                                    @if ($product->description)
                                        <div class="text-gray-600 leading-7 whitespace-pre-line">
                                            {{ $product->description }}
                                        </div>
                                    @else
                                        <p class="text-gray-400">
                                            No description provided.
                                        </p>
                                    @endif
                                </div>

                                <div x-show="activeTab === 'reviews'" x-transition>
                                    <p class="text-gray-500">
                                        Reviews will appear here.
                                    </p>
                                </div>

                                <div x-show="activeTab === 'shipping'" x-transition>
                                    <p class="text-gray-500">
                                        Shipping information will be displayed here.
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- END Description/Reviews/Shipping --}}

                    </div>
                    {{-- END Product Details --}}

                </div>
                {{-- END grid grid-cols-1 md:grid-cols-2 --}}

            </div>
            {{-- END Main Product Card --}}


            {{-- ========================================================= --}}
            {{-- Related Products --}}
            {{-- ========================================================= --}}
            @if (isset($relatedProducts) && $relatedProducts->count())
                <div class="mt-12 mb-12">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">
                        You may also like
                    </h2>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
                        @foreach ($relatedProducts as $related)
                            @php
                                $relatedOriginalPrice = (float) ($related->price ?? 0);

                                $relatedDiscountPrice =
                                    $related->discount_price !== null ? (float) $related->discount_price : null;

                                $relatedDiscount = 0;

                                if (
                                    $relatedDiscountPrice !== null &&
                                    $relatedOriginalPrice > 0 &&
                                    $relatedDiscountPrice < $relatedOriginalPrice
                                ) {
                                    $relatedDiscount = round((1 - $relatedDiscountPrice / $relatedOriginalPrice) * 100);
                                }

                                $relatedFinalPrice =
                                    $relatedDiscountPrice !== null && $relatedDiscountPrice < $relatedOriginalPrice
                                        ? $relatedDiscountPrice
                                        : $relatedOriginalPrice;
                            @endphp

                            <div class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col">

                                {{-- Product Image --}}
                                <a href="{{ route('product.show', ['slug' => $related->slug]) }}" class="block relative bg-gray-50 aspect-square overflow-hidden">
                                    @if (!empty($related->thumbnails))
                                        <img src="{{ asset('storage/' . $related->thumbnails[0]) }}" alt="{{ $related->name }}"
                                            class="w-full h-full object-contain p-4 group-hover:scale-110 transition duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-sm">
                                            No image
                                        </div>
                                    @endif

                                    @if ($relatedDiscount > 0)
                                        <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                                            -{{ $relatedDiscount }}%
                                        </span>
                                    @endif
                                </a>

                                {{-- Product Info --}}
                                <div class="p-4 flex flex-col flex-1">
                                    @if ($related->category)
                                        <p class="text-xs text-blue-600 font-semibold mb-1">
                                            {{ $related->category->name }}
                                        </p>
                                    @endif

                                    <a href="{{ route('product.show', ['slug' => $related->slug]) }}"
                                        class="text-sm font-bold text-gray-800 leading-snug mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                        {{ $related->name }}
                                    </a>

                                    <div class="flex items-center gap-2 mb-4">
                                        @if ($relatedDiscountPrice !== null && $relatedDiscountPrice < $relatedOriginalPrice)
                                            <span class="text-xl font-bold text-gray-900">
                                                Rs. {{ number_format($relatedFinalPrice, 2) }}
                                            </span>
                                            <span class="text-sm text-gray-400 line-through">
                                                Rs. {{ number_format($relatedOriginalPrice, 2) }}
                                            </span>
                                        @else
                                            <span class="text-xl font-bold text-gray-900">
                                                Rs. {{ number_format($relatedOriginalPrice, 2) }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-2 mt-auto">
                                        <a href="{{ route('product.show', ['slug' => $related->slug]) }}"
                                            class="flex-1 text-center bg-gray-900 hover:bg-blue-600 text-white py-2 rounded-xl text-sm font-semibold transition">
                                            View Product
                                        </a>

                                        @if ((int) $related->stock > 0)
                                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $related->id }}">
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
                </div>
            @endif


            {{-- ========================================================= --}}
            {{-- Recently Viewed --}}
            {{-- ========================================================= --}}
            <div class="mt-12 mb-12">
                @include('partials.recently-viewed')
            </div>

            {{-- Buy box --}}
            <div class="lg:col-span-7 space-y-4">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 md:p-6">
                    <div class="flex flex-wrap items-center gap-2 text-[11px] font-semibold uppercase tracking-wider">
                        @if ($product->brand)
                            <a href="{{ url('/brand/'.$product->brand->slug) }}" class="px-2 py-1 rounded bg-slate-900 text-white hover:bg-[#2563EB]">{{ $product->brand->name }}</a>
                        @endif
                        @if ($product->category)
                            <a href="{{ route('category.show', ['slug'=>$product->category->slug]) }}" class="px-2 py-1 rounded bg-slate-100 text-slate-600">{{ $product->category->name }}</a>
                        @endif
                        @if ($product->featured)
                            <span class="px-2 py-1 rounded bg-blue-50 text-[#2563EB]">Featured</span>
                        @endif
                    </div>


                    <h1 class="mt-3 text-[22px] md:text-[26px] font-bold text-slate-900 leading-snug">{{ $product->name }}</h1>

                    @if ($product->description)
                        <p id="productExcerpt" class="mt-3 text-sm text-slate-600 leading-6">{{ \Illuminate\Support\Str::limit(strip_tags($product->description), 240) }}</p>
                        <button type="button" onclick="switchTab('description')" class="mt-1 text-sm text-[#2563EB] hover:underline">Read full description</button>
                    @endif

                    <p id="selectedComboLabel" class="mt-1 text-sm text-slate-500 font-mono">{{ $activeVariants->count() ? 'Select finish & configuration' : 'Standard configuration' }}</p>

                    <div class="mt-3 flex flex-wrap items-center gap-3 text-sm">
                        <span class="inline-flex items-center gap-1 bg-slate-900 text-white text-xs font-bold px-2 py-1 rounded">
                            {{ $avgRating > 0 ? number_format($avgRating,1) : 'New' }} ★
                        </span>
                        <button type="button" onclick="setProductTab('reviews')" class="text-[#2563EB] hover:underline">{{ $reviewsCount }} reviews</button>
                        <span class="text-slate-300">|</span>
                        <span class="text-slate-600">{{ number_format($soldCount ?? 0) }} units sold</span>
                    </div>

                    <div class="mt-5 rounded-xl bg-slate-50 border border-slate-100 p-4">
                        <div class="flex flex-wrap items-end gap-3">
                            <span id="displayPrice" class="text-3xl md:text-[34px] font-bold text-slate-900 tracking-tight">Rs. {{ number_format($finalPrice, 2) }}</span>
                            <span id="displayOldPrice" class="{{ $youSave>0?'':'hidden' }} text-slate-400 line-through">Rs. {{ number_format($originalPrice, 2) }}</span>
                            <span id="displayOff" class="{{ $youSave>0?'':'hidden' }} text-xs font-bold px-2 py-1 rounded bg-emerald-100 text-emerald-700">{{ $discountPercent }}% OFF</span>
                        </div>
                        <p id="saveLine" class="text-sm text-emerald-700 mt-1 {{ $youSave>0?'':'hidden' }}">You save Rs. {{ number_format($youSave, 2) }}</p>
                        @if (($coinsEarnable ?? 0) > 0)
                            <p class="text-sm text-amber-700 mt-1">Earn {{ $coinsEarnable }} TechNova coins</p>
                        @endif
                        <p class="text-xs text-slate-400 mt-1">Price for selected SKU · 13% VAT at checkout</p>
                    </div>

                    @if ($activeVariants->count())
                        <div class="mt-6 space-y-6">
                            @if ($colors->count())
                                <div>
                                    <div class="flex items-baseline justify-between mb-3">
                                        <p class="text-sm font-bold text-slate-900">Finish</p>
                                        <span id="selectedColorLabel" class="text-sm text-[#2563EB] font-medium">Choose</span>
                                    </div>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach ($colors as $color)
                                            @php $sw = $colorSwatches[$color] ?? []; @endphp
                                            <button type="button" data-color="{{ $color }}" onclick="selectColor(@js($color))"
                                                class="color-btn disabled:opacity-30 disabled:cursor-not-allowed" title="{{ $color }}">
                                                <span class="block w-[72px] h-[72px] rounded-xl overflow-hidden border border-slate-200 bg-slate-100">
                                                    @if (!empty($sw['image']))
                                                        <img src="{{ $sw['image'] }}" class="w-full h-full object-contain p-1" alt="">
                                                    @elseif (!empty($sw['hex']))
                                                        <span class="block w-full h-full" style="background:{{ $sw['hex'] }}"></span>
                                                    @endif
                                                </span>
                                                <span class="block mt-1.5 text-[11px] text-center text-slate-600 w-[72px] truncate">{{ $color }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($sizes->count())
                                <div>
                                    <div class="flex items-baseline justify-between mb-3">
                                        <p class="text-sm font-bold text-slate-900">Storage / RAM / Config</p>
                                        <span id="selectedSizeLabel" class="text-sm text-[#2563EB] font-medium">Choose</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($sizes as $size)
                                            <button type="button" data-size="{{ $size }}" onclick="selectSize(@js($size))"
                                                class="size-btn min-w-[88px] h-12 px-4 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-800 hover:border-[#2563EB] disabled:opacity-30 disabled:line-through disabled:cursor-not-allowed">
                                                {{ $size }}
                                            </button>
                                        @endforeach
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-2">Use admin Size field for 128GB, 8/256, 16GB RAM, etc.</p>
                                </div>
                            @endif
                            <p id="variantHint" class="text-sm text-amber-600">Select finish and configuration to add to cart.</p>
                            <p id="stockLine" class="text-sm font-semibold"></p>
                        </div>
                    @else
                        <p class="mt-4 text-sm font-semibold {{ $productStock>0?'text-emerald-700':'text-red-600' }}">
                            {{ $productStock>0 ? 'In stock · '.$productStock.' units' : 'Out of stock' }}
                        </p>
                    @endif

                    @if ($productStock > 0)
                        <form method="POST" action="{{ route('cart.add', $product->id) }}" id="addToCartForm" class="mt-6">
                            @csrf
                            <input type="hidden" name="variant_id" id="variant_id" value="">
                            <input type="hidden" name="buy_now" id="buy_now" value="0">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-sm font-medium text-slate-600">Qty</span>
                                <div class="flex items-center h-11 rounded-xl border border-slate-300 overflow-hidden">
                                    <button type="button" onclick="changeQty(-1)" class="w-10 h-11 text-slate-600">−</button>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ min(max($productStock,1),10) }}" class="w-12 h-11 text-center border-0 font-bold">
                                    <button type="button" onclick="changeQty(1)" class="w-10 h-11 text-slate-600">+</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <button type="submit" id="addToCartBtn" class="h-12 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white font-bold">Add to Cart</button>
                                <button type="button" id="buyNowBtn" onclick="buyNow()" class="h-12 rounded-xl bg-slate-900 hover:bg-black text-white font-bold">Buy Now</button>
                            </div>
                        </form>
                    @endif
                    <button type="button" id="wishlistBtn" onclick="toggleWishlist({{ $product->id }})" class="mt-3 text-sm {{ !empty($isWishlisted)?'text-red-500':'text-slate-500' }}">
                        <span id="wishlistLabel">{{ !empty($isWishlisted) ? 'Saved to wishlist' : 'Save to wishlist' }}</span>
                    </button>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div class="bg-white rounded-xl border border-slate-200 p-3 text-center">
                        <p class="text-[11px] font-bold text-slate-900">WARRANTY</p>
                        <p class="text-[11px] text-slate-500 mt-1">Brand authorized</p>
                    </div>
                    <div class="bg-white rounded-xl border border-slate-200 p-3 text-center">
                        <p class="text-[11px] font-bold text-slate-900">VAT BILL</p>
                        <p class="text-[11px] text-slate-500 mt-1">13% at checkout</p>
                    </div>
                    <div class="bg-white rounded-xl border border-slate-200 p-3 text-center">
                        <p class="text-[11px] font-bold text-slate-900">COD / ESEWA</p>
                        <p class="text-[11px] text-slate-500 mt-1">Khalti supported</p>
                    </div>
                    <div class="bg-white rounded-xl border border-slate-200 p-3 text-center">
                        <p class="text-[11px] font-bold text-slate-900">VALLEY SHIP</p>
                        <p class="text-[11px] text-slate-500 mt-1">Free over 10k</p>
                    </div>
                </div>
            </div>
        </div>
<<<<<<< Updated upstream

                <div class="bg-white rounded-2xl border border-slate-200 p-5 md:p-8 mt-6" id="productTabs">
            <div class="flex flex-wrap gap-2 mb-6">
                <button type="button" data-tab="description" onclick="switchTab('description')" class="tn-tab px-4 py-2 rounded-lg text-sm font-semibold bg-slate-900 text-white">Description</button>
                <button type="button" data-tab="specs" onclick="switchTab('specs')" class="tn-tab px-4 py-2 rounded-lg text-sm font-semibold bg-slate-100 text-slate-600">Specifications</button>
                <button type="button" data-tab="reviews" onclick="switchTab('reviews')" class="tn-tab px-4 py-2 rounded-lg text-sm font-semibold bg-slate-100 text-slate-600">Reviews ({{ $reviewsCount }})</button>
                <button type="button" data-tab="shipping" onclick="switchTab('shipping')" class="tn-tab px-4 py-2 rounded-lg text-sm font-semibold bg-slate-100 text-slate-600">Delivery</button>
            </div>

            <div data-panel="description" class="tn-panel">
                <div id="productDescription" class="text-slate-600 leading-7 whitespace-pre-line max-w-3xl">{{ $product->description ?: 'No description added for this product yet.' }}</div>
            </div>
=======
        {{-- END Container mx-auto px-4 --}}
>>>>>>> Stashed changes

            <div data-panel="specs" class="tn-panel hidden">
                <div class="overflow-hidden rounded-xl border border-slate-200 max-w-3xl">
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-slate-100">
                            <tr class="bg-slate-50"><td class="px-4 py-3 w-48 font-medium text-slate-500">Model</td><td class="px-4 py-3 font-medium text-slate-900">{{ $product->name }}</td></tr>
                            <tr><td class="px-4 py-3 font-medium text-slate-500">Brand</td><td class="px-4 py-3">{{ $product->brand->name ?? '—' }}</td></tr>
                            <tr class="bg-slate-50"><td class="px-4 py-3 font-medium text-slate-500">Category</td><td class="px-4 py-3">{{ $product->category->name ?? '—' }}</td></tr>
                            @if ($colors->count())
                                <tr><td class="px-4 py-3 font-medium text-slate-500">Available finishes</td><td class="px-4 py-3">{{ $colors->join(', ') }}</td></tr>
                            @endif
                            @if ($sizes->count())
                                <tr class="bg-slate-50"><td class="px-4 py-3 font-medium text-slate-500">Configurations</td><td class="px-4 py-3 font-mono text-[13px]">{{ $sizes->join(' · ') }}</td></tr>
                            @endif
                            <tr><td class="px-4 py-3 font-medium text-slate-500">Stock</td><td class="px-4 py-3">{{ $productStock }} units</td></tr>
                            <tr class="bg-slate-50"><td class="px-4 py-3 font-medium text-slate-500">Seller</td><td class="px-4 py-3">TechNova Nepal · Kathmandu</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div data-panel="reviews" class="tn-panel hidden">
                @if ($reviewsCount > 0)
                    <div class="flex flex-wrap gap-8 mb-8">
                        <div>
                            <p class="text-4xl font-bold">{{ number_format($avgRating, 1) }}</p>
                            <p class="text-sm text-slate-500 mt-1">{{ $reviewsCount }} verified reviews</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        @foreach ($product->reviews as $review)
                            <div class="border border-slate-100 rounded-xl p-4">
                                <div class="flex justify-between gap-3">
                                    <p class="font-semibold text-slate-800">{{ $review->user->name ?? 'Customer' }}</p>
                                    <span class="text-xs text-slate-400">{{ $review->created_at?->format('d M Y') }}</span>
                                </div>
                                <p class="text-amber-400 text-sm mt-1">{!! $review->rating_stars_html !!}</p>
                                @if ($review->review)
                                    <p class="text-slate-600 text-sm mt-2">{{ $review->review }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500">No reviews yet. Review from My Orders after delivery.</p>
                @endif
            </div>

            <div data-panel="shipping" class="tn-panel hidden text-sm text-slate-600 leading-7 max-w-3xl space-y-4">
                <div>
                    <p class="font-bold text-slate-900">Kathmandu Valley</p>
                    <p>Free over Rs. 10,000 · otherwise Rs. 80–150 by order value.</p>
                </div>
                <div>
                    <p class="font-bold text-slate-900">Outside Valley</p>
                    <p>Rs. 100–500 by order value. Charge is calculated from your default address at checkout.</p>
                </div>
                <p>Sun–Fri 9:00–19:00. Returns from My Orders after delivery.</p>
            </div>
        </div>
        @if (isset($relatedProducts) && $relatedProducts->count())
            <div class="mt-10">
                <h2 class="text-xl font-bold text-slate-900 mb-4">More in this category</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($relatedProducts as $related)
                        @php
                            $rp=(float)($related->price??0);
                            $rd=$related->discount_price!==null?(float)$related->discount_price:null;
                            $rf=($rd!==null&&$rd<$rp)?$rd:$rp;
                        @endphp
                        <a href="{{ route('product.show', ['slug'=>$related->slug]) }}" class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-[#2563EB] transition">
                            <div class="bg-slate-50 aspect-square">
                                @if (!empty($related->thumbnails[0]))
                                    <img src="{{ asset('storage/'.$related->thumbnails[0]) }}" class="w-full h-full object-contain p-4" alt="">
                                @endif
                            </div>
                            <div class="p-3">
                                @if ($related->brand)<p class="text-[10px] uppercase tracking-wide text-slate-400">{{ $related->brand->name }}</p>@endif
                                <p class="text-sm font-semibold text-slate-800 line-clamp-2">{{ $related->name }}</p>
                                <p class="mt-1 font-bold text-slate-900">Rs. {{ number_format($rf, 2) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
<<<<<<< Updated upstream

    <script>
        const variants = @json($variantsForJs);
        const productImages = @json($productImagesForJs);
        const productDefaultDescription = @json($product->description ?? '');
        const hasColors = variants.some(v => v.color);
        const hasSizes = variants.some(v => v.size);
        const basePrice = {{ $finalPrice }};
        const baseOld = {{ $originalPrice }};
        let selectedColor = null;
        let selectedSize = null;

        function selectColor(color) {
            const btn = document.querySelector('.color-btn[data-color="'+color+'"]');
            if (btn && btn.disabled) return;
            selectedColor = selectedColor === color ? null : color;
            const lab = document.getElementById('selectedColorLabel');
            if (lab) lab.textContent = selectedColor || 'Choose';
            document.querySelectorAll('.color-btn').forEach(function (el) {
                el.classList.toggle('finish-on', el.dataset.color === selectedColor);
            });
            if (selectedSize && !findVariant(selectedColor, selectedSize)) {
                selectedSize = null;
                const sl = document.getElementById('selectedSizeLabel');
                if (sl) sl.textContent = 'Choose';
                document.querySelectorAll('.size-btn').forEach(function (el) { el.classList.remove('cfg-on'); });
            }
            previewColorGallery();
            applyVariant();
        }
        function selectSize(size) {
            const btn = document.querySelector('.size-btn[data-size="'+size+'"]');
            if (btn && btn.disabled) return;
            selectedSize = selectedSize === size ? null : size;
            const lab = document.getElementById('selectedSizeLabel');
            if (lab) lab.textContent = selectedSize || 'Choose';
            document.querySelectorAll('.size-btn').forEach(function (el) {
                el.classList.toggle('cfg-on', el.dataset.size === selectedSize);
            });
            if (selectedColor && !findVariant(selectedColor, selectedSize)) {
                selectedColor = null;
                const cl = document.getElementById('selectedColorLabel');
                if (cl) cl.textContent = 'Choose';
                document.querySelectorAll('.color-btn').forEach(function (el) { el.classList.remove('finish-on'); });
            }
            applyVariant();
        }
        function findVariant(color, size) {
            return variants.find(function (v) {
                return (!hasColors || v.color === color) && (!hasSizes || v.size === size);
            }) || null;
        }
        function currentVariant() {
            if (hasColors && !selectedColor) return null;
            if (hasSizes && !selectedSize) return null;
            return findVariant(selectedColor, selectedSize);
        }
        function matching() {
            return variants.filter(function (v) {
                return (!selectedColor || v.color === selectedColor) && (!selectedSize || v.size === selectedSize);
            });
        }
        function refreshAvailability() {
            document.querySelectorAll('.size-btn').forEach(function (btn) {
                const inStock = variants.some(function (v) {
                    return v.size === btn.dataset.size && v.stock > 0 && (!selectedColor || v.color === selectedColor);
                });
                btn.disabled = !inStock;
            });
            document.querySelectorAll('.color-btn').forEach(function (btn) {
                const inStock = variants.some(function (v) {
                    return v.color === btn.dataset.color && v.stock > 0 && (!selectedSize || v.size === selectedSize);
                });
                btn.disabled = !inStock;
            });
        }
        function previewColorGallery() {
            if (!selectedColor) { setVariantGallery(productImages); return; }
            const v = variants.find(function (x) { return x.color === selectedColor && x.images && x.images.length; })
                || variants.find(function (x) { return x.color === selectedColor; });
            if (v) setVariantGallery(v.images && v.images.length ? v.images : productImages);
        }
        function applyVariant() {
            refreshAvailability();
            const variant = currentVariant();
            const hint = document.getElementById('variantHint');
            const input = document.getElementById('variant_id');
            const qty = document.getElementById('quantity');
            const addBtn = document.getElementById('addToCartBtn');
            const buyBtn = document.getElementById('buyNowBtn');
            const priceEl = document.getElementById('displayPrice');
            const stockLine = document.getElementById('stockLine');
            const combo = document.getElementById('selectedComboLabel');
            const parts = [selectedColor, selectedSize].filter(Boolean);
            if (combo) combo.textContent = parts.length ? parts.join(' · ') : (variants.length ? 'Select finish & configuration' : 'Standard configuration');

            const pool = matching();
            const prices = pool.map(function (v) { return v.price > 0 ? v.price : basePrice; });
            if (prices.length && priceEl) {
                const min = Math.min.apply(null, prices);
                const max = Math.max.apply(null, prices);
                priceEl.textContent = min === max ? ('Rs. ' + min.toFixed(2)) : ('Rs. ' + min.toFixed(2) + ' - ' + max.toFixed(2));
            }

            if (!variant) {
                if (input) input.value = '';
                var descBox = document.getElementById('productDescription');
                var excerpt = document.getElementById('productExcerpt');
                if (descBox) descBox.textContent = productDefaultDescription || 'No description added for this product yet.';
                if (excerpt) excerpt.textContent = productDefaultDescription ? productDefaultDescription.substring(0, 240) : '';
                if (hint) { hint.classList.remove('hidden'); hint.textContent = 'Select finish and configuration to add to cart.'; }
                if (addBtn) addBtn.disabled = variants.length > 0;
                if (buyBtn) buyBtn.disabled = variants.length > 0;
                if (stockLine) stockLine.textContent = '';
                return;
            }
            if (hint) hint.classList.add('hidden');
            if (input) input.value = variant.id;
            var desc = (variant && variant.description) ? variant.description : productDefaultDescription;
            var descBox = document.getElementById('productDescription');
            var excerpt = document.getElementById('productExcerpt');
            if (descBox) descBox.textContent = desc || 'No description added for this product yet.';
            if (excerpt) excerpt.textContent = desc ? desc.substring(0, 240) : '';
            if (combo) combo.textContent = parts.join(' · ') + '  SKU #' + variant.id;
            if (priceEl) priceEl.textContent = 'Rs. ' + Number(variant.price > 0 ? variant.price : basePrice).toFixed(2);
            if (qty) {
                qty.max = Math.min(Math.max(variant.stock, 1), 10);
                if (parseInt(qty.value) > qty.max) qty.value = qty.max;
            }
            if (stockLine) {
                stockLine.textContent = variant.stock > 0 ? ('In stock · ' + variant.stock + ' units for this SKU') : 'This configuration is out of stock';
                stockLine.className = 'text-sm font-semibold ' + (variant.stock > 0 ? 'text-emerald-700' : 'text-red-600');
            }
            if (addBtn) addBtn.disabled = variant.stock <= 0;
            if (buyBtn) buyBtn.disabled = variant.stock <= 0;
            setVariantGallery(variant.images && variant.images.length ? variant.images : productImages);
        }
        function setVariantGallery(urls) {
            const list = (urls && urls.length) ? urls : productImages;
            const main = document.getElementById('mainProductImage');
            const thumbs = document.getElementById('productThumbs');
            if (main && list.length) { main.src = list[0]; main.classList.remove('hidden'); }
            if (!thumbs) return;
            if (list.length <= 1) { thumbs.classList.add('hidden'); thumbs.innerHTML = ''; return; }
            thumbs.classList.remove('hidden');
            thumbs.innerHTML = list.map(function (src, i) {
                const border = i === 0 ? 'border-[#2563EB]' : 'border-slate-200';
                return '<button type="button" onclick="changeProductImage(\'' + src + '\', this)" class="thumb-btn flex-shrink-0 w-[60px] h-[60px] rounded-lg border-2 overflow-hidden bg-white ' + border + '"><img src="' + src + '" class="w-full h-full object-contain p-1" alt=""></button>';
            }).join('');
        }
        function changeProductImage(src, btn) {
            const main = document.getElementById('mainProductImage');
            if (main) main.src = src;
            document.querySelectorAll('.thumb-btn').forEach(function (el) {
                el.classList.remove('border-[#2563EB]'); el.classList.add('border-slate-200');
            });
            if (btn) { btn.classList.remove('border-slate-200'); btn.classList.add('border-[#2563EB]'); }
        }
        function changeQty(d) {
            const input = document.getElementById('quantity');
            if (!input) return;
            const min = parseInt(input.min) || 1, max = parseInt(input.max) || 10;
            input.value = Math.min(Math.max((parseInt(input.value) || 1) + d, min), max);
        }
        function buyNow() {
            const form = document.getElementById('addToCartForm');
            if (!form) return;
            if (variants.length && !document.getElementById('variant_id').value) {
                alert('Select finish and configuration first.'); return;
            }
            document.getElementById('buy_now').value = '1';
            form.submit();
        }
        function switchTab(tab) {
            document.querySelectorAll('.tn-tab').forEach(function (btn) {
                const on = btn.getAttribute('data-tab') === tab;
                btn.classList.toggle('bg-slate-900', on);
                btn.classList.toggle('text-white', on);
                btn.classList.toggle('bg-slate-100', !on);
                btn.classList.toggle('text-slate-600', !on);
            });
            document.querySelectorAll('.tn-panel').forEach(function (panel) {
                if (panel.getAttribute('data-panel') === tab) {
                    panel.classList.remove('hidden');
                } else {
                    panel.classList.add('hidden');
                }
            });
            const box = document.getElementById('productTabs');
            if (box && tab !== 'description') {
                box.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function setProductTab(tab) {
            switchTab(tab);
        }

        function toggleWishlist(productId) {
            const body = new FormData();
            body.append('product_id', productId);
            body.append('_token', '{{ csrf_token() }}');

            fetch('{{ route('user.wishlist.toggle') }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: body
            }).then(function (res) {
                if (res.status === 401 || res.status === 419 || res.redirected) {
                    window.location.href = '{{ route('login') }}';
                    return null;
                }
                return res.json();
            }).then(function (data) {
                if (!data) return;
                const icon = document.getElementById('wishlistIcon');
                const label = document.getElementById('wishlistLabel');
                const on = !!data.wishlisted;
                if (icon) icon.setAttribute('fill', on ? 'currentColor' : 'none');
                if (label) label.textContent = on ? 'Saved to wishlist' : 'Save to wishlist';
            }).catch(function () {
                window.location.href = '{{ route('login') }}';
            });
        }
        function zoomMove(e) {
            const img = e.currentTarget.querySelector('img');
            if (!img) return;
            const r = e.currentTarget.getBoundingClientRect();
            img.style.transformOrigin = ((e.clientX - r.left) / r.width * 100) + '% ' + ((e.clientY - r.top) / r.height * 100) + '%';
        }
        function zoomLeave(e) {
            const img = e.currentTarget.querySelector('img');
            if (img) img.style.transformOrigin = 'center center';
        }

        refreshAvailability();
        if (variants.length === 1) {
            if (variants[0].color) selectColor(variants[0].color);
            if (variants[0].size) selectSize(variants[0].size);
        } else if (variants.length > 0) {
            const addBtn = document.getElementById('addToCartBtn');
            const buyBtn = document.getElementById('buyNowBtn');
            if (addBtn) addBtn.disabled = true;
            if (buyBtn) buyBtn.disabled = true;
        }
    </script>

</div>
    <script>
        function switchTab(tab) {
            document.querySelectorAll('.tn-tab').forEach(function (btn) {
                var on = btn.getAttribute('data-tab') === tab;
                btn.classList.toggle('bg-slate-900', on);
                btn.classList.toggle('text-white', on);
                btn.classList.toggle('bg-slate-100', !on);
                btn.classList.toggle('text-slate-600', !on);
            });
            document.querySelectorAll('.tn-panel').forEach(function (panel) {
                panel.classList.toggle('hidden', panel.getAttribute('data-panel') !== tab);
            });
        }

        document.addEventListener('click', function (e) {
            var tabBtn = e.target.closest('.tn-tab');
            if (tabBtn) {
                e.preventDefault();
                switchTab(tabBtn.getAttribute('data-tab'));
            }
        });

        function toggleWishlist(productId) {
            var body = new FormData();
            body.append('product_id', productId);
            body.append('_token', '{{ csrf_token() }}');

            fetch('{{ route('user.wishlist.toggle') }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: body
            }).then(function (res) {
                if (res.status === 401 || res.status === 419) {
                    window.location.href = '{{ route('login') }}';
                    return null;
                }
                return res.json();
            }).then(function (data) {
                if (!data) return;
                var icon = document.getElementById('wishlistIcon');
                var label = document.getElementById('wishlistLabel');
                if (icon) icon.setAttribute('fill', data.wishlisted ? 'currentColor' : 'none');
                if (label) label.textContent = data.wishlisted ? 'Saved to wishlist' : 'Save to wishlist';
            }).catch(function () {
                window.location.href = '{{ route('login') }}';
            });
        }
    </script>
=======
    {{-- END outer wrapper --}}


    {{-- ========================================================= --}}
    {{-- JavaScript --}}
    {{-- ========================================================= --}}
    <script>
        function changeProductImage(src, btn) {
            const mainImage = document.getElementById('mainProductImage');
            if (mainImage) {
                mainImage.src = src;
            }

            document.querySelectorAll('.thumb-btn').forEach(function(element) {
                element.classList.remove('border-blue-500');
                element.classList.add('border-gray-200');
            });

            if (btn) {
                btn.classList.remove('border-gray-200');
                btn.classList.add('border-blue-500');
            }
        }

        function changeQty(delta) {
            const input = document.getElementById('quantity');
            if (!input) return;

            let value = parseInt(input.value) || 1;
            const min = parseInt(input.min) || 1;
            const max = parseInt(input.max) || 10;

            value += delta;

            if (value < min) value = min;
            if (value > max) value = max;

            input.value = value;

            syncCartQuantity();
        }

        function syncCartQuantity() {
            const quantityInput = document.getElementById('quantity');
            if (!quantityInput) return;

            let quantity = parseInt(quantityInput.value) || 1;
            const min = parseInt(quantityInput.min) || 1;
            const max = parseInt(quantityInput.max) || 10;

            if (quantity < min) quantity = min;
            if (quantity > max) quantity = max;

            quantityInput.value = quantity;

            const cartQuantity = document.getElementById('cartQuantity');
            const buyNowQuantity = document.getElementById('buyNowQuantity');

            if (cartQuantity) cartQuantity.value = quantity;
            if (buyNowQuantity) buyNowQuantity.value = quantity;
        }

        function buyNowSubmit() {
            syncCartQuantity();
            return true;
        }

        function addToWishlist(productId) {
            alert('Wishlist functionality will be connected soon.');
        }

        document.addEventListener('DOMContentLoaded', function() {
            syncCartQuantity();
        });
    </script>

>>>>>>> Stashed changes
</x-frontend-layout>

