<x-frontend-layout>

    <div class="bg-gray-100 py-8">

        <div class="Container mx-auto">

            <div class="flex gap-6">

                <!-- Sidebar -->
                <x-user-dashboard.sidebar />

                <!-- Main Content -->
                <main class="flex-1 min-w-0">

                    <!-- Header -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">

                        <div class="flex items-center justify-between gap-4">

                            <div>
                                <div class="flex items-center gap-3">

                                    <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke-width="1.8"
                                             stroke="currentColor"
                                             class="w-6 h-6 text-red-500">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733C11.285 4.876 9.623 3.75 7.688 3.75 5.099 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>

                                        </svg>

                                    </div>

                                    <div>
                                        <h1 class="text-2xl font-bold text-[#111827]">
                                            My Wishlist
                                        </h1>

                                        <p class="text-gray-500 mt-1">
                                            Products you've saved for later.
                                        </p>
                                    </div>

                                </div>
                            </div>

                            @if(isset($wishlist) && $wishlist->count() > 0)

                                <div class="hidden sm:flex items-center gap-2
                                            bg-red-50 text-red-600
                                            px-4 py-2 rounded-xl font-semibold">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor"
                                         class="w-5 h-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733C11.285 4.876 9.623 3.75 7.688 3.75 5.099 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>

                                    </svg>

                                    {{ $wishlist->count() }}
                                    {{ $wishlist->count() == 1 ? 'Item' : 'Items' }}

                                </div>

                            @endif

                        </div>

                    </div>


                    <!-- Wishlist Products -->
                    @if(isset($wishlist) && $wishlist->count() > 0)

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                            @foreach($wishlist as $wishlistItem)

                                @php
                                    $product = $wishlistItem->product;

                                    $image = null;

                                    if ($product) {

                                        if (is_array($product->thumbnails ?? null)) {

                                            $image = $product->thumbnails[0] ?? null;

                                        } elseif (!empty($product->thumbnails)) {

                                            $image = $product->thumbnails;

                                        } elseif (!empty($product->image)) {

                                            $image = $product->image;

                                        }
                                    }

                                    $price = $product->discount_price
                                        ?? $product->price
                                        ?? 0;

                                    $originalPrice = $product->price ?? 0;

                                    $discountPercent = 0;

                                    if (
                                        $originalPrice > 0 &&
                                        $price < $originalPrice
                                    ) {
                                        $discountPercent = round(
                                            (($originalPrice - $price) / $originalPrice) * 100
                                        );
                                    }
                                @endphp


                                @if($product)

                                    <div class="bg-white rounded-2xl shadow-sm
                                                border border-gray-100
                                                overflow-hidden
                                                group
                                                hover:shadow-xl
                                                hover:-translate-y-1
                                                transition duration-300">

                                        <!-- Product Image -->
                                        <div class="relative bg-gray-50 h-64
                                                    flex items-center justify-center
                                                    overflow-hidden">

                                            @if($image)

                                                <img
                                                    src="{{ asset('storage/' . $image) }}"
                                                    alt="{{ $product->name }}"
                                                    class="w-full h-full object-contain
                                                           p-5
                                                           group-hover:scale-105
                                                           transition duration-300"
                                                >

                                            @else

                                                <div class="flex flex-col items-center
                                                            justify-center text-gray-400">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke-width="1.5"
                                                         stroke="currentColor"
                                                         class="w-16 h-16 mb-2">

                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.409 5.409m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.659 2.659m-18 2.25h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"/>

                                                    </svg>

                                                    <span class="text-sm">
                                                        Image unavailable
                                                    </span>

                                                </div>

                                            @endif


                                            <!-- Wishlist Heart -->
                                            <div class="absolute top-4 right-4
                                                        w-10 h-10
                                                        bg-white rounded-full
                                                        shadow-md
                                                        flex items-center justify-center">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 24 24"
                                                     fill="currentColor"
                                                     class="w-5 h-5 text-red-500">

                                                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.217 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.892 2.25 9.75A5.25 5.25 0 0 1 7.5 4.5c1.82 0 3.35.867 4.5 2.185A5.486 5.486 0 0 1 16.5 4.5a5.25 5.25 0 0 1 5.25 5.25c0 3.142-2.438 5.61-4.739 7.758a25.18 25.18 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.217l-.022.012-.007.003-.003.001a.75.75 0 0 1-.704 0l-.003-.001Z"/>

                                                </svg>

                                            </div>


                                            <!-- Discount Badge -->
                                            @if($discountPercent > 0)

                                                <span class="absolute top-4 left-4
                                                             bg-red-500 text-white
                                                             text-xs font-bold
                                                             px-3 py-1.5
                                                             rounded-lg">

                                                    -{{ $discountPercent }}%

                                                </span>

                                            @endif

                                        </div>


                                        <!-- Product Information -->
                                        <div class="p-5">

                                            <h2 class="text-lg font-bold text-gray-900
                                                       line-clamp-2
                                                       min-h-[56px]">

                                                {{ $product->name }}

                                            </h2>


                                            <!-- Price -->
                                            <div class="mt-3 flex items-center gap-2 flex-wrap">

                                                <span class="text-xl font-bold text-[#2563EB]">

                                                    Rs. {{ number_format($price, 2) }}

                                                </span>


                                                @if($discountPercent > 0)

                                                    <span class="text-sm text-gray-400 line-through">

                                                        Rs. {{ number_format($originalPrice, 2) }}

                                                    </span>

                                                @endif

                                            </div>


                                            <!-- Stock -->
                                            @if(isset($product->stock))

                                                @if($product->stock > 0)

                                                    <div class="flex items-center gap-2 mt-3">

                                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>

                                                        <span class="text-sm text-green-600 font-medium">

                                                            In Stock

                                                        </span>

                                                    </div>

                                                @else

                                                    <div class="flex items-center gap-2 mt-3">

                                                        <span class="w-2 h-2 rounded-full bg-red-500"></span>

                                                        <span class="text-sm text-red-600 font-medium">

                                                            Out of Stock

                                                        </span>

                                                    </div>

                                                @endif

                                            @endif


                                            <!-- Buttons -->
                                            <div class="flex gap-3 mt-5">

                                                <!-- View Product -->
                                                <a
                                                    href="{{ route('product.show', $product->slug) }}"
                                                    class="flex-1 inline-flex items-center
                                                           justify-center gap-2
                                                           px-4 py-3
                                                           bg-[#2563EB]
                                                           hover:bg-blue-700
                                                           text-white
                                                           font-semibold
                                                           rounded-xl
                                                           transition">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke-width="1.8"
                                                         stroke="currentColor"
                                                         class="w-5 h-5">

                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="M2.036 12.322a1.012 1.012 0 0 1 0-.644C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.178a1.012 1.012 0 0 1 0 .644C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178Z"/>

                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>

                                                    </svg>

                                                    View

                                                </a>


                                                <!-- Remove -->
                                                <form
                                                    action="{{ route('user.wishlist.remove', $product->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Remove this product from your wishlist?');"
                                                >

                                                    @csrf

                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="w-12 h-12
                                                               inline-flex items-center justify-center
                                                               border border-red-200
                                                               text-red-500
                                                               hover:bg-red-50
                                                               rounded-xl
                                                               transition"
                                                        title="Remove from wishlist"
                                                    >

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             fill="none"
                                                             viewBox="0 0 24 24"
                                                             stroke-width="1.8"
                                                             stroke="currentColor"
                                                             class="w-5 h-5">

                                                            <path stroke-linecap="round"
                                                                  stroke-linejoin="round"
                                                                  d="M6 7.5h12m-10.5 0v10.125A1.875 1.875 0 0 0 9.375 19.5h5.25a1.875 1.875 0 0 0 1.875-1.875V7.5m-8.25 0V5.625A1.125 1.125 0 0 1 9.375 4.5h5.25a1.125 1.125 0 0 1 1.125 1.125V7.5m-6 3v5.25m3-5.25v5.25"/>

                                                        </svg>

                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                @endif

                            @endforeach

                        </div>


                    @else

                        <!-- Empty Wishlist -->
                        <div class="bg-white rounded-2xl shadow-sm
                                    border border-gray-100 p-8">

                            <div class="text-center py-16">

                                <div class="w-24 h-24 mx-auto mb-6
                                            rounded-full
                                            bg-red-50
                                            flex items-center justify-center">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="w-12 h-12 text-red-500">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733C11.285 4.876 9.623 3.75 7.688 3.75 5.099 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>

                                    </svg>

                                </div>


                                <h2 class="text-2xl font-bold text-[#111827]">

                                    Your Wishlist is Empty

                                </h2>


                                <p class="text-gray-500 mt-2 max-w-md mx-auto">

                                    You haven't saved any products yet.
                                    Explore our collection and save your favorite products here.

                                </p>


                                <a
                                    href="{{ route('home') }}"
                                    class="inline-flex items-center justify-center
                                           gap-2
                                           mt-7
                                           px-7 py-3.5
                                           bg-[#2563EB]
                                           hover:bg-blue-700
                                           text-white
                                           font-semibold
                                           rounded-xl
                                           shadow-sm
                                           transition"
                                >

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor"
                                         class="w-5 h-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M2.25 3h1.386c.51 0 .955.343 1.087.835L5.25 6.75m0 0h13.5l-1.5 9h-10.5l-1.5-9Zm0 0L4.5 4.5m3.75 14.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm9 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>

                                    </svg>

                                    Continue Shopping

                                </a>

                            </div>

                        </div>

                    @endif

                </main>

            </div>

        </div>

    </div>

</x-frontend-layout>
