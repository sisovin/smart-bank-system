<?php
$pageTitle = 'Smart Banking for a Smarter Future';
require_once '../config/constants.php';
require_once '../app/middleware/AuthMiddleware.php';
?>
<?php
// Get current user if authenticated
$currentUser = AuthMiddleware::getCurrentUser();
$currentPath = $_SERVER['REQUEST_URI'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - <?php echo $pageTitle ?? 'Smart Banking for a Smarter Future'; ?></title>

    <!-- Tailwind CSS -->
    
     <!-- Custom CSS -->
    <link href="<?php echo BASE_URL; ?>/assets/css/main.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom styles -->
    <style>        
        .gradient-bg {
            background: linear-gradient(135deg, #1E3A8A 0%, #10B981 100%);
        }
        .gradient-text {
            background: linear-gradient(90deg, #10B981 0%, #F59E0B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hover-lift {
            transition: transform 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
        }
        .nav-link {
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            transform: translateY(-1px);
        }
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        .mobile-menu.open {
            transform: translateX(0);
        }
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-50">

<?php include __DIR__ . '/../resources/templates/header.php'; ?>

<!-- Main Content Container -->
    <main class="flex-1">
        <!-- Flash Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span><?php echo htmlspecialchars($_SESSION['success']); ?></span>
                    <button onclick="this.parentElement.style.display='none'" class="ml-auto text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span><?php echo htmlspecialchars($_SESSION['error']); ?></span>
                    <button onclick="this.parentElement.style.display='none'" class="ml-auto text-red-700 hover:text-red-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Page Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    </main>

    <!-- JavaScript for Mobile Menu and Dropdown -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeMobileMenu = document.getElementById('closeMobileMenu');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileOverlay = document.getElementById('mobileOverlay');

        function toggleMobileMenu() {
            mobileMenu.classList.toggle('open');
            mobileOverlay.classList.toggle('open');
            document.body.classList.toggle('overflow-hidden');
        }

        mobileMenuBtn.addEventListener('click', toggleMobileMenu);
        closeMobileMenu.addEventListener('click', toggleMobileMenu);
        mobileOverlay.addEventListener('click', toggleMobileMenu);

        // User Dropdown Toggle
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');

        if (userMenuBtn && userDropdown) {
            userMenuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                userDropdown.classList.remove('show');
            });

            // Close dropdown when pressing Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    userDropdown.classList.remove('show');
                }
            });
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            const flashMessages = document.querySelectorAll('.bg-green-100, .bg-red-100');
            flashMessages.forEach(message => {
                message.style.transition = 'opacity 0.5s ease';
                message.style.opacity = '0';
                setTimeout(() => message.style.display = 'none', 500);
            });
        }, 5000);
    </script>
    
    <?php include __DIR__ . '/../resources/templates/footer.php'; ?>

</body>
</html>
