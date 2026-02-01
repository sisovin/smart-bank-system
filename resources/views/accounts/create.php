<div class="min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../templates/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Open New Account</h1>
                <p class="mt-2 text-gray-600">Choose your account type and make an initial deposit</p>
            </div>

            <!-- Error Messages -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Account Creation Form -->
            <div class="bg-white rounded-lg shadow-sm p-8">
                <form action="<?php echo BASE_URL; ?>accounts" method="POST" class="space-y-6">
                    <!-- Account Type Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Account Type</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Savings Account -->
                            <div class="account-type-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition duration-200"
                                 data-type="savings">
                                <div class="text-center">
                                    <div class="bg-green-100 p-3 rounded-full inline-block mb-3">
                                        <i class="fas fa-piggy-bank text-green-600 text-2xl"></i>
                                    </div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Savings Account</h3>
                                    <p class="text-sm text-gray-600 mb-3">Earn interest on your savings</p>
                                    <p class="text-xs text-gray-500">Min. deposit: $100</p>
                                    <input type="radio" name="account_type" value="savings" class="hidden account-radio">
                                </div>
                            </div>

                            <!-- Checking Account -->
                            <div class="account-type-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition duration-200"
                                 data-type="checking">
                                <div class="text-center">
                                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-3">
                                        <i class="fas fa-credit-card text-blue-600 text-2xl"></i>
                                    </div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Checking Account</h3>
                                    <p class="text-sm text-gray-600 mb-3">For everyday transactions</p>
                                    <p class="text-xs text-gray-500">Min. deposit: $500</p>
                                    <input type="radio" name="account_type" value="checking" class="hidden account-radio">
                                </div>
                            </div>

                            <!-- Business Account -->
                            <div class="account-type-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition duration-200"
                                 data-type="business">
                                <div class="text-center">
                                    <div class="bg-purple-100 p-3 rounded-full inline-block mb-3">
                                        <i class="fas fa-building text-purple-600 text-2xl"></i>
                                    </div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Business Account</h3>
                                    <p class="text-sm text-gray-600 mb-3">For business transactions</p>
                                    <p class="text-xs text-gray-500">Min. deposit: $1,000</p>
                                    <input type="radio" name="account_type" value="business" class="hidden account-radio">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Initial Deposit -->
                    <div>
                        <label for="initial_deposit" class="block text-sm font-medium text-gray-700 mb-2">
                            Initial Deposit Amount
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" id="initial_deposit" name="initial_deposit" step="0.01" min="0"
                                   class="pl-7 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="0.00" required>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Minimum deposit varies by account type</p>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="text-gray-700">
                                    I agree to the <a href="#" class="text-blue-600 hover:text-blue-500">Terms and Conditions</a>
                                    and <a href="#" class="text-blue-600 hover:text-blue-500">Account Agreement</a>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4">
                        <a href="<?php echo BASE_URL; ?>accounts"
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-6 rounded-lg transition duration-200">
                            Cancel
                        </a>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                            Open Account
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Type Information -->
            <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Type Details</h3>
                <div class="space-y-4">
                    <div class="border-l-4 border-green-500 pl-4">
                        <h4 class="font-medium text-gray-900">Savings Account</h4>
                        <p class="text-sm text-gray-600">Perfect for saving money with competitive interest rates. Limited transactions per month.</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-4">
                        <h4 class="font-medium text-gray-900">Checking Account</h4>
                        <p class="text-sm text-gray-600">Ideal for daily banking needs with unlimited transactions and check writing capabilities.</p>
                    </div>
                    <div class="border-l-4 border-purple-500 pl-4">
                        <h4 class="font-medium text-gray-900">Business Account</h4>
                        <p class="text-sm text-gray-600">Designed for business owners with enhanced transaction limits and business-specific features.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Account type selection
document.querySelectorAll('.account-type-option').forEach(option => {
    option.addEventListener('click', function() {
        // Remove selected class from all options
        document.querySelectorAll('.account-type-option').forEach(opt => {
            opt.classList.remove('border-blue-500', 'bg-blue-50');
            opt.classList.add('border-gray-200');
        });

        // Add selected class to clicked option
        this.classList.remove('border-gray-200');
        this.classList.add('border-blue-500', 'bg-blue-50');

        // Check the radio button
        const radio = this.querySelector('.account-radio');
        radio.checked = true;

        // Update minimum deposit based on account type
        const accountType = this.dataset.type;
        const depositInput = document.getElementById('initial_deposit');
        const minDeposit = {
            'savings': 100,
            'checking': 500,
            'business': 1000
        };

        depositInput.min = minDeposit[accountType];
        depositInput.placeholder = minDeposit[accountType] + '.00';
    });
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const accountType = document.querySelector('input[name="account_type"]:checked');
    const deposit = parseFloat(document.getElementById('initial_deposit').value);

    if (!accountType) {
        e.preventDefault();
        alert('Please select an account type.');
        return;
    }

    const minDeposits = {
        'savings': 100,
        'checking': 500,
        'business': 1000
    };

    if (deposit < minDeposits[accountType.value]) {
        e.preventDefault();
        alert(`Minimum deposit for ${accountType.value} account is $${minDeposits[accountType.value]}.`);
        return;
    }
});
</script>