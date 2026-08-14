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
                                My Addresses
                            </h1>

                            <p class="text-sm text-gray-500 mt-1">
                                Manage your delivery addresses.
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="w-6 h-6 text-green-600">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M19.5 10.5c0 7.142-7.5 10.5-7.5 10.5S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Address Content --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">

                    {{-- Add Address --}}
                    <div class="flex justify-end mb-6">

                        <button
                            type="button"
                            class="inline-flex items-center gap-2 px-5 py-3 bg-[#2563EB] hover:bg-blue-700 text-white rounded-xl font-semibold transition">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="2"
                                 stroke="currentColor"
                                 class="w-5 h-5">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 4.5v15m7.5-7.5h-15"/>

                            </svg>

                            Add New Address

                        </button>

                    </div>


                    {{-- Empty State --}}
                    <div class="text-center py-14">

                        <div class="w-20 h-20 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-5">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="w-10 h-10 text-gray-400">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M19.5 10.5c0 7.142-7.5 10.5-7.5 10.5S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>

                            </svg>

                        </div>

                        <h2 class="text-xl font-semibold text-[#111827]">
                            No Addresses Added
                        </h2>

                        <p class="text-gray-500 mt-2">
                            Add a delivery address to make checkout faster.
                        </p>

                    </div>

                </div>

            </main>

        </div>

    </div>

</x-frontend-layout>
