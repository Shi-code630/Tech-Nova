<x-frontend-layout>

    <div class="min-h-screen bg-gray-100 py-8">

        <div class="max-w-7xl mx-auto px-4">

            <div class="flex gap-6">

                <!-- Sidebar -->
                @include('user.partials.sidebar')


                <!-- Main Content -->
                <main class="flex-1">

                    <!-- Page Header -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">

                        <div class="flex items-center justify-between">

                            <div>
                                <h1 class="text-2xl font-bold text-[#111827]">
                                    My Wishlist
                                </h1>

                                <p class="text-gray-500 mt-1">
                                    Products you've saved for later.
                                </p>
                            </div>

                            <div class="text-3xl">
                                ❤️
                            </div>

                        </div>

                    </div>


                    <!-- Wishlist -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">

                        <!-- Empty Wishlist -->
                        <div class="text-center py-16">

                            <div class="w-20 h-20 mx-auto mb-5 rounded-full bg-red-50 flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor"
                                     class="w-10 h-10 text-red-500">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733C11.285 4.876 9.623 3.75 7.688 3.75 5.099 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>

                                </svg>

                            </div>

                            <h2 class="text-xl font-semibold text-[#111827]">
                                Your Wishlist is Empty
                            </h2>

                            <p class="text-gray-500 mt-2">
                                Save products you love and find them here later.
                            </p>

                            <a href="{{ route('home') }}"
                               class="inline-flex items-center mt-6 px-6 py-3 bg-[#2563EB] hover:bg-blue-700 text-white font-semibold rounded-xl transition">

                                Continue Shopping

                            </a>

                        </div>

                    </div>

                </main>

            </div>

        </div>

    </div>

</x-frontend-layout>
