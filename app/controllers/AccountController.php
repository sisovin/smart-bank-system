<?php
class AccountController {
    private $accountModel;
    private $customerModel;

    public function __construct() {
        $this->accountModel = new Account();
        $this->customerModel = new Customer();
    }

    public function index() {
        $user = AuthMiddleware::getCurrentUser();
        if (!$user) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        // Get customer info
        $customer = $this->customerModel->findByUserId($user['id']);
        if (!$customer) {
            // Handle case where user doesn't have customer record
            $_SESSION['error'] = 'Customer profile not found. Please contact support.';
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }

        // Get customer's accounts
        $accounts = $this->accountModel->getByCustomer($customer['customer_id']);

        // Load the accounts view
        require_once __DIR__ . '/../../resources/templates/header.php';
        require_once __DIR__ . '/../../resources/views/accounts/index.php';
        require_once __DIR__ . '/../../resources/templates/footer.php';
    }

    public function create() {
        $user = AuthMiddleware::getCurrentUser();
        if (!$user) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        // Load the create account view
        require_once __DIR__ . '/../../resources/templates/header.php';
        require_once __DIR__ . '/../../resources/views/accounts/create.php';
        require_once __DIR__ . '/../../resources/templates/footer.php';
    }

    public function store() {
        $user = AuthMiddleware::getCurrentUser();
        if (!$user) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'accounts');
            exit;
        }

        // Validate input
        $accountType = filter_input(INPUT_POST, 'account_type', FILTER_SANITIZE_STRING);
        $initialDeposit = filter_input(INPUT_POST, 'initial_deposit', FILTER_VALIDATE_FLOAT);

        if (!$accountType || !in_array($accountType, [ACCOUNT_SAVINGS, ACCOUNT_CHECKING, ACCOUNT_BUSINESS])) {
            $_SESSION['error'] = 'Invalid account type selected.';
            header('Location: ' . BASE_URL . 'accounts/create');
            exit;
        }

        if ($initialDeposit === false || $initialDeposit < 0) {
            $_SESSION['error'] = 'Invalid initial deposit amount.';
            header('Location: ' . BASE_URL . 'accounts/create');
            exit;
        }

        // Minimum deposit requirements
        $minDeposit = match($accountType) {
            ACCOUNT_SAVINGS => 100,
            ACCOUNT_CHECKING => 500,
            ACCOUNT_BUSINESS => 1000,
            default => 100
        };

        if ($initialDeposit < $minDeposit) {
            $_SESSION['error'] = "Minimum initial deposit for $accountType account is $" . number_format($minDeposit, 2) . ".";
            header('Location: ' . BASE_URL . 'accounts/create');
            exit;
        }

        try {
            // Get customer info
            $customer = $this->customerModel->findByUserId($user['id']);
            if (!$customer) {
                $_SESSION['error'] = 'Customer profile not found. Please contact support.';
                header('Location: ' . BASE_URL . 'accounts/create');
                exit;
            }

            // Create the account
            $accountNumber = $this->accountModel->create($customer['customer_id'], $accountType, $initialDeposit);

            // Log the account creation
            $this->logAudit($user['id'], 'create_account', 'accounts', $accountNumber);

            $_SESSION['success'] = "Account created successfully! Account Number: $accountNumber";
            header('Location: ' . BASE_URL . 'accounts');
            exit;

        } catch (Exception $e) {
            error_log("Account creation error: " . $e->getMessage());
            $_SESSION['error'] = 'Failed to create account. Please try again.';
            header('Location: ' . BASE_URL . 'accounts/create');
            exit;
        }
    }

    private function logAudit($userId, $action, $table, $recordId) {
        $db = Database::getInstance()->getConnection();
        $sql = "INSERT INTO audit_log (user_id, action, table_name, record_id, ip_address, user_agent, timestamp)
                VALUES (:user_id, :action, :table_name, :record_id, :ip_address, :user_agent, NOW())";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':action' => $action,
            ':table_name' => $table,
            ':record_id' => $recordId,
            ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ]);
    }
}
?>
