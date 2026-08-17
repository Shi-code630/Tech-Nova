<x-frontend-layout>

    <div class="min-h-screen bg-gray-50">

        <div class="flex">

            {{-- Sidebar --}}
            <x-user-dashboard.sidebar />

            {{-- Main Content --}}
            <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8">

                {{-- Page Header --}}
                <div class="mb-6">
                    <h1 class="text-2xl sm:text-3xl font-bold text-[#111827]">
                        Settings
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage your account, security and preferences.
                    </p>
                </div>


                {{-- Settings Cards --}}
                <div class="space-y-5 max-w-5xl">

                    {{-- Profile Information --}}
                    <a href="#"
                       class="group block bg-white rounded-2xl border border-gray-200
                              shadow-sm hover:shadow-md hover:border-blue-200
                              transition-all duration-200">

                        <div class="flex items-center gap-4 p-5 sm:p-6">

                            <div class="flex-shrink-0 w-12 h-12 rounded-xl
                                        bg-blue-50 text-[#2563EB]
                                        flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor"
                                     class="w-6 h-6">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                                </svg>

                            </div>

                            <div class="flex-1 min-w-0">

                                <h2 class="font-semibold text-[#111827]
                                           group-hover:text-[#2563EB]
                                           transition-colors">

                                    Profile Information
                                </h2>

                                <p class="text-sm text-gray-500 mt-1">
                                    Update your name, email, phone number and personal information.
                                </p>

                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="2"
                                 stroke="currentColor"
                                 class="w-5 h-5 text-gray-400
                                        group-hover:text-[#2563EB]
                                        group-hover:translate-x-1
                                        transition-all">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m8.25 4.5 7.5 7.5-7.5 7.5" />

                            </svg>

                        </div>

                    </a>


                    {{-- Change Password --}}
                    <a href="#"
                       class="group block bg-white rounded-2xl border border-gray-200
                              shadow-sm hover:shadow-md hover:border-blue-200
                              transition-all duration-200">

                        <div class="flex items-center gap-4 p-5 sm:p-6">

                            <div class="flex-shrink-0 w-12 h-12 rounded-xl
                                        bg-amber-50 text-[#F59E0B]
                                        flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor"
                                     class="w-6 h-6">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M16.5 10.5V7.125a4.125 4.125 0 0 0-8.25 0V10.5m-.75 0h9.75A1.5 1.5 0 0 1 19 12v7.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 5 19.5V12a1.5 1.5 0 0 1 1.5-1.5Z" />

                                </svg>

                            </div>

                            <div class="flex-1 min-w-0">

                                <h2 class="font-semibold text-[#111827]
                                           group-hover:text-[#2563EB]
                                           transition-colors">

                                    Change Password
                                </h2>

                                <p class="text-sm text-gray-500 mt-1">
                                    Update your password and keep your account secure.
                                </p>

                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="2"
                                 stroke="currentColor"
                                 class="w-5 h-5 text-gray-400
                                        group-hover:text-[#2563EB]
                                        group-hover:translate-x-1
                                        transition-all">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m8.25 4.5 7.5 7.5-7.5 7.5" />

                            </svg>

                        </div>

                    </a>


                    {{-- Address Management --}}
                    <a href="#"
                       class="group block bg-white rounded-2xl border border-gray-200
                              shadow-sm hover:shadow-md hover:border-blue-200
                              transition-all duration-200">

                        <div class="flex items-center gap-4 p-5 sm:p-6">

                            <div class="flex-shrink-0 w-12 h-12 rounded-xl
                                        bg-emerald-50 text-emerald-600
                                        flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor"
                                     class="w-6 h-6">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />

                                </svg>

                            </div>

                            <div class="flex-1 min-w-0">

                                <h2 class="font-semibold text-[#111827]
                                           group-hover:text-[#2563EB]
                                           transition-colors">

                                    Address Management
                                </h2>

                                <p class="text-sm text-gray-500 mt-1">
                                    Add, edit or manage your saved delivery addresses.
                                </p>

                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="2"
                                 stroke="currentColor"
                                 class="w-5 h-5 text-gray-400
                                        group-hover:text-[#2563EB]
                                        group-hover:translate-x-1
                                        transition-all">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m8.25 4.5 7.5 7.5-7.5 7.5" />

                            </svg>

                        </div>

                    </a>


                    {{-- Notifications --}}
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">

                        <div class="flex items-center gap-4 p-5 sm:p-6">

                            <div class="flex-shrink-0 w-12 h-12 rounded-xl
                                        bg-purple-50 text-purple-600
                                        flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor"
                                     class="w-6 h-6">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9a6 6 0 0 0-12 0v.75a8.967 8.967 0 0 1-2.31 6.022 23.848 23.848 0 0 0 5.454 1.31m5.713 0a24.255 24.255 0 0 1-5.713 0m5.713 0a3 3 0 1 1-5.713 0" />

                                </svg>

                            </div>

                            <div class="flex-1">

                                <h2 class="font-semibold text-[#111827]">
                                    Notifications
                                </h2>

                                <p class="text-sm text-gray-500 mt-1">
                                    Receive updates about orders, delivery and promotions.
                                </p>

                            </div>

                            {{-- Toggle --}}
                            <label class="relative inline-flex items-center cursor-pointer">

                                <input type="checkbox"
                                       checked
                                       class="sr-only peer">

                                <div class="w-11 h-6 bg-gray-200 rounded-full
                                            peer peer-checked:bg-[#2563EB]
                                            transition-colors
                                            after:content-['']
                                            after:absolute
                                            after:top-[2px]
                                            after:left-[2px]
                                            after:bg-white
                                            after:border-gray-300
                                            after:border
                                            after:rounded-full
                                            after:h-5
                                            after:w-5
                                            after:transition-all
                                            peer-checked:after:translate-x-full
                                            peer-checked:after:border-white">
                                </div>

                            </label>

                        </div>

                    </div>


                    {{-- Privacy & Security --}}
                    <a href="#"
                       class="group block bg-white rounded-2xl border border-gray-200
                              shadow-sm hover:shadow-md hover:border-blue-200
                              transition-all duration-200">

                        <div class="flex items-center gap-4 p-5 sm:p-6">

                            <div class="flex-shrink-0 w-12 h-12 rounded-xl
                                        bg-red-50 text-red-500
                                        flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor"
                                     class="w-6 h-6">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.295 9 11.616 5.176-1.321 9-6.024 9-11.616 0-1.31-.21-2.57-.598-3.75A11.959 11.959 0 0 1 12 2.714Z" />

                                </svg>

                            </div>

                            <div class="flex-1 min-w-0">

                                <h2 class="font-semibold text-[#111827]
                                           group-hover:text-[#2563EB]
                                           transition-colors">

                                    Privacy & Security
                                </h2>

                                <p class="text-sm text-gray-500 mt-1">
                                    Manage your account security and privacy preferences.
                                </p>

                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="2"
                                 stroke="currentColor"
                                 class="w-5 h-5 text-gray-400
                                        group-hover:text-[#2563EB]
                                        group-hover:translate-x-1
                                        transition-all">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m8.25 4.5 7.5 7.5-7.5 7.5" />

                            </svg>

                        </div>

                    </a>


                    {{-- Logout --}}
                    <div class="pt-3">

                        <form method="POST" action="#">

                            @csrf

                            <button type="submit"
                                    class="w-full sm:w-auto flex items-center justify-center
                                           gap-2 px-6 py-3 rounded-xl
                                           border border-red-200
                                           text-red-600 bg-white
                                           hover:bg-red-50
                                           transition-colors font-medium">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor"
                                     class="w-5 h-5">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15" />

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M18 15l3-3m0 0-3-3m3 3H9" />

                                </svg>

                                Logout

                            </button>

                        </form>

                    </div>

                </div>

            </main>

        </div>

    </div>

</x-frontend-layout>+
