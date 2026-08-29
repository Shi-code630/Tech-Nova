<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shopping Cart - Tech Nova</title>

    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 px-4 py-8">

    <div class="mx-auto max-w-6xl rounded-2xl bg-white p-6 shadow-lg sm:p-8">


        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 sm:text-3xl">
                🛒 Shopping Cart
            </h1>

            <a
                href="{{ url('/') }}"
                class="hidden rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 sm:block"
            >
                Continue Shopping
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif


        @if($cartItems->count() > 0)

            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full text-left">

                    <thead class="border-b border-gray-200 bg-gray-50">
                        <tr>
                            <th class="px-5 py-4 text-sm font-semibold text-gray-600">
                                Product
                            </th>

                            <th class="px-5 py-4 text-sm font-semibold text-gray-600">
                                Price
                            </th>

                            <th class="px-5 py-4 text-sm font-semibold text-gray-600">
                                Quantity
                            </th>

                            <th class="px-5 py-4 text-sm font-semibold text-gray-600">
                                Subtotal
                            </th>

                            <th class="px-5 py-4 text-sm font-semibold text-gray-600">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($cartItems as $item)

                            <tr class="transition hover:bg-gray-50">

                                {{-- Product --}}
                                <td class="px-5 py-5">

                                    <div class="font-semibold text-gray-800">
                                        {{ $item->product->name }}
                                    </div>

                                    @if($item->variant)
                                        <div class="mt-1 text-sm text-gray-500">
                                            {{ $item->variant->full_name ?? 'Standard' }}
                                        </div>
                                    @endif

                                </td>


                                {{-- Price --}}
                                <td class="px-5 py-5 font-medium text-gray-700">
                                    Rs. {{ number_format($item->price, 2) }}
                                </td>


                                {{-- Quantity --}}
                                <td class="px-5 py-5">

                                    <form
                                        action="{{ route('cart.update', $item->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ $item->quantity }}"
                                            min="1"
                                            max="10"
                                            onchange="this.form.submit()"
                                            class="w-20 rounded-lg border border-gray-300 px-3 py-2 text-center text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                        >
                                    </form>

                                </td>



                                <td class="px-5 py-5 font-semibold text-gray-800">
                                    Rs.
                                    {{ number_format($item->price * $item->quantity, 2) }}
                                </td>


                                {{-- Remove --}}
                                <td class="px-5 py-5">

                                    <form
                                        action="{{ route('cart.remove', $item->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Remove this item?')"
                                            class="rounded-lg bg-red-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-600"
                                        >
                                            Remove
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Mobile Cards --}}
            <div class="space-y-4 md:hidden">

                @foreach($cartItems as $item)

                    <div class="rounded-xl border border-gray-200 p-4 shadow-sm">

                        <div class="mb-3">

                            <h3 class="font-semibold text-gray-800">
                                {{ $item->product->name }}
                            </h3>

                            @if($item->variant)
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $item->variant->full_name ?? 'Standard' }}
                                </p>
                            @endif

                        </div>


                        <div class="grid grid-cols-2 gap-4 text-sm">

                            <div>
                                <p class="text-gray-500">Price</p>

                                <p class="mt-1 font-semibold text-gray-800">
                                    Rs. {{ number_format($item->price, 2) }}
                                </p>
                            </div>


                            <div>
                                <p class="text-gray-500">Quantity</p>

                                <form
                                    action="{{ route('cart.update', $item->id) }}"
                                    method="POST"
                                    class="mt-1"
                                >
                                    @csrf
                                    @method('PUT')

                                    <input
                                        type="number"
                                        name="quantity"
                                        value="{{ $item->quantity }}"
                                        min="1"
                                        max="10"
                                        onchange="this.form.submit()"
                                        class="w-20 rounded-lg border border-gray-300 px-3 py-2 text-center outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                    >
                                </form>

                            </div>

                        </div>


                        <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4">

                            <div>
                                <p class="text-sm text-gray-500">
                                    Subtotal
                                </p>

                                <p class="font-bold text-gray-800">
                                    Rs.
                                    {{ number_format($item->price * $item->quantity, 2) }}
                                </p>
                            </div>


                            <form
                                action="{{ route('cart.remove', $item->id) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    onclick="return confirm('Remove this item?')"
                                    class="rounded-lg bg-red-500 px-4 py-2 text-sm font-medium text-white hover:bg-red-600"
                                >
                                    Remove
                                </button>

                            </form>

                        </div>

                    </div>

                @endforeach

            </div>



            <div class="mt-8 flex justify-end">

                <div class="w-full rounded-2xl bg-gray-50 p-6 sm:max-w-md">

                    <div class="mb-5 flex items-center justify-between">
                        <span class="text-lg font-medium text-gray-600">
                            Subtotal
                        </span>

                        <span class="text-2xl font-bold text-gray-900">
                            Rs. {{ number_format($subtotal, 2) }}
                        </span>
                    </div>



                    <a
                        href="#"
                        class="block w-full rounded-xl bg-green-600 px-6 py-3 text-center text-lg font-semibold text-white transition hover:bg-green-700"
                    >
                        Proceed to Checkout
                    </a>


                    <div class="mt-4 flex items-center justify-between">


                        <form
                            action="{{ route('cart.clear') }}"
                            method="POST"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                onclick="return confirm('Clear cart?')"
                                class="rounded-lg bg-yellow-400 px-4 py-2 text-sm font-medium text-gray-900 transition hover:bg-yellow-500"
                            >
                                Clear Cart
                            </button>

                        </form>


                        {{-- Continue Shopping --}}
                        <a
                            href="{{ url('/') }}"
                            class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline"
                        >
                            Continue Shopping
                        </a>

                    </div>

                </div>

            </div>


        @else

            {{-- Empty Cart --}}
            <div class="flex flex-col items-center justify-center py-20 text-center">

                <div class="mb-5 text-6xl">
                    🛒
                </div>

                <h2 class="text-2xl font-bold text-gray-800">
                    Your cart is empty
                </h2>

                <p class="mt-2 text-gray-500">
                    Looks like you haven't added anything to your cart yet.
                </p>

                <a
                    href="{{ url('/') }}"
                    class="mt-6 rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700"
                >
                    Start Shopping
                </a>

            </div>

        @endif

    </div>

</body>
</html>
