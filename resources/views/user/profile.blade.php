<x-frontend-layout>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="w-[95%] max-w-7xl mx-auto">

            <div class="flex flex-col lg:flex-row gap-6">

                {{-- Sidebar --}}
                <x-user-dashboard.sidebar />

                {{-- Main Content --}}
                <main class="flex-1">

                    {{-- Page Header --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                        <h1 class="text-2xl font-bold text-[#111827]">
                            Profile Information
                        </h1>

                        <p class="text-sm text-gray-500 mt-1">
                            Manage your personal information and account details.
                        </p>
                    </div>

                    {{-- Profile Card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                        {{-- Blue Header --}}
                        <div class="h-32 bg-gradient-to-r from-[#2563EB] to-[#1E40AF] relative">

                            <div class="absolute left-6 -bottom-14">
                                <div class="w-28 h-28 rounded-full bg-white p-1 shadow-lg">
                                    <div class="w-full h-full rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-white text-3xl font-bold">
                                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- User Name --}}
                        <div class="px-6 pt-16 pb-6 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-[#111827]">
                                {{ auth()->user()->name ?? 'User' }}
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ auth()->user()->email ?? 'No email available' }}
                            </p>
                        </div>

                        {{-- Personal Information --}}
                        <div class="p-6">

                            <h3 class="text-lg font-semibold text-[#111827] mb-5">
                                Personal Information
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                {{-- Name --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Full Name
                                    </label>

                                    <input
                                        type="text"
                                        value="{{ auth()->user()->name }}"
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700 focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100 outline-none"
                                    >
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Email Address
                                    </label>

                                    <input
                                        type="email"
                                        value="{{ auth()->user()->email }}"
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700 focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100 outline-none"
                                    >
                                </div>

                                {{-- Phone --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Phone Number
                                    </label>

                                    <input
                                        type="text"
                                        value="{{ auth()->user()->phone ?? '' }}"
                                        placeholder="Enter phone number"
                                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100 outline-none"
                                    >
                                </div>

                                {{-- Account --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Account Status
                                    </label>

                                    <div class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm">
                                        <span class="inline-flex items-center gap-2 text-green-600 font-medium">
                                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                            Active
                                        </span>
                                    </div>
                                </div>

                            </div>

                            {{-- Save Button --}}
                            <div class="flex justify-end mt-6 pt-5 border-t border-gray-100">

                                <button
                                    type="button"
                                    class="px-6 py-3 rounded-xl bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-sm font-semibold shadow-md transition">
                                    Save Changes
                                </button>

                            </div>

                        </div>

                    </div>

                </main>

            </div>

        </div>
    </div>

</x-frontend-layout>
