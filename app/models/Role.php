<?php
class Role {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function create($roleName, $description = '') {
        $sql = "INSERT INTO roles (role_name, description) VALUES (:name, :description)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $roleName,
            ':description' => $description
        ]);
        return $this->db->lastInsertId();
    }
    
    public function findById($roleId) {
        $sql = "SELECT * FROM roles WHERE role_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $roleId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function findByName($roleName) {
        $sql = "SELECT * FROM roles WHERE role_name = :name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':name' => $roleName]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAll() {
        $sql = "SELECT * FROM roles ORDER BY role_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function update($roleId, $roleName, $description) {
        $sql = "UPDATE roles SET role_name = :name, description = :description WHERE role_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $roleId,
            ':name' => $roleName,
            ':description' => $description
        ]);
    }
    
    public function delete($roleId) {
        $sql = "DELETE FROM roles WHERE role_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $roleId]);
    }
    
    public function hasPermission($roleId, $permission) {
        // For now, implement basic role-based permissions
        $rolePermissions = [
            ROLE_ADMIN => ['all'],
            ROLE_MANAGER => ['view_reports', 'manage_staff', 'approve_transactions'],
            ROLE_TELLER => ['process_transactions', 'view_customer_data'],
            ROLE_CUSTOMER => ['view_own_data', 'transfer_money']
        ];
        
        $role = $this->findById($roleId);
        if (!$role) return false;
        
        $permissions = $rolePermissions[$roleId] ?? [];
        return in_array('all', $permissions) || in_array($permission, $permissions);
    }
}
?>