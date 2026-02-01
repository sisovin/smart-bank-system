<?php
class RoleMiddleware {
    public static function checkRole($requiredRole) {
        $user = AuthMiddleware::getCurrentUser();
        
        if (!$user) {
            AuthMiddleware::redirectToLogin();
        }
        
        // Define role hierarchy (higher number = more permissions)
        $roleHierarchy = [
            'customer' => 1,
            'teller' => 2,
            'manager' => 3,
            'admin' => 4
        ];
        
        $userRoleLevel = $roleHierarchy[strtolower($user['role'])] ?? 0;
        $requiredRoleLevel = $roleHierarchy[strtolower($requiredRole)] ?? 999;
        
        if ($userRoleLevel < $requiredRoleLevel) {
            self::accessDenied();
        }
        
        return true;
    }
    
    public static function checkPermission($permission) {
        $user = AuthMiddleware::getCurrentUser();
        
        if (!$user) {
            AuthMiddleware::redirectToLogin();
        }
        
        $roleModel = new Role();
        return $roleModel->hasPermission($user['role_id'], $permission);
    }
    
    public static function isAdmin() {
        return self::checkRole('admin');
    }
    
    public static function isManager() {
        return self::checkRole('manager');
    }
    
    public static function isTeller() {
        return self::checkRole('teller');
    }
    
    public static function isCustomer() {
        return self::checkRole('customer');
    }
    
    private static function accessDenied() {
        http_response_code(403);
        echo json_encode(['error' => 'Access denied. Insufficient permissions.']);
        exit;
    }
}
?>