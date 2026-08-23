<x-frontend-layout>

    <div class="bg-gray-100 min-h-screen py-8">

        <div class="w-[95%] mx-auto flex gap-6 items-start">

            {{-- Dashboard Sidebar --}}
            <x-user-dashboard.sidebar />

            {{-- Main Content --}}
            <main class="flex-1 min-w-0">

                <div class="bg-white rounded-3xl shadow-sm p-6">

                    {{-- Page Header --}}
                    <div class="flex items-center justify-between mb-6">

                        <div>
                            <h1 class="text-2xl font-bold text-[#111827]">
                                My Orders
                            </h1>

                            <p class="text-sm text-gray-500 mt-1">
                                View and manage your orders
                            </p>
                        </div>

                    </div>

                    @if($orders->count())

                        <div class="space-y-4">

                            @foreach($orders as $order)

                                <div class="border border-gray-200 rounded-2xl p-5
                                            hover:shadow-md transition">

                                    <div class="flex items-center justify-between">

                                        <div>
                                            <p class="font-semibold text-[#111827]">
                                                Order #{{ $order->id }}
                                            </p>

                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $order->created_at->format('M d, Y') }}
                                            </p>
                                        </div>

                                        <div class="text-right">

                                            <p class="font-bold text-[#2563EB]">
                                                Rs {{ number_format($order->grand_total) }}
                                            </p>

                                            <span class="inline-block mt-1 px-3 py-1
                                                         rounded-full text-xs font-medium
                                                         bg-blue-50 text-[#2563EB]">
                                                {{ ucfirst($order->order_status) }}
                                            </span>

                                        </div>

                                    </div>

                                    <div class="mt-4 flex justify-end">

                                        <div class="flex items-center gap-3">

                                            <a
                                                href="{{ route('user.order.view', $order->id) }}"
                                                class="px-5 py-2 rounded-xl border border-gray-200
                                                    text-gray-700 hover:bg-gray-50 text-sm
                                                    font-medium transition">

                                                View Order

                                            </a>

                                            @if($order->order_status !== 'cancelled')

                                                <a
                                                    href="{{ route('user.order.track', $order->id) }}"
                                                    class="px-5 py-2 rounded-xl bg-[#2563EB]
                                                        hover:bg-blue-700 text-white text-sm
                                                        font-medium transition">

                                                    Track Order

                                                </a>
                                            @endif

                                        </div>
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        {{-- Empty Orders --}}
                        <div class="border border-gray-200 rounded-2xl
                                    min-h-[250px] flex flex-col
                                    items-center justify-center text-center">

                            <div class="w-16 h-16 rounded-full bg-blue-50
                                        flex items-center justify-center mb-4">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-8 h-8 text-[#2563EB]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4
                                           M7 13L5.4 5M7 13l-2.293 2.293
                                           c-.63.63-.184 1.707.707 1.707H17
                                           m0 0a2 2 0 100 4
                                           2 2 0 000-4
                                           zm-8 2a2 2 0 11-4 0
                                           2 2 0 014 0z" />

                                </svg>

                            </div>

                            <h2 class="text-lg font-semibold text-[#111827]">
                                You haven't placed any orders yet.
                            </h2>

                            <p class="text-sm text-gray-500 mt-2">
                                Start shopping and your orders will appear here.
                            </p>

                            <a
                                href="{{ route('home') }}"
                                class="mt-5 px-6 py-2.5 rounded-xl
                                       bg-[#2563EB] hover:bg-blue-700
                                       text-white text-sm font-semibold
                                       transition">

                                Start Shopping

                            </a>

                        </div>

                    @endif

                </div>

            </main>

        </div>

    </div>

</x-frontend-layout>
