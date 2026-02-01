    <!-- Header -->
    <header class="bg-green-600 shadow-lg sticky top-0 z-50">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo and Brand -->
                <div class="flex items-center">
                    <a href="<?php echo BASE_URL; ?>" class="flex items-center space-x-3">
                        <div class="w-10 h-10 gradient-bg rounded-full border-2 border-white shadow flex items-center justify-center">
                            <i class="fas fa-university text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-white"><?php echo APP_NAME; ?></h1>
                            <p class="text-xs text-blue-600 hidden sm:block">Secure Banking</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <?php if ($currentUser): ?>
                        <!-- Authenticated User Navigation -->
                        <?php if ($currentUser['role'] === 'customer'): ?>
                            <!-- Customer Navigation -->
                            <a href="<?php echo BASE_URL; ?>dashboard"
                               class="nav-link px-3 py-2 text-sm font-medium <?php echo strpos($currentPath, '/dashboard') !== false ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'; ?>">
                                <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                            </a>
                            <a href="<?php echo BASE_URL; ?>accounts"
                               class="nav-link px-3 py-2 text-sm font-medium <?php echo strpos($currentPath, '/accounts') !== false ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'; ?>">
                                <i class="fas fa-credit-card mr-1"></i>Accounts
                            </a>
                            <a href="<?php echo BASE_URL; ?>transactions"
                               class="nav-link px-3 py-2 text-sm font-medium <?php echo strpos($currentPath, '/transactions') !== false ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'; ?>">
                                <i class="fas fa-exchange-alt mr-1"></i>Transactions
                            </a>
                        <?php elseif ($currentUser['role'] === 'teller'): ?>
                            <!-- Teller Navigation -->
                            <a href="<?php echo BASE_URL; ?>staff/dashboard"
                               class="nav-link px-3 py-2 text-sm font-medium <?php echo strpos($currentPath, '/staff') !== false ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'; ?>">
                                <i class="fas fa-user-tie mr-1"></i>Staff Dashboard
                            </a>
                            <a href="<?php echo BASE_URL; ?>staff/customers"
                               class="nav-link px-3 py-2 text-sm font-medium text-gray-700 hover:text-primary">
                                <i class="fas fa-users mr-1"></i>Customers
                            </a>
                        <?php elseif ($currentUser['role'] === 'admin'): ?>
                            <!-- Admin Navigation -->
                            <a href="<?php echo BASE_URL; ?>admin/dashboard"
                               class="nav-link px-3 py-2 text-sm font-medium <?php echo strpos($currentPath, '/admin') !== false ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'; ?>">
                                <i class="fas fa-cog mr-1"></i>Admin Panel
                            </a>
                            <a href="<?php echo BASE_URL; ?>admin/users"
                               class="nav-link px-3 py-2 text-sm font-medium text-gray-700 hover:text-primary">
                                <i class="fas fa-user-shield mr-1"></i>Users
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- Public Navigation -->
                        <a href="<?php echo BASE_URL; ?>"
                           class="nav-link px-3 py-2 text-sm font-medium <?php echo $currentPath === '/' || $currentPath === '' ? 'text-white border-b-2 border-white' : 'text-green-100 hover:text-white'; ?>">
                            <i class="fas fa-home mr-1"></i>Home
                        </a>
                         <!--Features -->
                        <a href="<?php echo BASE_URL; ?>features"
                           class="nav-link px-3 py-2 text-sm font-medium text-green-100 hover:text-white">
                            <i class="fas fa-star mr-1"></i>Features
                        </a>
                        <!--Customers -->
                        <a href="<?php echo BASE_URL; ?>customers"
                           class="nav-link px-3 py-2 text-sm font-medium text-green-100 hover:text-white">
                            <i class="fas fa-user-circle mr-1"></i>Customers
                        </a>
                        <!--Investors -->
                        <a href="<?php echo BASE_URL; ?>investors"
                           class="nav-link px-3 py-2 text-sm font-medium text-green-100 hover:text-white">
                            <i class="fas fa-hand-holding-usd mr-1"></i>Investors
                        </a>
                         <!--Security -->
                        <a href="<?php echo BASE_URL; ?>security"
                           class="nav-link px-3 py-2 text-sm font-medium text-green-100 hover:text-white">
                            <i class="fas fa-shield-alt mr-1"></i>Security
                        </a>
                         <!--About -->
                        <a href="<?php echo BASE_URL; ?>about"
                           class="nav-link px-3 py-2 text-sm font-medium text-green-100 hover:text-white">
                            <i class="fas fa-info-circle mr-1"></i>About
                        </a>
                            <!--Contact -->
                        <a href="<?php echo BASE_URL; ?>contact"
                           class="nav-link px-3 py-2 text-sm font-medium text-green-100 hover:text-white">
                            <i class="fas fa-envelope mr-1"></i>Contact
                        </a>
                    <?php endif; ?>
                </nav>

                <!-- User Menu / Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <?php if ($currentUser): ?>
                        <!-- User Dropdown -->
                        <div class="relative">
                            <button id="userMenuBtn" class="flex items-center space-x-2 text-gray-700 hover:text-primary focus:outline-none">
                                <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <span class="hidden sm:block text-sm font-medium"><?php echo htmlspecialchars($currentUser['username']); ?></span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="userDropdown" class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($currentUser['username']); ?></p>
                                    <p class="text-xs text-gray-500 capitalize"><?php echo htmlspecialchars($currentUser['role']); ?></p>
                                </div>
                                <a href="<?php echo BASE_URL; ?>profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-circle mr-2"></i>Profile Settings
                                </a>
                                <a href="<?php echo BASE_URL; ?>settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Account Settings
                                </a>
                                <div class="border-t border-gray-200"></div>
                                <form action="<?php echo BASE_URL; ?>logout" method="POST" class="block">
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Auth Buttons -->
                        <div class="hidden sm:flex items-center space-x-3">
                            <a href="login.php"
                               class="px-4 py-2 text-sm font-medium text-white hover:text-green-300 transition duration-200 border border-white rounded-lg hover:bg-white hover:text-green-600">
                                Sign In
                            </a>
                            <a href="register.php"
                               class="bg-white text-green-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-300 transform hover:-translate-y-0.5 transition duration-200">
                                Open Account
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Mobile menu button -->
                    <button id="mobileMenuBtn" class="md:hidden p-2 rounded-md text-white hover:text-green-300 hover:bg-green-700 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobileMenu" class="mobile-menu md:hidden fixed inset-y-0 left-0 w-64 bg-white shadow-xl z-40 transform -translate-x-full">
            <div class="flex flex-col h-full">
                <!-- Mobile Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200">
                    <div class="flex items-center space-x-2">
                        <div class="bg-gradient-to-r from-primary to-secondary p-2 rounded-lg">
                            <i class="fas fa-university text-white text-lg"></i>
                        </div>
                        <span class="font-bold text-gray-900"><?php echo APP_NAME; ?></span>
                    </div>
                    <button id="closeMobileMenu" class="p-2 rounded-md text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Mobile Navigation Links -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <?php if ($currentUser): ?>
                        <!-- Mobile Authenticated Navigation -->
                        <div class="pb-4 mb-4 border-b border-gray-200">
                            <div class="flex items-center space-x-3 px-3 py-2">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($currentUser['username']); ?></p>
                                    <p class="text-xs text-gray-500 capitalize"><?php echo htmlspecialchars($currentUser['role']); ?></p>
                                </div>
                            </div>
                        </div>

                        <?php if ($currentUser['role'] === 'customer'): ?>
                            <a href="<?php echo BASE_URL; ?>dashboard" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-primary">
                                <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                            </a>
                            <a href="<?php echo BASE_URL; ?>accounts" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-primary">
                                <i class="fas fa-credit-card mr-3"></i>My Accounts
                            </a>
                            <a href="<?php echo BASE_URL; ?>transactions" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-primary">
                                <i class="fas fa-exchange-alt mr-3"></i>Transactions
                            </a>
                        <?php elseif ($currentUser['role'] === 'teller'): ?>
                            <a href="<?php echo BASE_URL; ?>staff/dashboard" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-primary">
                                <i class="fas fa-user-tie mr-3"></i>Staff Dashboard
                            </a>
                            <a href="<?php echo BASE_URL; ?>staff/customers" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-primary">
                                <i class="fas fa-users mr-3"></i>Customer Management
                            </a>
                        <?php elseif ($currentUser['role'] === 'admin'): ?>
                            <a href="<?php echo BASE_URL; ?>admin/dashboard" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-primary">
                                <i class="fas fa-cog mr-3"></i>Admin Panel
                            </a>
                            <a href="<?php echo BASE_URL; ?>admin/users" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-primary">
                                <i class="fas fa-user-shield mr-3"></i>User Management
                            </a>
                        <?php endif; ?>

                        <div class="pt-4 mt-4 border-t border-gray-200">
                            <a href="<?php echo BASE_URL; ?>profile" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100">
                                <i class="fas fa-user-circle mr-3"></i>Profile Settings
                            </a>
                            <form action="<?php echo BASE_URL; ?>logout" method="POST">
                                <button type="submit" class="w-full flex items-center px-3 py-3 text-red-600 rounded-lg hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-3"></i>Sign Out
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <!-- Mobile Public Navigation -->
                        <a href="<?php echo BASE_URL; ?>" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-primary">
                            <i class="fas fa-home mr-3"></i>Home
                        </a>
                        <a href="#features" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-primary">
                            <i class="fas fa-star mr-3"></i>Features
                        </a>
                        <a href="#about" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-primary">
                            <i class="fas fa-info-circle mr-3"></i>About
                        </a>
                        <a href="#contact" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-primary">
                            <i class="fas fa-envelope mr-3"></i>Contact
                        </a>

                        <div class="pt-4 mt-4 border-t border-gray-200 space-y-2">
                            <a href="login.php" class="block px-3 py-3 text-center bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                Sign In
                            </a>
                            <a href="register.php" class="block px-3 py-3 text-center bg-white text-green-600 rounded-lg hover:bg-green-50 border border-green-600">
                                Open Account
                            </a>
                        </div>
                    <?php endif; ?>
                </nav>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div id="mobileOverlay" class="mobile-menu md:hidden fixed inset-0 bg-black bg-opacity-50 z-30 -translate-x-full"></div>
    </header>

    