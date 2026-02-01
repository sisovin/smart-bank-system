<div class="min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../templates/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Accounts</h1>
                <p class="mt-2 text-gray-600">Manage your bank accounts</p>
            </div>

            <!-- Success/Error Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="mb-6">
                <a href="<?php echo BASE_URL; ?>accounts/create"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Open New Account
                </a>
            </div>

            <!-- Accounts Grid -->
            <?php if (empty($accounts)): ?>
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-credit-card text-6xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Accounts Found</h3>
                    <p class="text-gray-600 mb-6">You don't have any accounts yet. Open your first account to get started.</p>
                    <a href="<?php echo BASE_URL; ?>accounts/create"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                        Open Your First Account
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($accounts as $account): ?>
                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition duration-200">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="bg-blue-100 p-3 rounded-full">
                                        <i class="fas fa-credit-card text-blue-600 text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            <?php echo ucfirst(htmlspecialchars($account['account_type'])); ?> Account
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            <?php echo htmlspecialchars($account['account_number']); ?>
                                        </p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    <?php echo $account['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                    <?php echo ucfirst(htmlspecialchars($account['status'])); ?>
                                </span>
                            </div>

                            <div class="mb-4">
                                <p class="text-2xl font-bold text-gray-900">
                                    $<?php echo number_format($account['balance'], 2); ?>
                                </p>
                                <p class="text-sm text-gray-500">Current Balance</p>
                            </div>

                            <div class="flex space-x-2">
                                <a href="<?php echo BASE_URL; ?>transactions?account=<?php echo urlencode($account['account_number']); ?>"
                                   class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg text-center transition duration-200 text-sm">
                                    View Transactions
                                </a>
                                <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm"
                                        onclick="showTransferModal('<?php echo htmlspecialchars($account['account_number']); ?>')">
                                    Transfer
                                </button>
                            </div>

                            <div class="mt-4 text-xs text-gray-500">
                                Opened: <?php echo date('M j, Y', strtotime($account['created_at'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Account Summary -->
            <?php if (!empty($accounts)): ?>
                <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Account Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-blue-600"><?php echo count($accounts); ?></p>
                            <p class="text-gray-600">Total Accounts</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-green-600">
                                $<?php echo number_format(array_sum(array_column($accounts, 'balance')), 2); ?>
                            </p>
                            <p class="text-gray-600">Total Balance</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-purple-600">
                                <?php echo count(array_filter($accounts, fn($acc) => $acc['status'] === 'active')); ?>
                            </p>
                            <p class="text-gray-600">Active Accounts</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Transfer Modal -->
<div id="transferModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Transfer Money</h3>
                <button onclick="closeTransferModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="transferForm" action="<?php echo BASE_URL; ?>transfer" method="POST">
                <input type="hidden" id="fromAccount" name="from_account" value="">

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">To Account Number</label>
                    <input type="text" id="toAccount" name="to_account" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           placeholder="Enter account number">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Amount</label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0.01" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           placeholder="0.00">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description (Optional)</label>
                    <input type="text" id="description" name="description"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           placeholder="Transfer description">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeTransferModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-200">
                        Cancel
                    </button>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Transfer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showTransferModal(accountNumber) {
    document.getElementById('fromAccount').value = accountNumber;
    document.getElementById('transferModal').classList.remove('hidden');
}

function closeTransferModal() {
    document.getElementById('transferModal').classList.add('hidden');
    document.getElementById('transferForm').reset();
}

// Close modal when clicking outside
document.getElementById('transferModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTransferModal();
    }
});
</script>