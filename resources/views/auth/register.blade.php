<x-frontend-layout>

    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">

        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

            {{-- Heading --}}
            <div class="text-center mb-8">

                <h1 class="text-3xl font-bold text-[#111827]">
                    Create Account
                </h1>

                <p class="text-gray-500 mt-2">
                    Join TechNova Nepal today
                </p>

            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())

                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 p-4">

                    @foreach ($errors->all() as $error)

                        <p class="text-sm text-red-600">
                            {{ $error }}
                        </p>

                    @endforeach

                </div>

            @endif

            {{-- Register Form --}}
            <form
                method="POST"
                action="{{ route('register.submit') }}"
                class="space-y-5">

                @csrf

                {{-- Name --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        placeholder="Enter your full name"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200
                               focus:border-[#2563EB]
                               focus:ring-2 focus:ring-blue-100
                               outline-none transition">

                </div>

                {{-- Email --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="Enter your email"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200
                               focus:border-[#2563EB]
                               focus:ring-2 focus:ring-blue-100
                               outline-none transition">

                </div>

                {{-- Phone --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="98XXXXXXXX"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200
                               focus:border-[#2563EB]
                               focus:ring-2 focus:ring-blue-100
                               outline-none transition">

                </div>

                {{-- Password --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        placeholder="Minimum 8 characters"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200
                               focus:border-[#2563EB]
                               focus:ring-2 focus:ring-blue-100
                               outline-none transition">

                </div>

                {{-- Confirm Password --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        placeholder="Confirm your password"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200
                               focus:border-[#2563EB]
                               focus:ring-2 focus:ring-blue-100
                               outline-none transition">

                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-[#2563EB]
                           hover:bg-[#1D4ED8]
                           text-white font-semibold
                           transition duration-200">

                    Create Account

                </button>

            </form>

            {{-- Login Link --}}
            <div class="mt-6 pt-6 border-t border-gray-100 text-center">

                <p class="text-sm text-gray-500">

                    Already have an account?

                    <a
                        href="{{ route('login') }}"
                        class="text-[#2563EB] font-semibold hover:underline">

                        Login

                    </a>

                </p>

            </div>

        </div>

    </div>

</x-frontend-layout>
