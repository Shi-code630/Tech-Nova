<x-frontend-layout>

    <div class="bg-[#ebf4fa] w-full">
        <section class="Container mx-auto px-3 sm:px-4 pb-10">

            {{-- =====================================================
                BREADCRUMB
            ====================================================== --}}
            <section>
                <nav class="text-xs sm:text-sm md:text-base py-2 md:py-5
                            overflow-x-auto whitespace-nowrap scrollbar-hide">

                    <a href="/" class="hover:text-blue-700 transition">
                        Home
                    </a>

                    <span class="text-blue-200 mx-1 sm:mx-2">/</span>

                    <a href="{{ route('blogs.index') }}" class="hover:text-blue-700 transition">
                        Blogs
                    </a>

                    <span class="text-blue-200 mx-1 sm:mx-2">/</span>

                    <span class="text-gray-500">
                        {{ $blog->title }}
                    </span>

                </nav>
            </section>


            {{-- =====================================================
                MAIN BLOG AREA
            ====================================================== --}}
            <section class="pt-3 sm:pt-5">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-8">

                    {{-- ========================================= --}}
                    {{-- LEFT SIDE : BLOG CONTENT                 --}}
                    {{-- ========================================= --}}
                    <div class="lg:col-span-2 bg-white border border-gray-100 rounded-2xl
                                shadow-sm p-4 sm:p-5 lg:sticky lg:top-10">

                        {{-- Category + Date + Author --}}
                        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2
                                    text-xs sm:text-sm text-gray-500 mb-4">

                            <span class="text-blue-600 font-medium">
                                {{ $blog->category->name ?? 'Blog' }}
                            </span>

                            <span>•</span>

                            <span>
                                {{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}
                            </span>

                            @if ($blog->author)
                                <span>•</span>
                                <span>By {{ $blog->author }}</span>
                            @endif

                        </div>


                        {{-- Featured Image --}}
                        @if ($blog->featured_image)
                            <div class="w-full h-[200px] sm:h-[300px] md:h-[400px] lg:h-[500px]
                                        rounded-xl sm:rounded-2xl overflow-hidden mb-5 sm:mb-8">

                                <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                    alt="{{ $blog->title }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover">

                            </div>
                        @endif


                        {{-- Blog Title --}}
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900
                                   leading-tight pt-1 mb-4 sm:mb-6">
                            {{ $blog->title }}
                        </h1>


                        {{-- Excerpt --}}
                        @if ($blog->excerpt)
                            <div class="text-base sm:text-lg md:text-xl text-gray-600
                                        leading-relaxed mb-5 sm:mb-8">
                                {{ $blog->excerpt }}
                            </div>
                        @endif


                        {{-- ========================================= --}}
                        {{-- BLOG CONTENT (prose class)              --}}
                        {{-- ========================================= --}}
                        <article class="prose prose-sm sm:prose-base lg:prose-lg
                                        max-w-none
                                        prose-headings:text-gray-900 prose-headings:font-bold
                                        prose-p:text-gray-700 prose-p:leading-relaxed
                                        prose-a:text-blue-600 prose-a:underline
                                        prose-strong:text-gray-900
                                        prose-ul:list-disc prose-ul:pl-5
                                        prose-ol:list-decimal prose-ol:pl-5
                                        prose-li:mb-2
                                        prose-img:rounded-xl prose-img:my-6
                                        prose-blockquote:border-l-4 prose-blockquote:border-blue-600
                                        prose-blockquote:bg-gray-50 prose-blockquote:py-3
                                        prose-blockquote:px-5 prose-blockquote:rounded-r-lg
                                        prose-blockquote:text-gray-600
                                        prose-table:w-full prose-table:border-collapse
                                        prose-th:bg-gray-100 prose-th:border prose-th:border-gray-200
                                        prose-th:p-3 prose-th:text-left
                                        prose-td:border prose-td:border-gray-200
                                        prose-td:p-3
                                        prose-tr:even:bg-gray-50">
                            {!! $blog->content !!}
                        </article>


                        {{-- Tags --}}
                        @if ($blog->tags && count($blog->tags) > 0)
                            <div class="mt-8 sm:mt-10 pt-5 sm:pt-6 border-t border-gray-200">

                                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3">
                                    Tags
                                </h3>

                                <div class="flex flex-wrap gap-1.5 sm:gap-2">

                                    @foreach ($blog->tags as $tag)
                                        <span class="px-2.5 sm:px-3 py-1
                                                     bg-gray-100 text-gray-600
                                                     rounded-full text-xs sm:text-sm">
                                            #{{ $tag }}
                                        </span>
                                    @endforeach

                                </div>

                            </div>
                        @endif


                        {{-- Back to Blogs --}}
                        <div class="mt-8 sm:mt-10">

                            <a href="{{ route('blogs.index') }}"
                                class="inline-flex items-center font-semibold
                                       text-sm sm:text-base
                                       text-blue-600 hover:text-blue-800">
                                <span class="mr-2">←</span>
                                Back to Blogs
                            </a>

                        </div>

                    </div>


                    {{-- ========================================= --}}
                    {{-- RIGHT SIDE : POPULAR POSTS               --}}
                    {{-- ========================================= --}}
                    <aside class="lg:col-span-1">

                        <div class="bg-white border border-gray-100 rounded-2xl
                                    shadow-sm p-4 sm:p-5 lg:sticky lg:top-10">

                            <h2 class="text-lg sm:text-xl font-bold text-gray-900
                                       mb-4 sm:mb-5 pb-3 border-b">
                                Popular Posts
                            </h2>


                            @forelse($popularPosts as $popular)
                                <a href="{{ route('blogs.view', $popular->slug) }}"
                                    class="flex gap-3 sm:gap-4 mb-4 sm:mb-5 group">

                                    {{-- Image --}}
                                    <div class="w-20 h-16 sm:w-24 sm:h-20 flex-shrink-0
                                                rounded-lg sm:rounded-xl overflow-hidden">

                                        <img src="{{ $popular->featured_image
                                            ? asset('storage/' . $popular->featured_image)
                                            : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=400&q=80' }}"
                                            alt="{{ $popular->title }}"
                                            loading="lazy"
                                            class="w-full h-full object-cover
                                                   group-hover:scale-105 transition duration-300">

                                    </div>


                                    {{-- Content --}}
                                    <div class="min-w-0">

                                        <h3 class="font-semibold text-gray-900
                                                   text-xs sm:text-sm leading-snug
                                                   line-clamp-2
                                                   group-hover:text-blue-600 transition">
                                            {{ $popular->title }}
                                        </h3>

                                        <p class="text-[11px] sm:text-xs text-gray-500 mt-2">
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

        </section>
    </div>

</x-frontend-layout>
