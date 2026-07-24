<x-frontend-layout >
    <div class="bg-[#f0f9ff]">
        <div class="container mx-auto px-4" style="margin-top:10px;">
              <div class="relative max-w-[1500px] mx-auto h-[400px] overflow-hidden rounded-2xl shadow-2xl">
            <!-- Slides Wrapper -->
            <div id="slider" class="flex h-full transition-transform duration-500 ease-in-out will-change-transform">
                <img src="https://picsum.photos/seed/1/800/400" alt="Slide 1" class="w-full h-full object-cover flex-shrink-0">
                <img src="https://picsum.photos/seed/2/800/400" alt="Slide 2" class="w-full h-full object-cover flex-shrink-0">
                <img src="https://picsum.photos/seed/3/800/400" alt="Slide 3" class="w-full h-full object-cover flex-shrink-0">
            </div>

            <!-- Left Arrow -->
            <button onclick="moveSlide(-1)"
            class="absolute top-1/2 left-4 -translate-y-1/2 bg-black/50 text-white p-3 rounded-full cursor-pointer border-none text-xl hover:bg-black/80 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white/50 z-10">

            </button>

        <!-- Right Arrow -->
             <button onclick="moveSlide(1)"
                 class="absolute top-1/2 right-4 -translate-y-1/2 bg-black/50 text-white p-3 rounded-full cursor-pointer border-none text-xl hover:bg-black/80 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white/50 z-10">

                </button>

            <!-- Optional: Dots / Indicators -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                <span class="dot w-3 h-3 rounded-full bg-white/50 cursor-pointer transition-colors duration-300" data-index="0"></span>
                <span class="dot w-3 h-3 rounded-full bg-white/50 cursor-pointer transition-colors duration-300" data-index="1"></span>
                <span class="dot w-3 h-3 rounded-full bg-white/50 cursor-pointer transition-colors duration-300" data-index="2"></span>
            </div>
        </div>
        </div>
    </div>
</x-frontend-layout>
