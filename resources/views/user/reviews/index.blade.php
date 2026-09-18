<x-frontend-layout>

    <div class="bg-gray-100 w-full py-6 sm:py-8">

        <div class="Container mx-auto px-3 sm:px-4">

            <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">

                {{-- Sidebar --}}
                <aside class="w-full lg:w-64 flex-shrink-0">
                    <x-user-dashboard.sidebar />
                </aside>


                {{-- Main Content --}}
                <main class="flex-1 min-w-0 w-full">

                    {{-- =====================================================
                        PAGE HEADER
                    ====================================================== --}}
                    <div class="bg-white rounded-2xl shadow-sm
                                p-4 sm:p-6 mb-4 sm:mb-6">

                        <div class="flex items-center justify-between gap-3">

                            <div class="min-w-0">

                                <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-[#111827]">
                                    My Reviews
                                </h1>

                                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                    Manage your product reviews and ratings.
                                </p>

                            </div>


                            {{-- Header Icon --}}
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-yellow-50
                                        flex items-center justify-center flex-shrink-0">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.8" stroke="currentColor"
                                    class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-500">

                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.205 3.602a.563.563 0 0 0-.182.557l1.285 5.381c.116.485-.409.867-.84.608l-4.725-2.85a.563.563 0 0 0-.581 0l-4.725 2.85c-.431.259-.956-.123-.84-.608l1.285-5.381a.563.563 0 0 0-.182-.557L2.64 10.385c-.38-.325-.178-.948.321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />

                                </svg>

                            </div>

                        </div>

                    </div>


                    {{-- =====================================================
                        REVIEWS CONTENT
                    ====================================================== --}}
                    <div class="space-y-4 sm:space-y-5">

                        @forelse($reviews as $review)

                            <div
                                class="bg-white rounded-2xl shadow-sm border border-gray-100
                                        p-4 sm:p-6">

                                {{-- =========================
                                     USER PROFILE
                                ========================== --}}
                                <div class="flex items-center justify-between gap-3 mb-4 sm:mb-6">

                                    <div class="flex items-center gap-2 sm:gap-3 min-w-0">

                                        {{-- Profile Image --}}
                                        <div
                                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full
                                                    overflow-hidden bg-gray-100 flex-shrink-0">

                                            @if ($review->user && $review->user->profile_image)
                                                <img src="{{ asset('storage/' . $review->user->profile_image) }}"
                                                    alt="{{ $review->user->name }}" loading="lazy"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full flex items-center justify-center
                                                            bg-gray-100 text-gray-400">

                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
                                                        class="w-6 h-6 sm:w-7 sm:h-7">

                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />

                                                    </svg>

                                                </div>
                                            @endif

                                        </div>


                                        {{-- User Name --}}
                                        <div class="min-w-0">

                                            <p class="text-xs sm:text-sm font-semibold text-gray-900 truncate">
                                                {{ $review->user->name ?? 'Anonymous' }}
                                            </p>

                                            <p class="text-[10px] sm:text-xs text-gray-400">
                                                Customer
                                            </p>

                                        </div>

                                    </div>


                                    {{-- Review Status --}}
                                    @if ($review->status)
                                        <span
                                            class="px-2.5 sm:px-3 py-1 rounded-full
                                                     text-[10px] sm:text-xs font-semibold
                                                     bg-green-50 text-green-600 flex-shrink-0">
                                            Published
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 sm:px-3 py-1 rounded-full
                                                     text-[10px] sm:text-xs font-semibold
                                                     bg-yellow-50 text-yellow-600 flex-shrink-0">
                                            Pending
                                        </span>
                                    @endif

                                </div>


                                {{-- =========================
                                     PRODUCT + REVIEW
                                ========================== --}}
                                <div class="flex flex-col sm:flex-row gap-3 sm:gap-5">

                                    {{-- Product Image --}}
                                    <div
                                        class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl
                                                bg-gray-100 overflow-hidden flex-shrink-0
                                                mx-auto sm:mx-0">

                                        @if ($review->product && $review->product->image)
                                            <img src="{{ asset('storage/' . $review->product->image) }}"
                                                alt="{{ $review->product->name }}" loading="lazy"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-7 h-7 sm:w-8 sm:h-8">

                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.409 2.409M3.75 19.5h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />

                                                </svg>

                                            </div>
                                        @endif

                                    </div>


                                    {{-- Product + Review Details --}}
                                    <div class="flex-1 min-w-0">

                                        {{-- Product Name --}}
                                        <h2 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 break-words">
                                            {{ $review->product->name ?? 'Product' }}
                                        </h2>


                                        {{-- Rating --}}
                                        <div class="flex items-center gap-0.5 sm:gap-1 mt-2 flex-wrap">

                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <span class="text-yellow-500 text-base sm:text-lg">★</span>
                                                @else
                                                    <span class="text-gray-300 text-base sm:text-lg">★</span>
                                                @endif
                                            @endfor

                                            <span class="text-xs sm:text-sm text-gray-500 ml-1 sm:ml-2">
                                                {{ $review->rating }}/5
                                            </span>

                                        </div>


                                        {{-- Review Text --}}
                                        @if ($review->review)
                                            <div class="mt-3 sm:mt-4 bg-gray-50 rounded-xl p-3 sm:p-4">

                                                <p class="text-xs sm:text-sm text-gray-700 leading-6 break-words">
                                                    "{{ $review->review }}"
                                                </p>

                                            </div>
                                        @else
                                            <p class="text-xs sm:text-sm text-gray-400 mt-3 sm:mt-4 italic">
                                                No written review.
                                            </p>
                                        @endif


                                        {{-- Review Date --}}
                                        <p class="text-[10px] sm:text-xs text-gray-400 mt-3 sm:mt-4">
                                            Reviewed on {{ $review->created_at->format('d M Y, h:i A') }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                        @empty

                            {{-- =========================
                                 EMPTY STATE
                            ========================== --}}
                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-10">

                                <div class="text-center py-6 sm:py-10">

                                    <div
                                        class="w-16 h-16 sm:w-20 sm:h-20 mx-auto rounded-full
                                                bg-yellow-50 flex items-center justify-center
                                                mb-4 sm:mb-5">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-8 h-8 sm:w-10 sm:h-10 text-yellow-500">

                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.205 3.602a.563.563 0 0 0-.182.557l1.285 5.381c.116.485-.409.867-.84.608l-4.725-2.85a.563.563 0 0 0-.581 0l-4.725 2.85c-.431.259-.956-.123-.84-.608l1.285-5.381a.563.563 0 0 0-.182-.557L2.64 10.385c-.38-.325-.178-.948.321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />

                                        </svg>

                                    </div>


                                    <h2 class="text-base sm:text-lg md:text-xl font-semibold text-[#111827]">
                                        No Reviews Yet
                                    </h2>

                                    <p class="text-xs sm:text-sm text-gray-500 mt-2">
                                        Your product reviews will appear here.
                                    </p>


                                    <a href="{{ route('home') }}"
                                        class="inline-flex mt-4 sm:mt-6
                                               px-5 sm:px-6 py-2.5 sm:py-3
                                               rounded-xl bg-[#2563EB] hover:bg-blue-700
                                               text-white font-semibold
                                               text-xs sm:text-sm transition">

                                        Continue Shopping

                                    </a>

                                </div>

                            </div>

                        @endforelse

                    </div>

                </main>

            </div>

        </div>

    </div>

</x-frontend-layout>
