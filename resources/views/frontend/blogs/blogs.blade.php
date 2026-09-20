<x-frontend-layout
title="Tech blogs | TechNova Nepal"
    description="Guides and news on laptops, gadgets and accessories from TechNova Nepal."
    :canonical="route('blogs.index')">

    <div class="bg-[#ebf4fa] min-h-screen">

        <div class="Container mx-auto px-4 sm:px-5 pb-6">

            {{-- =====================================================
                BREADCRUMB
            ====================================================== --}}
            <section>
                <nav class="text-xs sm:text-sm md:text-base py-3 md:py-5">

                    <a href="{{ route('home') }}"
                        class="text-gray-700 hover:text-blue-700 transition">
                        Home
                    </a>

                    <span class="text-blue-200 mx-1.5 sm:mx-2">
                        /
                    </span>

                    <span class="text-gray-500">
                        Blogs
                    </span>

                </nav>
            </section>


            {{-- =====================================================
                BLOG PAGE HEADER
            ====================================================== --}}
            <section class="mb-6 sm:mb-8">

                <div class="max-w-3xl mx-auto text-center">

                    <h1 class="text-2xl
                               sm:text-3xl
                               md:text-4xl
                               font-bold
                               text-gray-900">

                        Blogs & Articles

                    </h1>

                    <p class="mt-2
                              text-xs
                              sm:text-sm
                              md:text-base
                              text-gray-600
                              px-2">

                        Discover the latest technology news, tips,
                        guides and useful information.

                    </p>

                </div>

            </section>


            {{-- =====================================================
                BLOG CARDS
                16 CARDS PER PAGE
                DESKTOP = EXACTLY 4 CARDS PER ROW
            ====================================================== --}}

            @if ($blogs->count())

                <div class="grid
                            grid-cols-1
                            sm:grid-cols-2
                            lg:grid-cols-4
                            gap-4
                            sm:gap-5
                            lg:gap-6
                            pb-8">

                    @foreach ($blogs as $blog)

                        <article
                            class="bg-white
                                   rounded-xl
                                   overflow-hidden
                                   border
                                   border-gray-100
                                   shadow-sm
                                   hover:shadow-lg
                                   transition-all
                                   duration-300
                                   flex
                                   flex-col
                                   h-full
                                   group">


                            {{-- =========================================
                                BLOG IMAGE
                            ========================================== --}}
                            <a href="{{ route('blogs.view', $blog->slug) }}"
                                class="block">

                                <div class="h-40
                                            sm:h-44
                                            lg:h-40
                                            overflow-hidden
                                            bg-gray-100">

                                    <img src="{{ $blog->featured_image
                                        ? asset('storage/' . $blog->featured_image)
                                        : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=900&q=80' }}"
                                        alt="{{ $blog->title }}"
                                        loading="lazy"
                                        class="w-full
                                               h-full
                                               object-cover
                                               group-hover:scale-105
                                               transition-transform
                                               duration-500">

                                </div>

                            </a>


                            {{-- =========================================
                                CARD CONTENT
                            ========================================== --}}
                            <div class="p-4
                                        flex
                                        flex-col
                                        flex-1">


                                {{-- Category --}}
                                <div class="mb-2">

                                    <span class="text-[11px]
                                                 sm:text-xs
                                                 font-semibold
                                                 text-blue-600
                                                 uppercase
                                                 tracking-wide
                                                 line-clamp-1">

                                        {{ $blog->category->name ?? 'Blog' }}

                                    </span>

                                </div>


                                {{-- =====================================
                                    TITLE
                                ====================================== --}}
                                <h2 class="text-sm
                                           sm:text-base
                                           font-bold
                                           text-gray-900
                                           leading-5
                                           mb-2
                                           line-clamp-2
                                           group-hover:text-blue-600
                                           transition">

                                    {{ $blog->title }}

                                </h2>


                                {{-- =====================================
                                    EXCERPT
                                ====================================== --}}
                                @if ($blog->excerpt)

                                    <p class="text-xs
                                              sm:text-sm
                                              text-gray-600
                                              leading-5
                                              line-clamp-3
                                              mb-4
                                              flex-1">

                                        {{ $blog->excerpt }}

                                    </p>

                                @else

                                    <div class="flex-1"></div>

                                @endif


                                {{-- =====================================
                                    DATE + READ MORE
                                ====================================== --}}
                                <div class="flex
                                            items-center
                                            justify-between
                                            gap-2
                                            pt-3
                                            border-t
                                            border-gray-100">


                                    {{-- Date --}}
                                    <span class="text-[10px]
                                                 sm:text-[11px]
                                                 text-gray-500
                                                 whitespace-nowrap">

                                        <i class="fa-regular fa-calendar mr-1"></i>

                                        {{ $blog->published_at
                                            ? $blog->published_at->format('d M Y')
                                            : $blog->created_at->format('d M Y') }}

                                    </span>


                                    {{-- Read More --}}
                                    <a href="{{ route('blogs.view', $blog->slug) }}"
                                        class="text-xs
                                               font-semibold
                                               text-blue-600
                                               hover:text-blue-800
                                               inline-flex
                                               items-center
                                               whitespace-nowrap
                                               transition">

                                        Read More

                                        <span class="ml-1">
                                            →
                                        </span>

                                    </a>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- =====================================================
                    PAGINATION
                ====================================================== --}}
                @if ($blogs->hasPages())

                    <div class="flex
                                justify-center
                                items-center
                                pt-2
                                pb-8">

                        <div class="flex
                                    items-center
                                    gap-1
                                    bg-white
                                    border
                                    border-gray-200
                                    rounded-xl
                                    shadow-sm
                                    p-1.5">

                            {{-- Previous --}}
                            @if ($blogs->onFirstPage())

                                <span class="px-3
                                             py-2
                                             text-xs
                                             sm:text-sm
                                             text-gray-300
                                             cursor-not-allowed">

                                    ← Previous

                                </span>

                            @else

                                <a href="{{ $blogs->previousPageUrl() }}"
                                    class="px-3
                                           py-2
                                           text-xs
                                           sm:text-sm
                                           text-gray-600
                                           hover:bg-blue-50
                                           hover:text-blue-600
                                           rounded-lg
                                           transition">

                                    ← Previous

                                </a>

                            @endif


                            {{-- Page Numbers --}}
                            @foreach ($blogs->getUrlRange(
                                max(1, $blogs->currentPage() - 2),
                                min($blogs->lastPage(), $blogs->currentPage() + 2)
                            ) as $page => $url)

                                @if ($page == $blogs->currentPage())

                                    <span class="min-w-[34px]
                                                 px-2
                                                 py-2
                                                 text-xs
                                                 sm:text-sm
                                                 text-center
                                                 font-semibold
                                                 bg-blue-600
                                                 text-white
                                                 rounded-lg">

                                        {{ $page }}

                                    </span>

                                @else

                                    <a href="{{ $url }}"
                                        class="min-w-[34px]
                                               px-2
                                               py-2
                                               text-xs
                                               sm:text-sm
                                               text-center
                                               text-gray-600
                                               hover:bg-blue-50
                                               hover:text-blue-600
                                               rounded-lg
                                               transition">

                                        {{ $page }}

                                    </a>

                                @endif

                            @endforeach


                            {{-- Next --}}
                            @if ($blogs->hasMorePages())

                                <a href="{{ $blogs->nextPageUrl() }}"
                                    class="px-3
                                           py-2
                                           text-xs
                                           sm:text-sm
                                           text-gray-600
                                           hover:bg-blue-50
                                           hover:text-blue-600
                                           rounded-lg
                                           transition">

                                    Next →

                                </a>

                            @else

                                <span class="px-3
                                             py-2
                                             text-xs
                                             sm:text-sm
                                             text-gray-300
                                             cursor-not-allowed">

                                    Next →

                                </span>

                            @endif

                        </div>

                    </div>

                @endif


            @else

                {{-- =====================================================
                    NO BLOGS
                ====================================================== --}}
                <div class="bg-white
                            rounded-2xl
                            border
                            border-gray-100
                            p-10
                            text-center
                            mb-8">

                    <div class="text-gray-300 text-4xl mb-3">
                        <i class="fa-regular fa-newspaper"></i>
                    </div>

                    <h2 class="text-lg
                               font-semibold
                               text-gray-800">

                        No blogs available

                    </h2>

                    <p class="text-sm
                              text-gray-500
                              mt-1">

                        Please check back later for new articles.

                    </p>

                </div>

            @endif

        </div>


        {{-- =====================================================
            LIMITED TIME DEAL BANNER
        ====================================================== --}}
        <section class="Container mx-auto px-4 sm:px-5 mt-2 mb-6">

            <div class="relative
                        overflow-hidden
                        rounded-2xl
                        bg-gradient-to-r
                        from-gray-900
                        via-gray-800
                        to-gray-900
                        shadow-lg">


                {{-- Decorative Circle --}}
                <div class="absolute
                            -top-20
                            -right-16
                            w-56
                            h-56
                            rounded-full
                            bg-red-600/20">
                </div>


                <div class="absolute
                            -bottom-24
                            -left-16
                            w-64
                            h-64
                            rounded-full
                            bg-orange-500/10">
                </div>


                {{-- Banner --}}
                <div class="relative
                            px-5
                            py-7
                            sm:px-7
                            sm:py-8
                            md:px-9">

                    <div class="flex
                                flex-col
                                md:flex-row
                                md:items-center
                                md:justify-between
                                gap-6">


                        {{-- Content --}}
                        <div class="max-w-2xl">

                            <div class="inline-flex
                                        items-center
                                        gap-2
                                        bg-red-500/10
                                        border
                                        border-red-400/20
                                        text-red-400
                                        px-3
                                        py-1
                                        rounded-full
                                        text-[10px]
                                        font-bold
                                        uppercase
                                        tracking-wider
                                        mb-3">

                                <i class="fa-solid fa-bolt"></i>

                                More Flash Deals

                            </div>


                            <h2 class="text-xl
                                       sm:text-2xl
                                       md:text-3xl
                                       font-extrabold
                                       text-white
                                       leading-tight">

                                Don't Miss Our

                                <span class="text-red-400">
                                    Limited-Time Offers
                                </span>

                            </h2>


                            <p class="mt-2
                                      text-xs
                                      sm:text-sm
                                      text-gray-400
                                      leading-6
                                      max-w-xl">

                                Explore more limited-time categories and discover
                                exclusive deals available for a short period.

                            </p>

                        </div>


                        {{-- Button --}}
                        <div class="flex-shrink-0">

                            <a href="{{ route('limited-time') }}"
                                class="group
                                       inline-flex
                                       items-center
                                       justify-center
                                       gap-2.5
                                       bg-red-600
                                       hover:bg-red-500
                                       text-white
                                       px-5
                                       py-3
                                       rounded-xl
                                       text-sm
                                       font-bold
                                       shadow-lg
                                       transition-all
                                       duration-300
                                       hover:-translate-y-0.5">

                                <span>
                                    Explore All Deals
                                </span>

                                <span class="w-7
                                             h-7
                                             rounded-lg
                                             bg-white/15
                                             flex
                                             items-center
                                             justify-center
                                             group-hover:translate-x-1
                                             transition-transform">

                                    <i class="fa-solid fa-arrow-right text-xs"></i>

                                </span>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

</x-frontend-layout>
