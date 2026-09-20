<x-frontend-layout>

    <div class="min-h-screen bg-gray-100 py-8">

        <div class="Container mx-auto px-4 ">

            <div class="flex gap-6">

                {{-- Sidebar --}}
                <x-user-dashboard.sidebar />

                {{-- Main Content --}}
                <main class="flex-1 min-w-0">

                    {{-- Page Header --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

                        <div class="flex items-center justify-between gap-4">

                            <div class="flex items-center gap-4">

                                {{-- Icon --}}
                                <div class="w-12 h-12 rounded-xl bg-green-50
                                            flex items-center justify-center">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor"
                                         class="w-6 h-6 text-green-600">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M19.5 10.5c0 7.142-7.5 10.5-7.5 10.5S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>

                                    </svg>

                                </div>


                                <div>

                                    <h1 class="text-2xl font-bold text-[#111827]">
                                        My Addresses
                                    </h1>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Manage your delivery addresses.
                                    </p>

                                </div>

                            </div>


                            {{-- Address Count --}}
                            @if(isset($addresses) && $addresses->count() > 0)

                                <div class="hidden sm:flex items-center gap-2
                                            bg-green-50 text-green-700
                                            px-4 py-2 rounded-xl
                                            text-sm font-semibold">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor"
                                         class="w-5 h-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M19.5 10.5c0 7.142-7.5 10.5-7.5 10.5S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>

                                    </svg>

                                    {{ $addresses->count() }}
                                    {{ $addresses->count() == 1 ? 'Address' : 'Addresses' }}

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- Address Content --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">


                        {{-- Top Action --}}
                        <div class="flex flex-col sm:flex-row
                                    sm:items-center
                                    sm:justify-between
                                    gap-4 mb-6">

                            <div>

                                <h2 class="text-lg font-bold text-[#111827]">
                                    Saved Addresses
                                </h2>

                                <p class="text-sm text-gray-500 mt-1">
                                    Choose an address during checkout.
                                </p>

                            </div>


                            {{-- Add Address --}}
                            <a
                                href="{{ route('checkout.address.create', ['from' => 'addresses']) }}"
                                class="inline-flex items-center justify-center
                                       gap-2
                                       px-5 py-3
                                       bg-[#2563EB]
                                       hover:bg-blue-700
                                       text-white
                                       rounded-xl
                                       font-semibold
                                       transition
                                       shadow-sm
                                       hover:shadow-md"
                            >

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="2"
                                     stroke="currentColor"
                                     class="w-5 h-5">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 4.5v15m7.5-7.5h-15"/>

                                </svg>

                                Add New Address

                            </a>

                        </div>


                        {{-- Success Message --}}
                        @if(session('success'))

                            <div class="mb-6 flex items-center gap-3
                                        rounded-xl border border-green-200
                                        bg-green-50 px-4 py-3
                                        text-green-700">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor"
                                     class="w-5 h-5 flex-shrink-0">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="m4.5 12.75 6 6 9-13.5"/>

                                </svg>

                                <p class="text-sm font-medium">
                                    {{ session('success') }}
                                </p>

                            </div>

                        @endif


                        {{-- Error Message --}}
                        @if(session('error'))

                            <div class="mb-6 rounded-xl border border-red-200
                                        bg-red-50 px-4 py-3 text-red-700">

                                <p class="text-sm font-medium">
                                    {{ session('error') }}
                                </p>

                            </div>

                        @endif


                        {{-- ============================= --}}
                        {{-- SAVED ADDRESSES --}}
                        {{-- ============================= --}}

                        @if(isset($addresses) && $addresses->count() > 0)

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                @foreach($addresses as $address)

                                    <div class="relative rounded-2xl
                                                border border-gray-200
                                                p-5
                                                hover:border-blue-200
                                                hover:shadow-md
                                                transition duration-300">


                                        {{-- Default Badge --}}
                                        @if($address->is_default)

                                            <div class="absolute top-4 right-4">

                                                <span class="inline-flex items-center gap-1.5
                                                             px-3 py-1.5
                                                             rounded-lg
                                                             bg-green-50
                                                             text-green-700
                                                             text-xs
                                                             font-bold">

                                                    <span class="w-1.5 h-1.5
                                                                 rounded-full
                                                                 bg-green-500"></span>

                                                    Default

                                                </span>

                                            </div>

                                        @endif


                                        {{-- Address Header --}}
                                        <div class="flex items-start gap-3 pr-20">

                                            <div class="w-11 h-11
                                                        rounded-xl
                                                        bg-blue-50
                                                        flex items-center justify-center
                                                        flex-shrink-0">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke-width="1.8"
                                                     stroke="currentColor"
                                                     class="w-5 h-5 text-[#2563EB]">

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="M19.5 10.5c0 7.142-7.5 10.5-7.5 10.5S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>

                                                </svg>

                                            </div>


                                            <div class="min-w-0">

                                                <h3 class="font-bold text-[#111827] text-lg">

                                                    {{ $address->full_name
                                                        ?? $address->name
                                                        ?? 'Customer' }}

                                                </h3>

                                                @if($address->phone)

                                                    <p class="text-sm text-gray-500 mt-1">
                                                        {{ $address->phone }}
                                                    </p>

                                                @endif

                                            </div>

                                        </div>


                                        {{-- Address Details --}}
                                        <div class="mt-5 space-y-2.5">


                                            {{-- Full Address --}}
                                            <div class="flex items-start gap-3">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke-width="1.6"
                                                     stroke="currentColor"
                                                     class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5">

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="M19.5 10.5c0 7.142-7.5 10.5-7.5 10.5S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>

                                                </svg>

                                                <p class="text-sm text-gray-600 leading-6">

                                                    {{ $address->address }}

                                                </p>

                                            </div>


                                            {{-- City / District --}}
                                            @if($address->city || $address->district)

                                                <div class="flex items-center gap-3">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke-width="1.6"
                                                         stroke="currentColor"
                                                         class="w-5 h-5 text-gray-400 flex-shrink-0">

                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="M3.75 21h16.5M4.5 18h15M6 18V7.5a1.5 1.5 0 0 1 1.5-1.5h9A1.5 1.5 0 0 1 18 7.5V18M8.25 9.75h1.5m-1.5 3h1.5m4.5-3h1.5m-1.5 3h1.5M9 21v-3h6v3"/>

                                                    </svg>

                                                    <p class="text-sm text-gray-600">

                                                        {{ $address->city }}

                                                        @if($address->city && $address->district)
                                                            ,
                                                        @endif

                                                        {{ $address->district }}

                                                    </p>

                                                </div>

                                            @endif


                                            {{-- Province --}}
                                            @if($address->province)

                                                <div class="flex items-center gap-3">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke-width="1.6"
                                                         stroke="currentColor"
                                                         class="w-5 h-5 text-gray-400 flex-shrink-0">

                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0c2.485-2.25 3.75-5.25 3.75-9S14.485 5.25 12 3m0 18c-2.485-2.25-3.75-5.25-3.75-9S9.515 5.25 12 3m-8.25 9h16.5"/>

                                                    </svg>

                                                    <p class="text-sm text-gray-600">
                                                        {{ $address->province }}
                                                    </p>

                                                </div>

                                            @endif


                                            {{-- Postal Code --}}
                                            @if($address->postal_code)

                                                <div class="flex items-center gap-3">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke-width="1.6"
                                                         stroke="currentColor"
                                                         class="w-5 h-5 text-gray-400 flex-shrink-0">

                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25H4.5a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0l-7.5-4.615a2.25 2.25 0 0 1-1.07-1.916V6.75"/>

                                                    </svg>

                                                    <p class="text-sm text-gray-600">

                                                        Postal Code:
                                                        <span class="font-medium text-gray-700">
                                                            {{ $address->postal_code }}
                                                        </span>

                                                    </p>

                                                </div>

                                            @endif

                                        </div>


                                        {{-- Divider --}}
                                        <div class="border-t border-gray-100 my-5"></div>


                                        {{-- Actions --}}
                                        <div class="flex items-center gap-3">


                                            {{-- Edit --}}
                                            <a
                                                href="{{ route('checkout.address.edit', $address->id) }}"
                                                class="flex-1 inline-flex items-center
                                                       justify-center gap-2
                                                       px-4 py-2.5
                                                       rounded-xl
                                                       border border-gray-200
                                                       text-gray-700
                                                       font-semibold
                                                       text-sm
                                                       hover:bg-gray-50
                                                       transition"
                                            >

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke-width="1.8"
                                                     stroke="currentColor"
                                                     class="w-4 h-4">

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13L6 17l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="M19.5 7.5 16.5 4.5"/>

                                                </svg>

                                                Edit

                                            </a>


                                            {{-- Delete --}}
                                            <form
                                                action="{{ route('checkout.address.delete', $address->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this address?');"
                                                class="flex-1"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="w-full inline-flex items-center
                                                           justify-center gap-2
                                                           px-4 py-2.5
                                                           rounded-xl
                                                           border border-red-200
                                                           text-red-500
                                                           font-semibold
                                                           text-sm
                                                           hover:bg-red-50
                                                           transition"
                                                >

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke-width="1.8"
                                                         stroke="currentColor"
                                                         class="w-4 h-4">

                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M4.772 5.79c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.132 0a48.11 48.11 0 0 0-3.478-.397m7.132 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0C7.91 2.613 7 3.597 7 4.777v.916"/>

                                                    </svg>

                                                    Delete

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                @endforeach

                            </div>


                        @else

                            {{-- ============================= --}}
                            {{-- EMPTY STATE --}}
                            {{-- ============================= --}}

                            <div class="text-center py-16">

                                <div class="w-24 h-24 mx-auto
                                            rounded-full bg-gray-100
                                            flex items-center justify-center mb-6">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="w-12 h-12 text-gray-400">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M19.5 10.5c0 7.142-7.5 10.5-7.5 10.5S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>

                                    </svg>

                                </div>


                                <h2 class="text-2xl font-bold text-[#111827]">
                                    No Addresses Added
                                </h2>


                                <p class="text-gray-500 mt-2 max-w-md mx-auto">
                                    Add a delivery address to make checkout
                                    faster and easier.
                                </p>


                                <a
                                    href="{{ route('checkout.address.create') }}"
                                    class="inline-flex items-center
                                           justify-center gap-2
                                           mt-7
                                           px-7 py-3.5
                                           rounded-xl
                                           bg-[#2563EB]
                                           hover:bg-blue-700
                                           text-white
                                           font-semibold
                                           shadow-sm
                                           transition"
                                >

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor"
                                         class="w-5 h-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 4.5v15m7.5-7.5h-15"/>

                                    </svg>

                                    Add Your First Address

                                </a>

                            </div>

                        @endif

                    </div>

                </main>

            </div>

        </div>

    </div>

</x-frontend-layout>
