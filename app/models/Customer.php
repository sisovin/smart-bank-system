<?php
class Customer {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function create($userId, $customerData) {
        $sql = "INSERT INTO customers (user_id, first_name, last_name, date_of_birth, address, phone) 
                VALUES (:user_id, :first_name, :last_name, :dob, :address, :phone)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':first_name' => $customerData['first_name'],
            ':last_name' => $customerData['last_name'],
            ':dob' => $customerData['date_of_birth'],
            ':address' => $customerData['address'],
            ':phone' => $customerData['phone']
        ]);
        
        return $this->db->lastInsertId();
    }
    
    public function findByUserId($userId) {
        $sql = "SELECT * FROM customers WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function findById($customerId) {
        $sql = "SELECT c.*, u.username, u.email 
                FROM customers c 
                JOIN users u ON c.user_id = u.user_id 
                WHERE c.customer_id = :customer_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':customer_id' => $customerId]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function update($customerId, $customerData) {
        $sql = "UPDATE customers SET 
                first_name = :first_name, 
                last_name = :last_name, 
                date_of_birth = :dob, 
                address = :address, 
                phone = :phone 
                WHERE customer_id = :customer_id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':customer_id' => $customerId,
            ':first_name' => $customerData['first_name'],
            ':last_name' => $customerData['last_name'],
            ':dob' => $customerData['date_of_birth'],
            ':address' => $customerData['address'],
            ':phone' => $customerData['phone']
        ]);
    }
    
    public function updateKYCStatus($customerId, $status, $documents = null) {
        $sql = "UPDATE customers SET kyc_status = :status";
        $params = [':status' => $status, ':customer_id' => $customerId];
        
        if ($documents) {
            $sql .= ", kyc_documents = :documents";
            $params[':documents'] = json_encode($documents);
        }
        
        $sql .= " WHERE customer_id = :customer_id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function getAccounts($customerId) {
        $accountModel = new Account();
        return $accountModel->getByCustomer($customerId);
    }
    
    public function search($searchTerm) {
        $sql = "SELECT c.*, u.username, u.email 
                FROM customers c 
                JOIN users u ON c.user_id = u.user_id 
                WHERE c.first_name LIKE :search 
                OR c.last_name LIKE :search 
                OR u.username LIKE :search 
                OR u.email LIKE :search";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':search' => '%' . $searchTerm . '%']);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}