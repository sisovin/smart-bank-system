<?php
require_once '../vendor/autoload.php';
require_once '../config/constants.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/middleware/AuthMiddleware.php';

// Get current user if authenticated (for header navigation)
$currentUser = AuthMiddleware::getCurrentUser();
$currentPath = $_SERVER['REQUEST_URI'] ?? '';

$authController = new AuthController();
$response = $authController->login();

if (isset($response['success']) && $response['success']) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartBank</title>
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
<body class="bg-white">
    <!-- Header -->
    <?php include '../resources/templates/header.php'; ?>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <div class="mx-auto h-12 w-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-university text-white text-xl"></i>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-black">
                    Sign in to SmartBank
                </h2>
                <?php if (isset($response['error'])): ?>
                    <div class="mt-4 bg-red-50 border-l-4 border-red-500 p-4">
                        <p class="text-red-700"><?php echo htmlspecialchars($response['error']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <form class="mt-8 space-y-6" method="POST">
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="username" class="sr-only">Username</label>
                        <input id="username" name="username" type="text" autocomplete="username" required
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                               placeholder="Username">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                               placeholder="Password">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-black">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-700 hover:text-blue-600">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" name="login_submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sign in
                    </button>
                </div>
                
                <div class="text-center">
                    <p class="text-sm text-gray-700">
                        Don't have an account? 
                        <a href="register.php" class="font-medium text-blue-700 hover:text-blue-600">
                            Sign up here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <!-- Footer -->
    <?php include '../resources/templates/footer.php'; ?>
</body>
</html>