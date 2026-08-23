<div class="bg-white rounded-2xl shadow-sm border border-gray-100">

    {{-- Header --}}
    <div class="flex items-center justify-between px-5 py-5 border-b border-gray-100">

        <div>
            <h2 class="text-lg font-bold text-[#111827]">
                Saved Addresses
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Your saved delivery addresses
            </p>
        </div>

        <a
            href="{{ route('checkout.address.create') }}"
            class="text-sm font-semibold text-[#2563EB] hover:text-blue-700 transition"
        >
            + Add New
        </a>

    </div>


    {{-- Addresses --}}
    <div class="p-5">

        @forelse($addresses as $address)

            <div
                class="border border-gray-200 rounded-xl p-4
                       {{ $loop->first ? '' : 'mt-4' }}
                       hover:border-[#2563EB] transition"
            >

                {{-- Name + Default --}}
                <div class="flex items-start justify-between gap-3">

                    <div>
                        <h3 class="font-semibold text-[#111827]">
                            {{ $address->full_name }}
                        </h3>

                        <p class="text-sm text-gray-600 mt-1">
                            {{ $address->phone }}
                        </p>
                    </div>

                    @if($address->is_default)
                        <span
                            class="px-2.5 py-1 rounded-full
                                   text-xs font-medium
                                   bg-blue-50 text-[#2563EB]"
                        >
                            Default
                        </span>
                    @endif

                </div>


                {{-- Address --}}
                <div class="mt-3">

                    <p class="text-sm text-gray-500 leading-6">

                        {{ $address->address }},
                        {{ $address->city }},
                        {{ $address->district }},
                        {{ $address->province }}

                        @if($address->postal_code)
                            - {{ $address->postal_code }}
                        @endif

                    </p>

                </div>

            </div>

        @empty

            {{-- Empty State --}}
            <div class="text-center py-8">

                <div
                    class="w-12 h-12 mx-auto rounded-full
                           bg-blue-50 flex items-center justify-center"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 text-[#2563EB]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z"
                        />
                        <circle
                            cx="12"
                            cy="11"
                            r="2.5"
                        />
                    </svg>
                </div>

                <h3 class="font-semibold text-[#111827] mt-4">
                    No saved addresses
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Add an address to make checkout faster.
                </p>

                <a
                    href="{{ route('checkout.address.create') }}"
                    class="inline-flex items-center mt-4
                           px-4 py-2.5 rounded-xl
                           bg-[#2563EB] hover:bg-blue-700
                           text-white text-sm font-semibold
                           transition"
                >
                    Add New Address
                </a>

            </div>

        @endforelse

    </div>

</div>
