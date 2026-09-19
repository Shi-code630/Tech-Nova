<x-frontend-layout>

    <div class="bg-[#ebf4fa] full">
        <div class="Container mx-auto px-4 pb-5">

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
