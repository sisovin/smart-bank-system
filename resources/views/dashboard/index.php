<?php
// Dashboard view for customers
$data = $data ?? []; // Data passed from controller
$user = $data['user'] ?? [];
$customer = $data['customer'] ?? [];
$totalBalance = $data['total_balance'] ?? 0;
$accounts = $data['accounts'] ?? [];
$recentTransactions = $data['recent_transactions'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SmartBank</title>
    <link href="/assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-primary">SmartBank</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, <?php echo htmlspecialchars($customer['first_name'] ?? 'Customer'); ?></span>
                    <div class="relative">
                        <button class="flex items-center text-gray-700 hover:text-gray-900">
                            <span class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center">
                                <?php echo strtoupper(substr($customer['first_name'] ?? 'C', 0, 1)); ?>
                            </span>
                        </button>
                    </div>
                    <a href="/logout" class="text-red-600 hover:text-red-800">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Balance Overview -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Account Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-r from-primary to-blue-600 text-white p-6 rounded-lg">
                    <h3 class="text-lg font-medium">Total Balance</h3>
                    <p class="text-3xl font-bold">$<?php echo number_format($totalBalance, 2); ?></p>
                </div>
                <div class="bg-white border border-gray-200 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900">Active Accounts</h3>
                    <p class="text-3xl font-bold text-primary"><?php echo count($accounts); ?></p>
                </div>
                <div class="bg-white border border-gray-200 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900">Recent Transactions</h3>
                    <p class="text-3xl font-bold text-primary"><?php echo count($recentTransactions); ?></p>
                </div>
            </div>
        </div>

        <!-- Accounts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Account List -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Accounts</h3>
                <div class="space-y-4">
                    <?php foreach ($accounts as $account): ?>
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900"><?php echo htmlspecialchars($account['number']); ?></p>
                            <p class="text-sm text-gray-500"><?php echo ucfirst($account['type']); ?> Account</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">$<?php echo number_format($account['balance'], 2); ?></p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                <?php echo $account['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                <?php echo ucfirst($account['status']); ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4">
                    <a href="/accounts/create" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-700">
                        Open New Account
                    </a>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Transactions</h3>
                <div class="space-y-4">
                    <?php if (empty($recentTransactions)): ?>
                    <p class="text-gray-500 text-center py-8">No transactions yet</p>
                    <?php else: ?>
                    <?php foreach ($recentTransactions as $transaction): ?>
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900"><?php echo htmlspecialchars($transaction['description'] ?: ucfirst($transaction['transaction_type'])); ?></p>
                            <p class="text-sm text-gray-500"><?php echo date('M j, Y', strtotime($transaction['created_at'])); ?></p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold <?php echo ($transaction['from_account_id'] && $transaction['to_account_id']) ? 'text-blue-600' : ($transaction['from_account_id'] ? 'text-red-600' : 'text-green-600'); ?>">
                                <?php
                                $amount = $transaction['amount'];
                                if ($transaction['from_account_id'] && !$transaction['to_account_id']) {
                                    echo '-$' . number_format($amount, 2);
                                } elseif (!$transaction['from_account_id'] && $transaction['to_account_id']) {
                                    echo '+$' . number_format($amount, 2);
                                } else {
                                    echo '$' . number_format($amount, 2);
                                }
                                ?>
                            </p>
                            <p class="text-xs text-gray-500"><?php echo strtoupper($transaction['transaction_type']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="mt-4">
                    <a href="/transactions" class="text-primary hover:text-blue-700 text-sm font-medium">View all transactions →</a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm p-6 mt-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="/transfer" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center mb-2">
                        ⇅
                    </div>
                    <span class="text-sm font-medium text-gray-900">Transfer Money</span>
                </a>
                <a href="/pay" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="w-12 h-12 bg-secondary text-white rounded-full flex items-center justify-center mb-2">
                        💳
                    </div>
                    <span class="text-sm font-medium text-gray-900">Pay Bills</span>
                </a>
                <a href="/accounts/create" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="w-12 h-12 bg-accent text-white rounded-full flex items-center justify-center mb-2">
                        +
                    </div>
                    <span class="text-sm font-medium text-gray-900">Open Account</span>
                </a>
                <a href="/statements" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="w-12 h-12 bg-gray-600 text-white rounded-full flex items-center justify-center mb-2">
                        📄
                    </div>
                    <span class="text-sm font-medium text-gray-900">Statements</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Add any interactive functionality here
        console.log('Dashboard loaded');
    </script>
</body>
</html>