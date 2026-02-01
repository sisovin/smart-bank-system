<!-- Hero Section -->
<section id="home" class="relative overflow-hidden gradient-bg text-white py-10 pb-10">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 0%, transparent 50%);"></div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-20 left-10 animate-bounce">
        <div class="bg-white/20 backdrop-blur-sm p-3 rounded-full">
            <i class="fas fa-shield-alt text-white text-xl"></i>
        </div>
    </div>
    <div class="absolute top-32 right-16 animate-pulse">
        <div class="bg-white/20 backdrop-blur-sm p-3 rounded-full">
            <i class="fas fa-lock text-white text-xl"></i>
        </div>
    </div>
    <div class="absolute bottom-32 left-20 animate-ping">
        <div class="bg-white/20 backdrop-blur-sm p-3 rounded-full">
            <i class="fas fa-mobile-alt text-white text-xl"></i>
        </div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-center lg:text-left">
                <!-- Badge -->
                <div class="inline-flex items-center bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full text-white text-sm font-medium mb-6">
                    <i class="fas fa-star text-yellow-300 mr-2"></i>
                    #1 Digital Banking Platform
                </div>

                <!-- Main Headline -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    Smart Banking for a
                    <span class="text-yellow-300">
                        Smarter Future
                    </span>
                </h1>

                <!-- Subheadline -->
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                    Experience next-generation banking with AI-powered insights, instant transfers, and bank-level security. Join millions who trust SmartBank for their financial journey.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start mb-8">
                    <a href="<?php echo BASE_URL; ?>register"
                       class="group bg-white text-gray-900 hover:bg-gray-50 px-8 py-4 rounded-2xl text-lg font-bold shadow-2xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-rocket mr-3 group-hover:animate-bounce"></i>
                        Get Started Free
                    </a>
                    <a href="#features"
                       class="group bg-transparent border-2 border-white text-white hover:bg-white hover:text-indigo-600 px-8 py-4 rounded-2xl text-lg font-bold transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                        <i class="fas fa-play-circle mr-3 group-hover:animate-pulse"></i>
                        Watch Demo
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div class="flex flex-wrap justify-center lg:justify-start items-center gap-6 text-white">
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt text-green-300 mr-2"></i>
                        <span class="text-sm font-medium">Bank-Level Security</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock text-yellow-300 mr-2"></i>
                        <span class="text-sm font-medium">24/7 Support</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-globe text-blue-300 mr-2"></i>
                        <span class="text-sm font-medium">Global Access</span>
                    </div>
                </div>
            </div>

            <!-- Right Content - App Mockup -->
            <div class="relative">
                <!-- Main Phone Mockup -->
                <div class="relative mx-auto max-w-sm">
                    <!-- Phone Frame -->
                    <div class="bg-gray-900 rounded-3xl p-4 shadow-2xl border-4 border-gray-800">
                        <!-- Screen -->
                        <div class="bg-white rounded-2xl p-6 h-96 flex flex-col">
                            <!-- Header -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 gradient-bg rounded-full border-2 border-blue-600 shadow flex items-center justify-center mb-4">
                                        <i class="fas fa-university text-white text-xl"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <h1 class="text-xl font-bold text-gray-900 text-sm">SmartBank</h1>
                                        <p class="text-xs text-gray-900 hidden sm:block">Secure Banking</p>>
                                    </div>
                                </div>
                                <i class="fas fa-wifi text-gray-400 text-xs"></i>
                            </div>

                            <!-- Balance Card -->
                            <div class="bg-primary rounded-xl p-4 mb-4 text-white">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm opacity-90 font-medium">Total Balance</span>
                                    <i class="fas fa-eye text-sm opacity-90"></i>
                                </div>
                                <div class="text-2xl font-bold mb-1 text-white">$12,847.32</div>
                                <div class="text-sm opacity-90 font-medium">**** 4567</div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="grid grid-cols-3 gap-3 mb-4">
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <i class="fas fa-arrow-up text-green-500 text-lg mb-1"></i>
                                    <div class="text-xs text-gray-600">Send</div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <i class="fas fa-arrow-down text-blue-500 text-lg mb-1"></i>
                                    <div class="text-xs text-gray-600">Receive</div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <i class="fas fa-credit-card text-purple-500 text-lg mb-1"></i>
                                    <div class="text-xs text-gray-600">Cards</div>
                                </div>
                            </div>

                            <!-- Recent Transactions -->
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Recent Activity</h4>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-plus text-green-700"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">Salary Deposit</div>
                                                <div class="text-xs text-gray-700">Today</div>
                                            </div>
                                        </div>
                                        <span class="text-sm font-bold text-green-700">+$2,500</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-minus text-red-700"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">Grocery Store</div>
                                                <div class="text-xs text-gray-700">Yesterday</div>
                                            </div>
                                        </div>
                                        <span class="text-sm font-bold text-red-700">-$87.32</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Cards -->
                    <div class="absolute -top-4 -right-4 bg-white rounded-xl p-3 shadow-lg animate-bounce">
                        <div class="text-center">
                            <div class="text-lg font-bold text-green-700">$2,500</div>
                            <div class="text-xs text-gray-700 font-medium">This Month</div>
                        </div>
                    </div>

                    <div class="absolute -bottom-4 -left-4 bg-white rounded-xl p-3 shadow-lg animate-pulse">
                        <div class="text-center">
                            <div class="text-lg font-bold text-blue-700">98%</div>
                            <div class="text-xs text-gray-700 font-medium">Satisfaction</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#features" class="text-white hover:text-blue-200 transition-colors">
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
    </div>
</section>