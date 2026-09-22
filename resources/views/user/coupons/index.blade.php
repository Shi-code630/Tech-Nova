<x-frontend-layout>

    <div class="bg-gray-100 w-full py-6 sm:py-8 min-h-screen">

        <div class="Container mx-auto px-3 sm:px-4">

            <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">

                {{-- =====================================================
                    SIDEBAR
                ====================================================== --}}
                <aside class="lg:w-64 flex-shrink-0">
                    <x-user-dashboard.sidebar />
                </aside>


                {{-- =====================================================
                    MAIN CONTENT
                ====================================================== --}}
                <main class="flex-1 min-w-0">


                    {{-- =====================================================
                        PAGE HEADER
                    ====================================================== --}}
                    <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 mb-4 sm:mb-6">

                        <div class="flex items-center justify-between gap-3">

                            <div class="min-w-0">

                                <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-[#111827]">
                                    My Coupons
                                </h1>

                                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                    Copy a code and apply it at checkout.
                                </p>

                            </div>

                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-purple-50
                                       flex items-center justify-center flex-shrink-0">

                                <span class="text-xl sm:text-2xl">
                                    🎁
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- =====================================================
                        SUCCESS MESSAGE
                    ====================================================== --}}
                    @if (session('success'))

                        <div
                            class="mb-4 sm:mb-6 rounded-xl
                                   border border-green-200
                                   bg-green-50
                                   px-3 sm:px-5 py-2.5 sm:py-4
                                   text-xs sm:text-sm
                                   text-green-700">

                            {{ session('success') }}

                        </div>

                    @endif


                    {{-- =====================================================
                        ERROR MESSAGE
                    ====================================================== --}}
                    @if (session('error'))

                        <div
                            class="mb-4 sm:mb-6 rounded-xl
                                   border border-red-200
                                   bg-red-50
                                   px-3 sm:px-5 py-2.5 sm:py-4
                                   text-xs sm:text-sm
                                   text-red-700">

                            {{ session('error') }}

                        </div>

                    @endif


                    {{-- =====================================================
                        AVAILABLE COUPONS
                    ====================================================== --}}
                    <div
                        class="bg-white rounded-2xl
                               shadow-sm border border-gray-100
                               p-4 sm:p-6 mb-4 sm:mb-6">


                        {{-- Section Header --}}
                        <div class="flex items-center justify-between mb-4">

                            <div>

                                <h2 class="text-base sm:text-lg font-bold text-[#111827]">
                                    Available Coupons
                                </h2>

                                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                    Save more on your next purchase
                                </p>

                            </div>


                            <div
                                class="w-10 h-10 rounded-xl bg-blue-50
                                       flex items-center justify-center">

                                <span class="text-xl">
                                    🎟️
                                </span>

                            </div>

                        </div>


                        {{-- =================================================
                            COUPON GRID
                            Desktop = 2 per row
                            Mobile = 1 per row
                        ================================================== --}}
                        @if ($available->count())

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                                @foreach ($available as $coupon)

                                    {{-- =====================================
                                        COUPON CARD
                                    ====================================== --}}
                                    <div
                                        class="relative overflow-hidden
                                               rounded-xl
                                               bg-gradient-to-r
                                               from-[#111a8b]
                                               to-[#2026a8]
                                               text-white
                                               shadow-md
                                               hover:shadow-lg
                                               transition">


                                        {{-- LEFT NOTCH --}}
                                        <div
                                            class="absolute
                                                   -left-2.5
                                                   top-1/2
                                                   -translate-y-1/2
                                                   w-5 h-5
                                                   rounded-full
                                                   bg-white">
                                        </div>


                                        {{-- RIGHT NOTCH --}}
                                        <div
                                            class="absolute
                                                   -right-2.5
                                                   top-1/2
                                                   -translate-y-1/2
                                                   w-5 h-5
                                                   rounded-full
                                                   bg-white">
                                        </div>


                                        {{-- COUPON CONTENT --}}
                                        <div class="flex min-h-[135px]">


                                            {{-- =================================
                                                COUPON CODE
                                            ================================== --}}
                                            <div
                                                class="w-[105px]
                                                       flex-shrink-0
                                                       flex flex-col
                                                       items-center
                                                       justify-center
                                                       px-2.5
                                                       border-r
                                                       border-dashed
                                                       border-white/40">


                                                <span
                                                    class="text-[8px]
                                                           uppercase
                                                           tracking-wider
                                                           text-white/60">

                                                    Code

                                                </span>


                                                <span
                                                    class="text-sm
                                                           font-black
                                                           tracking-wider
                                                           text-center
                                                           break-all
                                                           mt-1">

                                                    {{ $coupon->code }}

                                                </span>


                                                {{-- COPY BUTTON --}}
                                                <button
                                                    type="button"
                                                    onclick="
                                                        navigator.clipboard.writeText('{{ $coupon->code }}');
                                                        this.innerText='Copied';
                                                        setTimeout(() => this.innerText='Copy', 1500)
                                                    "
                                                    class="mt-2
                                                           px-2.5 py-1
                                                           rounded-md
                                                           bg-white
                                                           text-[#111a8b]
                                                           text-[9px]
                                                           font-bold
                                                           hover:bg-gray-100
                                                           transition">

                                                    Copy

                                                </button>

                                            </div>


                                            {{-- =================================
                                                COUPON DETAILS
                                            ================================== --}}
                                            <div
                                                class="flex-1
                                                       min-w-0
                                                       px-3
                                                       py-3
                                                       flex flex-col
                                                       justify-center">


                                                <div
                                                    class="flex items-center
                                                           gap-1.5 mb-1.5">

                                                    <span
                                                        class="text-[8px]
                                                               font-semibold
                                                               text-white/60
                                                               uppercase
                                                               tracking-wider">

                                                        Special Offer

                                                    </span>


                                                    <span
                                                        class="px-1.5 py-0.5
                                                               rounded-full
                                                               bg-white/15
                                                               border
                                                               border-white/20
                                                               text-[7px]
                                                               font-bold">

                                                        AVAILABLE

                                                    </span>

                                                </div>


                                                <h3
                                                    class="text-base
                                                           font-bold
                                                           leading-tight">

                                                    {{ $coupon->discount_formatted }}
                                                    OFF

                                                </h3>


                                                <div
                                                    class="mt-1.5
                                                           space-y-0.5
                                                           text-[9px]
                                                           text-white/75">


                                                    @if ($coupon->minimum_amount)

                                                        <p>

                                                            <span
                                                                class="font-semibold text-white">

                                                                Min:

                                                            </span>

                                                            Rs.
                                                            {{ number_format($coupon->minimum_amount, 0) }}

                                                        </p>

                                                    @else

                                                        <p>
                                                            No minimum order
                                                        </p>

                                                    @endif


                                                    @if ($coupon->expire_date)

                                                        <p>

                                                            <span
                                                                class="font-semibold text-white">

                                                                Exp:

                                                            </span>

                                                            {{ $coupon->expire_date->format('d M Y') }}

                                                        </p>

                                                    @endif

                                                </div>

                                            </div>


                                            {{-- =================================
                                                DISCOUNT + ACTION
                                            ================================== --}}
                                            <div
                                                class="w-[90px]
                                                       flex-shrink-0
                                                       flex flex-col
                                                       items-center
                                                       justify-center
                                                       px-2
                                                       bg-white/10
                                                       border-l
                                                       border-white/20">


                                                <span
                                                    class="text-[8px]
                                                           text-white/60
                                                           uppercase
                                                           tracking-widest">

                                                    Get

                                                </span>


                                                <span
                                                    class="text-xl
                                                           font-black
                                                           leading-none
                                                           my-1">

                                                    {{ $coupon->discount_formatted }}

                                                </span>


                                                <span
                                                    class="text-[8px]
                                                           text-white/60
                                                           mb-2">

                                                    Discount

                                                </span>


                                                {{-- USE COUPON --}}
                                                <a
                                                    href="{{ route('checkout', ['coupon' => $coupon->code]) }}"
                                                    class="w-full
                                                           text-center
                                                           px-2 py-1.5
                                                           rounded-lg
                                                           bg-white
                                                           text-[#111a8b]
                                                           text-[9px]
                                                           font-bold
                                                           hover:bg-gray-100
                                                           transition
                                                           shadow-sm">

                                                    Use Now

                                                </a>

                                            </div>


                                        </div>

                                    </div>

                                @endforeach


                            </div>

                        @else

                            {{-- =================================================
                                EMPTY STATE
                            ================================================== --}}
                            <div class="text-center py-10 sm:py-14">

                                <div
                                    class="w-16 h-16 sm:w-20 sm:h-20
                                           mx-auto rounded-full
                                           bg-purple-50
                                           flex items-center justify-center
                                           mb-4 sm:mb-5">

                                    <span class="text-3xl sm:text-4xl">
                                        🎟️
                                    </span>

                                </div>


                                <h2
                                    class="text-lg sm:text-xl
                                           font-semibold
                                           text-[#111827]">

                                    No coupons available

                                </h2>


                                <p
                                    class="text-xs sm:text-sm
                                           text-gray-500
                                           mt-2">

                                    Admin-created offers will show up here.

                                </p>


                                <a
                                    href="{{ route('home') }}"
                                    class="inline-flex
                                           mt-5 sm:mt-6
                                           px-5 sm:px-6
                                           py-2.5 sm:py-3
                                           rounded-xl
                                           bg-[#2563EB]
                                           hover:bg-blue-700
                                           text-white
                                           font-semibold
                                           text-xs sm:text-sm
                                           transition">

                                    Continue Shopping

                                </a>

                            </div>

                        @endif


                    </div>


                    {{-- =====================================================
                        USED COUPONS
                    ====================================================== --}}
                    @if ($used->count())

                        <div
                            class="bg-white rounded-2xl
                                   shadow-sm border border-gray-100
                                   p-4 sm:p-6">


                            <h2
                                class="text-base sm:text-lg
                                       font-bold text-[#111827]
                                       mb-3 sm:mb-4">

                                Already Used

                            </h2>


                            @foreach ($used as $coupon)

                                <div
                                    class="flex items-center
                                           justify-between
                                           gap-3
                                           border border-gray-100
                                           rounded-xl
                                           p-3 sm:p-4
                                           mb-3
                                           last:mb-0
                                           opacity-70">


                                    <div class="min-w-0">

                                        <p
                                            class="font-bold
                                                   tracking-wider
                                                   text-gray-700
                                                   text-xs sm:text-sm
                                                   truncate">

                                            {{ $coupon->code }}

                                        </p>


                                        <p
                                            class="text-[11px]
                                                   sm:text-sm
                                                   text-gray-500">

                                            {{ $coupon->discount_formatted }}
                                            off

                                        </p>

                                    </div>


                                    <span
                                        class="px-2.5 sm:px-3
                                               py-1
                                               rounded-full
                                               text-[10px] sm:text-xs
                                               font-semibold
                                               bg-gray-100
                                               text-gray-600
                                               flex-shrink-0">

                                        Used

                                    </span>

                                </div>

                            @endforeach


                        </div>

                    @endif


                </main>

            </div>

        </div>

    </div>

</x-frontend-layout>
