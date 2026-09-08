<div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

    {{-- =====================================================
         HEADER
    ====================================================== --}}
    <div class="flex items-center justify-between gap-4
                px-6 py-5
                border-b border-gray-100
                bg-gradient-to-r from-white to-blue-50/40">

        <div>
            <h2 class="text-lg font-bold text-[#111827]">
                Saved Addresses
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Your saved delivery addresses
            </p>
        </div>

        <a href="{{ route('checkout.address.create') }}"
            class="inline-flex items-center gap-1.5
                   px-4 py-2.5
                   rounded-xl
                   bg-[#2563EB]
                   hover:bg-[#1D4ED8]
                   text-white
                   text-sm
                   font-semibold
                   shadow-sm
                   hover:shadow-md
                   transition-all duration-200
                   whitespace-nowrap">

            <span class="text-base">+</span>
            <span>Add New</span>

        </a>

    </div>


    {{-- =====================================================
         ADDRESSES
    ====================================================== --}}
    <div class="p-6">

        @forelse($addresses as $address)

            <div class="
                {{ $loop->first ? '' : 'mt-4' }}
                group
                border border-gray-200
                rounded-2xl
                p-5
                bg-white
                hover:border-blue-300
                hover:shadow-md
                transition-all duration-200
            ">

                {{-- Top Section --}}
                <div class="flex items-start justify-between gap-4">

                    {{-- User Information --}}
                    <div class="flex items-start gap-3">

                        {{-- Location Icon --}}
                        <div class="
                            w-11 h-11
                            flex-shrink-0
                            rounded-xl
                            bg-blue-50
                            flex items-center justify-center
                            text-[#2563EB]
                        ">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z" />

                                <circle
                                    cx="12"
                                    cy="11"
                                    r="2.5" />

                            </svg>

                        </div>


                        {{-- Name + Phone --}}
                        <div>

                            <h3 class="
                                font-semibold
                                text-[#111827]
                                text-base
                            ">
                                {{ $address->full_name }}
                            </h3>

                            <p class="
                                text-sm
                                text-gray-500
                                mt-1
                            ">
                                📞 {{ $address->phone }}
                            </p>

                        </div>

                    </div>


                    {{-- Default Badge --}}
                    @if($address->is_default)

                        <span class="
                            flex-shrink-0
                            px-3 py-1
                            rounded-full
                            text-xs
                            font-semibold
                            bg-blue-50
                            text-[#2563EB]
                            border border-blue-100
                        ">
                            Default
                        </span>

                    @endif

                </div>


                {{-- Divider --}}
                <div class="border-t border-gray-100 my-4"></div>


                {{-- Address Details --}}
                <div class="flex items-start gap-3">

                    <div class="
                        mt-0.5
                        w-8 h-8
                        flex-shrink-0
                        rounded-lg
                        bg-gray-100
                        flex items-center justify-center
                    ">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 text-gray-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M17.657 16.657L13.414 21a2 2 0 01-2.828 0l-4.243-4.343a8 8 0 1111.314 0z" />

                            <circle
                                cx="12"
                                cy="11"
                                r="3" />

                        </svg>

                    </div>


                    <div>

                        <p class="
                            text-sm
                            font-medium
                            text-gray-700
                            leading-6
                        ">

                            {{ $address->address }}

                        </p>

                        <p class="
                            text-sm
                            text-gray-500
                            leading-6
                        ">

                            {{ $address->city }},
                            {{ $address->district }},
                            {{ $address->province }}

                            @if($address->postal_code)
                                - {{ $address->postal_code }}
                            @endif

                        </p>

                    </div>

                </div>

            </div>

        @empty

            {{-- =================================================
                 EMPTY STATE
            ================================================== --}}
            <div class="text-center py-12">

                {{-- Icon --}}
                <div class="
                    w-16 h-16
                    mx-auto
                    rounded-2xl
                    bg-blue-50
                    flex items-center justify-center
                ">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-8 h-8 text-[#2563EB]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z" />

                        <circle
                            cx="12"
                            cy="11"
                            r="2.5" />

                    </svg>

                </div>


                {{-- Title --}}
                <h3 class="
                    font-bold
                    text-lg
                    text-[#111827]
                    mt-5
                ">
                    No Saved Addresses
                </h3>


                {{-- Description --}}
                <p class="
                    text-sm
                    text-gray-500
                    mt-2
                    max-w-sm
                    mx-auto
                ">
                    Add your delivery address to make checkout
                    faster and easier.
                </p>


                {{-- Add Address Button --}}
                <a href="{{ route('checkout.address.create') }}"
                    class="
                        inline-flex
                        items-center
                        gap-2
                        mt-5
                        px-5
                        py-3
                        rounded-xl
                        bg-[#2563EB]
                        hover:bg-[#1D4ED8]
                        text-white
                        text-sm
                        font-semibold
                        shadow-sm
                        hover:shadow-md
                        transition-all duration-200
                    ">

                    <span class="text-lg">+</span>

                    <span>
                        Add New Address
                    </span>

                </a>

            </div>

        @endforelse

    </div>

</div>
