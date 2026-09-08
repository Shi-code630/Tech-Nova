<x-frontend-layout>

    <div class="bg-gray-100 py-8">

        <div class="Container mx-auto">
            <div class="flex gap-6 ">

            {{-- Sidebar --}}
            <x-user-dashboard.sidebar />

            {{-- Main Content --}}
            <main class="flex-1">

                {{-- Page Header --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">

                    <div class="flex items-center justify-between">

                        <div>
                            <h1 class="text-2xl font-bold text-[#111827]">
                                My Coupons
                            </h1>

                            <p class="text-sm text-gray-500 mt-1">
                                View your available and redeemed coupons.
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="w-6 h-6 text-purple-600">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.03.84-1.86 1.87-1.86h10.26c1.03 0 1.87.83 1.87 1.86Z"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9 9.75h.008v.008H9V9.75Zm6 4.5h.008v.008H15v-.008Z"/>

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Coupons Content --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">

                    {{-- Empty State --}}
                    <div class="text-center py-16">

                        <div class="w-20 h-20 mx-auto rounded-full bg-purple-50 flex items-center justify-center mb-5">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="w-10 h-10 text-purple-500">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.03.84-1.86 1.87-1.86h10.26c1.03 0 1.87.83 1.87 1.86Z"/>

                            </svg>

                        </div>

                        <h2 class="text-xl font-semibold text-[#111827]">
                            No Coupons Available
                        </h2>

                        <p class="text-gray-500 mt-2">
                            Your available coupons and offers will appear here.
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

    </div>

</x-frontend-layout>
