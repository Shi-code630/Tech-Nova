<x-frontend-layout>

    <div class="bg-[#ebf4fa] min-h-screen">

        {{-- =====================================================
            MAIN CONTAINER
        ====================================================== --}}
        <section class="Container mx-auto px-3 sm:px-4 pb-6">

            {{-- =====================================================
                BREADCRUMB
            ====================================================== --}}
            <nav class="text-xs sm:text-sm py-3 sm:py-4
                        overflow-x-auto whitespace-nowrap scrollbar-hide">

                <a href="{{ route('home') }}"
                    class="text-gray-600 hover:text-blue-700 transition">
                    Home
                </a>

                <span class="text-blue-300 mx-1.5 sm:mx-2">/</span>

                <a href="{{ route('blogs.index') }}"
                    class="text-gray-600 hover:text-blue-700 transition">
                    Blogs
                </a>

                <span class="text-blue-300 mx-1.5 sm:mx-2">/</span>

                <span class="text-gray-500">
                    {{ $blog->title }}
                </span>

            </nav>


            {{-- =====================================================
                BLOG AREA
            ====================================================== --}}
            <section>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:gap-6">


                    {{-- =================================================
                        LEFT : BLOG CONTENT
                    ================================================= --}}
                    <article class="lg:col-span-2">

                        <div class="bg-white
                                    border border-gray-100
                                    rounded-xl sm:rounded-2xl
                                    shadow-sm
                                    p-4 sm:p-5 md:p-6">


                            {{-- =========================================
                                CATEGORY / DATE / AUTHOR
                            ========================================== --}}
                            <div class="flex flex-wrap items-center
                                        gap-x-2 gap-y-1
                                        text-xs sm:text-sm
                                        text-gray-500
                                        mb-4">

                                <span class="text-blue-600 font-semibold">
                                    {{ $blog->category->name ?? 'Blog' }}
                                </span>

                                <span class="text-gray-300">•</span>

                                <span>
                                    {{ $blog->published_at
                                        ? $blog->published_at->format('d M Y')
                                        : $blog->created_at->format('d M Y') }}
                                </span>

                                @if ($blog->author)

                                    <span class="text-gray-300">•</span>

                                    <span>
                                        By {{ $blog->author }}
                                    </span>

                                @endif

                            </div>


                            {{-- =========================================
                                FEATURED IMAGE
                            ========================================== --}}
                            @if ($blog->featured_image)

                                <div class="w-full
                                            h-[180px]
                                            sm:h-[230px]
                                            md:h-[300px]
                                            lg:h-[340px]
                                            rounded-xl
                                            overflow-hidden
                                            mb-5">

                                    <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                        alt="{{ $blog->title }}"
                                        loading="lazy"
                                        class="w-full h-full object-cover">

                                </div>

                            @endif


                            {{-- =========================================
                                TITLE
                            ========================================== --}}
                            <h1 class="text-xl
                                       sm:text-2xl
                                       md:text-3xl
                                       font-bold
                                       text-gray-900
                                       leading-tight
                                       mb-4">

                                {{ $blog->title }}

                            </h1>


                            {{-- =========================================
                                EXCERPT
                            ========================================== --}}
                            @if ($blog->excerpt)

                                <div class="text-sm
                                            sm:text-base
                                            text-gray-600
                                            leading-7
                                            mb-5
                                            pb-5
                                            border-b
                                            border-gray-100">

                                    {{ $blog->excerpt }}

                                </div>

                            @endif


                            {{-- =========================================
                                BLOG CONTENT
                            ========================================== --}}
                            <article class="blog-content
                                            text-sm
                                            sm:text-[15px]
                                            md:text-base
                                            text-gray-700
                                            leading-7">

                                {!! $blog->content !!}

                            </article>


                            {{-- =========================================
                                TAGS
                            ========================================== --}}
                            @if ($blog->tags && count($blog->tags) > 0)

                                <div class="mt-7
                                            pt-5
                                            border-t
                                            border-gray-200">

                                    <h3 class="text-sm
                                               sm:text-base
                                               font-semibold
                                               text-gray-900
                                               mb-3">

                                        Tags

                                    </h3>

                                    <div class="flex flex-wrap gap-2">

                                        @foreach ($blog->tags as $tag)

                                            <span class="px-3
                                                         py-1
                                                         bg-gray-100
                                                         hover:bg-blue-50
                                                         text-gray-600
                                                         hover:text-blue-600
                                                         rounded-full
                                                         text-xs
                                                         transition">

                                                #{{ $tag }}

                                            </span>

                                        @endforeach

                                    </div>

                                </div>

                            @endif


                            {{-- =========================================
                                BACK TO BLOGS
                            ========================================== --}}
                            <div class="mt-7">

                                <a href="{{ route('blogs.index') }}"
                                    class="inline-flex
                                           items-center
                                           text-sm
                                           font-semibold
                                           text-blue-600
                                           hover:text-blue-800
                                           transition">

                                    <span class="mr-2">←</span>

                                    Back to Blogs

                                </a>

                            </div>

                        </div>

                    </article>


                    {{-- =================================================
                        RIGHT : POPULAR POSTS
                    ================================================= --}}
                    <aside class="lg:col-span-1">

                        <div class="bg-white
                                    border border-gray-100
                                    rounded-xl sm:rounded-2xl
                                    shadow-sm
                                    p-4
                                    lg:sticky
                                    lg:top-6">


                            {{-- Heading --}}
                            <h2 class="text-base
                                       sm:text-lg
                                       font-bold
                                       text-gray-900
                                       mb-4
                                       pb-3
                                       border-b
                                       border-gray-100">

                                Popular Posts

                            </h2>


                            {{-- Popular Posts --}}
                            @forelse($popularPosts as $popular)

                                <a href="{{ route('blogs.view', $popular->slug) }}"
                                    class="flex gap-3
                                           mb-4
                                           last:mb-0
                                           group">

                                    {{-- Image --}}
                                    <div class="w-[82px]
                                                h-[62px]
                                                sm:w-[90px]
                                                sm:h-[68px]
                                                flex-shrink-0
                                                rounded-lg
                                                overflow-hidden
                                                bg-gray-100">

                                        <img src="{{ $popular->featured_image
                                            ? asset('storage/' . $popular->featured_image)
                                            : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=400&q=80' }}"
                                            alt="{{ $popular->title }}"
                                            loading="lazy"
                                            class="w-full
                                                   h-full
                                                   object-cover
                                                   group-hover:scale-105
                                                   transition
                                                   duration-300">

                                    </div>


                                    {{-- Content --}}
                                    <div class="min-w-0">

                                        <h3 class="font-semibold
                                                   text-gray-900
                                                   text-xs
                                                   sm:text-sm
                                                   leading-5
                                                   line-clamp-2
                                                   group-hover:text-blue-600
                                                   transition">

                                            {{ $popular->title }}

                                        </h3>

                                        <p class="text-[10px]
                                                  sm:text-xs
                                                  text-gray-500
                                                  mt-1.5">

                                            {{ $popular->published_at
                                                ? $popular->published_at->format('d M Y')
                                                : $popular->created_at->format('d M Y') }}

                                        </p>

                                    </div>

                                </a>

                            @empty

                                <p class="text-sm text-gray-500">
                                    No popular posts available.
                                </p>

                            @endforelse

                        </div>

                    </aside>

                </div>

            </section>

        </section>


        {{-- =====================================================
            LIMITED TIME DEAL BANNER
        ====================================================== --}}
        <section class="Container mx-auto px-3 sm:px-4 mt-1 mb-6">

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


                {{-- Banner Content --}}
                <div class="relative
                            px-5
                            py-7
                            sm:px-7
                            sm:py-8
                            md:px-9">

                    <div class="flex flex-col
                                md:flex-row
                                md:items-center
                                md:justify-between
                                gap-6">


                        {{-- Text --}}
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


                        {{-- CTA --}}
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


    {{-- =====================================================
        BLOG CONTENT CUSTOM CSS
    ====================================================== --}}
    <style>

        .blog-content {
            overflow-wrap: break-word;
            word-break: normal;
        }

        /* Paragraph */
        .blog-content p {
            margin-top: 0;
            margin-bottom: 1rem;
            color: #374151;
        }

        /* Headings */
        .blog-content h1 {
            font-size: 1.75rem;
            line-height: 1.3;
            font-weight: 700;
            color: #111827;
            margin-top: 1.75rem;
            margin-bottom: 0.8rem;
        }

        .blog-content h2 {
            font-size: 1.45rem;
            line-height: 1.35;
            font-weight: 700;
            color: #111827;
            margin-top: 1.5rem;
            margin-bottom: 0.7rem;
        }

        .blog-content h3 {
            font-size: 1.2rem;
            line-height: 1.4;
            font-weight: 700;
            color: #111827;
            margin-top: 1.3rem;
            margin-bottom: 0.6rem;
        }

        .blog-content h4 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #111827;
            margin-top: 1.2rem;
            margin-bottom: 0.5rem;
        }

        /* Links */
        .blog-content a {
            color: #2563eb;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .blog-content a:hover {
            color: #1d4ed8;
        }

        /* Strong */
        .blog-content strong {
            color: #111827;
            font-weight: 700;
        }

        /* Lists */
        .blog-content ul {
            list-style-type: disc;
            padding-left: 1.4rem;
            margin-top: 0.8rem;
            margin-bottom: 1rem;
        }

        .blog-content ol {
            list-style-type: decimal;
            padding-left: 1.4rem;
            margin-top: 0.8rem;
            margin-bottom: 1rem;
        }

        .blog-content li {
            margin-bottom: 0.35rem;
            padding-left: 0.15rem;
        }

        /* Images inside blog */
        .blog-content img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 1.25rem auto;
            border-radius: 0.75rem;
        }

        /* Blockquote */
        .blog-content blockquote {
            margin: 1.25rem 0;
            padding: 0.8rem 1rem;
            border-left: 4px solid #2563eb;
            background: #f8fafc;
            color: #4b5563;
            border-radius: 0 0.5rem 0.5rem 0;
        }

        /* Tables */
        .blog-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.25rem 0;
            font-size: 0.9rem;
            overflow: hidden;
        }

        .blog-content th {
            background: #f3f4f6;
            color: #111827;
            font-weight: 600;
            text-align: left;
            border: 1px solid #e5e7eb;
            padding: 0.65rem;
        }

        .blog-content td {
            border: 1px solid #e5e7eb;
            padding: 0.65rem;
            color: #374151;
        }

        .blog-content tr:nth-child(even) {
            background: #f9fafb;
        }

        /* Mobile */
        @media (max-width: 640px) {

            .blog-content {
                font-size: 0.9rem;
                line-height: 1.75;
            }

            .blog-content h1 {
                font-size: 1.45rem;
            }

            .blog-content h2 {
                font-size: 1.25rem;
            }

            .blog-content h3 {
                font-size: 1.1rem;
            }

            .blog-content table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

        }

    </style>

</x-frontend-layout>
