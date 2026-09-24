<x-frontend-layout>

    <div class="bg-gray-50 w-full py-6 sm:py-8">

        <div class="Container mx-auto px-3 sm:px-4">

            <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">

                {{-- =====================================================
                     SIDEBAR
                ====================================================== --}}
                <aside class="w-full lg:w-64 flex-shrink-0">
                    <x-user-dashboard.sidebar />
                </aside>


                {{-- =====================================================
                     MAIN CONTENT
                ====================================================== --}}
                <main class="flex-1 min-w-0 w-full">


                    {{-- =================================================
                         PAGE HEADER
                    ================================================== --}}
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100
                                p-4 sm:p-6 mb-4 sm:mb-6">

                        <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-[#111827]">
                            Profile Information
                        </h1>

                        <p class="text-xs sm:text-sm text-gray-500 mt-1">
                            Manage your personal information and account details.
                        </p>

                    </div>


                    {{-- =================================================
                         SUCCESS MESSAGE
                    ================================================== --}}
                    @if (session('success'))
                        <div
                            class="mb-4 sm:mb-6 flex items-center gap-2 sm:gap-3
                                    rounded-xl border border-green-200 bg-green-50
                                    px-3 sm:px-5 py-3 sm:py-4
                                    text-xs sm:text-sm text-green-700">

                            <div
                                class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-green-100
                                        flex items-center justify-center flex-shrink-0 text-xs sm:text-sm">
                                ✓
                            </div>

                            <span class="font-medium">
                                {{ session('success') }}
                            </span>

                        </div>
                    @endif


                    {{-- =================================================
                         PROFILE CARD
                    ================================================== --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">


                        {{-- =================================================
                             BLUE PROFILE HEADER
                        ================================================== --}}
                        <div class="h-24 sm:h-32 bg-gradient-to-r from-[#2563EB] to-[#1E40AF] relative">

                            {{-- Profile Image Area --}}
                            <div class="absolute left-4 sm:left-6 -bottom-12 sm:-bottom-14">

                                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-white p-1 shadow-lg relative">

                                    {{-- Profile Image --}}
                                    @if (auth()->user()->image)
                                        <img src="{{ auth()->user()->image }}" alt="{{ auth()->user()->name }}"
                                            class="w-full h-full rounded-full object-cover">
                                    @else
                                        <div
                                            class="w-full h-full rounded-full
                                                    bg-gradient-to-br from-[#F59E0B] to-[#D97706]
                                                    flex items-center justify-center
                                                    text-white text-2xl sm:text-3xl font-bold">

                                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}

                                        </div>
                                    @endif


                                    {{-- Camera Button --}}
                                    <label for="profile_image"
                                        class="absolute bottom-1 right-1
                                               w-8 h-8 sm:w-9 sm:h-9
                                               rounded-full bg-[#2563EB] hover:bg-[#1D4ED8]
                                               border-4 border-white
                                               flex items-center justify-center
                                               text-white cursor-pointer shadow-md transition"
                                        title="Change Profile Picture">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7h2l2-3h10l2 3h2a2 2 0 012 2v9a2 2 0 01-2 2H3a2 2 0 01-2-2V9a2 2 0 012-2z" />

                                            <circle cx="12" cy="13" r="3" />

                                        </svg>

                                    </label>

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                             USER BASIC INFORMATION
                        ================================================== --}}
                        <div class="px-4 sm:px-6 pt-14 sm:pt-16 pb-4 sm:pb-6 border-b border-gray-100">

                            <h2 class="text-base sm:text-lg md:text-xl font-bold text-[#111827] break-words">
                                {{ auth()->user()->name ?? 'User' }}
                            </h2>

                            <p class="text-xs sm:text-sm text-gray-500 mt-1 break-all">
                                {{ auth()->user()->email ?? 'No email available' }}
                            </p>

                            <p class="text-[10px] sm:text-xs text-gray-400 mt-2">
                                Click the camera icon to change your profile picture.
                            </p>

                        </div>


                        {{-- =================================================
                             PROFILE UPDATE FORM
                        ================================================== --}}
                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">

                            @csrf
                            @method('PUT')


                            <div class="p-4 sm:p-6">

                                {{-- Hidden Profile Image --}}
                                <input type="file" name="image" id="profile_image"
                                    accept="image/jpeg,image/png,image/webp" class="hidden">


                                {{-- Section Title --}}
                                <div class="mb-4 sm:mb-5">

                                    <h3 class="text-base sm:text-lg font-semibold text-[#111827]">
                                        Personal Information
                                    </h3>

                                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                        Update your personal information below.
                                    </p>

                                </div>


                                {{-- Form Fields --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">


                                    {{-- Full Name --}}
                                    <div>

                                        <label
                                            class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                                            Full Name
                                        </label>

                                        <input type="text" name="name"
                                            value="{{ old('name', auth()->user()->name) }}" required
                                            class="w-full rounded-xl border border-gray-200 bg-white
                                                   px-3 sm:px-4 py-2.5 sm:py-3
                                                   text-xs sm:text-sm text-gray-700 outline-none
                                                   focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100 transition">

                                        @error('name')
                                            <p class="text-[10px] sm:text-xs text-red-500 mt-1">
                                                {{ $message }}
                                            </p>
                                        @enderror

                                    </div>


                                    {{-- Email --}}
                                    <div>

                                        <label
                                            class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                                            Email Address
                                        </label>

                                        <input type="email" value="{{ auth()->user()->email }}" readonly
                                            class="w-full rounded-xl border border-gray-200 bg-gray-50
                                                   px-3 sm:px-4 py-2.5 sm:py-3
                                                   text-xs sm:text-sm text-gray-500 outline-none cursor-not-allowed">

                                        <p class="text-[10px] sm:text-xs text-gray-400 mt-1">
                                            Email address cannot be changed here.
                                        </p>

                                    </div>


                                    {{-- Phone --}}
                                    <div>

                                        <label
                                            class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                                            Phone Number
                                        </label>

                                        <input type="text" name="phone"
                                            value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                            placeholder="Enter phone number"
                                            class="w-full rounded-xl border border-gray-200 bg-white
                                                   px-3 sm:px-4 py-2.5 sm:py-3
                                                   text-xs sm:text-sm text-gray-700 outline-none
                                                   focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100 transition">

                                        @error('phone')
                                            <p class="text-[10px] sm:text-xs text-red-500 mt-1">
                                                {{ $message }}
                                            </p>
                                        @enderror

                                    </div>


                                    {{-- Account Status --}}
                                    <div>

                                        <label
                                            class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                                            Account Status
                                        </label>

                                        <div
                                            class="w-full rounded-xl border border-gray-200 bg-gray-50
                                                    px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm">

                                            @if (auth()->user()->status)
                                                <span
                                                    class="inline-flex items-center gap-1.5 sm:gap-2 text-green-600 font-medium">
                                                    <span
                                                        class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-green-500"></span>
                                                    Active
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1.5 sm:gap-2 text-red-600 font-medium">
                                                    <span
                                                        class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-red-500"></span>
                                                    Inactive
                                                </span>
                                            @endif

                                        </div>

                                    </div>

                                </div>


                                {{-- Image Information --}}
                                <div
                                    class="mt-4 sm:mt-5 rounded-xl border border-blue-100 bg-blue-50
                                            px-3 sm:px-4 py-2.5 sm:py-3">

                                    <div class="flex items-start gap-2 sm:gap-3">

                                        <div
                                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-blue-100
                                                    flex items-center justify-center
                                                    text-[#2563EB] flex-shrink-0 text-xs sm:text-sm">
                                            📷
                                        </div>

                                        <div class="min-w-0">

                                            <p class="text-xs sm:text-sm font-semibold text-blue-900">
                                                Profile Picture
                                            </p>

                                            <p class="text-[10px] sm:text-xs text-blue-700 mt-1">
                                                JPG, JPEG, PNG or WEBP. Maximum size 2MB.
                                            </p>

                                        </div>

                                    </div>

                                </div>


                                {{-- Save Button --}}
                                <div class="flex justify-end mt-5 sm:mt-6 pt-4 sm:pt-5 border-t border-gray-100">

                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 sm:gap-2
                                               px-4 sm:px-6 py-2.5 sm:py-3
                                               rounded-xl bg-[#2563EB] hover:bg-[#1D4ED8]
                                               text-white text-xs sm:text-sm font-semibold
                                               shadow-md hover:shadow-lg transition">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />

                                        </svg>

                                        Save Changes

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                    <div class="pt-5">
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <button type="button" id="passwordToggle" onclick="togglePasswordPanel()"
                            class="w-full flex items-center gap-3 sm:gap-4 p-4 sm:p-6 text-left hover:bg-slate-50 transition">
                            <div
                                class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-50 text-[#F59E0B] flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.8" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V7.125a4.125 4.125 0 0 0-8.25 0V10.5m-.75 0h9.75A1.5 1.5 0 0 1 19 12v7.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 5 19.5V12a1.5 1.5 0 0 1 1.5-1.5Z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h2 class="font-semibold text-sm sm:text-base text-[#111827]">Change Password</h2>
                                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Update your password and keep your
                                    account secure.</p>
                            </div>
                            <svg id="passwordChevron" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                class="w-4 h-4 text-gray-400 transition-transform {{ $errors->hasAny(['current_password', 'password', 'password_confirmation']) ? 'rotate-90' : '' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>

                        <div id="passwordPanel"
                            class="border-t border-gray-100 px-4 sm:px-6 pb-6 {{ $errors->hasAny(['current_password', 'password', 'password_confirmation']) ? '' : 'hidden' }}">
                            <form method="POST" action="{{ route('user.password.update') }}"
                                class="max-w-md space-y-4 pt-5">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Current
                                        password</label>
                                    <div class="relative">
                                        <input id="current_password" type="password" name="current_password" required
                                            class="w-full h-11 rounded-xl border {{ $errors->has('current_password') ? 'border-red-400' : 'border-gray-300' }} px-3 pr-10 text-sm focus:ring-2 focus:ring-[#2563EB] focus:border-[#2563EB]">
                                        <button type="button"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-500"
                                            onclick="toggleEye('current_password', this)">Show</button>
                                    </div>
                                    @error('current_password')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">New password</label>
                                    <div class="relative">
                                        <input id="password" type="password" name="password" required
                                            minlength="8"
                                            class="w-full h-11 rounded-xl border {{ $errors->has('password') ? 'border-red-400' : 'border-gray-300' }} px-3 pr-10 text-sm focus:ring-2 focus:ring-[#2563EB] focus:border-[#2563EB]"
                                            oninput="checkPasswordMatch()">
                                        <button type="button"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-500"
                                            onclick="toggleEye('password', this)">Show</button>
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-1">At least 8 characters.</p>
                                    @error('password')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Confirm new
                                        password</label>
                                    <div class="relative">
                                        <input id="password_confirmation" type="password"
                                            name="password_confirmation" required minlength="8"
                                            class="w-full h-11 rounded-xl border border-gray-300 px-3 pr-10 text-sm focus:ring-2 focus:ring-[#2563EB] focus:border-[#2563EB]"
                                            oninput="checkPasswordMatch()">
                                        <button type="button"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-500"
                                            onclick="toggleEye('password_confirmation', this)">Show</button>
                                    </div>
                                    <p id="matchHint" class="text-xs mt-1"></p>
                                </div>

                                <button type="submit"
                                    class="h-11 px-5 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white text-sm font-semibold">
                                    Save new password
                                </button>
                            </form>
                        </div>
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
            if (!b) {
                hint.textContent = '';
                return;
            }
            if (a === b) {
                hint.textContent = 'Passwords match';
                hint.className = 'text-xs mt-1 text-emerald-600';
            } else {
                hint.textContent = 'Passwords do not match';
                hint.className = 'text-xs mt-1 text-red-600';
            }
        }
    </script>
</x-frontend-layout>
