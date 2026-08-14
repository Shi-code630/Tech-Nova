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
                                      d="M2.25 3h1.386c.51 0 .955.343 1.086.836L5.75 7.5m0 0h13.5l-1.5 7.5H7.25L5.75 7.5Zm1.5 10.5h10.5M9 21a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Cart Content --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">

                    {{-- Empty Cart --}}
                    <div class="text-center py-16">

                        <div class="w-20 h-20 mx-auto rounded-full bg-blue-50 flex items-center justify-center mb-5">

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
                           class="inline-flex mt-6 px-6 py-3 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white font-semibold transition">

                            Continue Shopping

                        </a>

                    </div>

                </div>

            </main>

        </div>

    </div>

</x-frontend-layout>
