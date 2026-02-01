<?php
$pageTitle = 'Smart Banking for a Smarter Future';
require_once '../config/constants.php';
require_once '../app/middleware/AuthMiddleware.php';

// Get current user if authenticated (for header navigation)
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
    <link href="<?php echo BASE_URL; ?>/assets/css/main.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom styles -->
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1E3A8A 0%, #10B981 100%);
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

<?php include '../resources/templates/header.php'; ?>

<!-- Hero Section -->
<?php require_once '../components/hero_section.php'; ?>

<!-- Features Section -->
<?php require_once '../components/features_section.php'; ?>


<!-- Customer & Investor Benefits Section -->
<?php require_once '../components/benefits_section.php'; ?>

<!-- Trust & Compliance Section -->
<?php require_once '../components/trust_section.php'; ?>


<!-- Call-to-Action Section -->
<?php require_once '../components/cta_section.php'; ?>

<!-- Investor Portal Section (Hidden by default, shown when clicked) -->
<?php require_once '../components/investor_portal.php'; ?>

<!-- Landing Page Specific JavaScript -->

<script>
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if(targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if(targetElement) {
                // Show investor portal if that's the target
                if(targetId === '#investor-portal') {
                    targetElement.classList.remove('hidden');
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                } else {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // Intersection Observer for animations
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

        // Observe sections for animation
        document.querySelectorAll('section > div').forEach(section => {
            observer.observe(section);
        });
    }

    // Add loading animation for CTA buttons
    document.querySelectorAll('.group').forEach(button => {
        button.addEventListener('click', function() {
            if(this.href && !this.href.includes('#')) {
                this.innerHTML += '<span class="ml-2"><i class="fas fa-spinner fa-spin"></i></span>';
            }
        });
    });

    // Hero section parallax effect (subtle)
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('#home');
        if(hero) {
            hero.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });

    // Add some custom CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }

        /* Enhanced hover effects */
        .hover-lift:hover {
            transform: translateY(-8px) scale(1.02);
        }

        /* Gradient text animation */
        .gradient-text {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .hover-lift:hover {
                transform: none;
            }
        }
    `;
    document.head.appendChild(style);
</script>
<?php include '../resources/templates/footer.php'; ?>
</body>
</html>

