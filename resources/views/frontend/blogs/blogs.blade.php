<x-frontend-layout>

    <div class="bg-[#ebf4fa] full">
        <div class="Container mx-auto px-4 pb-10 ">

            <!-- Hero Banner -->
            <section class="Container mx-auto ">
                <nav class=" text-sm md:text-base py-2 md:py-5">
                    <a href="/" class="hover:text-blue-700 transition">
                        Home
                    </a>

                    <span class="text-blue-200">/</span>

                    <a href="/blogs" class="text-black hover:text-blue-700 transition">
                        Blogs
                    </a>
                </nav>
            </section>


            {{-- Blog Page Header --}}
            <section class="Container mx-auto px-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">

                        <h1 class="mt-3 text-3xl md:text-4xl font-bold text-gray-900">
                            Blogs & Articles
                        </h1>

                        <p class="mt-1 max-w-2xl mx-auto">
                            Discover the latest technology news, tips, guides and useful information.
                        </p>

                    </div>
                </div>
            </section>


            {{-- Blog Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 pt-10 gap-6 pb-10">

                @foreach ($blogs as $blog)
                    <article
                        class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition duration-300">

                        {{-- Blog Image --}}
                        <div class="h-52 overflow-hidden">

                            <img src="{{ $blog->featured_image
                                ? asset('storage/' . $blog->featured_image)
                                : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=900&q=80' }}"
                                alt="{{ $blog->title }}"
                                class="w-full h-full object-cover hover:scale-105 transition duration-500">

                        </div>


                        <div class="p-4">

                            {{-- Category + Date --}}
                            <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">

                                <span class="text-blue-600 font-medium line-clamp-1">
                                    {{ $blog->category->name ?? 'Blog' }}
                                </span>



                            </div>


                            {{-- Title --}}
                            <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2">
                                {{ $blog->title }}
                            </h3>


                            {{-- Excerpt - Maximum 3 Lines --}}
                            <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                                {{ $blog->excerpt }}
                            </p>


                            {{-- Date + Read More --}}
                            <div class="flex items-center justify-between">

                                {{-- Date - Left --}}
                                <span class="text-sm text-gray-500">📅
                                    {{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}
                                </span>

                                {{-- Read More - Right --}}
                                <a href="{{ route('blogs.view', $blog->slug) }}"
                                    class="text-sm text-blue-600 hover:text-blue-800 inline-flex items-center">
                                    Read More
                                    <span class="ml-2">→</span>
                                </a>

                            </div>
                        </div>

                    </article>
                @endforeach

            </div>

        </div>
    </div>

</x-frontend-layout>
