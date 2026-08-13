<x-frontend-layout>

    <div class="max-w-7xl mx-auto px-4 py-10">

        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            My Orders
        </h1>

        @forelse ($orders as $order)

            <div class="bg-white border border-gray-200 rounded-xl p-5 mb-4 shadow-sm">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="font-semibold text-gray-900">
                            Order #{{ $order->id }}
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $order->created_at->format('M d, Y') }}
                        </p>
                    </div>

                    <a
                        href="{{ route('user.order.view', $order->id) }}"
                        class="px-4 py-2 bg-[#2563EB] text-white rounded-lg text-sm hover:bg-blue-700"
                    >
                        View Order
                    </a>

                </div>

            </div>

        @empty

            <div class="bg-white border border-gray-200 rounded-xl p-10 text-center">
                <p class="text-gray-500">
                    You haven't placed any orders yet.
                </p>
            </div>

        @endforelse

    </div>

</x-frontend-layout>
