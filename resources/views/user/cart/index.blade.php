
<x-frontend-layout>
<div class="min-h-screen bg-gray-100 p-6">

    <div class="flex gap-6 max-w-7xl mx-auto">

        {{-- Sidebar --}}
        <x-user-dashboard.sidebar />

        {{-- Main Content --}}
        <main class="flex-1">

            {{-- Page Header --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">

                <div class="flex items-center justify-between">

                    <div>
                        <h1 class="text-2xl font-bold text-[#111827]">
                            My Cart
                        </h1>

                        <p class="text-sm text-gray-500 mt-1">
                            Review the products you've added to your cart.
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.8"
                             stroke="currentColor"
                             class="w-6 h-6 text-[#2563EB]">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>

                        </svg>

                    </div>

                </div>

            </div>


            {{-- Cart Content --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">

                @if($cartItems->count() > 0)

                    {{-- Cart Items --}}
                    <div class="space-y-4">

                        @foreach($cartItems as $item)

                            <div class="border border-gray-200 rounded-2xl p-4
                                        flex items-center gap-5
                                        hover:shadow-sm transition">

                                {{-- Product Image --}}
                                <div class="w-24 h-24 rounded-xl bg-gray-100
                                            flex items-center justify-center
                                            overflow-hidden flex-shrink-0">

                                    @if($item->product && $item->product->image)

                                        <img
                                            src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="w-full h-full object-contain">

                                    @else

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke-width="1.5"
                                             stroke="currentColor"
                                             class="w-10 h-10 text-gray-400">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l2.159 2.159m-1.5 1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.409 2.409M3.75 19.5h16.5A1.5 1.5 0 0 0 21.75 18V6A1.5 1.5 0 0 0 20.25 4.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"/>

                                        </svg>

                                    @endif

                                </div>


                                {{-- Product Details --}}
                                <div class="flex-1 min-w-0">

                                    <h2 class="font-semibold text-[#111827] text-lg">
                                        {{ $item->product->name ?? 'Product' }}
                                    </h2>

                                    <p class="text-[#2563EB] font-semibold mt-1">
                                        Rs {{ number_format($item->price, 2) }}
                                    </p>

                                    <div class="flex-1 min-w-0">

                                        <h2 class="font-semibold text-[#111827] text-lg">
                                            {{ $item->product->name ?? 'Product' }}
                                        </h2>

                                        <p class="text-[#2563EB] font-semibold mt-1">
                                            Rs {{ number_format($item->price, 2) }}
                                        </p>

                                        {{-- Replace the old Quantity <p> with the quantity controls --}}
                                        <div class="flex items-center gap-2 mt-3">

                                            {{-- Decrease --}}
                                            <form action="{{ route('cart.update', $item->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('PATCH')

                                                <input type="hidden"
                                                    name="quantity"
                                                    value="{{ $item->quantity - 1 }}">

                                                <button type="submit"
                                                        class="w-8 h-8 rounded-lg border border-gray-300
                                                            flex items-center justify-center
                                                            text-gray-700 font-bold
                                                            hover:bg-gray-100 transition"
                                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                    −
                                                </button>

                                            </form>

                                            {{-- Quantity --}}
                                            <div class="w-10 h-8 rounded-lg bg-gray-100
                                                        flex items-center justify-center
                                                        font-semibold text-gray-800">
                                                {{ $item->quantity }}
                                            </div>

                                            {{-- Increase --}}
                                            <form action="{{ route('cart.update', $item->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('PATCH')

                                                <input type="hidden"
                                                    name="quantity"
                                                    value="{{ $item->quantity + 1 }}">

                                                <button type="submit"
                                                        class="w-8 h-8 rounded-lg border border-gray-300
                                                            flex items-center justify-center
                                                            text-gray-700 font-bold
                                                            hover:bg-gray-100 transition"
                                                        {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                                    +
                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>


                                {{-- Item Total --}}
                                <div class="text-right">

                                    <p class="text-sm text-gray-500">
                                        Total
                                    </p>

                                    <p class="font-bold text-lg text-[#111827] mt-1">
                                        Rs {{ number_format($item->price * $item->quantity, 2) }}
                                    </p>

                                </div>

                            </div>

                            <div class="flex flex-col items-end gap-3">

                                <div class="text-right">
                                    <p class="text-sm text-gray-500">
                                        Total
                                    </p>

                                    <p class="font-bold text-lg text-[#111827]">
                                        Rs {{ number_format($item->price * $item->quantity, 2) }}
                                    </p>
                                </div>

                                <form action="{{ route('cart.remove', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to remove this product from your cart?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-sm font-semibold text-red-500 hover:text-red-700 transition">
                                        Remove
                                    </button>

                                </form>

                            </div>

                        @endforeach

                    </div>


                    {{-- Bottom Summary --}}
                    <div class="border-t border-gray-200 mt-6 pt-6">

                        <div class="flex justify-between items-center">

                            <div>
                                <p class="text-sm text-gray-500">
                                    {{ $cartItems->count() }}
                                    {{ $cartItems->count() == 1 ? 'item' : 'items' }}
                                    in your cart
                                </p>
                            </div>

                            <div class="text-right">

                                <p class="text-sm text-gray-500">
                                    Cart Total
                                </p>

                                <p class="text-2xl font-bold text-[#2563EB]">
                                    Rs {{ number_format($subtotal, 2) }}
                                </p>

                            </div>

                        </div>


                        {{-- Checkout Button --}}
                        <div class="flex justify-end mt-6">

                           <a href="{{ route('checkout') }}"
                                class="w-full block text-center px-6 py-3 rounded-xl
                                        bg-[#2563EB] hover:bg-blue-700
                                        text-white font-semibold transition">

                                    Proceed to Checkout

                            </a>

                        </div>

                    </div>


                @else

                    {{-- Empty Cart --}}
                    <div class="text-center py-16">

                        <div class="w-20 h-20 mx-auto rounded-full
                                    bg-blue-50 flex items-center justify-center mb-5">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="w-10 h-10 text-[#2563EB]">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1-3 0Z"/>

                            </svg>

                        </div>

                        <h2 class="text-xl font-semibold text-[#111827]">
                            Your Cart is Empty
                        </h2>

                        <p class="text-gray-500 mt-2">
                            Products you add to your cart will appear here.
                        </p>

                        <a href="{{ route('home') }}"
                           class="inline-flex mt-6 px-6 py-3 rounded-xl
                                  bg-[#2563EB] hover:bg-blue-700
                                  text-white font-semibold transition">

                            Continue Shopping

                        </a>

                    </div>

                @endif

            </div>

        </main>

    </div>

</div>
</x-frontend-layout>
