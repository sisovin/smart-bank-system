<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function create($username, $email, $password, $roleId = ROLE_CUSTOMER) {
        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
        
        $sql = "INSERT INTO users (username, email, password_hash, role_id) 
                VALUES (:username, :email, :password_hash, :role_id)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password_hash' => $hashedPassword,
            ':role_id' => $roleId
        ]);
        
        return $this->db->lastInsertId();
    }
    
    public function findByUsername($username) {
        $sql = "SELECT u.*, r.role_name FROM users u 
                JOIN roles r ON u.role_id = r.role_id 
                WHERE u.username = :username";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $username]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }
    
    public function update($userId, $username, $email) {
        $sql = "UPDATE users SET username = :username, email = :email WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':user_id' => $userId
        ]);
    }
    
    public function updateLoginAttempt($username, $ip, $success) {
        // Ensure username is not null or empty
        if (empty($username)) {
            return false;
        }

        $sql = "INSERT INTO login_attempts (username, ip_address, success) 
                VALUES (:username, :ip, :success)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':username' => $username,
            ':ip' => $ip,
            ':success' => $success
        ]);
    }
    
    public function getFailedAttempts($username, $minutes = 15) {
        $sql = "SELECT COUNT(*) as attempts FROM login_attempts 
                WHERE username = :username 
                AND success = 0 
                AND attempt_time > DATE_SUB(NOW(), INTERVAL :minutes MINUTE)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':minutes' => $minutes
        ]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['attempts'];
    }
}
?>