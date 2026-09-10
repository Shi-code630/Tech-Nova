<x-frontend-layout>

    <div class="bg-gray-100 py-8 min-h-screen">
        <div class="Container mx-auto">
            <div class="flex gap-6">

                <x-user-dashboard.sidebar />

                <main class="flex-1">

                    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-[#111827]">My Coupons</h1>
                                <p class="text-sm text-gray-500 mt-1">
                                    Copy a code and apply it at checkout.
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center">
                                <span class="text-2xl">🎁</span>
                            </div>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                        <h2 class="text-lg font-bold text-[#111827] mb-4">Available coupons</h2>

                        @forelse ($available as $coupon)
                            <div class="flex flex-col sm:flex-row sm:items-center gap-4 border border-gray-100 rounded-2xl p-5 mb-4 last:mb-0">
                                <div class="flex-1">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <span class="px-3 py-1 rounded-lg bg-purple-50 text-purple-700 font-bold tracking-wider">
                                            {{ $coupon->code }}
                                        </span>
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-[#2563EB]">
                                            {{ $coupon->discount_formatted }} OFF
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-600">
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

                                <div class="flex gap-2">
                                    <button type="button"
                                            onclick="navigator.clipboard.writeText('{{ $coupon->code }}'); this.textContent='Copied'; setTimeout(() => this.textContent='Copy', 1500)"
                                            class="px-4 py-2 rounded-xl border border-gray-200 text-sm font-semibold hover:bg-gray-50">
                                        Copy
                                    </button>

                                    <a href="{{ route('checkout', ['coupon' => $coupon->code]) }}"
                                       class="px-4 py-2 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white text-sm font-semibold">
                                        Use at checkout
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-14">
                                <div class="w-20 h-20 mx-auto rounded-full bg-purple-50 flex items-center justify-center mb-5">
                                    <span class="text-4xl">🎁</span>
                                </div>
                                <h2 class="text-xl font-semibold text-[#111827]">No coupons available</h2>
                                <p class="text-gray-500 mt-2">Admin-created offers will show up here.</p>
                                <a href="{{ route('home') }}"
                                   class="inline-flex mt-6 px-6 py-3 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white font-semibold">
                                    Continue shopping
                                </a>
                            </div>
                        @endforelse
                    </div>

                    @if ($used->count())
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-lg font-bold text-[#111827] mb-4">Already used</h2>

                            @foreach ($used as $coupon)
                                <div class="flex items-center justify-between border border-gray-100 rounded-2xl p-4 mb-3 last:mb-0 opacity-70">
                                    <div>
                                        <p class="font-bold tracking-wider text-gray-700">{{ $coupon->code }}</p>
                                        <p class="text-sm text-gray-500">{{ $coupon->discount_formatted }} off</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Used</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </main>
            </div>
        </div>
    </div>

</x-frontend-layout>
