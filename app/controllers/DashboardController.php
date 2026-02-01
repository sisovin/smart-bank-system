<?php
class DashboardController {
    private $userModel;
    private $accountModel;
    private $transactionModel;
    
    public function __construct() {
        $this->userModel = new User();
        $this->accountModel = new Account();
        $this->transactionModel = new Transaction();
    }
    
    public function index() {
        // Get current user
        $user = AuthMiddleware::getCurrentUser();
        
        if (!$user) {
            header('Location: ' . BASE_URL . 'login.php');
            exit;
        }
        
        // Get customer info
        $customerModel = new Customer();
        $customer = $customerModel->findByUserId($user['id']);
        
        if (!$customer) {
            // Handle case where customer profile doesn't exist
            return ['error' => 'Customer profile not found'];
        }
        
        // Get accounts
        $accounts = $this->accountModel->getByCustomer($customer['customer_id']);
        
        // Calculate total balance
        $totalBalance = 0;
        foreach ($accounts as $account) {
            $totalBalance += $account['balance'];
        }
        
        // Get recent transactions (across all accounts)
        $recentTransactions = [];
        foreach ($accounts as $account) {
            $transactions = $this->transactionModel->getHistory($account['account_id'], 5);
            $recentTransactions = array_merge($recentTransactions, $transactions);
        }
        
        // Sort by date and limit to 10 most recent
        usort($recentTransactions, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        $recentTransactions = array_slice($recentTransactions, 0, 10);
        
        // Get account summaries
        $accountSummaries = [];
        foreach ($accounts as $account) {
            $accountSummaries[] = [
                'id' => $account['account_id'],
                'number' => $account['account_number'],
                'type' => $account['account_type'],
                'balance' => $account['balance'],
                'status' => $account['status']
            ];
        }
        
        return [
            'user' => $user,
            'customer' => $customer,
            'total_balance' => $totalBalance,
            'accounts' => $accountSummaries,
            'recent_transactions' => $recentTransactions
        ];
    }
    
    public function getAccountSummary($accountId) {
        // Verify account belongs to user
        $user = AuthMiddleware::getCurrentUser();
        $customerModel = new Customer();
        $customer = $customerModel->findByUserId($user['id']);
        
        $account = $this->accountModel->getById($accountId);
        
        if (!$account || $account['customer_id'] != $customer['customer_id']) {
            return ['error' => 'Account not found or access denied'];
        }
        
        // Get recent transactions for this account
        $transactions = $this->transactionModel->getHistory($accountId, 20);
        
        return [
            'account' => $account,
            'transactions' => $transactions,
            'balance' => $account['balance']
        ];
    }
}