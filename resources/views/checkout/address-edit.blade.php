<x-frontend-layout>

    <div class="min-h-screen bg-gray-100 py-6 sm:py-8">

        <div class="container mx-auto px-4 max-w-4xl">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">

                {{-- Header --}}
                <div class="mb-6">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                        Edit Address
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Update your delivery address details.
                    </p>
                </div>

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">
                        <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Edit Form --}}
                <form
                    action="{{ route('checkout.address.update', $address->id) }}"
                    method="POST"
                    class="space-y-5 sm:space-y-6"
                >

                    @csrf
                    @method('PUT')

                    {{-- Full Name --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="full_name"
                            value="{{ old('full_name', $address->full_name) }}"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-2.5 sm:py-3
                                   focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                            placeholder="Enter full name"
                        >
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Phone Number
                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone', $address->phone) }}"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-2.5 sm:py-3
                                   focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                            placeholder="Enter phone number"
                        >
                    </div>

                    {{-- Province + District --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Province
                            </label>

                            <input
                                type="text"
                                name="province"
                                value="{{ old('province', $address->province) }}"
                                required
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 sm:py-3
                                       focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                placeholder="Enter province"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                District
                            </label>

                            <input
                                type="text"
                                name="district"
                                value="{{ old('district', $address->district) }}"
                                required
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 sm:py-3
                                       focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                placeholder="Enter district"
                            >
                        </div>

                    </div>

                    {{-- City + Postal Code --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                City
                            </label>

                            <input
                                type="text"
                                name="city"
                                value="{{ old('city', $address->city) }}"
                                required
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 sm:py-3
                                       focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                placeholder="Enter city"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Postal Code
                            </label>

                            <input
                                type="text"
                                name="postal_code"
                                value="{{ old('postal_code', $address->postal_code) }}"
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 sm:py-3
                                       focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                placeholder="Enter postal code"
                            >
                        </div>

                    </div>

                    {{-- Address --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Full Address
                        </label>

                        <textarea
                            name="address"
                            rows="4"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-2.5 sm:py-3
                                   focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                            placeholder="Enter complete address"
                        >{{ old('address', $address->address) }}</textarea>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">

                        <a
                            href="{{ route('checkout.addresses') }}"
                            class="flex-1 inline-flex items-center justify-center
                                   px-5 py-2.5 sm:py-3 rounded-xl
                                   border border-gray-300
                                   text-gray-700 font-semibold text-sm sm:text-base
                                   hover:bg-gray-50 transition"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="flex-1 inline-flex items-center justify-center
                                   px-5 py-2.5 sm:py-3 rounded-xl
                                   bg-blue-600 hover:bg-blue-700
                                   text-white font-semibold text-sm sm:text-base
                                   transition shadow-sm"
                        >
                            Update Address
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-frontend-layout>
