<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

    {{-- =====================================================
         TOTAL ORDERS
    ====================================================== --}}
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl
                transition-all duration-300 p-6
                border border-gray-100
                flex flex-col justify-between">

        <div class="flex items-center justify-between gap-4">

            <div class="w-16 h-16 flex-shrink-0 rounded-2xl
                        bg-blue-100
                        flex items-center justify-center
                        text-3xl">
                📦
            </div>

            <h2 class="text-1xl lg:text-3xl font-bold text-blue-600 text-right">
                {{ $totalOrders }}
            </h2>

        </div>

        <div class="mt-5">

            <h3 class="text-xl font-semibold text-gray-800">
                Total Orders
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                All your placed orders
            </p>

        </div>

        <a href="{{ route('user.orders') }}"
            class="mt-4 inline-flex items-center gap-1
                   text-blue-600 font-semibold
                   hover:text-blue-800
                   transition-colors duration-200">

            View Orders
            <span>→</span>

        </a>

    </div>


    {{-- =====================================================
         IN PROGRESS
    ====================================================== --}}
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl
                transition-all duration-300 p-6
                border border-gray-100
                flex flex-col justify-between">

        <div class="flex items-center justify-between gap-4">

            <div class="w-16 h-16 flex-shrink-0 rounded-2xl
                        bg-green-100
                        flex items-center justify-center
                        text-3xl">
                🚚
            </div>

            <h2 class="text-3xl lg:text-3xl font-bold text-green-600 text-right">
                {{ $inProgress }}
            </h2>

        </div>

        <div class="mt-5">

            <h3 class="text-xl font-semibold text-gray-800">
                In Progress
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Orders currently processing
            </p>

        </div>

        <a href="{{ route('user.orders') }}"
            class="mt-4 inline-flex items-center gap-1
                   text-green-600 font-semibold
                   hover:text-green-800
                   transition-colors duration-200">

            Track Orders
            <span>→</span>

        </a>

    </div>


    {{-- =====================================================
         WISHLIST
    ====================================================== --}}
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl
                transition-all duration-300 p-6
                border border-gray-100
                flex flex-col justify-between">

        <div class="flex items-center justify-between gap-4">

            <div class="w-16 h-16 flex-shrink-0 rounded-2xl
                        bg-pink-100
                        flex items-center justify-center
                        text-3xl">
                ❤️
            </div>

            <h2 class="text-3xl lg:text-3xl font-bold text-pink-600 text-right">
                {{ $wishlistCount }}
            </h2>

        </div>

        <div class="mt-5">

            <h3 class="text-xl font-semibold text-gray-800">
                Wishlist
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Products saved for later
            </p>

        </div>

        <a href="{{ route('user.wishlist') }}"
            class="mt-4 inline-flex items-center gap-1
                   text-pink-600 font-semibold
                   hover:text-pink-800
                   transition-colors duration-200">

            View Wishlist
            <span>→</span>

        </a>

    </div>


    {{-- =====================================================
         TOTAL SPENT
    ====================================================== --}}
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl
                transition-all duration-300 p-6
                border border-gray-100
                flex flex-col justify-between">

        <div class="flex items-center justify-between gap-4">

            <div class="w-16 h-16 flex-shrink-0 rounded-2xl
                        bg-orange-100
                        flex items-center justify-center
                        text-3xl">
                💰
            </div>

            <h2 class="text-2xl lg:text-1xl font-bold text-orange-600 text-right">
                Rs {{ number_format($totalSpent, 2) }}
            </h2>

        </div>

        <div class="mt-5">

            <h3 class="text-xl font-semibold text-gray-800">
                Total Spent
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Your total purchase amount
            </p>

        </div>

        <a href="{{ route('user.orders') }}"
            class="mt-4 inline-flex items-center gap-1
                   text-orange-600 font-semibold
                   hover:text-orange-800
                   transition-colors duration-200">

            Order History
            <span>→</span>

        </a>

    </div>

</div>
