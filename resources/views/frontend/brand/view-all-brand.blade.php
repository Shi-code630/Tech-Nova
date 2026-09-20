<x-frontend-layout>

    {{-- =========================================================
        ALL BRANDS PAGE
    ========================================================== --}}

    <div class="bg-gray-50 min-h-screen py-8">

        <div class="Container mx-auto px-4">

            {{-- =================================================
                BREADCRUMB
            ================================================== --}}
            <div class="mb-5">
                <nav class="flex items-center gap-2 text-xs text-gray-500">
                    <a href="{{ route('home') }}"
                       class="hover:text-blue-600 transition-colors">
                        Home
                    </a>

                    <i class="fa-solid fa-chevron-right text-[8px] text-gray-400"></i>

                    <span class="text-gray-800 font-medium">
                        All Brands
                    </span>
                </nav>
            </div>


            {{-- =================================================
                PAGE HEADER
            ================================================== --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 md:p-6 mb-6">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-900">
                            All Brands
                        </h1>

                        <p class="text-xs md:text-sm text-gray-500 mt-1">
                            Explore products from trusted global brands.
                        </p>
                    </div>

                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="fa-solid fa-tags text-blue-600"></i>

                        <span>
                            {{ $brands->count() }} Brands
                        </span>
                    </div>

                </div>

            </div>


            {{-- =================================================
                BRANDS
            ================================================== --}}
            @if ($brands->count() > 0)

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">

                    @foreach ($brands as $brand)

                        <a href="{{ route('brand.show', $brand->slug) }}"
                           class="group bg-white rounded-2xl border border-gray-200 shadow-sm
                                  hover:shadow-lg hover:border-blue-500
                                  transition-all duration-300
                                  hover:-translate-y-1
                                  min-h-[170px]
                                  flex flex-col items-center justify-center
                                  p-5">

                            {{-- =================================
                                BRAND LOGO / ICON
                            ================================== --}}
                            <div class="w-24 h-24 flex items-center justify-center mb-3">

                                @if ($brand->logo && file_exists(public_path('storage/' . $brand->logo)))

                                    <img src="{{ asset('storage/' . $brand->logo) }}"
                                         alt="{{ $brand->name }}"
                                         class="w-20 h-20 object-contain
                                                group-hover:scale-110
                                                transition-transform duration-300"
                                         loading="lazy">

                                @else

                                    <div class="w-20 h-20 rounded-full
                                                bg-blue-50
                                                border border-blue-100
                                                flex items-center justify-center
                                                text-blue-600
                                                text-2xl
                                                font-bold
                                                group-hover:bg-blue-600
                                                group-hover:text-white
                                                transition-all duration-300">

                                        {{ strtoupper(substr($brand->name, 0, 1)) }}

                                    </div>

                                @endif

                            </div>


                            {{-- =================================
                                BRAND NAME
                            ================================== --}}
                            <h2 class="text-sm font-semibold text-gray-800
                                       text-center line-clamp-1
                                       group-hover:text-blue-600
                                       transition-colors duration-300">

                                {{ $brand->name }}

                            </h2>


                            {{-- =================================
                                VIEW PRODUCTS
                            ================================== --}}
                            <div class="mt-2 flex items-center gap-1
                                        text-[10px] text-gray-400
                                        group-hover:text-blue-600
                                        transition-colors">

                                <span>View Products</span>

                                <i class="fa-solid fa-arrow-right text-[8px]
                                          transition-transform
                                          group-hover:translate-x-1"></i>

                            </div>

                        </a>

                    @endforeach

                </div>

            @else

                {{-- =============================================
                    NO BRANDS
                ============================================== --}}
                <div class="bg-white rounded-2xl border border-gray-200
                            py-16 text-center">

                    <div class="w-16 h-16 mx-auto rounded-full
                                bg-gray-100 flex items-center justify-center mb-4">

                        <i class="fa-solid fa-tags text-2xl text-gray-400"></i>

                    </div>

                    <h2 class="text-lg font-semibold text-gray-800">
                        No Brands Available
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        There are no active brands available at the moment.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-frontend-layout>
