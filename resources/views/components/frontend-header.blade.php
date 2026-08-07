<header class="">
<div class="w-full shadow-md ">

        <!-- Top Header -->
        <div class="bg-[#2563EB] p-2 ">
            <div class="flex items-center justify-between container mx-auto">

                <!-- Logo -->
                <a href="{{ route('home')}}" class="flex-shrink-0">
                    <img src="{{ asset('image/logo.png') }}" alt="logo" class="w-auto h-11 drop-shadow-sm">
                </a>

                <!-- Search -->
                <div class="flex-1 max-w-xl mx-8 relative">
                    <input type="text" placeholder="Search products..."
                    class="w-full h-9 rounded-full outline-none pl-5 pr-14 text-sm border-2 border-white/30 bg-white/90 backdrop-blur-sm focus:bg-white focus:border-[#F59E0B] transition-all duration-300 shadow-inner text-[#111827]">
                    <button class="absolute right-1 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] flex items-center justify-center hover:scale-105 hover:shadow-[0_0_15px_rgba(37,99,235,0.4)] transition-all duration-200 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-5.2-5.2m2.2-5.3a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>

                <!-- Right Icons -->
                <div class="flex items-center gap-5">

                    <!-- Coin / Price -->
                    <a href="#" class="relative group cursor-pointer">
                        <div class="bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-all duration-300 rounded-full px-3 py-0.5 flex items-center gap-2 border border-white/30 shadow-lg">
                            <span class="text-white font-bold text-lg tracking-tight">01</span>
                            <span class="w-6 h-6 rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-xs shadow-md animate-pulse">💰</span>
                            <span class="text-white/60 text-xs font-medium hidden sm:inline">Coins</span>
                        </div>
                        <div class="absolute -bottom-10 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                            <span class="text-[10px] bg-[#111827] text-white px-2 py-0.5 rounded whitespace-nowrap">Your balance</span>
                        </div>
                    </a>

                    <!-- Cart -->
                    <a href="#" class="relative group">
                        <div class="bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-all duration-300 rounded-full p-2.5 border border-white/30 shadow-lg group-hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="absolute -bottom-7 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-[10px] bg-[#111827] text-white px-2 py-0.5 rounded whitespace-nowrap pointer-events-none">Cart</span>
                    </a>

                    <!-- Wishlist -->
                    <a href="#" class="relative group">
                        <div class="bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-all duration-300 rounded-full p-2.5 border border-white/30 shadow-lg group-hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 text-white group-hover:text-[#F59E0B] transition-colors duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z"/>
                            </svg>
                        </div>
                        <span class="absolute -bottom-7 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-[10px] bg-[#111827] text-white px-2 py-0.5 rounded whitespace-nowrap pointer-events-none">Wishlist</span>
                    </a>

                    <!-- Profile -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-all duration-300 rounded-full pl-2 pr-3 py-1 border border-white/30 shadow-lg group-hover:scale-105">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center text-white font-bold text-sm shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.121 17.804A9 9 0 1118.88 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <span class="text-white text-sm font-medium hidden sm:inline">Account</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2 text-white/70 hidden sm:block transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <span class="text-white text-sm font-medium hidden sm:inline">
                            Account
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-3 h-3 text-white/70 hidden sm:block transition-transform duration-300 group-hover:rotate-180"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>

                        <!-- Profile Dropdown -->
                        <div class="absolute right-0 top-full mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden">
                            <div class="py-2">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-[#111827]">John Doe</p>
                                    <p class="text-xs text-gray-500">john@example.com</p>
                                </div>
                                <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-blue-50 hover:text-[#2563EB] transition-colors text-sm text-[#111827]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    My Profile
                                </a>
                                <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-blue-50 hover:text-[#2563EB] transition-colors text-sm text-[#111827]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    My Orders
                                </a>
                                <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-blue-50 hover:text-[#2563EB] transition-colors text-sm text-[#111827]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z"/></svg>
                                    Wishlist
                                </a>
                                <div class="border-t border-gray-100 mt-1 pt-1">
                                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 hover:text-red-600 transition-colors text-sm text-[#111827]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- Category Menu -->
        <div class="bg-gradient-to-r from-[#EAF8FF] to-[#D6EEFF] border-t border-blue-100/60 shadow-inner">
            <div class="max-w-7xl mx-auto px-2">
                <ul class="flex items-center gap-5 h-11 text-[14px] font-semibold text-[#111827]">

                    <!-- Mobile & Tablets -->
                    <li class="relative group">
                        <a href="#" class="flex items-center gap-1 hover:text-[#2563EB] py-3 px-3 rounded-lg hover:bg-white/50 transition-all duration-200 whitespace-nowrap">
                            Mobile & Tablets
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                        <div class="absolute left-0 top-full hidden group-hover:block w-64 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                            <ul class="py-2">
                                <li><a href="{{ route('smartphones') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">📱 Smartphones</a></li>
                                <li><a href="{{ route('mobile.accessories') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🎧 Mobile Accessories</a></li>
                                <li><a href="{{ route('smart.watches') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">⌚ Smart Watches</a></li>
                                <li><a href="{{ route('power.charging') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🔋 Power & Charging</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Computers Office -->
                    <li class="relative group">
                        <a href="#" class="flex items-center gap-1 hover:text-[#2563EB] py-3 px-3 rounded-lg hover:bg-white/50 transition-all duration-200 whitespace-nowrap">
                            Computers Office
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                        <div class="absolute left-0 top-full hidden group-hover:block w-72 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                            <ul class="py-2">
                                <li><a href="{{ route('laptops') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">💻 Laptops</a></li>
                                <li><a href="{{ route('desktop.computers') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🖥️ Desktop Computers</a></li>
                                <li><a href="{{ route('monitors') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🖥 Monitors</a></li>
                                <li><a href="{{ route('computer.accessories') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">⌨️ Computer Accessories</a></li>
                                <li><a href="{{ route('storage.devices') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">💾 Storage Devices</a></li>
                                <li><a href="{{ route('printers.office.equipment') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🖨️ Printers & Office Equipment</a></li>
                                <li><a href="{{ route('networking.devices') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">📡 Networking Devices</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Gaming & Entertainment -->
                    <li class="relative group">
                        <a href="#" class="flex items-center gap-1 hover:text-[#2563EB] py-3 px-3 rounded-lg hover:bg-white/50 transition-all duration-200 whitespace-nowrap">
                            Gaming & Entertainment
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                        <div class="absolute left-0 top-full hidden group-hover:block w-80 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                            <ul class="py-2">
                                <li><a href="{{ route('gaming') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🎮 Gaming</a></li>
                                <li><a href="{{ route('audio') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🎵 Audio</a></li>
                                <li><a href="{{ route('gaming.controllers') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🕹️ Gaming Controllers</a></li>
                                <li><a href="{{ route('headsets.audio.devices') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🎧 Headsets & Audio Devices</a></li>
                                <li><a href="{{ route('cameras') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">📷 Cameras</a></li>
                                <li><a href="{{ route('smart.tvs') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">📺 Smart TVs</a></li>
                                <li><a href="{{ route('led.tvs') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">📺 LED TVs</a></li>
                                <li><a href="{{ route('android.tvs') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🤖 Android TVs</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Home Appliances -->
                    <li class="relative group">
                        <a href="#" class="flex items-center gap-1 hover:text-[#2563EB] py-3 px-3 rounded-lg hover:bg-white/50 transition-all duration-200 whitespace-nowrap">
                            Home Appliances
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                        <div class="absolute left-0 top-full hidden group-hover:block w-80 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                            <ul class="py-2">
                                <li><a href="{{ route('air.conditioners') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">❄️ Air Conditioners (AC)</a></li>
                                <li><a href="{{ route('air.coolers') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🌬️ Air Coolers</a></li>
                                <li><a href="{{ route('fans') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🌀 Fans</a></li>
                                <li><a href="{{ route('refrigerators') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🧊 Refrigerators</a></li>
                                <li><a href="{{ route('washing.machines') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">👕 Washing Machines</a></li>
                                <li><a href="{{ route('microwave.ovens') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🍲 Microwave Ovens</a></li>
                                <li><a href="{{ route('rice.cookers') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🍚 Rice Cookers</a></li>
                                <li><a href="{{ route('electric.kettles') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">☕ Electric Kettles</a></li>
                                <li><a href="{{ route('vacuum.cleaners') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🧹 Vacuum Cleaners</a></li>
                                <li><a href="{{ route('water.heaters') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🚿 Water Heaters (Geysers)</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Smart Home -->
                    <li class="relative group">
                        <a href="#" class="flex items-center gap-1 hover:text-[#2563EB] py-3 px-3 rounded-lg hover:bg-white/50 transition-all duration-200 whitespace-nowrap">
                            Smart Home
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                        <div class="absolute left-0 top-full hidden group-hover:block w-72 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                            <ul class="py-2">
                                <li><a href="{{ route('smart.speakers') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🏠 Smart Home Devices</a></li>
                                <li><a href="{{ route('smart.security') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">📹 CCTV & Security</a></li>
                                <li><a href="{{ route('smart.sensors') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">☀️ Solar Products</a></li>
                                <li><a href="{{ route('smart.locks') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🔋 Inverters & UPS</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Electrical -->
                    <li class="relative group">
                        <a href="#" class="flex items-center gap-1 hover:text-[#2563EB] py-3 px-3 rounded-lg hover:bg-white/50 transition-all duration-200 whitespace-nowrap">
                            Electrical
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                        <div class="absolute left-0 top-full hidden group-hover:block w-72 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                            <ul class="py-2">
                                <li><a href="{{ route('cables.adapters') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🔌 Cables & Adapters</a></li>
                                <li><a href="{{ route('chargers') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🔋 Chargers</a></li>
                                <li><a href="{{ route('extension.boards') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🧰 Extension Boards</a></li>
                                <li><a href="{{ route('power.banks') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🔋 Power Banks</a></li>
                                <li><a href="{{ route('batteries') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🔋 Batteries</a></li>
                                <li><a href="{{ route('electrical.accessories') }}" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">⚡ Electrical Accessories</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Today's Deals -->
                    <li class="relative group">
                        <a href="#" class="flex items-center gap-1 hover:text-[#2563EB] py-3 px-3 rounded-lg hover:bg-white/50 transition-all duration-200 whitespace-nowrap">
                            <span class="text-[#F59E0B]">🔥</span> Today's Deals
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                        <div class="absolute right-0 top-full hidden group-hover:block w-72 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                            <ul class="py-2">
                                <li><a href="#" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🆕 New Products</a></li>
                                <li><a href="#" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">⏳ Limited Time Offers</a></li>
                                <li><a href="#" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">💥 Today's Deals</a></li>
                                <li><a href="#" class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-600 text-sm">🎉 Dhamaka Sale</a></li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
        </div>

    </div>
</header>

