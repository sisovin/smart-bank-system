<?php
class AuthMiddleware {
    public static function handle() {
        // Check if session cookies exist
        if (!isset($_COOKIE['session_id']) || !isset($_COOKIE['token'])) {
            self::redirectToLogin();
        }
        
        $sessionId = $_COOKIE['session_id'];
        $token = $_COOKIE['token'];
        
        // Verify session in database
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT s.*, u.username, u.email, u.status, r.role_name, r.role_id, c.first_name, c.last_name 
                FROM sessions s 
                JOIN users u ON s.user_id = u.user_id 
                JOIN roles r ON u.role_id = r.role_id 
                LEFT JOIN customers c ON u.user_id = c.user_id 
                WHERE s.session_id = :session_id 
                AND s.token_hash = :token_hash 
                AND s.expires_at > NOW() 
                AND s.revoked = 0
                AND u.status = 'active'";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':session_id' => $sessionId,
            ':token_hash' => hash('sha256', $token)
        ]);
        
        $session = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$session) {
            self::redirectToLogin();
        }
        
        // Store user data in session for use in controllers
        $_SESSION['user'] = [
            'id' => $session['user_id'],
            'username' => $session['username'],
            'email' => $session['email'],
            'first_name' => $session['first_name'] ?? $session['username'],
            'last_name' => $session['last_name'] ?? '',
            'role' => $session['role_name'],
            'role_id' => $session['role_id']
        ];
        
        return true;
    }
    
    public static function requireAuth() {
        self::handle();
    }
    
    public static function getCurrentUser() {
        return $_SESSION['user'] ?? null;
    }
    
    public static function isAuthenticated() {
        return isset($_SESSION['user']);
    }
    
    public static function logout() {
        if (isset($_COOKIE['session_id'])) {
            $db = Database::getInstance()->getConnection();
            $sql = "UPDATE sessions SET revoked = 1 WHERE session_id = :session_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([':session_id' => $_COOKIE['session_id']]);
        }
        
        // Clear session
        session_destroy();
        
        // Clear cookies
        setcookie('session_id', '', time() - 3600, '/');
        setcookie('token', '', time() - 3600, '/');
        setcookie('refresh_token', '', time() - 3600, '/');
        
        self::redirectToLogin();
    }
    
    private static function redirectToLogin() {
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }
}
?>