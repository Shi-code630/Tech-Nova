<x-frontend-layout>

    <div class="bg-gray-100 w-full py-6 sm:py-8 min-h-screen">

        <div class="Container mx-auto px-3 sm:px-4">

            <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">

                {{-- Sidebar --}}
                <aside class="lg:w-64 flex-shrink-0">
                    <x-user-dashboard.sidebar />
                </aside>


                {{-- Main Content --}}
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

                                <span class="text-xl sm:text-2xl">🎁</span>

                            </div>

                        </div>

                    </div>


                    {{-- Success Message --}}
                    @if (session('success'))
                        <div
                            class="mb-4 sm:mb-6 rounded-xl border border-green-200 bg-green-50
                                    px-3 sm:px-5 py-2.5 sm:py-4 text-xs sm:text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif


                    {{-- Error Message --}}
                    @if (session('error'))
                        <div
                            class="mb-4 sm:mb-6 rounded-xl border border-red-200 bg-red-50
                                    px-3 sm:px-5 py-2.5 sm:py-4 text-xs sm:text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif


                    {{-- =====================================================
                        AVAILABLE COUPONS
                    ====================================================== --}}
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100
                                p-4 sm:p-6 mb-4 sm:mb-6">

                        <h2 class="text-base sm:text-lg font-bold text-[#111827] mb-3 sm:mb-4">
                            Available coupons
                        </h2>


                        @forelse ($available as $coupon)
                            <div
                                class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4
                                        border border-gray-100 rounded-2xl
                                        p-4 sm:p-5 mb-3 sm:mb-4 last:mb-0">

                                {{-- Coupon Info --}}
                                <div class="flex-1 min-w-0">

                                    <div class="flex flex-wrap items-center gap-2 mb-2">

                                        <span
                                            class="px-2.5 sm:px-3 py-1 rounded-lg
                                                     bg-purple-50 text-purple-700
                                                     font-bold tracking-wider
                                                     text-xs sm:text-sm">
                                            {{ $coupon->code }}
                                        </span>

                                        <span
                                            class="px-2 py-1 rounded-full
                                                     text-[10px] sm:text-xs font-medium
                                                     bg-blue-50 text-[#2563EB]">
                                            {{ $coupon->discount_formatted }} OFF
                                        </span>

                                    </div>

                                    <p class="text-xs sm:text-sm text-gray-600">

                                        @if ($coupon->minimum_amount)
                                            Min order: Rs. {{ number_format($coupon->minimum_amount, 2) }}
                                        @else
                                            No minimum order
                                        @endif

                                        @if ($coupon->expire_date)
                                            · Expires {{ $coupon->expire_date->format('d M Y') }}
                                        @endif

                                    </p>

                                </div>


                                {{-- Action Buttons --}}
                                <div class="flex gap-2 flex-shrink-0">

                                    <button type="button"
                                        onclick="navigator.clipboard.writeText('{{ $coupon->code }}'); this.textContent='Copied'; setTimeout(() => this.textContent='Copy', 1500)"
                                        class="flex-1 sm:flex-initial
                                               px-3 sm:px-4 py-2 rounded-xl
                                               border border-gray-200
                                               text-xs sm:text-sm font-semibold
                                               hover:bg-gray-50 transition">
                                        Copy
                                    </button>

                                    <a href="{{ route('checkout', ['coupon' => $coupon->code]) }}"
                                        class="flex-1 sm:flex-initial
                                               px-3 sm:px-4 py-2 rounded-xl
                                               bg-[#2563EB] hover:bg-blue-700
                                               text-white text-xs sm:text-sm font-semibold
                                               transition whitespace-nowrap text-center">
                                        Use at checkout
                                    </a>

                                </div>

                            </div>

                        @empty

                            {{-- Empty State --}}
                            <div class="text-center py-10 sm:py-14">

                                <div
                                    class="w-16 h-16 sm:w-20 sm:h-20 mx-auto rounded-full
                                            bg-purple-50 flex items-center justify-center mb-4 sm:mb-5">

                                    <span class="text-3xl sm:text-4xl">🎁</span>

                                </div>

                                <h2 class="text-lg sm:text-xl font-semibold text-[#111827]">
                                    No coupons available
                                </h2>

                                <p class="text-xs sm:text-sm text-gray-500 mt-2">
                                    Admin-created offers will show up here.
                                </p>

                                <a href="{{ route('home') }}"
                                    class="inline-flex mt-5 sm:mt-6
                                           px-5 sm:px-6 py-2.5 sm:py-3 rounded-xl
                                           bg-[#2563EB] hover:bg-blue-700
                                           text-white font-semibold
                                           text-xs sm:text-sm transition">
                                    Continue shopping
                                </a>

                            </div>
                        @endforelse

                    </div>


                    {{-- =====================================================
                        USED COUPONS
                    ====================================================== --}}
                    @if ($used->count())

                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100
                                    p-4 sm:p-6">

                            <h2 class="text-base sm:text-lg font-bold text-[#111827] mb-3 sm:mb-4">
                                Already used
                            </h2>


                            @foreach ($used as $coupon)
                                <div
                                    class="flex items-center justify-between gap-3
                                            border border-gray-100 rounded-2xl
                                            p-3 sm:p-4 mb-3 last:mb-0 opacity-70">

                                    <div class="min-w-0">

                                        <p
                                            class="font-bold tracking-wider text-gray-700
                                                  text-xs sm:text-sm truncate">
                                            {{ $coupon->code }}
                                        </p>

                                        <p class="text-[11px] sm:text-sm text-gray-500">
                                            {{ $coupon->discount_formatted }} off
                                        </p>

                                    </div>

                                    <span
                                        class="px-2.5 sm:px-3 py-1 rounded-full
                                                 text-[10px] sm:text-xs font-semibold
                                                 bg-gray-100 text-gray-600 flex-shrink-0">
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
