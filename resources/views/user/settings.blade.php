<x-frontend-layout title="Settings | TechNova Nepal" robots="noindex,nofollow">

    <div class="min-h-screen bg-gray-50 w-full py-6 sm:py-8">
        <div class="Container mx-auto px-3 sm:px-4">
            <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">

                <aside class="w-full lg:w-64 flex-shrink-0">
                    <x-user-dashboard.sidebar />
                </aside>

                <main class="flex-1 min-w-0 w-full p-3 sm:p-6 lg:p-8">

                    <div class="mb-4 sm:mb-6">
                        <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-[#111827]">Settings</h1>
                        <p class="mt-1 text-xs sm:text-sm text-gray-500">Manage your account, security and preferences.</p>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 font-medium">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 font-medium">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="space-y-4 sm:space-y-5 max-w-5xl">

                        <a href="{{ route('user.profile') }}"
                            class="group block bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-200">
                            <div class="flex items-center gap-3 sm:gap-4 p-4 sm:p-6">
                                <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-[#2563EB] flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h2 class="font-semibold text-sm sm:text-base text-[#111827] group-hover:text-[#2563EB]">Profile Information</h2>
                                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">{{ auth()->user()->name }} · {{ auth()->user()->email }}</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-400 group-hover:text-[#2563EB] group-hover:translate-x-1 transition-all">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>

                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                            <button type="button" id="passwordToggle" onclick="togglePasswordPanel()"
                                class="w-full flex items-center gap-3 sm:gap-4 p-4 sm:p-6 text-left hover:bg-slate-50 transition">
                                <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-50 text-[#F59E0B] flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.125a4.125 4.125 0 0 0-8.25 0V10.5m-.75 0h9.75A1.5 1.5 0 0 1 19 12v7.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 5 19.5V12a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h2 class="font-semibold text-sm sm:text-base text-[#111827]">Change Password</h2>
                                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Update your password and keep your account secure.</p>
                                </div>
                                <svg id="passwordChevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-400 transition-transform {{ $errors->hasAny(['current_password','password','password_confirmation']) ? 'rotate-90' : '' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>

                            <div id="passwordPanel" class="border-t border-gray-100 px-4 sm:px-6 pb-6 {{ $errors->hasAny(['current_password','password','password_confirmation']) ? '' : 'hidden' }}">
                                <form method="POST" action="{{ route('user.password.update') }}" class="max-w-md space-y-4 pt-5">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Current password</label>
                                        <div class="relative">
                                            <input id="current_password" type="password" name="current_password" required
                                                class="w-full h-11 rounded-xl border {{ $errors->has('current_password') ? 'border-red-400' : 'border-gray-300' }} px-3 pr-10 text-sm focus:ring-2 focus:ring-[#2563EB] focus:border-[#2563EB]">
                                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-500" onclick="toggleEye('current_password', this)">Show</button>
                                        </div>
                                        @error('current_password')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">New password</label>
                                        <div class="relative">
                                            <input id="password" type="password" name="password" required minlength="8"
                                                class="w-full h-11 rounded-xl border {{ $errors->has('password') ? 'border-red-400' : 'border-gray-300' }} px-3 pr-10 text-sm focus:ring-2 focus:ring-[#2563EB] focus:border-[#2563EB]"
                                                oninput="checkPasswordMatch()">
                                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-500" onclick="toggleEye('password', this)">Show</button>
                                        </div>
                                        <p class="text-[11px] text-slate-400 mt-1">At least 8 characters.</p>
                                        @error('password')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Confirm new password</label>
                                        <div class="relative">
                                            <input id="password_confirmation" type="password" name="password_confirmation" required minlength="8"
                                                class="w-full h-11 rounded-xl border border-gray-300 px-3 pr-10 text-sm focus:ring-2 focus:ring-[#2563EB] focus:border-[#2563EB]"
                                                oninput="checkPasswordMatch()">
                                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-500" onclick="toggleEye('password_confirmation', this)">Show</button>
                                        </div>
                                        <p id="matchHint" class="text-xs mt-1"></p>
                                    </div>

                                    <button type="submit" class="h-11 px-5 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white text-sm font-semibold">
                                        Save new password
                                    </button>
                                </form>
                            </div>
                        </div>

                        <a href="{{ route('checkout.addresses') }}"
                            class="group block bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-200">
                            <div class="flex items-center gap-3 sm:gap-4 p-4 sm:p-6">
                                <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h2 class="font-semibold text-sm sm:text-base text-[#111827] group-hover:text-[#2563EB]">Address Management</h2>
                                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Add, edit or manage your saved delivery addresses.</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-400 group-hover:translate-x-1 transition-all">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>

                        <a href="{{ route('privacy-policy') }}"
                            class="group block bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-200">
                            <div class="flex items-center gap-3 sm:gap-4 p-4 sm:p-6">
                                <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-red-50 text-red-500 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.295 9 11.616 5.176-1.321 9-6.024 9-11.616 0-1.31-.21-2.57-.598-3.75A11.959 11.959 0 0 1 12 2.714Z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h2 class="font-semibold text-sm sm:text-base text-[#111827] group-hover:text-[#2563EB]">Privacy Policy</h2>
                                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">How TechNova Nepal handles your data.</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-400 group-hover:translate-x-1 transition-all">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>

                        <div class="pt-2 sm:pt-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 rounded-xl border border-red-200 text-red-600 bg-white hover:bg-red-50 transition-colors font-medium text-xs sm:text-sm">
                                    Logout
                                </button>
                            </form>
                        </div>

                    </div>
                </main>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordPanel() {
            var panel = document.getElementById('passwordPanel');
            var chev = document.getElementById('passwordChevron');
            panel.classList.toggle('hidden');
            chev.classList.toggle('rotate-90');
        }
        function toggleEye(id, btn) {
            var input = document.getElementById(id);
            var hide = input.type === 'password';
            input.type = hide ? 'text' : 'password';
            btn.textContent = hide ? 'Hide' : 'Show';
        }
        function checkPasswordMatch() {
            var a = document.getElementById('password').value;
            var b = document.getElementById('password_confirmation').value;
            var hint = document.getElementById('matchHint');
            if (!b) { hint.textContent = ''; return; }
            if (a === b) { hint.textContent = 'Passwords match'; hint.className = 'text-xs mt-1 text-emerald-600'; }
            else { hint.textContent = 'Passwords do not match'; hint.className = 'text-xs mt-1 text-red-600'; }
        }
    </script>
</x-frontend-layout>
