<x-frontend-layout>

    <div class="bg-[#ebf4fa] full">
        <section class="Container mx-auto px-4 pb-6">
            {{-- Breadcrumb --}}
            <section>
                <nav class="text-sm md:text-base py-2 md:py-5">

                    <a href="/" class="hover:text-blue-700 transition">
                        Home
                    </a>

                    <span class="text-blue-200 mx-2">/</span>

                    <a href="{{ route('blogs.index') }}" class="hover:text-blue-700 transition">
                        Blogs
                    </a>

                    <span class="text-blue-200 mx-2">/</span>

                    <span class="text-gray-500">
                        {{ $blog->title }}
                    </span>

                </nav>
            </section>


            {{-- Main Blog Area --}}
            <section class="pt-5">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 ">

                    {{-- ========================================= --}}
                    {{-- LEFT SIDE : BLOG CONTENT --}}
                    {{-- ========================================= --}}
                    <div class="lg:col-span-2 bg-white border border-gray-100 rounded-2xl shadow-sm p-5 sticky top-10">

                        {{-- Category + Date + Author --}}
                        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 mb-4">

                            <span class="text-blue-600 font-medium">
                                {{ $blog->category->name ?? 'Blog' }}
                            </span>

                            <span>•</span>

                            <span>
                                {{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}
                            </span>

                            @if ($blog->author)
                                <span>•</span>

                                <span>
                                    By {{ $blog->author }}
                                </span>
                            @endif

                        </div>

                        {{-- Featured Image --}}
                        @if ($blog->featured_image)
                            <div class="w-full h-[300px] md:h-[500px] rounded-2xl overflow-hidden mb-8">

                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                                    class="w-full h-full object-cover">

                            </div>
                        @endif
                        {{-- Blog Title --}}
                        <h1 class="text-3xl md:text-2xl font-bold text-gray-900 leading-tight pt-1 mb-6">
                            {{ $blog->title }}
                        </h1>

                        {{-- Excerpt --}}
                        @if ($blog->excerpt)
                            <div class="text-lg md:text-xl text-gray-600 leading-relaxed mb-8">
                                {{ $blog->excerpt }}
                            </div>
                        @endif


                        {{-- ========================================= --}}
                        {{-- BLOG LONG DESCRIPTION / CONTENT --}}
                        {{-- ========================================= --}}
                        <article class="blog-content">

                            {!! $blog->content !!}

                        </article>


                        {{-- Tags --}}
                        @if ($blog->tags && count($blog->tags) > 0)

                            <div class="mt-10 pt-6 border-t border-gray-200">

                                <h3 class="text-lg font-semibold text-gray-900 mb-3">
                                    Tags
                                </h3>

                                <div class="flex flex-wrap gap-2">

                                    @foreach ($blog->tags as $tag)
                                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">
                                            #{{ $tag }}
                                        </span>
                                    @endforeach

                                </div>

                            </div>

                        @endif


                        {{-- Back to Blogs --}}
                        <div class="mt-10">

                            <a href="{{ route('blogs.index') }}"
                                class="inline-flex items-center font-semibold text-blue-600 hover:text-blue-800">
                                <span class="mr-2">←</span>
                                Back to Blogs
                            </a>

                        </div>

                    </div>


                    {{-- ========================================= --}}
                    {{-- RIGHT SIDE : POPULAR POSTS --}}
                    {{-- ========================================= --}}
                    <aside class="lg:col-span-1">

                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 sticky top-10">

                            <h2 class="text-xl font-bold text-gray-900 mb-5 pb-3 border-b">
                                Popular Posts
                            </h2>


                            @forelse($popularPosts as $popular)
                                <a href="{{ route('blogs.view', $popular->slug) }}" class="flex gap-4 mb-5 group">

                                    {{-- Image --}}
                                    <div class="w-24 h-20 flex-shrink-0 rounded-xl overflow-hidden">

                                        <img src="{{ $popular->featured_image
                                            ? asset('storage/' . $popular->featured_image)
                                            : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=400&q=80' }}"
                                            alt="{{ $popular->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300">

                                    </div>


                                    {{-- Content --}}
                                    <div>

                                        <h3
                                            class="font-semibold text-gray-900 text-sm leading-snug line-clamp-2 group-hover:text-blue-600 transition">
                                            {{ $popular->title }}
                                        </h3>

                                        <p class="text-xs text-gray-500 mt-2">
                                            {{ $popular->published_at ? $popular->published_at->format('d M Y') : $popular->created_at->format('d M Y') }}
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


            {{-- ========================================= --}}
            {{-- BLOG CONTENT STYLE --}}
            {{-- ========================================= --}}
            <style>
                .blog-content {
                    color: #374151;
                    font-size: 17px;
                    line-height: 1.8;
                }

                .blog-content p {
                    margin-bottom: 20px;
                }

                .blog-content h1,
                .blog-content h2,
                .blog-content h3,
                .blog-content h4 {
                    color: #111827;
                    font-weight: 700;
                    margin-top: 30px;
                    margin-bottom: 15px;
                }

                .blog-content h1 {
                    font-size: 32px;
                }

                .blog-content h2 {
                    font-size: 26px;
                }

                .blog-content h3 {
                    font-size: 22px;
                }

                .blog-content ul {
                    list-style: disc;
                    padding-left: 25px;
                    margin-bottom: 20px;
                }

                .blog-content ol {
                    list-style: decimal;
                    padding-left: 25px;
                    margin-bottom: 20px;
                }

                .blog-content li {
                    margin-bottom: 8px;
                }

                .blog-content a {
                    color: #2563eb;
                    text-decoration: underline;
                }

                .blog-content img {
                    max-width: 100%;
                    height: auto;
                    border-radius: 12px;
                    margin: 25px 0;
                }

                /* Table */
                .blog-content table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 25px 0;
                    font-size: 15px;
                    overflow: hidden;
                }

                .blog-content table th,
                .blog-content table td {
                    border: 1px solid #e5e7eb;
                    padding: 12px 14px;
                    text-align: left;
                }

                .blog-content table th {
                    background: #f3f4f6;
                    color: #111827;
                    font-weight: 700;
                }

                .blog-content table tr:nth-child(even) {
                    background: #f9fafb;
                }

                .blog-content blockquote {
                    border-left: 4px solid #2563eb;
                    padding: 15px 20px;
                    margin: 25px 0;
                    background: #f9fafb;
                    color: #4b5563;
                    border-radius: 0 8px 8px 0;
                }

                .blog-content strong {
                    color: #111827;
                    font-weight: 700;
                }
            </style>
        </section>
        <section class="Conteiner mx-auto px-8 mt-3 mb-6">
            <div
                class="relative overflow-hidden
    rounded-3xl
    bg-gradient-to-r
    from-gray-900
    via-gray-800
    to-gray-900
    shadow-xl">

                {{-- Decorative elements --}}
                <div class="absolute -top-24 -right-20
        w-72 h-72
        rounded-full
        bg-red-600/20">
                </div>

                <div
                    class="absolute -bottom-32 -left-20
        w-80 h-80
        rounded-full
        bg-orange-500/10">
                </div>


                <div class="relative
        px-6 py-9
        md:px-10 md:py-11">

                    <div
                        class="flex flex-col
            md:flex-row
            md:items-center
            md:justify-between
            gap-7">


                        {{-- Content --}}
                        <div class="max-w-2xl">

                            <div
                                class="inline-flex items-center gap-2
                    bg-red-500/10
                    border border-red-400/20
                    text-red-400
                    px-3 py-1.5
                    rounded-full
                    text-[10px]
                    font-bold
                    uppercase
                    tracking-widest
                    mb-4">

                                <i class="fa-solid fa-bolt"></i>

                                More Flash Deals

                            </div>


                            <h2
                                class="text-2xl md:text-3xl
                    font-extrabold
                    text-white
                    leading-tight">

                                Don't Miss Our
                                <span class="text-red-400">
                                    Limited-Time Offers
                                </span>

                            </h2>


                            <p
                                class="mt-3
                    text-sm
                    text-gray-400
                    leading-relaxed
                    max-w-xl">

                                Explore more limited-time categories and discover
                                exclusive deals available for a short period.
                                New offers can disappear quickly.

                            </p>

                        </div>


                        {{-- CTA --}}
                        <div class="flex-shrink-0">

                            <a href="{{ route('limited-time') }}"
                                class="group inline-flex
                    items-center
                    justify-center
                    gap-3
                    bg-red-600
                    hover:bg-red-500
                    text-white
                    px-6 py-3.5
                    rounded-2xl
                    text-sm
                    font-bold
                    shadow-lg
                    shadow-red-900/20
                    transition-all
                    duration-300
                    hover:-translate-y-0.5">

                                <span>
                                    Explore All Deals
                                </span>

                                <span
                                    class="w-8 h-8
                        rounded-xl
                        bg-white/15
                        flex items-center
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
