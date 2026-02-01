<?php
require_once '../vendor/autoload.php';
require_once '../config/constants.php';
require_once '../app/middleware/AuthMiddleware.php';
require_once '../app/models/Customer.php';
require_once '../app/models/User.php';

AuthMiddleware::requireAuth();

// Get user data
$user = $_SESSION['user'];

// Get customer data if user is customer
$customer = null;
if ($user['role'] === 'customer') {
    $customerModel = new Customer();
    $customer = $customerModel->findByUserId($user['id']);
}

// Handle profile update
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userModel = new User();
    $customerModel = new Customer();
    
    // Update user info
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
    // Check if username is taken by another user
    $existingUser = $userModel->findByUsername($username);
    if ($existingUser && $existingUser['user_id'] != $user['id']) {
        $message = 'Username already taken';
    } else {
        // Update user
        $userModel->update($user['id'], $username, $email);
        
        // Update customer info if customer
        if ($user['role'] === 'customer' && $customer) {
            $customerData = [
                'first_name' => filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING),
                'last_name' => filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING),
                'date_of_birth' => $_POST['dob'],
                'address' => filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING),
                'phone' => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING)
            ];
            $customerModel->update($customer['customer_id'], $customerData);
            
            // Refresh customer data
            $customer = $customerModel->findByUserId($user['id']);
        }
        
        // Update session
        $_SESSION['user']['username'] = $username;
        $message = 'Profile updated successfully';
        
        // Refresh user data
        $user = $_SESSION['user'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - SmartBank</title>
    <!-- Tailwind CSS -->
    <link href="<?php echo BASE_URL; ?>/assets/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="flex h-screen">
        <aside class="w-64 bg-blue-800 text-white">
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-university text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-xl font-bold">SmartBank</span>
                </div>
            </div>
            
            <nav class="mt-6">
                <a href="dashboard.php" class="block py-3 px-6 hover:bg-blue-700">
                    <i class="fas fa-home mr-3"></i> Dashboard
                </a>
                <?php if ($user['role'] === 'customer'): ?>
                <a href="accounts.php" class="block py-3 px-6 hover:bg-blue-700">
                    <i class="fas fa-wallet mr-3"></i> Accounts
                </a>
                <a href="transactions.php" class="block py-3 px-6 hover:bg-blue-700">
                    <i class="fas fa-exchange-alt mr-3"></i> Transactions
                </a>
                <a href="transfer.php" class="block py-3 px-6 hover:bg-blue-700">
                    <i class="fas fa-paper-plane mr-3"></i> Transfer Funds
                </a>
                <?php elseif ($user['role'] === 'investor'): ?>
                <a href="investments.php" class="block py-3 px-6 hover:bg-blue-700">
                    <i class="fas fa-chart-line mr-3"></i> Investments
                </a>
                <?php endif; ?>
                <a href="profile.php" class="block py-3 px-6 bg-blue-900">
                    <i class="fas fa-user mr-3"></i> Profile
                </a>
                <a href="logout.php" class="block py-3 px-6 hover:bg-blue-700">
                    <i class="fas fa-sign-out-alt mr-3"></i> Logout
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-auto">
            <header class="bg-white shadow">
                <div class="px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-600"><?php echo date('F j, Y'); ?></span>
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Profile Content -->
            <div class="p-6">
                <?php if ($message): ?>
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4">
                        <p class="text-green-700"><?php echo htmlspecialchars($message); ?></p>
                    </div>
                <?php endif; ?>
                
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="px-6 py-4 border-b">
                        <h2 class="text-xl font-bold">Personal Information</h2>
                    </div>
                    
                    <form method="POST" class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? $user['username'] . '@smartbank.com'); ?>" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <?php if ($user['role'] === 'customer' && $customer): ?>
                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($customer['first_name']); ?>" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($customer['last_name']); ?>" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <!-- Date of Birth -->
                            <div>
                                <label for="dob" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($customer['date_of_birth']); ?>" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <textarea id="address" name="address" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($customer['address']); ?></textarea>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Account Info (Read-only) -->
                        <div class="mt-8 pt-6 border-t">
                            <h3 class="text-lg font-semibold mb-4">Account Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Account Type</label>
                                    <input type="text" value="<?php echo ucfirst($user['role']); ?>" readonly
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Member Since</label>
                                    <input type="text" value="<?php echo date('F Y', strtotime('2026-01-01')); ?>" readonly
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-save mr-2"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Security Section -->
                <div class="bg-white rounded-xl shadow overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b">
                        <h2 class="text-xl font-bold">Security Settings</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 border rounded-lg">
                                <div>
                                    <h3 class="font-semibold">Change Password</h3>
                                    <p class="text-sm text-gray-600">Update your account password</p>
                                </div>
                                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                                    Change Password
                                </button>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 border rounded-lg">
                                <div>
                                    <h3 class="font-semibold">Two-Factor Authentication</h3>
                                    <p class="text-sm text-gray-600">Add an extra layer of security</p>
                                </div>
                                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                                    Enable 2FA
                                </button>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 border rounded-lg">
                                <div>
                                    <h3 class="font-semibold">Login History</h3>
                                    <p class="text-sm text-gray-600">View recent login activity</p>
                                </div>
                                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                                    View History
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Profile page interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                }
            });
            
            // Auto-format phone number
            const phoneField = document.getElementById('phone');
            if (phoneField) {
                phoneField.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 10) {
                        value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
                    }
                    e.target.value = value;
                });
            }
        });
    </script>
</body>
</html>