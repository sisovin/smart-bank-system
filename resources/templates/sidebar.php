<!-- Sidebar -->
<div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl transform transition-all duration-300 ease-in-out lg:translate-x-0 <?php echo isset($_SESSION['sidebar_collapsed']) && $_SESSION['sidebar_collapsed'] ? '-translate-x-full' : ''; ?>">
    <div class="flex flex-col h-full">
        <!-- Header -->
        <div class="flex items-center justify-between h-16 px-4 bg-gradient-to-r from-primary to-secondary shadow-sm">
            <div class="flex items-center space-x-3">
                <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                    <i class="fas fa-university text-white text-lg"></i>
                </div>
                <h1 class="text-xl font-bold text-white"><?php echo APP_NAME; ?></h1>
            </div>
            <button id="sidebarToggle" class="lg:hidden text-white hover:bg-white hover:bg-opacity-20 p-2 rounded-lg transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- User Profile Section -->
        <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                        <?php echo strtoupper(substr($_SESSION['user']['username'], 0, 1)); ?>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">
                        <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                    </p>
                    <p class="text-xs text-gray-600 capitalize">
                        <?php
                        $roleNames = [
                            ROLE_ADMIN => 'Administrator',
                            ROLE_TELLER => 'Bank Teller',
                            ROLE_CUSTOMER => 'Customer'
                        ];
                        echo $roleNames[$_SESSION['user']['role']] ?? 'User';
                        ?>
                    </p>
                </div>
            </div>

            <!-- Quick Stats for Staff/Admin -->
            <?php if (in_array($_SESSION['user']['role'], [ROLE_ADMIN, ROLE_TELLER])): ?>
            <div class="mt-3 grid grid-cols-2 gap-2">
                <div class="bg-white p-2 rounded-lg text-center">
                    <div class="text-lg font-bold text-primary"><?php echo rand(5, 25); ?></div>
                    <div class="text-xs text-gray-600">In Queue</div>
                </div>
                <div class="bg-white p-2 rounded-lg text-center">
                    <div class="text-lg font-bold text-secondary"><?php echo rand(10, 50); ?></div>
                    <div class="text-xs text-gray-600">Processed</div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <?php
            $currentPage = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
            $userRole = $_SESSION['user']['role'];

            // Helper function to check active state
            if (!function_exists('isActive')) {
                function isActive($pages) {
                    if (!isset($_SERVER['REQUEST_URI'])) {
                        return 'text-gray-700 hover:bg-gray-100 hover:text-primary';
                    }
                    $uri = $_SERVER['REQUEST_URI'];
                    $path = parse_url($uri, PHP_URL_PATH);
                    if ($path === null) {
                        $path = $uri; // Fallback if parse_url fails
                    }
                    $current = basename($path);
                    return in_array($current, (array)$pages) ? 'bg-primary bg-opacity-10 text-primary border-r-4 border-primary' : 'text-gray-700 hover:bg-gray-100 hover:text-primary';
                }
            }
            ?>

            ?>

            <!-- Dashboard - All Roles -->
            <a href="<?php echo BASE_URL; ?>dashboard"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                <i class="fas fa-tachometer-alt mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Dashboard</span>
                <?php if ($userRole === ROLE_ADMIN): ?>
                <span class="ml-auto bg-primary text-white text-xs px-2 py-1 rounded-full">Live</span>
                <?php endif; ?>
            </a>

            <?php if ($userRole === ROLE_ADMIN): ?>
            <!-- Admin Navigation -->
            <div class="pt-4">
                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Management</h3>
                <a href="<?php echo BASE_URL; ?>admin/users" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-users mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">User Management</span>
                </a>
                <a href="<?php echo BASE_URL; ?>admin/accounts" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-credit-card mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Account Management</span>
                </a>
                <a href="<?php echo BASE_URL; ?>admin/transactions" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-exchange-alt mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Transaction Monitoring</span>
                </a>
            </div>
            <div class="pt-4">
                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Analytics</h3>
                <a href="<?php echo BASE_URL; ?>admin/reports" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-chart-bar mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Reports & Analytics</span>
                </a>
                <a href="<?php echo BASE_URL; ?>admin/audit" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-shield-alt mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Audit & Security</span>
                </a>
            </div>
            <?php endif; ?>

            <?php if ($userRole === ROLE_TELLER): ?>
            <!-- Teller Navigation -->
            <div class="pt-4">
                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Customer Service</h3>
                <a href="<?php echo BASE_URL; ?>teller/customers" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-user-friends mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Customer Lookup</span>
                </a>
                <a href="<?php echo BASE_URL; ?>teller/queue" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-clock mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Service Queue</span>
                </a>
            </div>
            <div class="pt-4">
                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Transactions</h3>
                <a href="<?php echo BASE_URL; ?>teller/transactions" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-exchange-alt mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Process Transactions</span>
                </a>
                <a href="<?php echo BASE_URL; ?>teller/accounts" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-plus-circle mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Open Accounts</span>
                </a>
            </div>
            <?php endif; ?>

            <?php if ($userRole === ROLE_CUSTOMER): ?>
            <!-- Customer Navigation -->
            <div class="pt-4">
                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Banking</h3>
                <a href="<?php echo BASE_URL; ?>accounts" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-credit-card mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">My Accounts</span>
                </a>
                <a href="<?php echo BASE_URL; ?>transactions" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-exchange-alt mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Transactions</span>
                </a>
                <a href="<?php echo BASE_URL; ?>transfer" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-paper-plane mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Transfer Money</span>
                </a>
                <a href="<?php echo BASE_URL; ?>paybills" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-file-invoice-dollar mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Pay Bills</span>
                </a>
            </div>
            <div class="pt-4">
                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Services</h3>
                <a href="<?php echo BASE_URL; ?>cards" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-credit-card mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Cards & Loans</span>
                </a>
                <a href="<?php echo BASE_URL; ?>investments" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-chart-line mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Investments</span>
                </a>
                <a href="<?php echo BASE_URL; ?>support" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-headset mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Support</span>
                </a>
            </div>
            <?php endif; ?>

            <!-- Common Navigation -->
            <div class="pt-4 border-t border-gray-200 mt-4">
                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Account</h3>
                <a href="<?php echo BASE_URL; ?>profile" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-user mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Profile</span>
                </a>
                <a href="<?php echo BASE_URL; ?>settings" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-cog mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Settings</span>
                </a>
            </div>
        </nav>

        <!-- Footer -->
        <div class="border-t border-gray-200 p-4 bg-gray-50">
            <div class="flex items-center justify-between mb-3">
                <div class="text-xs text-gray-600">
                    <i class="fas fa-clock mr-1"></i>
                    <?php echo date('H:i'); ?>
                </div>
                <div class="text-xs text-gray-600">
                    <i class="fas fa-calendar mr-1"></i>
                    <?php echo date('M j'); ?>
                </div>
            </div>

            <form action="<?php echo BASE_URL; ?>logout" method="POST" class="w-full">
                <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    <span class="font-medium">Logout</span>
                </button>
            </form>

            <!-- Version Info -->
            <div class="mt-3 text-center">
                <p class="text-xs text-gray-500"><?php echo APP_NAME; ?> v<?php echo APP_VERSION; ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="closeSidebar()"></div>

<!-- Sidebar Toggle Button (Mobile) -->
<button id="mobileSidebarToggle"
        class="fixed top-4 left-4 z-30 lg:hidden bg-primary text-white p-3 rounded-lg shadow-lg hover:bg-blue-700 transition-colors">
    <i class="fas fa-bars"></i>
</button>

<script>
// Sidebar functionality
function openSidebar() {
    document.getElementById('sidebar').classList.remove('-translate-x-full');
    document.getElementById('sidebarOverlay').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeSidebar() {
    document.getElementById('sidebar').classList.add('-translate-x-full');
    document.getElementById('sidebarOverlay').classList.add('hidden');
    document.body.style.overflow = '';
}

// Event listeners
document.getElementById('mobileSidebarToggle').addEventListener('click', openSidebar);
document.getElementById('sidebarToggle').addEventListener('click', closeSidebar);

// Close sidebar on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeSidebar();
    }
});

// Handle responsive behavior
window.addEventListener('resize', function() {
    if (window.innerWidth >= 1024) { // lg breakpoint
        closeSidebar();
        document.getElementById('sidebar').classList.remove('-translate-x-full');
    } else {
        document.getElementById('sidebar').classList.add('-translate-x-full');
    }
});

// Auto-refresh queue counts for staff/admin (simulate real-time updates)
<?php if (in_array($_SESSION['user']['role'], [ROLE_ADMIN, ROLE_TELLER])): ?>
setInterval(function() {
    // In a real app, this would fetch from an API
    const queueElements = document.querySelectorAll('.queue-count');
    queueElements.forEach(el => {
        const current = parseInt(el.textContent);
        const newCount = Math.max(0, current + (Math.random() > 0.7 ? 1 : Math.random() > 0.8 ? -1 : 0));
        el.textContent = newCount;
        el.classList.toggle('animate-pulse', newCount > current);
    });
}, 30000); // Update every 30 seconds
<?php endif; ?>
</script>

<style>
/* Custom scrollbar for sidebar */
nav::-webkit-scrollbar {
    width: 4px;
}

nav::-webkit-scrollbar-track {
    background: #f1f5f9;
}

nav::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 2px;
}

nav::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Active navigation animation */
.sidebar-link-active {
    animation: slideInRight 0.3s ease-out;
}

@keyframes slideInRight {
    from {
        transform: translateX(-10px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Hover effects */
.sidebar-link:hover .fa-icon {
    transform: scale(1.1);
}

/* Notification badge animation */
.notification-badge {
    animation: bounce 0.6s ease-in-out;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-3px);
    }
    60% {
        transform: translateY(-2px);
    }
}
</style>
