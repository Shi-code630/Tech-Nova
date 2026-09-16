<x-frontend-layout class="bg-[#eef2f7]">
<style>
    [x-cloak]{display:none!important}
    .tn-zoom{overflow:hidden;cursor:crosshair}
    .tn-zoom img{transition:transform .12s ease;will-change:transform}
    @media (hover:hover){.tn-zoom:hover img{transform:scale(1.55)}}
    .finish-on span{box-shadow:0 0 0 2px #fff,0 0 0 4px #2563EB}
    .cfg-on{border-color:#2563EB!important;background:#eff6ff!important;color:#1d4ed8!important}
</style>
<div>
    @if (session('success'))
        <div class="Container mx-auto px-4 pt-4">
            <div class="rounded-xl bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm font-medium">{{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="Container mx-auto px-4 pt-4">
            <div class="rounded-xl bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm font-medium">{{ session('error') }}</div>
        </div>
    @endif

    <div class="Container mx-auto px-4 pb-14">
        @php
            $category = $product->category;
            $ancestors = $category ? $category->getAncestors() : collect();
            $images = is_array($product->thumbnails) ? $product->thumbnails : [];
            $mainImage = $images[0] ?? null;
            $originalPrice = (float) ($product->price ?? 0);
            $discountPrice = $product->discount_price !== null && (float) $product->discount_price > 0 ? (float) $product->discount_price : null;
            $discountPercent = ($discountPrice && $originalPrice > 0 && $discountPrice < $originalPrice)
                ? round((1 - $discountPrice / $originalPrice) * 100) : 0;
            $finalPrice = ($discountPrice && $discountPrice < $originalPrice) ? $discountPrice : $originalPrice;
            $youSave = ($discountPrice && $discountPrice < $originalPrice) ? $originalPrice - $discountPrice : 0;
            $activeVariants = $product->variants ?? collect();
            $productStock = $activeVariants->count() ? (int) $activeVariants->sum('stock') : (int) ($product->stock ?? 0);
            $avgRating = round((float) ($product->average_rating ?? 0), 1);
            $reviewsCount = (int) ($product->reviews_count ?? 0);
            $colors = $activeVariants->pluck('color')->filter()->unique()->values();
            $sizes = $activeVariants->pluck('size')->filter()->unique()->values();
            $ratingBreakdown = $ratingBreakdown ?? collect([5=>0,4=>0,3=>0,2=>0,1=>0]);
            $colorHexMap = [
                'black'=>'#111827','white'=>'#f8fafc','red'=>'#dc2626','blue'=>'#2563EB','navy'=>'#1e3a8a',
                'green'=>'#16a34a','silver'=>'#c0c7d1','grey'=>'#6b7280','gray'=>'#6b7280','gold'=>'#d4af37',
                'pink'=>'#ec4899','purple'=>'#7c3aed','orange'=>'#f97316','space gray'=>'#4b5563','graphite'=>'#374151',
                'midnight'=>'#0f172a','starlight'=>'#f5f0e6','natural titanium'=>'#b8b0a4','blue titanium'=>'#5b6b7a',
            ];
            $colorSwatches = [];
            foreach ($colors as $color) {
                $match = $activeVariants->first(function ($v) use ($color) {
                    return $v->color === $color && count($v->gallery ?? []);
                }) ?: $activeVariants->firstWhere('color', $color);
                $gallery = $match->gallery ?? [];
                $colorSwatches[$color] = [
                    'image' => $gallery ? asset('storage/'.$gallery[0]) : null,
                    'hex' => $colorHexMap[strtolower(trim($color))] ?? null,
                ];
            }
            $variantsForJs = $activeVariants->map(function ($v) {
                $gallery = collect($v->gallery ?? [])->map(fn ($img) => asset('storage/'.$img))->values();
                return [
                    'id'=>$v->id,'color'=>$v->color,'size'=>$v->size,
                    'price'=>(float)$v->price,'stock'=>(int)$v->stock,
                    'image'=>$gallery->first(),'images'=>$gallery,
                    'description' => $v->description,
                ];
            })->values();
            $productImagesForJs = collect($images)->map(fn ($img) => asset('storage/'.$img))->values();
        @endphp

        <nav class="flex flex-wrap items-center gap-2 text-[13px] text-slate-500 py-4">
            <a href="{{ route('home') }}" class="hover:text-[#2563EB]">Home</a>
            @foreach ($ancestors as $ancestor)
                <span>/</span>
                <a href="{{ route('category.show', ['slug'=>$ancestor->slug]) }}" class="hover:text-[#2563EB]">{{ $ancestor->name }}</a>
            @endforeach
            @if ($category)
                <span>/</span>
                <a href="{{ route('category.show', ['slug'=>$category->slug]) }}" class="hover:text-[#2563EB]">{{ $category->name }}</a>
            @endif
            <span>/</span>
            <span class="text-slate-700 line-clamp-1">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

            {{-- Gallery --}}
            <div class="lg:col-span-5 lg:sticky lg:top-20">
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="flex flex-col-reverse md:flex-row">
                        <div id="productThumbs" class="flex md:flex-col gap-2 p-3 overflow-auto md:max-h-[500px] md:w-[76px] bg-slate-50 {{ count($images)>1?'':'hidden' }}">
                            @foreach ($images as $index => $image)
                                <button type="button" onclick="changeProductImage(@js(asset('storage/'.$image)), this)"
                                    class="thumb-btn flex-shrink-0 w-[60px] h-[60px] rounded-lg border-2 overflow-hidden bg-white {{ $index===0?'border-[#2563EB]':'border-slate-200' }}">
                                    <img src="{{ asset('storage/'.$image) }}" class="w-full h-full object-contain p-1" alt="">
                                </button>
                            @endforeach
                        </div>
                        <div class="relative flex-1 bg-[#0f172a]">
                            @if ($discountPercent > 0)
                                <span class="absolute z-10 top-3 left-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded">-{{ $discountPercent }}%</span>
                            @endif
                            <button type="button" onclick="toggleWishlist({{ $product->id }})"
                                class="absolute z-10 top-3 right-3 w-10 h-10 rounded-full bg-white/95 flex items-center justify-center {{ !empty($isWishlisted)?'text-red-500':'text-slate-500' }}">
                                <svg id="wishlistIcon" class="w-5 h-5" fill="{{ !empty($isWishlisted)?'currentColor':'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                            <div class="tn-zoom min-h-[340px] md:min-h-[460px] flex items-center justify-center" onmousemove="zoomMove(event)" onmouseleave="zoomLeave(event)">
                                @if ($mainImage)
                                    <img id="mainProductImage" src="{{ asset('storage/'.$mainImage) }}" alt="{{ $product->name }}" class="max-h-[420px] md:max-h-[440px] w-auto object-contain p-6">
                                @else
                                    <span class="text-slate-400 text-sm">No image</span>
                                    <img id="mainProductImage" src="" alt="" class="hidden">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between px-4 py-2.5 bg-slate-900 text-slate-300 text-[11px] tracking-wide">
                        <span>TECHNOVA NEPAL · GENUINE HARDWARE</span>
                        <span class="hidden sm:inline">Hover image to inspect</span>
                    </div>
                </div>
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
</x-frontend-layout>
