<x-frontend-layout>

    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">

        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

            <h1 class="text-3xl font-bold text-center text-[#111827]">
                Welcome Back
            </h1>

            <p class="text-center text-gray-500 mt-2 mb-8">
                Login to your TechNova Nepal account
            </p>

            @if ($errors->any())
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 p-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-red-600">
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">

                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="Enter your email"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200
                               focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100
                               outline-none transition"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        placeholder="Enter your password"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200
                               focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100
                               outline-none transition"
                    >
                </div>

                <div class="flex items-center gap-2">

                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="rounded border-gray-300 text-[#2563EB] focus:ring-[#2563EB]"
                    >

                    <label class="text-sm text-gray-600">
                        Remember me
                    </label>

                </div>

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-[#2563EB]
                           hover:bg-[#1D4ED8] text-white font-semibold
                           transition duration-200">
                    Login
                </button>

            </form>

            <div class="mt-6 pt-6 border-t border-gray-100 text-center">

                <p class="text-sm text-gray-500">
                    Don't have an account?

                    <a
                        href="{{ route('register') }}"
                        class="text-[#2563EB] font-semibold hover:underline">
                        Create Account
                    </a>
                </p>

            </div>

        </div>

    </div>

</x-frontend-layout>
