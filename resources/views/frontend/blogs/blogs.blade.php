<x-frontend-layout>

<section class="pb-10 container">

    <!-- Hero Banner -->
    <section class="py-4 px-4">
        <nav class="container text-sm md:text-base py-5 md:py-5">
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
    <section class="bg-gray-50 border-b">
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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 pt-5 gap-6 pb-10">

        @foreach($blogs as $blog)

            <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition duration-300">

                {{-- Blog Image --}}
                <div class="h-52 overflow-hidden">

                    <img
                        src="{{ $blog->featured_image
                            ? asset('storage/' . $blog->featured_image)
                            : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=900&q=80'
                        }}"
                        alt="{{ $blog->title }}"
                        class="w-full h-full object-cover hover:scale-105 transition duration-500"
                    >

                </div>


                <div class="p-5">

                    {{-- Category + Date --}}
                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">

                        <span class="text-blue-600 font-medium">
                            {{ $blog->category->name ?? 'Blog' }}
                        </span>

                        <span>•</span>

                        <span>
                            {{ $blog->published_at
                                ? $blog->published_at->format('d M Y')
                                : $blog->created_at->format('d M Y')
                            }}
                        </span>

                    </div>


                    {{-- Title --}}
                    <h3 class="text-lg font-bold text-gray-900 mb-3">
                        {{ $blog->title }}
                    </h3>


                    {{-- Excerpt --}}
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        {{ Str::limit($blog->excerpt, 120) }}
                    </p>


                    {{-- Read More --}}
                    <a href="{{ route('blogs.view', $blog->slug) }}"
                    class="inline-flex items-center font-semibold text-blue-600 hover:text-blue-800">
                        Read More
                        <span class="ml-2">→</span>
                    </a>


                </div>

            </article>

        @endforeach

    </div>

</section>

</x-frontend-layout>
