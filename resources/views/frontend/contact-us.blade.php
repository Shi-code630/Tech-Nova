<x-frontend-layout>
   <section class="bg-blue-50 pb-4">
     <!-- Hero Banner (exact same as Privacy Policy) -->
    <section class="py-4 px-4">
        <nav class="container text-sm md:text-base py-5 md:py-5">
            <a href="/" class="hover:text-blue-700 transition">Home</a>
            <span class="text-blue-200">/</span>
            <a href="/contact-us" class="text-black hover:text-blue-700 transition">Contact Us</a>
        </nav>
    </section>
    <section class="text-black">
        <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-4xl font-extrabold tracking-tight mb-2">Contact Us</h1>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 md:py-3">
        <!-- Contact Form & Map Row -->
        <div class="grid lg:grid-cols-full gap-8 mb-10">
            <!-- Form Column -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition transform hover:-translate-y-1 hover:shadow-xl duration-300">
                    <div class="p-6 md:p-8">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800 mb-2">Send Us a Message</h2>
                                <p class="text-gray-600 leading-relaxed">Fill in the form below and we'll get back to you as soon as possible.</p>
                            </div>
                        </div>
                        <form action="#" method="POST" class="mt-6 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                    <input type="text" id="first_name" name="first_name" placeholder="your name" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none text-gray-800">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" placeholder="your last name" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none text-gray-800">
                                </div>
                            </div>
                             <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="text" id="first_name" name="first_name" placeholder="your email" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none text-gray-800">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="text" id="last_name" name="last_name" placeholder="your phone number" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none text-gray-800">
                                </div>
                            </div>

                            <div>
                                <label for="order_number" class="block text-sm font-medium text-gray-700 mb-1">Order Number <span class="text-gray-400 text-xs">(Optional)</span></label>
                                <input type="text" id="order_number" name="order_number" placeholder="#TN-12345" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none text-gray-800">
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea id="message" name="message" rows="4" placeholder="How can we help you?" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none text-gray-800 resize-none"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition duration-200 transform hover:-translate-y-0.5">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Map  -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Map Card -->
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition transform hover:-translate-y-1 hover:shadow-xl duration-300">
                            <div class="p-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800">Find Us</h3>
                                    </div>
                                </div>
                                <div class="mt-4 aspect-w-16 aspect-h-9 rounded-xl overflow-hidden bg-gray-200">
                                    <!-- Placeholder Google Map embed -->
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.317248837209!2d85.3241585!3d27.7172453!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb190a2a9e7a9f%3A0x6b3f3b8f5c6f1b0d!2sKathmandu%2C%20Nepal!5e0!3m2!1sen!2snp!4v1650000000000" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" class="rounded-xl"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
        <!-- Customer Support Section -->
        <div class="mb-10 py-6">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition transform hover:-translate-y-1 hover:shadow-xl duration-300">
                <div class="p-6 md:p-8">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636a9 9 0 010 12.728m0 0l-3.182 3.182m3.182-3.182l-3.182-3.182M5.636 5.636a9 9 0 00-4.243 7.071c0 2.485 1.008 4.736 2.636 6.364m0 0l3.182 3.182m-3.182-3.182l3.182-3.182" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Customer Support</h2>
                            <p class="text-gray-600 leading-relaxed">We're here to assist you with any queries.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                        <!-- Product Support -->
                        <div class="bg-blue-50 rounded-xl p-5 text-center hover:shadow-md transition">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800 mt-2">Product Support</h4>
                            <p class="text-gray-500 text-sm">Get help with product features and usage.</p>
                        </div>
                        <!-- Order Tracking -->
                        <div class="bg-blue-50 rounded-xl p-5 text-center hover:shadow-md transition">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800 mt-2">Order Tracking</h4>
                            <p class="text-gray-500 text-sm">Track your order status in real-time.</p>
                        </div>
                        <!-- Returns & Refunds -->
                        <div class="bg-blue-50 rounded-xl p-5 text-center hover:shadow-md transition">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800 mt-2">Returns & Refunds</h4>
                            <p class="text-gray-500 text-sm">Learn about our return and refund policies.</p>
                        </div>
                        <!-- Technical Support -->
                        <div class="bg-blue-50 rounded-xl p-5 text-center hover:shadow-md transition">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800 mt-2">Technical Support</h4>
                            <p class="text-gray-500 text-sm">Get assistance with technical issues.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mb-10">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition transform hover:-translate-y-1 hover:shadow-xl duration-300">
                <div class="p-6 md:p-8">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Frequently Asked Questions</h2>
                            <p class="text-gray-600 leading-relaxed">Find quick answers to common queries.</p>
                        </div>
                    </div>
                    <div class="mt-6 space-y-4">
                        <!-- FAQ 1 -->
                        <div class="border-b border-gray-100 pb-4">
                            <details class="group">
                                <summary class="flex items-center justify-between cursor-pointer text-gray-800 font-medium hover:text-blue-600 transition">
                                    <span>How do I place an order?</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <p class="mt-2 text-gray-600 text-sm">Simply browse our products, add items to your cart, proceed to checkout, fill in your details, and choose a payment method. You'll receive an order confirmation via email.</p>
                            </details>
                        </div>
                        <!-- FAQ 2 -->
                        <div class="border-b border-gray-100 pb-4">
                            <details class="group">
                                <summary class="flex items-center justify-between cursor-pointer text-gray-800 font-medium hover:text-blue-600 transition">
                                    <span>How long does delivery take?</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <p class="mt-2 text-gray-600 text-sm">Delivery typically takes 2-5 business days within Nepal. You'll receive a tracking number to monitor your shipment.</p>
                            </details>
                        </div>
                        <!-- FAQ 3 -->
                        <div class="border-b border-gray-100 pb-4">
                            <details class="group">
                                <summary class="flex items-center justify-between cursor-pointer text-gray-800 font-medium hover:text-blue-600 transition">
                                    <span>How can I track my order?</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <p class="mt-2 text-gray-600 text-sm">Once your order is shipped, we'll send you a tracking link via email. You can also log in to your account to view order status.</p>
                            </details>
                        </div>
                        <!-- FAQ 4 -->
                        <div class="border-b border-gray-100 pb-4">
                            <details class="group">
                                <summary class="flex items-center justify-between cursor-pointer text-gray-800 font-medium hover:text-blue-600 transition">
                                    <span>How do I return a product?</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <p class="mt-2 text-gray-600 text-sm">You can return items within 7 days of delivery. Contact our support team to initiate the process. Items must be unused and in original packaging.</p>
                            </details>
                        </div>
                        <!-- FAQ 5 -->
                        <div class="border-b border-gray-100 pb-4">
                            <details class="group">
                                <summary class="flex items-center justify-between cursor-pointer text-gray-800 font-medium hover:text-blue-600 transition">
                                    <span>What payment methods are accepted?</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <p class="mt-2 text-gray-600 text-sm">We accept credit/debit cards, eSewa, Khalti, bank transfers, and Cash on Delivery (COD).</p>
                            </details>
                        </div>
                        <!-- FAQ 6 -->
                        <div class="border-b border-gray-100 pb-4">
                            <details class="group">
                                <summary class="flex items-center justify-between cursor-pointer text-gray-800 font-medium hover:text-blue-600 transition">
                                    <span>Is Cash on Delivery available?</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <p class="mt-2 text-gray-600 text-sm">Yes, Cash on Delivery is available for most areas in Nepal. Additional charges may apply.</p>
                            </details>
                        </div>
                        <!-- FAQ 7 -->
                        <div class="border-b border-gray-100 pb-4">
                            <details class="group">
                                <summary class="flex items-center justify-between cursor-pointer text-gray-800 font-medium hover:text-blue-600 transition">
                                    <span>How do I claim warranty?</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <p class="mt-2 text-gray-600 text-sm">For warranty claims, contact our support with your order number and a description of the issue. We'll facilitate the process with the manufacturer.</p>
                            </details>
                        </div>
                        <!-- FAQ 8 -->
                        <div>
                            <details class="group">
                                <summary class="flex items-center justify-between cursor-pointer text-gray-800 font-medium hover:text-blue-600 transition">
                                    <span>How do I contact customer support?</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <p class="mt-2 text-gray-600 text-sm">You can reach us via email at support@technova.com.np, call us at +977 1-555-1234, or use the live chat on our website.</p>
                            </details>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact Details & Emergency Box -->
        <div class="grid lg:grid-cols-2 gap-8 mb-10">
            <!-- Contact Details -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition transform hover:-translate-y-1 hover:shadow-xl duration-300 p-6 md:p-8">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Contact Details</h3>
                        <ul class="mt-4 space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span><strong>Office Address:</strong> Kathmandu, Nepal</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span><strong>Phone:</strong> +977 1-555-1234</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span><strong>Email:</strong> support@technova.com.np</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span><strong>Working Hours:</strong> Sun-Fri 9AM-7PM, Sat Closed</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9" />
                                </svg>
                                <span><strong>Website:</strong> <a href="/" class="text-blue-600 hover:underline">technova.com.np</a></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact Box (same style as policy) -->
            <div class="bg-blue-50 rounded-2xl shadow-md border border-blue-200 p-6 md:p-8 transition transform hover:scale-[1.01] duration-300">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Emergency Contact</h3>
                        <div class="mt-3 space-y-3 text-gray-700">
                            <div class="flex items-center justify-between border-b border-blue-200 pb-2">
                                <span class="font-medium">Customer Hotline</span>
                                <span class="text-blue-700 font-semibold">+977 1-555-5678</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-blue-200 pb-2">
                                <span class="font-medium">WhatsApp Support</span>
                                <span class="text-blue-700 font-semibold">+977 980-1234567</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-medium">Emergency Email</span>
                                <span class="text-blue-700 font-semibold">urgent@technova.com.np</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-4">Available 24/7 for urgent assistance.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
   </section>
</x-frontend-layout>
