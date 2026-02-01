        </div> <!-- End page content -->
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, rgba(30, 58, 138, 0.1) 0%, transparent 50%), radial-gradient(circle at 75% 75%, rgba(16, 185, 129, 0.1) 0%, transparent 50%);"></div>
        </div>

        <div class="relative w-full mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Footer Content -->
            <div class="py-12 lg:py-16">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12">
                    <!-- Company Info & Branding -->
                    <div class="lg:col-span-4 space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="bg-gradient-to-r from-primary to-secondary p-3 rounded-full border-2 border-blue-600 shadow-lg">
                                <i class="fas fa-university text-white text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold"><?php echo APP_NAME; ?></h2>
                                <p class="text-sm text-gray-400">Smart Banking Solutions</p>
                            </div>
                        </div>

                        <p class="text-gray-300 leading-relaxed text-sm">
                            Empowering your financial future with secure, innovative banking solutions.
                            Experience the next generation of digital banking with SmartBank.
                        </p>

                        <!-- Trust Badges -->
                        <div class="flex flex-wrap gap-3">
                            <div class="flex items-center space-x-2 bg-gray-800 px-3 py-2 rounded-lg">
                                <i class="fas fa-shield-alt text-primary text-sm"></i>
                                <span class="text-xs font-medium">SSL Secured</span>
                            </div>
                            <div class="flex items-center space-x-2 bg-gray-800 px-3 py-2 rounded-lg">
                                <i class="fas fa-lock text-secondary text-sm"></i>
                                <span class="text-xs font-medium">Bank Grade</span>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="flex space-x-4">
                            <a href="#" class="bg-gray-800 hover:bg-primary p-3 rounded-lg transition-all duration-300 transform hover:scale-110 group">
                                <i class="fab fa-facebook-f text-gray-400 group-hover:text-white"></i>
                            </a>
                            <a href="#" class="bg-gray-800 hover:bg-primary p-3 rounded-lg transition-all duration-300 transform hover:scale-110 group">
                                <i class="fab fa-twitter text-gray-400 group-hover:text-white"></i>
                            </a>
                            <a href="#" class="bg-gray-800 hover:bg-primary p-3 rounded-lg transition-all duration-300 transform hover:scale-110 group">
                                <i class="fab fa-linkedin-in text-gray-400 group-hover:text-white"></i>
                            </a>
                            <a href="#" class="bg-gray-800 hover:bg-primary p-3 rounded-lg transition-all duration-300 transform hover:scale-110 group">
                                <i class="fab fa-instagram text-gray-400 group-hover:text-white"></i>
                            </a>
                            <a href="#" class="bg-gray-800 hover:bg-secondary p-3 rounded-lg transition-all duration-300 transform hover:scale-110 group">
                                <i class="fab fa-youtube text-gray-400 group-hover:text-white"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="lg:col-span-2 space-y-6">
                        <h3 class="text-lg font-semibold text-white relative">
                            Quick Links
                            <span class="absolute -bottom-1 left-0 w-8 h-0.5 bg-gradient-to-r from-primary to-secondary"></span>
                        </h3>
                        <nav class="space-y-3">
                            <a href="<?php echo BASE_URL; ?>" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-home mr-2 text-primary opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Home
                            </a>
                            <a href="#about" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-info-circle mr-2 text-primary opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                About Us
                            </a>
                            <a href="#features" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-star mr-2 text-primary opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Features
                            </a>
                            <a href="#careers" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-briefcase mr-2 text-primary opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Careers
                            </a>
                            <a href="#contact" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-envelope mr-2 text-primary opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Contact
                            </a>
                        </nav>
                    </div>

                    <!-- Services -->
                    <div class="lg:col-span-2 space-y-6">
                        <h3 class="text-lg font-semibold text-white relative">
                            Services
                            <span class="absolute -bottom-1 left-0 w-8 h-0.5 bg-gradient-to-r from-primary to-secondary"></span>
                        </h3>
                        <nav class="space-y-3">
                            <a href="#" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-user mr-2 text-secondary opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Personal Banking
                            </a>
                            <a href="#" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-building mr-2 text-secondary opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Business Banking
                            </a>
                            <a href="#" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-mobile-alt mr-2 text-secondary opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Mobile Banking
                            </a>
                            <a href="#" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-chart-line mr-2 text-secondary opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Investments
                            </a>
                            <a href="#" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-credit-card mr-2 text-secondary opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Cards & Loans
                            </a>
                        </nav>
                    </div>

                    <!-- Support -->
                    <div class="lg:col-span-2 space-y-6">
                        <h3 class="text-lg font-semibold text-white relative">
                            Support
                            <span class="absolute -bottom-1 left-0 w-8 h-0.5 bg-gradient-to-r from-primary to-secondary"></span>
                        </h3>
                        <nav class="space-y-3">
                            <a href="#" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-question-circle mr-2 text-accent opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Help Center
                            </a>
                            <a href="#" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-life-ring mr-2 text-accent opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Support
                            </a>
                            <a href="#" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-file-alt mr-2 text-accent opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Documentation
                            </a>
                            <a href="#" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-comments mr-2 text-accent opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Community
                            </a>
                            <a href="#" class="block text-gray-400 hover:text-white transition-colors duration-200 text-sm group">
                                <i class="fas fa-tools mr-2 text-accent opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                API Docs
                            </a>
                        </nav>
                    </div>

                    <!-- Contact & Newsletter -->
                    <div class="lg:col-span-2 space-y-6">
                        <h3 class="text-lg font-semibold text-white relative">
                            Stay Connected
                            <span class="absolute -bottom-1 left-0 w-8 h-0.5 bg-gradient-to-r from-primary to-secondary"></span>
                        </h3>

                        <!-- Newsletter Signup -->
                        <div class="space-y-3">
                            <p class="text-gray-400 text-sm">Get the latest updates and offers</p>
                            <form class="space-y-3">
                                <div class="relative">
                                    <input type="email" placeholder="Enter your email"
                                           class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-primary hover:bg-blue-700 px-3 py-1 rounded text-xs font-medium transition-colors">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Contact Info -->
                        <div class="space-y-2 text-sm text-gray-400">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-phone text-primary"></i>
                                <span>1-800-SMARTBANK</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-envelope text-primary"></i>
                                <span>support@smartbank.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security & Compliance Section -->
            <div class="border-t border-gray-800 py-8">
                <div class="text-center mb-6">
                    <h4 class="text-lg font-semibold text-white mb-4">Trusted & Secure</h4>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center group">
                        <div class="bg-gray-800 group-hover:bg-gray-700 p-4 rounded-xl transition-colors duration-300 mx-auto w-16 h-16 flex items-center justify-center mb-3">
                            <i class="fas fa-shield-alt text-2xl text-primary"></i>
                        </div>
                        <h5 class="font-medium text-white text-sm mb-1">SSL Encrypted</h5>
                        <p class="text-gray-400 text-xs">256-bit encryption</p>
                    </div>

                    <div class="text-center group">
                        <div class="bg-gray-800 group-hover:bg-gray-700 p-4 rounded-xl transition-colors duration-300 mx-auto w-16 h-16 flex items-center justify-center mb-3">
                            <i class="fas fa-lock text-2xl text-secondary"></i>
                        </div>
                        <h5 class="font-medium text-white text-sm mb-1">Bank-Level Security</h5>
                        <p class="text-gray-400 text-xs">FDIC insured</p>
                    </div>

                    <div class="text-center group">
                        <div class="bg-gray-800 group-hover:bg-gray-700 p-4 rounded-xl transition-colors duration-300 mx-auto w-16 h-16 flex items-center justify-center mb-3">
                            <i class="fas fa-check-circle text-2xl text-accent"></i>
                        </div>
                        <h5 class="font-medium text-white text-sm mb-1">PCI DSS Compliant</h5>
                        <p class="text-gray-400 text-xs">Payment card industry</p>
                    </div>

                    <div class="text-center group">
                        <div class="bg-gray-800 group-hover:bg-gray-700 p-4 rounded-xl transition-colors duration-300 mx-auto w-16 h-16 flex items-center justify-center mb-3">
                            <i class="fas fa-user-shield text-2xl text-primary"></i>
                        </div>
                        <h5 class="font-medium text-white text-sm mb-1">Fraud Protection</h5>
                        <p class="text-gray-400 text-xs">24/7 monitoring</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 py-6">
                <div class="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0">
                    <!-- Copyright -->
                    <div class="text-center lg:text-left">
                        <p class="text-gray-400 text-sm">
                            © <?php echo date('Y'); ?> <span class="text-white font-medium"><?php echo APP_NAME; ?></span>.
                            All rights reserved. | Licensed by <a href="https://www.nbc.org.kh" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors duration-200">the National Bank of Cambodia</a>
                        </p>
                    </div>

                    <!-- Legal Links -->
                    <div class="flex flex-wrap justify-center lg:justify-end space-x-6 text-sm">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Terms of Service</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Cookie Policy</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Accessibility</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Sitemap</a>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="mt-4 pt-4 border-t border-gray-800">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0 text-xs text-gray-500">
                        <div class="flex flex-wrap justify-center md:justify-start space-x-4">
                            <span>Member FDIC</span>
                            <span>Equal Housing Lender</span>
                            <span>NCUA Insured</span>
                        </div>
                        <div class="text-center md:text-right">
                            <span>Last updated: <?php echo date('F j, Y'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Top Button -->
        <button id="backToTop"
                class="fixed bottom-6 right-6 bg-gradient-to-r from-primary to-secondary text-white p-4 rounded-full shadow-lg opacity-0 invisible transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1 hover:scale-110 z-50 group"
                aria-label="Back to top">
            <i class="fas fa-arrow-up group-hover:animate-bounce"></i>
        </button>

        <!-- Floating Action Button for Mobile -->
        <button id="mobileHelp"
                class="fixed bottom-6 left-6 bg-gradient-to-r from-secondary to-accent text-white p-4 rounded-full shadow-lg opacity-0 invisible transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1 hover:scale-110 z-50 lg:hidden group"
                aria-label="Get help">
            <i class="fas fa-question group-hover:animate-pulse"></i>
        </button>
    </footer>

    <!-- Additional JavaScript -->
    <script>
        // Back to Top Button
        const backToTopBtn = document.getElementById('backToTop');
        const mobileHelpBtn = document.getElementById('mobileHelp');

        function toggleBackToTop() {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.remove('opacity-0', 'invisible');
                mobileHelpBtn.classList.remove('opacity-0', 'invisible');
            } else {
                backToTopBtn.classList.add('opacity-0', 'invisible');
                mobileHelpBtn.classList.add('opacity-0', 'invisible');
            }
        }

        window.addEventListener('scroll', toggleBackToTop);

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Mobile Help Button
        mobileHelpBtn.addEventListener('click', () => {
            // You can implement a help modal or redirect to help page
            alert('Need help? Contact our support team at 1-800-SMARTBANK or support@smartbank.com');
        });

        // Add loading states for forms
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.disabled = true;
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';

                        // Re-enable after 10 seconds as fallback
                        setTimeout(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        }, 10000);
                    }
                });
            });
        });

        // Newsletter form handling
        document.addEventListener('DOMContentLoaded', function() {
            const newsletterForm = document.querySelector('form');
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const emailInput = this.querySelector('input[type="email"]');
                    const submitBtn = this.querySelector('button[type="submit"]');

                    if (emailInput && emailInput.value) {
                        // Here you would typically send the email to your backend
                        submitBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Subscribed!';
                        submitBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                        submitBtn.disabled = true;

                        // Reset after 3 seconds
                        setTimeout(() => {
                            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
                            submitBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
                            submitBtn.disabled = false;
                            emailInput.value = '';
                        }, 3000);
                    }
                });
            }
        });

        // Smooth transitions for page loads
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('opacity-0');
            setTimeout(() => {
                document.body.classList.remove('opacity-0');
                document.body.classList.add('transition-opacity', 'duration-500');
            }, 100);
        });

        // Add intersection observer for animations
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in');
                    }
                });
            }, observerOptions);

            // Observe footer sections
            document.querySelectorAll('.space-y-6').forEach(section => {
                observer.observe(section);
            });
        }

        // Add keyboard navigation support
        document.addEventListener('keydown', function(e) {
            // Escape key closes any open modals/dropdowns
            if (e.key === 'Escape') {
                // Close any open dropdowns or modals
                document.querySelectorAll('.dropdown-menu.show').forEach(dropdown => {
                    dropdown.classList.remove('show');
                });
            }
        });
    </script>

    <!-- Add some custom CSS for animations -->
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out forwards;
        }

        /* Ensure footer links are accessible */
        footer a:focus {
            outline: 2px solid #3B82F6;
            outline-offset: 2px;
        }

        /* Improve mobile touch targets */
        @media (max-width: 768px) {
            footer a, footer button {
                min-height: 44px;
                min-width: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        /* Print styles */
        @media print {
            footer {
                display: none !important;
            }
        }
    </style>
</body>
</html>
