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
                                My Reviews
                            </h1>

                            <p class="text-sm text-gray-500 mt-1">
                                Manage your product reviews and ratings.
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="w-6 h-6 text-yellow-500">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.205 3.602a.563.563 0 0 0-.182.557l1.285 5.381c.116.485-.409.867-.84.608l-4.725-2.85a.563.563 0 0 0-.581 0l-4.725 2.85c-.431.259-.956-.123-.84-.608l1.285-5.381a.563.563 0 0 0-.182-.557L2.64 10.385c-.38-.325-.178-.948.321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Reviews Content --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">

                    {{-- Empty State --}}
                    <div class="text-center py-16">

                        <div class="w-20 h-20 mx-auto rounded-full bg-yellow-50 flex items-center justify-center mb-5">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="w-10 h-10 text-yellow-500">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.205 3.602a.563.563 0 0 0-.182.557l1.285 5.381c.116.485-.409.867-.84.608l-4.725-2.85a.563.563 0 0 0-.581 0l-4.725 2.85c-.431.259-.956-.123-.84-.608l1.285-5.381a.563.563 0 0 0-.182-.557L2.64 10.385c-.38-.325-.178-.948.321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>

                            </svg>

                        </div>

                        <h2 class="text-xl font-semibold text-[#111827]">
                            No Reviews Yet
                        </h2>

                        <p class="text-gray-500 mt-2">
                            Your product reviews will appear here.
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
