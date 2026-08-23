<x-frontend-layout>

    <div class="bg-gray-100 min-h-screen py-10">

        <div class="max-w-4xl mx-auto px-6">

            {{-- Header --}}
            <div class="mb-8">

                <h1 class="text-3xl font-bold text-[#111827]">
                    Add New Address
                </h1>

                <p class="text-gray-500 mt-2">
                    Enter your delivery information.
                </p>

            </div>


            {{-- Form --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <form
                    action="{{ route('checkout.address.store') }}"
                    method="POST">

                    @csrf


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Full Name --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="full_name"
                                value="{{ old('full_name') }}"
                                required
                                class="w-full rounded-xl border border-gray-300
                                       px-4 py-3 focus:ring-2
                                       focus:ring-[#2563EB]
                                       focus:border-[#2563EB]">

                            @error('full_name')
                                <p class="text-sm text-red-500 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
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
                                required
                                class="w-full rounded-xl border border-gray-300
                                       px-4 py-3 focus:ring-2
                                       focus:ring-[#2563EB]
                                       focus:border-[#2563EB]">

                            @error('phone')
                                <p class="text-sm text-red-500 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Province --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Province
                            </label>

                            <input
                                type="text"
                                name="province"
                                value="{{ old('province') }}"
                                required
                                class="w-full rounded-xl border border-gray-300
                                       px-4 py-3 focus:ring-2
                                       focus:ring-[#2563EB]
                                       focus:border-[#2563EB]">

                            @error('province')
                                <p class="text-sm text-red-500 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- District --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                District
                            </label>

                            <input
                                type="text"
                                name="district"
                                value="{{ old('district') }}"
                                required
                                class="w-full rounded-xl border border-gray-300
                                       px-4 py-3 focus:ring-2
                                       focus:ring-[#2563EB]
                                       focus:border-[#2563EB]">

                            @error('district')
                                <p class="text-sm text-red-500 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- City --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                City</label>

                            <input
                                type="text"
                                name="city"
                                value="{{ old('city') }}"
                                required
                                class="w-full rounded-xl border border-gray-300
                                       px-4 py-3 focus:ring-2
                                       focus:ring-[#2563EB]
                                       focus:border-[#2563EB]">

                            @error('city')
                                <p class="text-sm text-red-500 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Postal Code --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Postal Code
                            </label>

                            <input
                                type="text"
                                name="postal_code"
                                value="{{ old('postal_code') }}"
                                class="w-full rounded-xl border border-gray-300
                                       px-4 py-3 focus:ring-2
                                       focus:ring-[#2563EB]
                                       focus:border-[#2563EB]">

                            @error('postal_code')
                                <p class="text-sm text-red-500 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Address --}}
                        <div class="md:col-span-2">

                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Complete Address
                            </label>

                            <textarea
                                name="address"
                                rows="4"
                                required
                                class="w-full rounded-xl border border-gray-300
                                       px-4 py-3 focus:ring-2
                                       focus:ring-[#2563EB]
                                       focus:border-[#2563EB]">{{ old('address') }}</textarea>

                            @error('address')
                                <p class="text-sm text-red-500 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 mt-8">

                        <a
                            href="{{ route('checkout') }}"
                            class="px-6 py-3 rounded-xl bg-gray-100
                                   hover:bg-gray-200 text-gray-700
                                   font-semibold transition">

                            Cancel

                        </a>


                        <button
                            type="submit"
                            class="px-6 py-3 rounded-xl
                                   bg-[#2563EB] hover:bg-blue-700
                                   text-white font-semibold transition">

                            Save Address

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-frontend-layout>
