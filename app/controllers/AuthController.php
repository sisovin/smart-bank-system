<?php
class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            
            // Validation
            if ($password !== $confirmPassword) {
                return ['error' => 'Passwords do not match'];
            }
            
            if ($this->userModel->findByUsername($username)) {
                return ['error' => 'Username already exists'];
            }
            
            if ($this->userModel->findByEmail($email)) {
                return ['error' => 'Email already registered'];
            }
            
            // Create user
            $userId = $this->userModel->create($username, $email, $password);
            
            // Create customer record
            $customerModel = new Customer();
            $customerId = $customerModel->create($userId, [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'date_of_birth' => $_POST['dob'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone']
            ]);
            
            // Create initial account
            $accountModel = new Account();
            $accountNumber = $accountModel->create($customerId, ACCOUNT_SAVINGS, 0);
            
            return [
                'success' => true,
                'message' => 'Registration successful',
                'account_number' => $accountNumber
            ];
        }
        
        return [];
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
            $input = $_SERVER['REQUEST_METHOD'] === 'POST' ? INPUT_POST : INPUT_GET;
            $username = filter_input($input, 'username', FILTER_SANITIZE_STRING);
            $password = $input === INPUT_POST ? $_POST['password'] : $_GET['password'];
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            
            // Check for brute force
            $failedAttempts = $this->userModel->getFailedAttempts($username);
            if ($failedAttempts >= MAX_LOGIN_ATTEMPTS) {
                return ['error' => 'Account locked due to too many failed attempts'];
            }
            
            $user = $this->userModel->findByUsername($username);
            
            if (!$user) {
                $this->userModel->updateLoginAttempt($username, $ipAddress, false);
                return ['error' => 'Invalid credentials'];
            }
            
            if (!$this->userModel->verifyPassword($password, $user['password_hash'])) {
                $this->userModel->updateLoginAttempt($username, $ipAddress, false);
                return ['error' => 'Invalid credentials'];
            }
            
            // Successful login
            $this->userModel->updateLoginAttempt($username, $ipAddress, true);
            
            // Create session with refresh token
            $token = bin2hex(random_bytes(32));
            $refreshToken = bin2hex(random_bytes(32));
            $sessionId = session_create_id();
            
            // Store session in database
            $this->createSession($sessionId, $user['user_id'], $token, $refreshToken);
            
            // Set session cookies
            setcookie('session_id', $sessionId, time() + TOKEN_EXPIRY, '/', '', false, true);
            setcookie('token', $token, time() + TOKEN_EXPIRY, '/', '', false, true);
            setcookie('refresh_token', $refreshToken, time() + REFRESH_TOKEN_EXPIRY, '/', '', false, true);
            
            // Log audit trail
            $this->logAudit($user['user_id'], 'login', 'users', $user['user_id']);
            
            return [
                'success' => true,
                'user' => [
                    'id' => $user['user_id'],
                    'username' => $user['username'],
                    'role' => $user['role_name']
                ]
            ];
        }
        
        return [];
    }
    
    private function createSession($sessionId, $userId, $token, $refreshToken) {
        $sql = "INSERT INTO sessions (session_id, user_id, token_hash, refresh_token_hash, expires_at) 
                VALUES (:session_id, :user_id, :token_hash, :refresh_token_hash, DATE_ADD(NOW(), INTERVAL :expiry SECOND))";
        
        $stmt = Database::getInstance()->getConnection()->prepare($sql);
        $stmt->execute([
            ':session_id' => $sessionId,
            ':user_id' => $userId,
            ':token_hash' => hash('sha256', $token),
            ':refresh_token_hash' => hash('sha256', $refreshToken),
            ':expiry' => TOKEN_EXPIRY
        ]);
    }
    
    private function logAudit($userId, $action, $table = null, $recordId = null) {
        $sql = "INSERT INTO audit_logs (user_id, action_type, table_name, record_id, ip_address, user_agent) 
                VALUES (:user_id, :action, :table, :record_id, :ip, :ua)";
        
        $stmt = Database::getInstance()->getConnection()->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':action' => $action,
            ':table' => $table,
            ':record_id' => $recordId,
            ':ip' => $_SERVER['REMOTE_ADDR'],
            ':ua' => $_SERVER['HTTP_USER_AGENT']
        ]);
    }

    public function refreshToken() {
        if (!isset($_COOKIE['refresh_token'])) {
            return ['error' => 'No refresh token provided'];
        }
        
        $refreshToken = $_COOKIE['refresh_token'];
        
        // Find session by refresh token
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM sessions WHERE refresh_token_hash = :refresh_hash AND expires_at > NOW()";
        $stmt = $db->prepare($sql);
        $stmt->execute([':refresh_hash' => hash('sha256', $refreshToken)]);
        
        $session = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$session) {
            return ['error' => 'Invalid refresh token'];
        }
        
        // Generate new tokens
        $newToken = bin2hex(random_bytes(32));
        $newRefreshToken = bin2hex(random_bytes(32));
        
        // Update session
        $updateSql = "UPDATE sessions SET token_hash = :token_hash, refresh_token_hash = :refresh_hash, 
                      expires_at = DATE_ADD(NOW(), INTERVAL :expiry SECOND) 
                      WHERE session_id = :session_id";
        $updateStmt = $db->prepare($updateSql);
        $updateStmt->execute([
            ':token_hash' => hash('sha256', $newToken),
            ':refresh_hash' => hash('sha256', $newRefreshToken),
            ':expiry' => TOKEN_EXPIRY,
            ':session_id' => $session['session_id']
        ]);
        
        // Set new cookies
        setcookie('token', $newToken, time() + TOKEN_EXPIRY, '/', '', true, true);
        setcookie('refresh_token', $newRefreshToken, time() + REFRESH_TOKEN_EXPIRY, '/', '', true, true);
        
        return ['success' => true, 'message' => 'Token refreshed'];
    }
}
?>