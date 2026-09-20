<x-frontend-layout title="Today's deals | TechNova Nepal" description="Limited-time laptop and gadget deals at TechNova Nepal, Kathmandu." :canonical="route('today-deals')">  <div class="bg-[#ebf4fa] full py-2">


{{-- =========================================================
    PAGE WRAPPER
========================================================== --}}
<div class="Container mx-auto py-5">

    {{-- =========================================================
        CUSTOM ANIMATION
    ========================================================== --}}
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(22px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes floatSlow {
            0%,
            100% {
                transform: translateY(0) translateX(0);
            }

            50% {
                transform: translateY(-12px) translateX(8px);
            }
        }

        @keyframes floatReverse {
            0%,
            100% {
                transform: translateY(0) translateX(0);
            }

            50% {
                transform: translateY(12px) translateX(-8px);
            }
        }

        @keyframes pulseSoft {
            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.04);
                opacity: .9;
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-120%);
            }

            100% {
                transform: translateX(120%);
            }
        }

        .deal-page-header {
            animation: fadeUp .7s ease-out both;
        }

        .deal-section {
            animation: fadeUp .65s ease-out both;
        }

        .deal-badge {
            animation: pulseSoft 2.5s ease-in-out infinite;
        }

        .floating-one {
            animation: floatSlow 7s ease-in-out infinite;
        }

        .floating-two {
            animation: floatReverse 9s ease-in-out infinite;
        }

        .product-card {
            animation: fadeUp .55s ease-out both;
            transition:
                transform .3s ease,
                box-shadow .3s ease,
                border-color .3s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
        }

        .product-image {
            transition:
                transform .5s cubic-bezier(.2, .8, .2, 1);
        }

        .product-card:hover .product-image {
            transform: scale(1.07);
        }

        .wishlist-button:hover {
            transform: scale(1.08);
        }

        .wishlist-button:active {
            transform: scale(.92);
        }

        .deal-shimmer {
            position: absolute;
            inset: 0;
            width: 45%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, .08),
                transparent
            );
            transform: translateX(-120%);
            animation: shimmer 5s ease-in-out infinite;
            pointer-events: none;
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>


    {{-- =========================================================
        BREADCRUMB
    ========================================================== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <nav
            class="flex items-center gap-2 text-[12px] overflow-x-auto whitespace-nowrap">

            <a
                href="{{ route('home') }}"
                class="text-slate-500 hover:text-blue-600 transition-colors duration-200">

                Home

            </a>

            <span class="text-slate-300">
                /
            </span>

            <span class="text-slate-800 font-semibold">
                {{ $category->name }}
            </span>

        </nav>

    </div>


    {{-- =========================================================
        MAIN HERO
    ========================================================== --}}
    <section
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">

        <div
            class="deal-page-header
                   relative
                   overflow-hidden
                   rounded-[20px]
                   bg-gradient-to-br
                   from-blue-700
                   via-blue-600
                   to-indigo-700
                   shadow-[0_10px_30px_rgba(37,99,235,0.16)]">

            {{-- Decorative circle --}}
            <div
                class="floating-one
                       absolute
                       -top-16
                       -right-10
                       w-44
                       h-44
                       rounded-full
                       bg-white/10">
            </div>

            {{-- Decorative circle --}}
            <div
                class="floating-two
                       absolute
                       -bottom-20
                       -left-12
                       w-52
                       h-52
                       rounded-full
                       bg-indigo-400/20">
            </div>

            {{-- Decorative dots --}}
            <div
                class="absolute
                       top-6
                       right-[25%]
                       w-1.5
                       h-1.5
                       rounded-full
                       bg-white/30">
            </div>

            <div
                class="absolute
                       bottom-6
                       right-[18%]
                       w-2
                       h-2
                       rounded-full
                       bg-white/20">
            </div>

            <div class="deal-shimmer"></div>

            <div
                class="relative
                       px-5
                       py-4
                       sm:px-7
                       md:px-9
                       md:py-5">

                {{-- Badge --}}
                <div
                    class="deal-badge
                           inline-flex
                           items-center
                           gap-2
                           bg-white/10
                           border
                           border-white/20
                           backdrop-blur-sm
                           text-white
                           px-3
                           py-1.5
                           rounded-full
                           text-[9px]
                           font-bold
                           uppercase
                           tracking-[.14em]
                           mb-2">

                    <span
                        class="flex
                               items-center
                               justify-center
                               w-5
                               h-5
                               rounded-full
                               bg-white/15
                               border
                               border-white/10">

                        {{-- Tag SVG --}}
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="w-3 h-3 text-white">

                            <path
                                d="M20.59 13.41L11 3H4v7l10.59 10.59a2 2 0 0 0 2.82 0l3.18-3.18a2 2 0 0 0 0-2.82Z">
                            </path>

                            <circle
                                cx="7.5"
                                cy="7.5"
                                r="1">
                            </circle>

                        </svg>

                    </span>

                    <span>
                        Today's Deals
                    </span>

                </div>


                {{-- Heading --}}
                <h1
                    class="text-xl
                           sm:text-2xl
                           md:text-3xl
                           font-black
                           tracking-tight
                           text-white
                           leading-tight">

                    {{ $category->name }}

                </h1>


                {{-- Description --}}
                <p
                    class="mt-1
                          max-w-xl
                          text-[11px]
                          sm:text-xs
                          text-blue-100
                          leading-5">

                    Discover exciting offers, exclusive deals and special prices
                    from our latest deal categories.

                </p>


                {{-- Info --}}
                <div
                    class="flex
                           flex-wrap
                           items-center
                           gap-2
                           mt-2">

                    {{-- Special Prices --}}
                    <div
                        class="inline-flex
                               items-center
                               gap-1.5
                               rounded-md
                               bg-white/10
                               border
                               border-white/10
                               px-2.5
                               py-1
                               text-[9px]
                               text-white">

                        {{-- Tag SVG --}}
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="w-3 h-3 text-blue-200 shrink-0">

                            <path
                                d="M20.59 13.41L11 3H4v7l10.59 10.59a2 2 0 0 0 2.82 0l3.18-3.18a2 2 0 0 0 0-2.82Z">
                            </path>

                            <circle
                                cx="7.5"
                                cy="7.5"
                                r="1">
                            </circle>

                        </svg>

                        <span>
                            Special Prices
                        </span>

                    </div>


                    {{-- Hot Deals --}}
                    <div
                        class="inline-flex
                               items-center
                               gap-1.5
                               rounded-md
                               bg-white/10
                               border
                               border-white/10
                               px-2.5
                               py-1
                               text-[9px]
                               text-white">

                        {{-- Flame SVG --}}
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="w-3 h-3 text-orange-300 shrink-0">

                            <path
                                d="M12 2C12 2 7 7 7 12a5 5 0 0 0 10 0c0-2.5-1.5-4.5-3-6 0 2-1 3-2 3-1.5-2-1-5-0-7Z">
                            </path>

                            <path d="M9.5 16.5a3 3 0 0 0 5 0">
                            </path>

                        </svg>

                        <span>
                            Hot Deals
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        CHILD CATEGORIES
    ========================================================== --}}
    <main
        class="max-w-7xl
               mx-auto
               px-4
               sm:px-6
               lg:px-8
               mt-9">

        @forelse ($childCategories as $child)

            @php
                /*
                |--------------------------------------------------------------------------
                | LIMITED TIME OFFER CHECK
                |--------------------------------------------------------------------------
                */
                $isLimitedTimeOffer =
                    $child->slug === 'limited-time-offer';

                /*
                |--------------------------------------------------------------------------
                | PRODUCTS
                |--------------------------------------------------------------------------
                | Limited Time Offer products are intentionally hidden here.
                | They will be shown on the dedicated Limited Time Offer page.
                |--------------------------------------------------------------------------
                */
                $currentChildProducts = $isLimitedTimeOffer
                    ? collect()
                    : (
                        isset($childProducts)
                        && is_array($childProducts)
                        ? ($childProducts[$child->id] ?? collect())
                        : ($child->today_deals_products ?? collect())
                    );
            @endphp


            {{-- =====================================================
                CHILD CATEGORY MAIN CONTAINER
            ====================================================== --}}
            <section
                class="deal-section
                       mb-10
                       rounded-[26px]
                       border
                       border-slate-200
                       bg-white
                       p-3
                       sm:p-4
                       shadow-[0_8px_30px_rgba(15,23,42,0.06)]
                       overflow-hidden">


                {{-- =================================================
                    LIMITED TIME OFFER BANNER
                ================================================== --}}
                @if ($isLimitedTimeOffer)

                    <a
                        href="{{ route('limited-time') }}"
                        class="group
                               relative
                               block
                               overflow-hidden
                               rounded-[20px]
                               bg-gradient-to-r
                               from-red-600
                               via-orange-500
                               to-amber-500
                               mb-1
                               shadow-[0_8px_25px_rgba(234,88,12,0.18)]
                               transition-all
                               duration-300
                               hover:-translate-y-1
                               hover:shadow-[0_14px_35px_rgba(234,88,12,0.25)]">

                        {{-- Decorative Circle --}}
                        <div
                            class="absolute
                                   -top-16
                                   -right-10
                                   w-44
                                   h-44
                                   rounded-full
                                   bg-white/10
                                   transition-transform
                                   duration-700
                                   group-hover:scale-110">
                        </div>


                        {{-- Decorative Circle --}}
                        <div
                            class="absolute
                                   -bottom-20
                                   left-[35%]
                                   w-52
                                   h-52
                                   rounded-full
                                   bg-white/10
                                   blur-2xl">
                        </div>


                        <div
                            class="relative
                                   flex
                                   items-center
                                   justify-between
                                   gap-4
                                   px-5
                                   py-5
                                   sm:px-7
                                   sm:py-6">

                            {{-- Left --}}
                            <div
                                class="flex
                                       items-center
                                       gap-4
                                       min-w-0">

                                {{-- Fire Icon --}}
                                <span
                                    class="w-12
                                           h-12
                                           sm:w-14
                                           sm:h-14
                                           rounded-2xl
                                           bg-white/15
                                           border
                                           border-white/20
                                           flex
                                           items-center
                                           justify-center
                                           shrink-0
                                           backdrop-blur-sm
                                           transition-transform
                                           duration-300
                                           group-hover:scale-110">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="w-6 h-6 sm:w-7 sm:h-7 text-white">

                                        <path
                                            d="M12 2
                                               C12 2 7 7 7 12
                                               C7 15.31 9.24 18 12 18
                                               C14.76 18 17 15.31 17 12
                                               C17 9.5 15.5 7.5 14 6
                                               C14 8 13 9 12 9
                                               C10.5 7 11 4 12 2Z">
                                        </path>

                                        <path
                                            d="M9.5 17.5
                                               C10.2 20
                                               13.8 20
                                               14.5 17.5">
                                        </path>

                                    </svg>

                                </span>


                                {{-- Text --}}
                                <div class="min-w-0">

                                    <div
                                        class="text-[9px]
                                               sm:text-[10px]
                                               font-bold
                                               uppercase
                                               tracking-[.18em]
                                               text-white/75
                                               mb-1">

                                        Special Deal

                                    </div>


                                    <h2
                                        class="text-xl
                                               sm:text-2xl
                                               md:text-[28px]
                                               font-black
                                               text-white
                                               tracking-tight
                                               leading-tight">

                                        Limited Time Offer

                                    </h2>


                                    <p
                                        class="mt-1
                                               text-[10px]
                                               sm:text-xs
                                               text-white/80">

                                        Grab exclusive deals before they disappear.

                                    </p>

                                </div>

                            </div>


                            {{-- Right Arrow --}}
                            <span
                                class="w-9
                                       h-9
                                       sm:w-10
                                       sm:h-10
                                       rounded-xl
                                       bg-white
                                       text-orange-600
                                       flex
                                       items-center
                                       justify-center
                                       shrink-0
                                       shadow-lg
                                       transition-all
                                       duration-300
                                       group-hover:translate-x-1
                                       group-hover:scale-105">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="w-4 h-4">

                                    <path d="M5 12h14"></path>
                                    <path d="m13 6 6 6-6 6"></path>

                                </svg>

                            </span>

                        </div>

                    </a>


                @else

                    {{-- =================================================
                        NORMAL CHILD CATEGORY HEADER
                    ================================================== --}}
                    <div
                        class="mb-4
                               px-2
                               sm:px-3
                               pt-1
                               pb-2
                               border-b
                               border-slate-200">

                        <div
                            class="flex
                                   items-center
                                   justify-between
                                   gap-3">

                            {{-- Left --}}
                            <div
                                class="flex
                                       items-center
                                       gap-2.5
                                       min-w-0">

                                <span
                                    class="w-1
                                           h-7
                                           rounded-full
                                           bg-blue-600
                                           shrink-0">
                                </span>


                                <div class="min-w-0">

                                    <h2
                                        class="text-lg
                                               sm:text-xl
                                               md:text-2xl
                                               font-extrabold
                                               tracking-tight
                                               text-slate-900
                                               truncate">

                                        {{ $child->name }}

                                    </h2>


                                    @if ($currentChildProducts->count())

                                        <p
                                            class="mt-0.5
                                                   text-[10px]
                                                   sm:text-xs
                                                   text-slate-400">

                                            Featured Products

                                        </p>

                                    @endif

                                </div>

                            </div>


                            {{-- View All --}}
                            <a
                                href="{{ route('category.show', ['slug' => $child->slug]) }}"
                                class="group
                                       inline-flex
                                       items-center
                                       gap-1.5
                                       shrink-0
                                       text-[10px]
                                       sm:text-xs
                                       font-bold
                                       text-blue-600
                                       hover:text-blue-700
                                       transition-colors
                                       duration-200">

                                <span>
                                    View All {{ $child->name }}
                                </span>


                                <span
                                    class="w-6
                                           h-6
                                           rounded-md
                                           bg-blue-50
                                           group-hover:bg-blue-600
                                           text-blue-600
                                           group-hover:text-white
                                           flex
                                           items-center
                                           justify-center
                                           transition-all
                                           duration-200
                                           group-hover:translate-x-1">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="w-3 h-3">

                                        <path d="M5 12h14"></path>
                                        <path d="m13 6 6 6-6 6"></path>

                                    </svg>

                                </span>

                            </a>

                        </div>

                    </div>

                @endif


                {{-- =========================================================
                    PRODUCTS AREA
                    LIMITED TIME OFFER KE LIYE YE AREA COMPLETELY HIDDEN
                ========================================================== --}}
                @if (!$isLimitedTimeOffer)

                    @if ($currentChildProducts->count())

                        <div
                            class="rounded-2xl
                                   bg-slate-50/70
                                   border
                                   border-slate-100
                                   p-2.5
                                   sm:p-3">

                            {{-- Product Grid --}}
                            <div
                                class="grid
                                       grid-cols-2
                                       sm:grid-cols-3
                                       md:grid-cols-4
                                       lg:grid-cols-5
                                       gap-3">

                                @foreach ($currentChildProducts as $index => $product)

                                    @php

                                        $hasDiscount =
                                            isset($product->discount_price) &&
                                            $product->discount_price &&
                                            $product->price > $product->discount_price;

                                        $discountAmount =
                                            $hasDiscount
                                                ? $product->price - $product->discount_price
                                                : 0;

                                        $discountPercent =
                                            $hasDiscount && $product->price > 0
                                                ? round(
                                                    ($discountAmount / $product->price) * 100
                                                )
                                                : 0;

                                        $isWishlisted =
                                            in_array(
                                                $product->id,
                                                $wishlistProductIds ?? []
                                            );

                                        $reviewCount =
                                            $product->reviews_count ?? 0;

                                        $thumb = null;

                                        if (!empty($product->thumbnails)) {
                                            $thumb = asset(
                                                'storage/' . $product->thumbnails[0]
                                            );
                                        }

                                    @endphp


                                    {{-- =================================================
                                        PRODUCT CARD
                                    ================================================== --}}
                                    <article
                                        onclick="window.location.href='{{ route('product.show', ['slug' => $product->slug]) }}'"
                                        style="animation-delay: {{ min($index * 70, 280) }}ms"
                                        class="product-card
                                               group
                                               bg-white
                                               rounded-xl
                                               border
                                               border-slate-200
                                               overflow-hidden
                                               shadow-sm
                                               hover:shadow-xl
                                               hover:border-blue-200
                                               cursor-pointer
                                               flex
                                               flex-col
                                               transition-all
                                               duration-300
                                               hover:-translate-y-1">

                                        {{-- IMAGE --}}
                                        <div
                                            class="relative
                                                   bg-slate-50
                                                   h-36
                                                   overflow-hidden">

                                            {{-- NEW --}}
                                            @if (
                                                $product->created_at &&
                                                $product->created_at->gt(now()->subDays(14))
                                            )

                                                <span
                                                    class="absolute
                                                           top-2
                                                           left-2
                                                           z-10
                                                           px-1.5
                                                           py-0.5
                                                           rounded-md
                                                           bg-blue-600
                                                           text-white
                                                           text-[8px]
                                                           font-extrabold
                                                           tracking-wide
                                                           shadow-sm">

                                                    NEW

                                                </span>

                                            @endif


                                            {{-- DISCOUNT --}}
                                            @if ($hasDiscount)

                                                <span
                                                    class="absolute
                                                           top-2
                                                           right-2
                                                           z-10
                                                           px-1.5
                                                           py-0.5
                                                           rounded-md
                                                           bg-slate-950
                                                           text-white
                                                           text-[8px]
                                                           font-extrabold">

                                                    -{{ $discountPercent }}%

                                                </span>

                                            @endif


                                            {{-- PRODUCT IMAGE --}}
                                            <a
                                                href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                                onclick="event.stopPropagation();"
                                                class="block w-full h-full">

                                                @if ($thumb)

                                                    <img
                                                        src="{{ $thumb }}"
                                                        alt="{{ $product->name }}"
                                                        loading="lazy"
                                                        class="product-image
                                                               w-full
                                                               h-full
                                                               object-contain
                                                               p-2.5
                                                               transition-transform
                                                               duration-500
                                                               group-hover:scale-105">

                                                @else

                                                    <div
                                                        class="w-full
                                                               h-full
                                                               flex
                                                               flex-col
                                                               items-center
                                                               justify-center
                                                               text-slate-400
                                                               gap-2">

                                                        {{-- Image SVG --}}
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="1.7"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="w-7 h-7">

                                                            <rect
                                                                x="3"
                                                                y="3"
                                                                width="18"
                                                                height="18"
                                                                rx="2">
                                                            </rect>

                                                            <circle
                                                                cx="8.5"
                                                                cy="8.5"
                                                                r="1.5">
                                                            </circle>

                                                            <path
                                                                d="m21 15-5-5L5 21">
                                                            </path>

                                                        </svg>

                                                        <span class="text-[10px]">
                                                            No image
                                                        </span>

                                                    </div>

                                                @endif

                                            </a>


                                            {{-- WISHLIST --}}
                                            <button
                                                type="button"
                                                onclick="toggleWishlist(event, this, {{ $product->id }})"
                                                data-wishlisted="{{ $isWishlisted ? 'true' : 'false' }}"
                                                aria-label="{{ $isWishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}"
                                                class="wishlist-button
                                                       absolute
                                                       right-2
                                                       bottom-2
                                                       z-20
                                                       w-8
                                                       h-8
                                                       rounded-full
                                                       bg-white/95
                                                       backdrop-blur-sm
                                                       flex
                                                       items-center
                                                       justify-center
                                                       shadow-md
                                                       transition-all
                                                       duration-200
                                                       hover:scale-110
                                                       {{ $isWishlisted
                                                           ? 'text-red-500'
                                                           : 'text-slate-500 hover:text-blue-500' }}">

                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24"
                                                    fill="{{ $isWishlisted ? 'currentColor' : 'none' }}"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="w-4 h-4">

                                                    <path
                                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z">
                                                    </path>

                                                </svg>

                                            </button>

                                        </div>


                                        {{-- PRODUCT INFORMATION --}}
                                        <div
                                            class="p-3
                                                   flex
                                                   flex-col
                                                   flex-1">

                                            {{-- BRAND --}}
                                            @if ($product->brand)

                                                <p
                                                    class="text-[9px]
                                                           uppercase
                                                           tracking-[.12em]
                                                           text-blue-600
                                                           font-extrabold
                                                           mb-1">

                                                    {{ $product->brand->name }}

                                                </p>

                                            @elseif ($product->category)

                                                <p
                                                    class="text-[9px]
                                                           uppercase
                                                           tracking-[.12em]
                                                           text-blue-600
                                                           font-extrabold
                                                           mb-1">

                                                    {{ $product->category->name }}

                                                </p>

                                            @endif


                                            {{-- NAME --}}
                                            <a
                                                href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                                onclick="event.stopPropagation();"
                                                class="text-[13px]
                                                       font-bold
                                                       text-slate-800
                                                       leading-[1.35]
                                                       mb-1.5
                                                       line-clamp-2
                                                       group-hover:text-blue-600
                                                       transition-colors
                                                       duration-200">

                                                {{ $product->name }}

                                            </a>


                                            {{-- RATING --}}
                                            <div
                                                class="flex
                                                       items-center
                                                       gap-1
                                                       mb-2">

                                                <div
                                                    class="flex
                                                           text-yellow-400
                                                           text-[10px]
                                                           tracking-[-1px]">

                                                    ★★★★★

                                                </div>

                                                <span
                                                    class="text-slate-400
                                                           text-[9px]">

                                                    ({{ $reviewCount }})

                                                </span>

                                            </div>


                                            {{-- PRICE --}}
                                            <div
                                                class="flex
                                                       flex-wrap
                                                       items-center
                                                       gap-1.5
                                                       mb-2.5">

                                                @if ($hasDiscount)

                                                    <span
                                                        class="text-[15px]
                                                               font-black
                                                               text-slate-950">

                                                        Rs.
                                                        {{ number_format($product->discount_price) }}

                                                    </span>

                                                    <span
                                                        class="text-[10px]
                                                               text-slate-400
                                                               line-through">

                                                        Rs.
                                                        {{ number_format($product->price) }}

                                                    </span>

                                                @else

                                                    <span
                                                        class="text-[15px]
                                                               font-black
                                                               text-slate-950">

                                                        Rs.
                                                        {{ number_format($product->price) }}

                                                    </span>

                                                @endif

                                            </div>


                                            {{-- STOCK --}}
                                            @if ($product->stock > 0)

                                                <p
                                                    class="text-[9px]
                                                           text-green-600
                                                           font-semibold
                                                           mb-2
                                                           flex
                                                           items-center
                                                           gap-1">

                                                    {{-- Green Dot SVG --}}
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24"
                                                        fill="currentColor"
                                                        class="w-1.5 h-1.5">

                                                        <circle
                                                            cx="12"
                                                            cy="12"
                                                            r="8">
                                                        </circle>

                                                    </svg>

                                                    {{ $product->stock }} in stock

                                                </p>

                                            @else

                                                <p
                                                    class="text-[9px]
                                                           text-red-500
                                                           font-semibold
                                                           mb-2
                                                           flex
                                                           items-center
                                                           gap-1">

                                                    {{-- Red Dot SVG --}}
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24"
                                                        fill="currentColor"
                                                        class="w-1.5 h-1.5">

                                                        <circle
                                                            cx="12"
                                                            cy="12"
                                                            r="8">
                                                        </circle>

                                                    </svg>

                                                    Out of stock

                                                </p>

                                            @endif


                                            {{-- ADD TO CART --}}
                                            @if ($product->stock > 0)

                                                <form
                                                    method="POST"
                                                    action="{{ route('cart.add', ['product' => $product->id]) }}"
                                                    onclick="event.stopPropagation();"
                                                    class="w-full mt-auto">

                                                    @csrf

                                                    <input
                                                        type="hidden"
                                                        name="quantity"
                                                        value="1">


                                                    <button
                                                        type="submit"
                                                        class="w-full
                                                               bg-blue-600
                                                               hover:bg-blue-700
                                                               active:bg-blue-800
                                                               text-white
                                                               py-2
                                                               rounded-lg
                                                               font-semibold
                                                               text-[10px]
                                                               transition-all
                                                               duration-200
                                                               flex
                                                               items-center
                                                               justify-center
                                                               gap-1.5
                                                               hover:-translate-y-0.5
                                                               hover:shadow-md">

                                                        {{-- Cart SVG --}}
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="1.8"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="w-3 h-3">

                                                            <circle
                                                                cx="9"
                                                                cy="20"
                                                                r="1">
                                                            </circle>

                                                            <circle
                                                                cx="19"
                                                                cy="20"
                                                                r="1">
                                                            </circle>

                                                            <path
                                                                d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 1.9-1.4L21 8H6">
                                                            </path>

                                                            <path
                                                                d="M16 5v5">
                                                            </path>

                                                            <path
                                                                d="M13.5 7.5h5">
                                                            </path>

                                                        </svg>

                                                        Add to Cart

                                                    </button>

                                                </form>

                                            @else

                                                <button
                                                    type="button"
                                                    disabled
                                                    onclick="event.stopPropagation();"
                                                    class="w-full
                                                           bg-slate-100
                                                           text-slate-400
                                                           border
                                                           border-slate-200
                                                           py-2
                                                           rounded-lg
                                                           font-semibold
                                                           text-[10px]
                                                           cursor-not-allowed
                                                           flex
                                                           items-center
                                                           justify-center
                                                           gap-1.5">

                                                    {{-- Cart SVG --}}
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="w-3 h-3">

                                                        <circle
                                                            cx="9"
                                                            cy="20"
                                                            r="1">
                                                        </circle>

                                                        <circle
                                                            cx="19"
                                                            cy="20"
                                                            r="1">
                                                        </circle>

                                                        <path
                                                            d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 1.9-1.4L21 8H6">
                                                        </path>

                                                    </svg>

                                                    Out of Stock

                                                </button>

                                            @endif

                                        </div>

                                    </article>

                                @endforeach

                            </div>

                        </div>


                    @else

                        {{-- =================================================
                            EMPTY NORMAL CHILD CATEGORY
                        ================================================== --}}
                        <div
                            class="bg-slate-50
                                   rounded-2xl
                                   border
                                   border-slate-200
                                   py-10
                                   px-5
                                   text-center">

                            <div
                                class="w-14
                                       h-14
                                       mx-auto
                                       rounded-2xl
                                       bg-white
                                       border
                                       border-slate-200
                                       flex
                                       items-center
                                       justify-center">

                                {{-- Package SVG --}}
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="w-7 h-7 text-slate-400">

                                    <path
                                        d="M3.5 7.5L12 3l8.5 4.5v9L12 21l-8.5-4.5v-9Z">
                                    </path>

                                    <path
                                        d="M3.5 7.5L12 12l8.5-4.5">
                                    </path>

                                    <path
                                        d="M12 12v9">
                                    </path>

                                    <path
                                        d="M7.5 5.2L16 9.7">
                                    </path>

                                    <path
                                        d="M16.5 14.5l2-1">
                                    </path>

                                </svg>

                            </div>


                            <h3
                                class="mt-4
                                       text-base
                                       font-bold
                                       text-slate-800">

                                No Products Available

                            </h3>


                            <p
                                class="mt-1
                                      text-xs
                                      text-slate-500">

                                There are currently no products in
                                {{ $child->name }}.

                            </p>

                        </div>

                    @endif

                @endif

            </section>

        @empty

            {{-- =========================================================
                NO CHILD CATEGORIES
            ========================================================== --}}
            <div
                class="bg-white
                       rounded-2xl
                       border
                       border-slate-200
                       shadow-sm
                       py-16
                       px-6
                       text-center">

                <div
                    class="w-20
                           h-20
                           mx-auto
                           rounded-3xl
                           bg-blue-50
                           flex
                           items-center
                           justify-center">

                    {{-- Layer SVG --}}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="w-9 h-9 text-blue-600">

                        <path
                            d="m12 3 9 5-9 5-9-5 9-5Z">
                        </path>

                        <path
                            d="m3 12 9 5 9-5">
                        </path>

                        <path
                            d="m3 16 9 5 9-5">
                        </path>

                    </svg>

                </div>


                <h2
                    class="mt-5
                           text-xl
                           font-bold
                           text-slate-900">

                    No Deal Categories Found

                </h2>


                <p
                    class="mt-2
                          text-sm
                          text-slate-500">

                    There are currently no active deal categories.

                </p>

            </div>

        @endforelse

    </main>
@if (!empty($category->description))
                <section class="px-8">

                    <div
                        class="bg-white
                                rounded-2xl
                                border border-slate-200
                                shadow-sm
                                p-6 sm:p-8">

                        <div class="flex items-center gap-3 mb-4">

                            <div
                                class="w-9 h-9
                                        rounded-lg
                                        bg-blue-50
                                        flex items-center
                                        justify-center">

                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />

                                </svg>

                            </div>

                            <h2
                                class="text-base sm:text-lg
                                       font-bold
                                       text-slate-900">

                                About {{ $category->name }}

                            </h2>

                        </div>


                        <div
                            class="text-sm
                                    leading-7
                                    text-slate-600
                                    prose prose-sm
                                    max-w-none">

                            {!! nl2br(e($category->description)) !!}

                        </div>

                    </div>

                </section>
            @endif
</div>


{{-- =============================================================
    WISHLIST JAVASCRIPT
============================================================= --}}
<script>
    async function toggleWishlist(event, btn, productId) {

        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        const token =
            document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute('content')
            || '{{ csrf_token() }}';

        try {

            const response = await fetch(
                "{{ route('user.wishlist.toggle') }}",
                {
                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": token,
                        "X-Requested-With": "XMLHttpRequest"
                    },

                    body: JSON.stringify({
                        product_id: productId
                    })
                }
            );


            const data = await response.json();


            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Wishlist request failed.'
                );

            }


            const icon = btn.querySelector('svg');


            if (data.wishlisted) {

                btn.dataset.wishlisted = 'true';

                btn.setAttribute(
                    'aria-label',
                    'Remove from wishlist'
                );


                btn.classList.remove(
                    'text-slate-500',
                    'text-gray-500',
                    'hover:text-blue-500',
                    'hover:text-Blue-500'
                );


                btn.classList.add(
                    'text-red-500'
                );


                if (icon) {

                    icon.setAttribute(
                        'fill',
                        'currentColor'
                    );

                }


                btn.animate(
                    [
                        {
                            transform: 'scale(1)'
                        },
                        {
                            transform: 'scale(1.25)'
                        },
                        {
                            transform: 'scale(1)'
                        }
                    ],
                    {
                        duration: 280,
                        easing: 'ease-out'
                    }
                );


            } else {

                btn.dataset.wishlisted = 'false';


                btn.setAttribute(
                    'aria-label',
                    'Add to wishlist'
                );


                btn.classList.remove(
                    'text-red-500'
                );


                btn.classList.add(
                    'text-slate-500',
                    'hover:text-blue-500'
                );


                if (icon) {

                    icon.setAttribute(
                        'fill',
                        'none'
                    );

                }

            }


            console.log(data.message);

        } catch (error) {

            console.error(
                'Wishlist Error:',
                error
            );


            alert(
                error.message ||
                'Something went wrong while updating wishlist.'
            );

        }

    }
</script>


</x-frontend-layout>
