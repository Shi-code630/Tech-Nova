<x-frontend-layout>

    <div class="bg-gray-50 py-8">
        <div class="Container mx-auto">

            <div class="flex flex-col lg:flex-row gap-6">

                {{-- =====================================================
                     SIDEBAR
                ====================================================== --}}
                <x-user-dashboard.sidebar />


                {{-- =====================================================
                     MAIN CONTENT
                ====================================================== --}}
                <main class="flex-1 min-w-0">


                    {{-- =================================================
                         PAGE HEADER
                    ================================================== --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

                        <h1 class="text-2xl font-bold text-[#111827]">
                            Profile Information
                        </h1>

                        <p class="text-sm text-gray-500 mt-1">
                            Manage your personal information and account details.
                        </p>

                    </div>


                    {{-- =================================================
                         SUCCESS MESSAGE
                    ================================================== --}}
                    @if (session('success'))
                        <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">

                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
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
                        <div class="h-32 bg-gradient-to-r from-[#2563EB] to-[#1E40AF] relative">

                            {{-- Profile Image Area --}}
                            <div class="absolute left-6 -bottom-14">

                                <div class="w-28 h-28 rounded-full bg-white p-1 shadow-lg relative">


                                    {{-- =====================================
                                         PROFILE IMAGE
                                        
                                    ====================================== --}}
                                    @if (auth()->user()->image)
                                        <img src="{{ auth()->user()->image }}"
                                            alt="{{ auth()->user()->name }}"
                                            class="w-full h-full rounded-full object-cover">
                                    @else
                                        <div class="w-full h-full rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-white text-3xl font-bold">
                                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                        </div>
                                    @endif


                                    {{-- =====================================
                                         CAMERA BUTTON
                                    ====================================== --}}
                                    <label for="profile_image"
                                        class="absolute bottom-1 right-1 w-9 h-9 rounded-full bg-[#2563EB] hover:bg-[#1D4ED8] border-4 border-white flex items-center justify-center text-white cursor-pointer shadow-md transition"
                                        title="Change Profile Picture">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

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
                        <div class="px-6 pt-16 pb-6 border-b border-gray-100">

                            <h2 class="text-xl font-bold text-[#111827]">
                                {{ auth()->user()->name ?? 'User' }}
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ auth()->user()->email ?? 'No email available' }}
                            </p>

                            <p class="text-xs text-gray-400 mt-2">
                                Click the camera icon to change your profile picture.
                            </p>

                        </div>


                        {{-- =================================================
                             PROFILE UPDATE FORM
                        ================================================== --}}
                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">

                            @csrf
                            @method('PUT')


                            <div class="p-6">


                                {{-- Hidden Profile Image --}}
                                <input type="file" name="image" id="profile_image"
                                    accept="image/jpeg,image/png,image/webp" class="hidden">


                                {{-- =========================================
                                     SECTION TITLE
                                ========================================== --}}
                                <div class="mb-5">

                                    <h3 class="text-lg font-semibold text-[#111827]">
                                        Personal Information
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Update your personal information below.
                                    </p>

                                </div>


                                {{-- =========================================
                                     FORM FIELDS
                                ========================================== --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                                    {{-- =====================================
                                         FULL NAME
                                    ====================================== --}}
                                    <div>

                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Full Name
                                        </label>

                                        <input type="text" name="name"
                                            value="{{ old('name', auth()->user()->name) }}" required
                                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100 transition">

                                        @error('name')
                                            <p class="text-xs text-red-500 mt-1">
                                                {{ $message }}
                                            </p>
                                        @enderror

                                    </div>


                                    {{-- =====================================
                                         EMAIL
                                    ====================================== --}}
                                    <div>

                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Email Address
                                        </label>

                                        <input type="email" value="{{ auth()->user()->email }}" readonly
                                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-500 outline-none cursor-not-allowed">

                                        <p class="text-xs text-gray-400 mt-1">
                                            Email address cannot be changed here.
                                        </p>

                                    </div>


                                    {{-- =====================================
                                         PHONE
                                    ====================================== --}}
                                    <div>

                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number
                                        </label>

                                        <input type="text" name="phone"
                                            value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                            placeholder="Enter phone number"
                                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100 transition">

                                        @error('phone')
                                            <p class="text-xs text-red-500 mt-1">
                                                {{ $message }}
                                            </p>
                                        @enderror

                                    </div>


                                    {{-- =====================================
                                         ACCOUNT STATUS
                                    ====================================== --}}
                                    <div>

                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Account Status
                                        </label>

                                        <div class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm">

                                            @if (auth()->user()->status)
                                                <span class="inline-flex items-center gap-2 text-green-600 font-medium">

                                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>

                                                    Active

                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-2 text-red-600 font-medium">

                                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>

                                                    Inactive

                                                </span>
                                            @endif

                                        </div>

                                    </div>

                                </div>


                                {{-- =========================================
                                     IMAGE INFORMATION
                                ========================================== --}}
                                <div class="mt-5 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3">

                                    <div class="flex items-start gap-3">

                                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-[#2563EB] flex-shrink-0">
                                            📷
                                        </div>

                                        <div>

                                            <p class="text-sm font-semibold text-blue-900">
                                                Profile Picture
                                            </p>

                                            <p class="text-xs text-blue-700 mt-1">
                                                JPG, JPEG, PNG or WEBP. Maximum size 2MB.
                                            </p>

                                        </div>

                                    </div>

                                </div>


                                {{-- =========================================
                                     SAVE BUTTON
                                ========================================== --}}
                                <div class="flex justify-end mt-6 pt-5 border-t border-gray-100">

                                    <button type="submit"
                                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-sm font-semibold shadow-md hover:shadow-lg transition">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />

                                        </svg>

                                        Save Changes

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>


                    {{-- =================================================
                         SAVED ADDRESSES
                    ================================================== --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-6">


                        {{-- =============================================
                             ADDRESS HEADER
                        ============================================== --}}
                        <div class="flex items-center justify-between gap-4 px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-white to-blue-50/40">

                            <div>

                                <h2 class="text-lg font-bold text-[#111827]">
                                    Saved Addresses
                                </h2>

                                <p class="text-sm text-gray-500 mt-1">
                                    Manage your delivery addresses.
                                </p>

                            </div>


                            {{-- Add Address --}}
                            <a href="{{ route('checkout.address.create') }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-sm font-semibold shadow-sm hover:shadow-md transition whitespace-nowrap">

                                <span class="text-base">
                                    +
                                </span>

                                Add Address

                            </a>

                        </div>


                        {{-- =============================================
                             ADDRESS CONTENT
                        ============================================== --}}
                        <div class="p-6">

                            @php
                                $addresses = auth()->user()->addresses ?? collect();
                            @endphp


                            @forelse($addresses as $address)
                                {{-- =====================================
                                     ADDRESS CARD
                                ====================================== --}}
                                <div class="{{ $loop->first ? '' : 'mt-4' }} group border border-gray-200 rounded-2xl p-5 bg-white hover:border-blue-300 hover:shadow-md transition-all duration-200">


                                    {{-- =================================
                                         TOP SECTION
                                    ================================== --}}
                                    <div class="flex items-start justify-between gap-4">


                                        {{-- User / Address Name --}}
                                        <div class="flex items-start gap-3">

                                            {{-- Location Icon --}}
                                            <div class="w-11 h-11 flex-shrink-0 rounded-xl bg-blue-50 flex items-center justify-center text-[#2563EB]">

                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">

                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z" />

                                                    <circle cx="12" cy="11" r="2.5" />

                                                </svg>

                                            </div>


                                            <div>

                                                <h3 class="font-semibold text-[#111827] text-base">
                                                    {{ $address->full_name }}
                                                </h3>

                                                <p class="text-sm text-gray-500 mt-1">
                                                    📞 {{ $address->phone }}
                                                </p>

                                            </div>

                                        </div>


                                        {{-- =================================
                                             RIGHT SIDE
                                        ================================== --}}
                                        <div class="flex items-center gap-2 flex-wrap justify-end">


                                            {{-- Default Badge --}}
                                            @if ($address->is_default)
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-[#2563EB] border border-blue-100">
                                                    Default
                                                </span>
                                            @endif


                                            {{-- Edit Button --}}
                                            <a href="{{ route('checkout.address.edit', $address->id) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-[#2563EB] bg-blue-50 hover:bg-blue-100 transition">

                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">

                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />

                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />

                                                </svg>

                                                Edit

                                            </a>

                                        </div>

                                    </div>


                                    {{-- Divider --}}
                                    <div class="border-t border-gray-100 my-4"></div>


                                    {{-- =================================
                                         ADDRESS DETAILS
                                    ================================== --}}
                                    <div class="flex items-start gap-3">


                                        {{-- Address Icon --}}
                                        <div class="mt-0.5 w-8 h-8 flex-shrink-0 rounded-lg bg-gray-100 flex items-center justify-center">

                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">

                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M17.657 16.657L13.414 21a2 2 0 01-2.828 0l-4.243-4.343a8 8 0 1111.314 0z" />

                                                <circle cx="12" cy="11" r="3" />

                                            </svg>

                                        </div>


                                        <div class="min-w-0">

                                            {{-- Main Address --}}
                                            <p class="text-sm font-medium text-gray-700 leading-6">
                                                {{ $address->address }}
                                            </p>


                                            {{-- Location --}}
                                            <p class="text-sm text-gray-500 leading-6">

                                                {{ $address->city }},
                                                {{ $address->district }},
                                                {{ $address->province }}

                                                @if ($address->postal_code)
                                                    - {{ $address->postal_code }}
                                                @endif

                                            </p>

                                        </div>

                                    </div>

                                </div>


                            @empty


                                {{-- =====================================
                                     EMPTY ADDRESS
                                ====================================== --}}
                                <div class="text-center py-12">


                                    {{-- Icon --}}
                                    <div class="w-16 h-16 mx-auto rounded-2xl bg-blue-50 flex items-center justify-center">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#2563EB]"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">

                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z" />

                                            <circle cx="12" cy="11" r="2.5" />

                                        </svg>

                                    </div>


                                    {{-- Title --}}
                                    <h3 class="font-bold text-lg text-[#111827] mt-5">
                                        No Saved Addresses
                                    </h3>


                                    {{-- Description --}}
                                    <p class="text-sm text-gray-500 mt-2 max-w-sm mx-auto">
                                        Add your delivery address to make checkout
                                        faster and easier.
                                    </p>


                                    {{-- Add Address --}}
                                    <a href="{{ route('checkout.address.create') }}"
                                        class="inline-flex items-center gap-2 mt-5 px-5 py-3 rounded-xl bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-sm font-semibold shadow-sm hover:shadow-md transition">

                                        <span class="text-lg">
                                            +
                                        </span>

                                        Add New Address

                                    </a>

                                </div>
                            @endforelse

                        </div>

                    </div>

                </main>

            </div>

        </div>

    </div>

</x-frontend-layout>
