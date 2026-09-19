<x-frontend-layout>

    <div class="bg-gray-100 py-8">

        <div class="Container mx-auto px-4">

            {{-- =========================================================
                HEADER
            ========================================================== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

                <h1 class="text-2xl font-bold text-gray-900">
                    Review Your Order
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Order #{{ $order->order_number }}
                </p>

            </div>


            {{-- =========================================================
                SUCCESS MESSAGE
            ========================================================== --}}
            @if (session('success'))

                <div class="mb-6 rounded-xl bg-green-50 border border-green-200 p-4">

                    <p class="text-green-700 text-sm font-medium">
                        {{ session('success') }}
                    </p>

                </div>

            @endif


            {{-- =========================================================
                ERROR MESSAGE
            ========================================================== --}}
            @if (session('error'))

                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">

                    <p class="text-red-700 text-sm font-medium">
                        {{ session('error') }}
                    </p>

                </div>

            @endif


            {{-- =========================================================
                VALIDATION ERRORS
            ========================================================== --}}
            @if ($errors->any())

                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">

                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =========================================================
                PRODUCTS
            ========================================================== --}}
            @forelse($order->items as $item)

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-5">


                    {{-- =====================================================
                        PRODUCT INFORMATION
                    ====================================================== --}}
                    <div class="flex items-start gap-4">


                        {{-- PRODUCT IMAGE --}}
             
{{-- PRODUCT IMAGE --}}
@php
    $productImage = null;

    if ($item->product) {

        // 1. thumbnails array
        if (
            isset($item->product->thumbnails) &&
            is_array($item->product->thumbnails) &&
            count($item->product->thumbnails) > 0
        ) {
            $productImage = $item->product->thumbnails[0];
        }

        // 2. image field
        if (!$productImage && !empty($item->product->image)) {
            $productImage = $item->product->image;
        }

        // 3. thumbnail field
        if (!$productImage && !empty($item->product->thumbnail)) {
            $productImage = $item->product->thumbnail;
        }

        // If image itself is array
        if (is_array($productImage)) {
            $productImage = $productImage[0] ?? null;
        }
    }
@endphp


<div
    class="w-20
           h-20
           rounded-xl
           bg-gray-100
           overflow-hidden
           flex-shrink-0">

    @if ($productImage)

        <img
            src="{{ asset('storage/' . ltrim($productImage, '/')) }}"
            alt="{{ $item->product->name ?? 'Product' }}"
            class="w-full
                   h-full
                   object-contain
                   p-1">

    @else

        <div
            class="w-full
                   h-full
                   flex
                   items-center
                   justify-center
                   text-gray-400
                   text-xs">

            No Image

        </div>

    @endif

</div>


                        {{-- PRODUCT INFO --}}
                        <div class="flex-1 min-w-0">

                            <h2
                                class="text-lg
                                       font-bold
                                       text-gray-900
                                       line-clamp-2">

                                {{ $item->product->name ?? 'Product' }}

                            </h2>

                            <p class="text-sm text-gray-500 mt-1">

                                Quantity:
                                {{ $item->quantity }}

                            </p>

                            <p class="text-sm text-gray-500">

                                Price:
                                Rs. {{ number_format($item->price, 2) }}

                            </p>

                        </div>

                    </div>


                    {{-- =====================================================
                        REVIEW FORM
                    ====================================================== --}}
                    <form
                        action="{{ route('orders.review.submit', $order) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mt-6">

                        @csrf


                        {{-- PRODUCT ID --}}
                        <input
                            type="hidden"
                            name="product_id"
                            value="{{ $item->product_id }}">


                        {{-- =================================================
                            RATING
                        ================================================== --}}
                        <div class="mb-5">

                            <label
                                class="block
                                       text-sm
                                       font-semibold
                                       text-gray-700
                                       mb-2">

                                Your Rating

                            </label>

                            <select
                                name="rating"
                                required
                                class="w-full
                                       rounded-xl
                                       border
                                       border-gray-300
                                       px-4
                                       py-3
                                       bg-white
                                       focus:border-blue-500
                                       focus:ring-blue-500">

                                <option value="">
                                    Select Rating
                                </option>

                                <option
                                    value="5"
                                    {{ old('rating') == 5 ? 'selected' : '' }}>
                                    ★★★★★ — Excellent
                                </option>

                                <option
                                    value="4"
                                    {{ old('rating') == 4 ? 'selected' : '' }}>
                                    ★★★★☆ — Very Good
                                </option>

                                <option
                                    value="3"
                                    {{ old('rating') == 3 ? 'selected' : '' }}>
                                    ★★★☆☆ — Good
                                </option>

                                <option
                                    value="2"
                                    {{ old('rating') == 2 ? 'selected' : '' }}>
                                    ★★☆☆☆ — Fair
                                </option>

                                <option
                                    value="1"
                                    {{ old('rating') == 1 ? 'selected' : '' }}>
                                    ★☆☆☆☆ — Poor
                                </option>

                            </select>

                        </div>


                        {{-- =================================================
                            REVIEW
                        ================================================== --}}
                        <div class="mb-5">

                            <label
                                class="block
                                       text-sm
                                       font-semibold
                                       text-gray-700
                                       mb-2">

                                Your Review

                            </label>

                            <textarea
                                name="review"
                                rows="4"
                                class="w-full
                                       rounded-xl
                                       border
                                       border-gray-300
                                       px-4
                                       py-3
                                       focus:border-blue-500
                                       focus:ring-blue-500"
                                placeholder="Write your review...">{{ old('review') }}</textarea>

                        </div>


                        {{-- =================================================
                            REVIEW IMAGE
                        ================================================== --}}
                        <div class="mb-5">

                            <label
                                class="block
                                       text-sm
                                       font-semibold
                                       text-gray-700
                                       mb-2">

                                Add Photo
                                <span class="text-gray-400 font-normal">
                                    (Optional)
                                </span>

                            </label>


                            {{-- SELECT IMAGE --}}
                            <label
                                for="review_image_{{ $item->id }}"
                                class="inline-flex
                                       items-center
                                       gap-2
                                       px-4
                                       py-2.5
                                       rounded-xl
                                       bg-blue-50
                                       text-blue-600
                                       border
                                       border-blue-200
                                       hover:bg-blue-100
                                       cursor-pointer
                                       transition
                                       text-sm
                                       font-semibold">

                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />

                                </svg>

                                <span>
                                    Select Image
                                </span>

                            </label>


                            {{-- FILE INPUT --}}
                            <input
                                type="file"
                                id="review_image_{{ $item->id }}"
                                name="review_image"
                                accept="image/jpeg,image/png,image/webp"
                                class="hidden"
                                onchange="previewReviewImage(
                                    this,
                                    '{{ $item->id }}'
                                )">


                            {{-- IMAGE PREVIEW --}}
                            <div
                                id="review_preview_{{ $item->id }}"
                                class="hidden mt-3">

                                <div class="flex items-start gap-3">

                                    <img
                                        id="review_preview_img_{{ $item->id }}"
                                        src=""
                                        alt="Review image preview"
                                        class="w-24
                                               h-24
                                               object-cover
                                               rounded-xl
                                               border
                                               border-gray-200">


                                    <button
                                        type="button"
                                        onclick="removeReviewImage('{{ $item->id }}')"
                                        class="text-xs
                                               text-red-500
                                               hover:text-red-600
                                               font-medium">

                                        Remove Image

                                    </button>

                                </div>

                            </div>


                            <p class="text-xs text-gray-400 mt-2">
                                JPG, PNG or WEBP. Maximum 2MB.
                            </p>

                        </div>


                        {{-- =================================================
                            SUBMIT
                        ================================================== --}}
                        <button
                            type="submit"
                            class="w-full
                                   sm:w-auto
                                   px-6
                                   py-3
                                   rounded-xl
                                   bg-blue-600
                                   hover:bg-blue-700
                                   text-white
                                   font-semibold
                                   transition
                                   inline-flex
                                   items-center
                                   justify-center
                                   gap-2">

                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7" />

                            </svg>

                            Submit Review

                        </button>

                    </form>

                </div>

            @empty

                {{-- =========================================================
                    NO PRODUCTS
                ========================================================== --}}
                <div
                    class="bg-white
                           rounded-2xl
                           shadow-sm
                           p-10
                           text-center">

                    <div
                        class="w-16
                               h-16
                               mx-auto
                               rounded-full
                               bg-gray-100
                               flex
                               items-center
                               justify-center
                               mb-4">

                        <svg
                            class="w-8 h-8 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0l-2.5-2.5a2 2 0 00-2.828 0L12 14.172l-1.672-1.672a2 2 0 00-2.828 0L5 15m15-2v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5" />

                        </svg>

                    </div>

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


    {{-- =============================================================
        IMAGE PREVIEW JAVASCRIPT
    ============================================================== --}}
    <script>

        function previewReviewImage(input, id)
        {
            const preview = document.getElementById(
                'review_preview_' + id
            );

            const previewImage = document.getElementById(
                'review_preview_img_' + id
            );


            if (!input.files || !input.files[0]) {

                preview.classList.add('hidden');

                previewImage.src = '';

                return;
            }


            const file = input.files[0];


            // Check image type
            if (!file.type.startsWith('image/')) {

                alert('Please select a valid image.');

                input.value = '';

                preview.classList.add('hidden');

                previewImage.src = '';

                return;
            }


            // Check file size - 2MB
            if (file.size > 2 * 1024 * 1024) {

                alert('Image size must be less than 2MB.');

                input.value = '';

                preview.classList.add('hidden');

                previewImage.src = '';

                return;
            }


            const reader = new FileReader();


            reader.onload = function(event) {

                previewImage.src =
                    event.target.result;

                preview.classList.remove('hidden');

            };


            reader.readAsDataURL(file);
        }


        function removeReviewImage(id)
        {
            const input = document.getElementById(
                'review_image_' + id
            );

            const preview = document.getElementById(
                'review_preview_' + id
            );

            const previewImage = document.getElementById(
                'review_preview_img_' + id
            );


            if (input) {
                input.value = '';
            }

            if (previewImage) {
                previewImage.src = '';
            }

            if (preview) {
                preview.classList.add('hidden');
            }
        }

    </script>

</x-frontend-layout>
