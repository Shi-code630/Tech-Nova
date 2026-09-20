<x-frontend-layout title="Careers | TechNova Nepal" description="Jobs at TechNova Nepal, Kathmandu." :canonical="route('careers')">
    {{-- ========================================================= --}}
    {{-- 1. HERO SECTION --}}
    {{-- ========================================================= --}}
    <section class="relative bg-gradient-to-br from-[#2563EB] via-[#1E40AF] to-indigo-900 text-white overflow-hidden">

        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="absolute -top-24 -right-24 w-72 h-72 sm:w-96 sm:h-96 bg-yellow-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 sm:w-96 sm:h-96 bg-blue-400/20 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-4 sm:px-6 py-14 sm:py-20 md:py-28 relative">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-xs sm:text-sm font-semibold mb-4 sm:mb-5">
                    <span class="w-2 h-2 bg-yellow-300 rounded-full animate-pulse"></span>
                    We're Hiring!
                </span>

                <h1 class="text-3xl sm:text-4xl md:text-6xl font-bold mb-4 sm:mb-6 leading-tight">
                    Join Our Team at
                    <span class="text-yellow-300">Tech Nova</span>
                </h1>

                <p class="text-base sm:text-lg md:text-xl text-blue-100 mb-6 sm:mb-8 leading-relaxed">
                    Build the future of technology with us. We're looking for passionate individuals who love to innovate, create, and grow together.
                </p>

                <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4">
                    <a href="#openings" class="text-center px-6 sm:px-8 py-3 sm:py-3.5 bg-white text-[#2563EB] font-semibold rounded-xl hover:bg-yellow-300 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        View Openings →
                    </a>
                    <a href="#culture" class="text-center px-6 sm:px-8 py-3 sm:py-3.5 border-2 border-white/30 text-white font-semibold rounded-xl hover:bg-white/10 transition-all duration-300">
                        Our Culture
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-3 sm:gap-6 mt-8 sm:mt-12 pt-6 sm:pt-8 border-t border-white/20">
                    <div>
                        <p class="text-xl sm:text-3xl md:text-4xl font-bold text-yellow-300">50+</p>
                        <p class="text-[11px] sm:text-sm text-blue-100 mt-1">Team Members</p>
                    </div>
                    <div>
                        <p class="text-xl sm:text-3xl md:text-4xl font-bold text-yellow-300">5+</p>
                        <p class="text-[11px] sm:text-sm text-blue-100 mt-1">Years Strong</p>
                    </div>
                    <div>
                        <p class="text-xl sm:text-3xl md:text-4xl font-bold text-yellow-300">{{ count($jobs) }}</p>
                        <p class="text-[11px] sm:text-sm text-blue-100 mt-1">Open Roles</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================================= --}}
    {{-- 2. WHY WORK WITH US --}}
    {{-- ========================================================= --}}
    <section class="py-14 sm:py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6">

            <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-16">
                <span class="inline-block px-4 py-1.5 bg-blue-50 text-[#2563EB] rounded-full text-xs sm:text-sm font-semibold mb-3 sm:mb-4">
                    Benefits
                </span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-3 sm:mb-4">
                    Why Work With Us?
                </h2>
                <p class="text-sm sm:text-base text-gray-500">
                    We believe in creating an environment where everyone can thrive.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

                <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center mb-3 sm:mb-4 transition">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-[#2563EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-1.5 sm:mb-2">Competitive Salary</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Industry-competitive salaries with regular reviews and performance bonuses.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-green-50 group-hover:bg-green-100 flex items-center justify-center mb-3 sm:mb-4 transition">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-1.5 sm:mb-2">Career Growth</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Clear career paths with mentorship, training, and opportunities to lead.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-purple-50 group-hover:bg-purple-100 flex items-center justify-center mb-3 sm:mb-4 transition">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-1.5 sm:mb-2">Health & Wellness</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Medical insurance, wellness programs, and paid time off.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-orange-50 group-hover:bg-orange-100 flex items-center justify-center mb-3 sm:mb-4 transition">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-1.5 sm:mb-2">Great Team</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Work with talented, supportive people who care about success.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- ========================================================= --}}
    {{-- 3. OUR CULTURE --}}
    {{-- ========================================================= --}}
    <section id="culture" class="py-14 sm:py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 sm:gap-12 items-center">

                <div>
                    <span class="inline-block px-4 py-1.5 bg-blue-50 text-[#2563EB] rounded-full text-xs sm:text-sm font-semibold mb-3 sm:mb-4">
                        Our Culture
                    </span>

                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-4 sm:mb-6 leading-tight">
                        Where Innovation Meets <span class="text-[#2563EB]">Passion</span>
                    </h2>

                    <p class="text-sm sm:text-base text-gray-500 leading-relaxed mb-6 sm:mb-8">
                        At Tech Nova, we foster a culture of creativity, collaboration, and continuous learning. We believe great ideas come from diverse perspectives and open communication.
                    </p>

                    <div class="space-y-4 sm:space-y-5">

                        <div class="flex gap-3 sm:gap-4">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-base sm:text-lg">💡</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm sm:text-base">Innovation First</h4>
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">We embrace new ideas and technologies to solve real problems.</p>
                            </div>
                        </div>

                        <div class="flex gap-3 sm:gap-4">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-base sm:text-lg">🤝</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm sm:text-base">Teamwork</h4>
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">Together we achieve more. Collaboration is at our core.</p>
                            </div>
                        </div>

                        <div class="flex gap-3 sm:gap-4">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-base sm:text-lg">📈</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm sm:text-base">Growth Mindset</h4>
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">We invest in learning and development for everyone.</p>
                            </div>
                        </div>

                        <div class="flex gap-3 sm:gap-4">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-base sm:text-lg">⚖️</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm sm:text-base">Work-Life Balance</h4>
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">Flexible hours and remote options to fit your lifestyle.</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="relative mt-4 sm:mt-0">
                    <div class="aspect-square rounded-3xl bg-gradient-to-br from-[#2563EB] to-[#1E40AF] p-6 sm:p-8 flex items-center justify-center shadow-2xl">
                        <div class="text-center text-white">
                            <div class="text-6xl sm:text-8xl mb-3 sm:mb-4">🚀</div>
                            <p class="text-xl sm:text-2xl font-bold">Tech Nova</p>
                            <p class="text-blue-100 mt-2 text-sm sm:text-base">Innovate. Create. Grow.</p>
                        </div>
                    </div>

                    <div class="absolute -bottom-4 -right-4 sm:-bottom-6 sm:-right-6 bg-white rounded-2xl shadow-xl p-4 sm:p-5 border border-gray-100">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-green-100 flex items-center justify-center">
                                <span class="text-xl sm:text-2xl">⭐</span>
                            </div>
                            <div>
                                <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ number_format($employeeRating ?? 4.9, 1) }}/5</p>
                                <p class="text-[11px] sm:text-xs text-gray-500">Employee Rating</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ========================================================= --}}
    {{-- 4. OPEN POSITIONS --}}
    {{-- ========================================================= --}}
    <section id="openings" class="py-14 sm:py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6">

            <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-12">
                <span class="inline-block px-4 py-1.5 bg-blue-50 text-[#2563EB] rounded-full text-xs sm:text-sm font-semibold mb-3 sm:mb-4">
                    Open Positions
                </span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-3 sm:mb-4">
                    Find Your Next Role
                </h2>
                <p class="text-sm sm:text-base text-gray-500">
                    Explore our current openings and become part of something amazing.
                </p>
            </div>

            {{-- Flash success message after applying --}}
            @if(session('application_success'))
                <div class="max-w-4xl mx-auto mb-6 sm:mb-8 bg-green-50 border border-green-200 text-green-800 rounded-2xl px-4 sm:px-6 py-3 sm:py-4 flex items-start sm:items-center gap-3">
                    <span class="text-xl sm:text-2xl">✅</span>
                    <p class="text-sm sm:text-base">{{ session('application_success') }}</p>
                </div>
            @endif

            {{-- Filter bar: horizontally scrollable on mobile so buttons never wrap awkwardly --}}
            <div class="flex sm:flex-wrap sm:justify-center gap-2 sm:gap-3 mb-8 sm:mb-10 overflow-x-auto pb-2 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0 no-scrollbar">
                <button onclick="filterJobs('all', this)" class="filter-btn active shrink-0 px-4 sm:px-5 py-2 sm:py-2.5 bg-[#2563EB] text-white rounded-xl font-medium text-xs sm:text-sm shadow-sm transition">
                    All ({{ count($jobs) }})
                </button>
                <button onclick="filterJobs('Engineering', this)" class="filter-btn shrink-0 px-4 sm:px-5 py-2 sm:py-2.5 bg-white text-gray-600 hover:bg-gray-100 rounded-xl font-medium text-xs sm:text-sm border border-gray-200 transition">
                    Engineering
                </button>
                <button onclick="filterJobs('Marketing', this)" class="filter-btn shrink-0 px-4 sm:px-5 py-2 sm:py-2.5 bg-white text-gray-600 hover:bg-gray-100 rounded-xl font-medium text-xs sm:text-sm border border-gray-200 transition">
                    Marketing
                </button>
                <button onclick="filterJobs('Design', this)" class="filter-btn shrink-0 px-4 sm:px-5 py-2 sm:py-2.5 bg-white text-gray-600 hover:bg-gray-100 rounded-xl font-medium text-xs sm:text-sm border border-gray-200 transition">
                    Design
                </button>
                <button onclick="filterJobs('Support', this)" class="filter-btn shrink-0 px-4 sm:px-5 py-2 sm:py-2.5 bg-white text-gray-600 hover:bg-gray-100 rounded-xl font-medium text-xs sm:text-sm border border-gray-200 transition">
                    Support
                </button>
                <button onclick="filterJobs('Product', this)" class="filter-btn shrink-0 px-4 sm:px-5 py-2 sm:py-2.5 bg-white text-gray-600 hover:bg-gray-100 rounded-xl font-medium text-xs sm:text-sm border border-gray-200 transition">
                    Product
                </button>
            </div>

            <div class="space-y-4 max-w-4xl mx-auto" id="jobs-container">

                @foreach($jobs as $job)
                    <div class="job-card bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 hover:shadow-xl hover:border-blue-200 transition-all duration-300 group" data-department="{{ $job['department'] }}">

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-2">
                                    <h3 class="text-base sm:text-xl font-bold text-gray-800 group-hover:text-[#2563EB] transition break-words">
                                        {{ $job['title'] }}
                                    </h3>
                                    <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 bg-blue-50 text-[#2563EB] text-[11px] sm:text-xs font-semibold rounded-full whitespace-nowrap">
                                        {{ $job['department'] }}
                                    </span>
                                </div>

                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 sm:gap-4 text-xs sm:text-sm text-gray-500 mt-2 sm:mt-3">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $job['location'] }}
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $job['type'] }}
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $job['posted'] }}
                                    </span>
                                    <span class="md:hidden text-gray-400">
                                        {{ $job['experience'] }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="hidden md:block text-sm text-gray-400">
                                    {{ $job['experience'] }}
                                </span>
                                <button type="button"
                                        onclick="openApplyModal('{{ $job['title'] }}')"
                                        class="w-full md:w-auto text-center px-5 sm:px-6 py-2.5 sm:py-3 bg-[#2563EB] hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-sm hover:shadow-md text-sm sm:text-base">
                                    Apply Now →
                                </button>
                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

            <div id="no-jobs" class="hidden text-center py-12 sm:py-16">
                <div class="text-5xl sm:text-6xl mb-3 sm:mb-4">📭</div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2">No positions found</h3>
                <p class="text-sm sm:text-base text-gray-500">Try selecting a different department.</p>
            </div>

        </div>
    </section>

    {{-- ========================================================= --}}
    {{-- APPLY NOW MODAL --}}
    {{-- ========================================================= --}}
    <div id="apply-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/50" onclick="closeApplyModal()"></div>

        {{-- Modal card --}}
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg p-5 sm:p-6 md:p-8 max-h-[92vh] overflow-y-auto">

            <button type="button" onclick="closeApplyModal()"
                    class="absolute top-3 right-3 sm:top-4 sm:right-4 text-gray-400 hover:text-gray-600 text-2xl leading-none">
                &times;
            </button>

            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-1 pr-8">Apply for <span id="apply-job-title" class="text-[#2563EB]"></span></h3>
            <p class="text-xs sm:text-sm text-gray-500 mb-5 sm:mb-6">Fill in your details and attach your resume — we'll be in touch soon.</p>

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-xs sm:text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('careers.apply') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <input type="hidden" name="job_title" id="apply-job-title-input" value="">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[#2563EB]/40 focus:border-[#2563EB]">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[#2563EB]/40 focus:border-[#2563EB]">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="tel" name="phone" required value="{{ old('phone') }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[#2563EB]/40 focus:border-[#2563EB]">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Resume (PDF/DOC, max 5MB)</label>
                    <input type="file" name="resume" required accept=".pdf,.doc,.docx"
                           class="w-full text-xs sm:text-sm text-gray-600 file:mr-3 sm:file:mr-4 file:py-2 file:px-3 sm:file:px-4 file:rounded-xl file:border-0 file:bg-blue-50 file:text-[#2563EB] file:font-semibold hover:file:bg-blue-100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Message (optional)</label>
                    <textarea name="message" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[#2563EB]/40 focus:border-[#2563EB]">{{ old('message') }}</textarea>
                </div>

                <button type="submit"
                        class="w-full py-3 bg-[#2563EB] hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-sm hover:shadow-md text-sm sm:text-base">
                    Submit Application
                </button>

            </form>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- 5. HIRING PROCESS --}}
    {{-- ========================================================= --}}
    <section class="py-14 sm:py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6">

            <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-16">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-3 sm:mb-4">
                    Our Hiring Process
                </h2>
                <p class="text-sm sm:text-base text-gray-500">
                    Simple, transparent, and fast — here's what to expect.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-6 max-w-5xl mx-auto">

                <div class="relative text-center group">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto rounded-2xl bg-[#2563EB] text-white flex items-center justify-center font-bold text-base sm:text-xl shadow-lg mb-3 sm:mb-4 group-hover:scale-110 transition">
                        1
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1 sm:mb-2 text-sm sm:text-base">Apply</h3>
                    <p class="text-xs sm:text-sm text-gray-500">Submit your application online</p>
                </div>

                <div class="relative text-center group">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto rounded-2xl bg-[#2563EB] text-white flex items-center justify-center font-bold text-base sm:text-xl shadow-lg mb-3 sm:mb-4 group-hover:scale-110 transition">
                        2
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1 sm:mb-2 text-sm sm:text-base">Screening</h3>
                    <p class="text-xs sm:text-sm text-gray-500">Initial call with our HR team</p>
                </div>

                <div class="relative text-center group">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto rounded-2xl bg-[#2563EB] text-white flex items-center justify-center font-bold text-base sm:text-xl shadow-lg mb-3 sm:mb-4 group-hover:scale-110 transition">
                        3
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1 sm:mb-2 text-sm sm:text-base">Interview</h3>
                    <p class="text-xs sm:text-sm text-gray-500">Technical & culture fit rounds</p>
                </div>

                <div class="relative text-center group">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto rounded-2xl bg-green-600 text-white flex items-center justify-center font-bold text-base sm:text-xl shadow-lg mb-3 sm:mb-4 group-hover:scale-110 transition">
                        ✓
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1 sm:mb-2 text-sm sm:text-base">Offer</h3>
                    <p class="text-xs sm:text-sm text-gray-500">Welcome to Tech Nova!</p>
                </div>

            </div>
        </div>
    </section>

    {{-- ========================================================= --}}
    {{-- 6. CTA SECTION --}}
    {{-- ========================================================= --}}
    <section class="py-14 sm:py-20 bg-gradient-to-br from-[#2563EB] to-[#1E40AF] text-white">
        <div class="container mx-auto px-4 sm:px-6 text-center">

            <div class="max-w-2xl mx-auto">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-3 sm:mb-4">
                    Don't See Your Perfect Role?
                </h2>
                <p class="text-blue-100 text-sm sm:text-lg mb-6 sm:mb-8">
                    We're always looking for talented people. Send us your resume and we'll reach out when a matching opportunity opens up.
                </p>

                <button type="button" onclick="openApplyModal('General Application')"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3.5 sm:py-4 bg-white text-[#2563EB] font-semibold rounded-xl hover:bg-yellow-300 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm sm:text-base">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Send Your Resume
                </button>

                <p class="text-xs sm:text-sm text-blue-200 mt-5 sm:mt-6 break-all">
                    technova2083@gmail.com
                </p>
            </div>

        </div>
    </section>

    <script>
        function filterJobs(department, btn) {
            const cards = document.querySelectorAll('.job-card');
            const noJobs = document.getElementById('no-jobs');
            const buttons = document.querySelectorAll('.filter-btn');
            let visibleCount = 0;

            buttons.forEach(b => {
                b.classList.remove('bg-[#2563EB]', 'text-white', 'shadow-sm', 'active');
                b.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-200');
            });

            btn.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-200');
            btn.classList.add('bg-[#2563EB]', 'text-white', 'shadow-sm', 'active');

            cards.forEach(card => {
                if (department === 'all' || card.dataset.department === department) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.3s ease-in';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            noJobs.classList.toggle('hidden', visibleCount > 0);
        }

        function openApplyModal(jobTitle) {
            document.getElementById('apply-job-title').textContent = jobTitle;
            document.getElementById('apply-job-title-input').value = jobTitle;
            document.getElementById('apply-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeApplyModal() {
            document.getElementById('apply-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Re-open modal automatically if validation failed server-side
        @if ($errors->any() && old('job_title'))
            document.addEventListener('DOMContentLoaded', function () {
                openApplyModal(@json(old('job_title')));
            });
        @endif
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

</x-frontend-layout>
