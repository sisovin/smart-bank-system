<?php
class Account {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function create($customerId, $accountType = ACCOUNT_SAVINGS, $initialDeposit = 0) {
        $accountNumber = $this->generateAccountNumber();
        
        $sql = "INSERT INTO accounts (account_number, customer_id, account_type, balance) 
                VALUES (:account_number, :customer_id, :account_type, :balance)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':account_number' => $accountNumber,
            ':customer_id' => $customerId,
            ':account_type' => $accountType,
            ':balance' => $initialDeposit
        ]);
        
        return $accountNumber;
    }
    
    private function generateAccountNumber() {
        return 'SB' . date('Ymd') . str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
    }
    
    public function getByCustomer($customerId) {
        $sql = "SELECT * FROM accounts WHERE customer_id = :customer_id AND status = 'active'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':customer_id' => $customerId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByNumber($accountNumber) {
        $sql = "SELECT a.*, c.first_name, c.last_name 
                FROM accounts a 
                JOIN customers c ON a.customer_id = c.customer_id 
                WHERE a.account_number = :account_number";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':account_number' => $accountNumber]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateBalance($accountId, $amount) {
        $sql = "UPDATE accounts SET balance = balance + :amount WHERE account_id = :account_id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':amount' => $amount,
            ':account_id' => $accountId
        ]);
    }
    
    public function getBalance($accountId) {
        $sql = "SELECT balance FROM accounts WHERE account_id = :account_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':account_id' => $accountId]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['balance'] ?? 0;
    }
    
    public function updateStatus($accountId, $status) {
        $sql = "UPDATE accounts SET status = :status WHERE account_id = :account_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':account_id' => $accountId
        ]);
    }
    
    public function freezeAccount($accountId) {
        return $this->updateStatus($accountId, 'frozen');
    }
    
    public function unfreezeAccount($accountId) {
        return $this->updateStatus($accountId, 'active');
    }
    
    public function closeAccount($accountId) {
        return $this->updateStatus($accountId, 'closed');
    }
    
    public function getStatus($accountId) {
        $sql = "SELECT status FROM accounts WHERE account_id = :account_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':account_id' => $accountId]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['status'] ?? null;
    }
}
?>