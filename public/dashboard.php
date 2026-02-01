<?php
require_once '../vendor/autoload.php';
require_once '../config/constants.php';
require_once '../app/middleware/AuthMiddleware.php';
require_once '../app/models/Customer.php';
require_once '../app/models/Account.php';
AuthMiddleware::requireAuth();

// Get user data
$user = $_SESSION['user'];

// Initialize variables
$customer = null;
$accounts = [];
$totalBalance = 0;
$accountCount = 0;
$recentTransactions = [];
$monthTransactions = 0;

if ($user['role'] === 'customer') {
    // Get customer data
    $customerModel = new Customer();
    $customer = $customerModel->findByUserId($user['id']);
    
    if ($customer) {
        // Get accounts
        $accountModel = new Account();
        $accounts = $accountModel->getByCustomer($customer['customer_id']);
        
        // Calculate totals
        $accountCount = count($accounts);
        foreach ($accounts as $account) {
            $totalBalance += $account['balance'];
        }
        
        // Get recent transactions (last 30 days)
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT t.*, a.account_number 
                FROM transactions t 
                JOIN accounts a ON t.from_account_id = a.account_id OR t.to_account_id = a.account_id 
                WHERE a.customer_id = :customer_id 
                AND t.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) 
                ORDER BY t.created_at DESC LIMIT 10";
        $stmt = $db->prepare($sql);
        $stmt->execute([':customer_id' => $customer['customer_id']]);
        $recentTransactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Count transactions this month
        $sql = "SELECT COUNT(*) as count FROM transactions t 
                JOIN accounts a ON t.from_account_id = a.account_id OR t.to_account_id = a.account_id 
                WHERE a.customer_id = :customer_id 
                AND MONTH(t.created_at) = MONTH(NOW()) 
                AND YEAR(t.created_at) = YEAR(NOW())";
        $stmt = $db->prepare($sql);
        $stmt->execute([':customer_id' => $customer['customer_id']]);
        $monthTransactions = $stmt->fetchColumn();
    }
} elseif ($user['role'] === 'investor') {
    // For investors, no customer data, accounts, etc.
    // Perhaps in future, add investor-specific data
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SmartBank</title>
    <!-- Tailwind CSS -->
    <link href="<?php echo BASE_URL; ?>/assets/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .account-card {
            background: linear-gradient(135deg, #1E3A8A 0%, #10B981 100%);
            border-radius: 12px;
            color: white;
        }
        .mobile-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 8px 0;
            z-index: 50;
        }
        .mobile-nav a {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px;
            color: #6b7280;
            text-decoration: none;
            font-size: 12px;
        }
        .mobile-nav a.active {
            color: #1E3A8A;
        }
        .mobile-nav i {
            font-size: 20px;
            margin-bottom: 4px;
        }
        @media (min-width: 768px) {
            .mobile-nav {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Header -->
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="<?php echo BASE_URL; ?>" class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-university text-white text-sm"></i>
                        </div>
                        <span class="text-lg font-bold text-gray-900 hidden sm:block">SmartBank</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="#" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Dashboard</a>
                    <a href="accounts.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Accounts</a>
                    <a href="transactions.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Transactions</a>
                    <?php if ($user['role'] === 'customer'): ?>
                    <a href="transfer.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Transfer</a>
                    <?php endif; ?>
                </nav>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- Notifications -->
                    <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 relative">
                        <i class="fas fa-bell"></i>
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full text-xs"></span>
                    </button>

                    <!-- Profile -->
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 hidden sm:block"><?php echo htmlspecialchars($user['first_name'] ?? $user['username']); ?></span>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button class="md:hidden p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar (Desktop) -->
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0 md:pt-16">
        <div class="flex-1 flex flex-col min-h-0 bg-white border-r border-gray-200">
            <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                <nav class="flex-1 px-2 space-y-1">
                    <a href="#" class="bg-blue-50 border-blue-500 text-blue-700 group flex items-center px-2 py-2 text-sm font-medium border-l-4">
                        <i class="fas fa-home mr-3 text-blue-500"></i>
                        Dashboard
                    </a>
                    <a href="accounts.php" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium border-l-4 border-transparent">
                        <i class="fas fa-wallet mr-3 text-gray-400"></i>
                        Accounts
                    </a>
                    <a href="transactions.php" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium border-l-4 border-transparent">
                        <i class="fas fa-exchange-alt mr-3 text-gray-400"></i>
                        Transactions
                    </a>
                    <?php if ($user['role'] === 'customer'): ?>
                    <a href="transfer.php" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium border-l-4 border-transparent">
                        <i class="fas fa-paper-plane mr-3 text-gray-400"></i>
                        Transfer Funds
                    </a>
                    <?php elseif ($user['role'] === 'investor'): ?>
                    <a href="investments.php" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium border-l-4 border-transparent">
                        <i class="fas fa-chart-line mr-3 text-gray-400"></i>
                        Investments
                    </a>
                    <?php endif; ?>
                    <a href="profile.php" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium border-l-4 border-transparent">
                        <i class="fas fa-user mr-3 text-gray-400"></i>
                        Profile
                    </a>
                    <a href="logout.php" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium border-l-4 border-transparent">
                        <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i>
                        Logout
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="md:pl-64">
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Welcome Section -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                        Welcome back, <?php echo htmlspecialchars($user['first_name'] ?? $user['username']); ?>!
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Here's what's happening with your <?php echo $user['role'] === 'investor' ? 'investments' : 'accounts'; ?> today.
                    </p>
                </div>

                <?php if ($user['role'] === 'customer' && !empty($accounts)): ?>
                <!-- Quick Actions Bar -->
                <div class="mb-8">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-6">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h2>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <a href="transfer.php" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-paper-plane text-2xl text-blue-600 mb-2"></i>
                                    <span class="text-sm font-medium text-gray-900">Transfer</span>
                                </a>
                                <a href="transactions.php" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-receipt text-2xl text-green-600 mb-2"></i>
                                    <span class="text-sm font-medium text-gray-900">Pay Bills</span>
                                </a>
                                <a href="accounts.php" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-plus text-2xl text-purple-600 mb-2"></i>
                                    <span class="text-sm font-medium text-gray-900">New Account</span>
                                </a>
                                <a href="profile.php" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-cog text-2xl text-gray-600 mb-2"></i>
                                    <span class="text-sm font-medium text-gray-900">Settings</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Cards -->
                <div class="mb-8">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Your Accounts</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($accounts as $account): ?>
                        <div class="account-card p-6 shadow-lg">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold"><?php echo ucfirst($account['account_type']); ?> Account</h3>
                                    <p class="text-blue-100 text-sm">****<?php echo substr($account['account_number'], -4); ?></p>
                                </div>
                                <i class="fas fa-wallet text-2xl opacity-75"></i>
                            </div>
                            <div class="mb-4">
                                <p class="text-3xl font-bold">$<?php echo number_format($account['balance'], 2); ?></p>
                                <p class="text-blue-100 text-sm">Available Balance</p>
                            </div>
                            <div class="flex space-x-2">
                                <button class="flex-1 bg-white bg-opacity-20 hover:bg-opacity-30 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                                    View Details
                                </button>
                                <button class="flex-1 bg-white bg-opacity-20 hover:bg-opacity-30 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                                    Transfer
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Recent Activity -->
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Activity</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Your latest transactions and account updates</p>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        <?php if (!empty($recentTransactions)): ?>
                            <?php foreach (array_slice($recentTransactions, 0, 5) as $transaction): ?>
                            <li>
                                <a href="#" class="block hover:bg-gray-50">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 rounded-full flex items-center justify-center 
                                                        <?php echo $transaction['transaction_type'] === 'deposit' ? 'bg-green-100' : 
                                                               ($transaction['transaction_type'] === 'withdrawal' ? 'bg-red-100' : 'bg-blue-100'); ?>">
                                                        <i class="fas <?php echo $transaction['transaction_type'] === 'deposit' ? 'fa-arrow-down' : 
                                                                          ($transaction['transaction_type'] === 'withdrawal' ? 'fa-arrow-up' : 'fa-exchange-alt'); ?> text-sm"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars($transaction['description']); ?>
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        <?php echo date('M j, Y', strtotime($transaction['created_at'])); ?>
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-sm font-semibold 
                                                        <?php echo $transaction['transaction_type'] === 'deposit' ? 'text-green-600' : 
                                                               ($transaction['transaction_type'] === 'withdrawal' ? 'text-red-600' : 'text-gray-900'); ?>">
                                                        <?php echo $transaction['transaction_type'] === 'deposit' ? '+' : 
                                                               ($transaction['transaction_type'] === 'withdrawal' ? '-' : ''); ?>
                                                        $<?php echo number_format($transaction['amount'], 2); ?>
                                                    </p>
                                                    <p class="text-xs text-gray-500 capitalize"><?php echo $transaction['status']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>
                                <div class="px-4 py-8 sm:px-6 text-center">
                                    <i class="fas fa-inbox text-gray-400 text-3xl mb-4"></i>
                                    <p class="text-gray-500">No recent transactions</p>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6">
                        <a href="transactions.php" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            View all transactions <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Insights & Offers (Placeholder) -->
                <?php if ($user['role'] === 'customer'): ?>
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-chart-pie text-2xl text-blue-600"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Spending This Month</dt>
                                        <dd class="text-lg font-medium text-gray-900">$<?php echo number_format($monthTransactions * 100, 2); ?></dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="mt-5">
                                <div class="relative">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">Progress to budget</span>
                                        <span class="text-gray-500">75%</span>
                                    </div>
                                    <div class="mt-2">
                                        <div class="overflow-hidden h-2 text-xs flex rounded-full bg-gray-200">
                                            <div style="width:75%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-gift text-2xl text-green-600"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Special Offer</dt>
                                        <dd class="text-lg font-medium text-gray-900">Cash Back Rewards</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="mt-5">
                                <p class="text-sm text-gray-600">Earn 2% cash back on dining and entertainment purchases this month.</p>
                                <button class="mt-3 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                    Learn More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-nav md:hidden">
        <a href="#" class="active">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="accounts.php">
            <i class="fas fa-wallet"></i>
            <span>Accounts</span>
        </a>
        <a href="transactions.php">
            <i class="fas fa-exchange-alt"></i>
            <span>Transfer</span>
        </a>
        <a href="transfer.php">
            <i class="fas fa-paper-plane"></i>
            <span>Pay</span>
        </a>
        <a href="profile.php">
            <i class="fas fa-user"></i>
            <span>More</span>
        </a>
    </nav>

    <script>
        // Dashboard interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-refresh data every 30 seconds
            setInterval(() => {
                // In a real app, this would refresh data via AJAX
                console.log('Refreshing dashboard data...');
            }, 30000);

            // Mobile menu toggle
            const mobileMenuButton = document.querySelector('button.md\\:hidden');
            const sidebar = document.querySelector('.md\\:flex.md\\:w-64');
            
            if (mobileMenuButton && sidebar) {
                mobileMenuButton.addEventListener('click', () => {
                    sidebar.classList.toggle('hidden');
                });
            }

            // Account card hover effects
            const accountCards = document.querySelectorAll('.account-card');
            accountCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-2px)';
                    card.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0)';
                    card.style.boxShadow = '';
                });
            });
        });
    </script>
</body>
</html>