<x-frontend-layout>

    <div class="bg-[#ebf4fa] w-full">
        <div class="Container mx-auto px-3 sm:px-4 pb-10">

            {{-- =====================================================
                HERO BANNER
            ====================================================== --}}
            <section>
                <nav class="text-xs sm:text-sm md:text-base py-2 md:py-5">
                    <a href="/" class="hover:text-blue-700 transition">
                        Home
                    </a>

                    <span class="text-blue-200">/</span>

                    <a href="/blogs" class="text-black hover:text-blue-700 transition">
                        Blogs
                    </a>
                </nav>
            </section>


            {{-- =====================================================
                BLOG PAGE HEADER
            ====================================================== --}}
            <section>
                <div class="max-w-7xl mx-auto text-center">

                    <h1 class="mt-3 text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">
                        Blogs & Articles
                    </h1>

                    <p class="mt-1 max-w-2xl mx-auto text-sm sm:text-base text-gray-600 px-2">
                        Discover the latest technology news, tips, guides and useful information.
                    </p>

                </div>
            </section>


            {{-- =====================================================
                BLOG CARDS
            ====================================================== --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4
                        pt-6 sm:pt-10 gap-4 sm:gap-6 pb-10">

                @foreach ($blogs as $blog)
                    <article
                        class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm
                               hover:shadow-xl transition duration-300 flex flex-col">

                        {{-- Blog Image --}}
                        <div class="h-44 sm:h-52 overflow-hidden">
                            <img src="{{ $blog->featured_image
                                ? asset('storage/' . $blog->featured_image)
                                : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=900&q=80' }}"
                                alt="{{ $blog->title }}"
                                loading="lazy"
                                class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </div>


                        <div class="p-4 flex-1 flex flex-col">

                            {{-- Category --}}
                            <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-3">
                                <span class="text-blue-600 font-medium line-clamp-1">
                                    {{ $blog->category->name ?? 'Blog' }}
                                </span>
                            </div>


                            {{-- Title --}}
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-3 line-clamp-2">
                                {{ $blog->title }}
                            </h3>


                            {{-- Excerpt --}}
                            <p class="text-gray-600 text-xs sm:text-sm leading-relaxed mb-4 line-clamp-3 flex-1">
                                {{ $blog->excerpt }}
                            </p>


                            {{-- Date + Read More --}}
                            <div class="flex items-center justify-between gap-2 pt-2 border-t border-gray-100">

                                <span class="text-[11px] sm:text-sm text-gray-500 whitespace-nowrap">
                                    📅 {{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}
                                </span>

                                <a href="{{ route('blogs.view', $blog->slug) }}"
                                    class="text-xs sm:text-sm text-blue-600 hover:text-blue-800
                                           inline-flex items-center whitespace-nowrap font-medium">
                                    Read More
                                    <span class="ml-1 sm:ml-2">→</span>
                                </a>

                            </div>

                        </div>

                    </article>
                @endforeach

            </div>

        </div>
    </div>

</x-frontend-layout>
