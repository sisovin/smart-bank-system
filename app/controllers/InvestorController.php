<?php
// InvestorController.php - Handles investor dashboard functionality

require_once '../models/Database.php';
require_once '../models/User.php';
require_once '../models/Role.php';

class InvestorController {
    private $db;
    private $user;
    private $role;

    public function __construct() {
        $this->db = new Database();
        $this->user = new User($this->db);
        $this->role = new Role($this->db);
    }

    // Main dashboard view
    public function dashboard() {
        // Check if user is authenticated and is an investor
        if (!$this->isAuthenticated() || !$this->isInvestor()) {
            header('Location: /login.php?error=unauthorized');
            exit();
        }

        // Get investor data
        $investorData = $this->getInvestorData();

        // Load the dashboard view
        require_once '../views/investor/index.php';
    }

    // API endpoint for financial data
    public function getFinancialData() {
        header('Content-Type: application/json');

        if (!$this->isAuthenticated() || !$this->isInvestor()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $data = [
            'revenue' => $this->getRevenueData(),
            'performance' => $this->getPerformanceMetrics(),
            'market' => $this->getMarketData(),
            'opportunities' => $this->getInvestmentOpportunities()
        ];

        echo json_encode($data);
    }

    // API endpoint for documents
    public function getDocuments() {
        header('Content-Type: application/json');

        if (!$this->isAuthenticated() || !$this->isInvestor()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $documents = $this->getAvailableDocuments();
        echo json_encode($documents);
    }

    // Handle partnership application
    public function submitPartnershipApplication() {
        if (!$this->isAuthenticated() || !$this->isInvestor()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->validateApplicationData($data)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid application data']);
            return;
        }

        $result = $this->savePartnershipApplication($data);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Application submitted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to submit application']);
        }
    }

    // Private helper methods
    private function isAuthenticated() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    private function isInvestor() {
        if (!isset($_SESSION['role'])) {
            return false;
        }
        return $_SESSION['role'] === 'investor' || $_SESSION['role'] === 'accredited_investor';
    }

    private function getInvestorData() {
        // Mock data - in real implementation, fetch from database
        return [
            'name' => 'John Investor',
            'company' => 'ABC Investment Group',
            'accreditation_status' => 'Accredited Investor',
            'portfolio_value' => 2400000,
            'investments' => [
                ['name' => 'SmartBank Strategic Partnership', 'amount' => 500000, 'date' => '2023-06-15'],
                ['name' => 'SmartBank Private Equity', 'amount' => 1000000, 'date' => '2023-08-20']
            ]
        ];
    }

    private function getRevenueData() {
        // Mock revenue data for charts
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'data' => [32, 35, 38, 36, 41, 39, 44, 42, 46, 43, 48, 45.2]
        ];
    }

    private function getPerformanceMetrics() {
        return [
            'net_profit_margin' => 18.5,
            'operating_margin' => 22.3,
            'roe' => 14.2,
            'roa' => 1.8,
            'debt_equity_ratio' => 0.45,
            'current_ratio' => 1.32
        ];
    }

    private function getMarketData() {
        return [
            'market_share' => 8.5,
            'digital_adoption' => 92,
            'customer_satisfaction' => 4.8,
            'industry_growth' => [3.2, 4.1, 5.8, 7.2, 8.9, 11.2]
        ];
    }

    private function getInvestmentOpportunities() {
        return [
            [
                'type' => 'Strategic Partnership',
                'description' => 'Joint venture opportunities in fintech innovation',
                'range' => [5000000, 25000000]
            ],
            [
                'type' => 'Private Equity',
                'description' => 'Direct investment in bank expansion',
                'range' => [10000000, 50000000]
            ],
            [
                'type' => 'Real Estate Partnership',
                'description' => 'Investment in branch network expansion',
                'range' => [15000000, 75000000]
            ]
        ];
    }

    private function getAvailableDocuments() {
        return [
            [
                'id' => 1,
                'name' => 'Annual Report 2023',
                'type' => 'Financial Report',
                'size' => '2.4 MB',
                'updated' => '2023-12-31',
                'url' => '/downloads/annual-report-2023.pdf'
            ],
            [
                'id' => 2,
                'name' => 'Investor Presentation Q4 2023',
                'type' => 'Presentation',
                'size' => '8.7 MB',
                'updated' => '2024-01-15',
                'url' => '/downloads/investor-presentation-q4-2023.pptx'
            ],
            [
                'id' => 3,
                'name' => 'Financial Projections 2024-2026',
                'type' => 'Financial Model',
                'size' => '1.2 MB',
                'updated' => '2024-02-01',
                'url' => '/downloads/financial-projections-2024-2026.xlsx'
            ]
        ];
    }

    private function validateApplicationData($data) {
        return isset($data['partnership_type']) &&
               isset($data['investment_amount']) &&
               isset($data['message']) &&
               is_numeric($data['investment_amount']) &&
               $data['investment_amount'] > 0;
    }

    private function savePartnershipApplication($data) {
        // Mock implementation - in real app, save to database
        // Log the application for review
        error_log("Partnership application received: " . json_encode($data));
        return true;
    }
}

// Handle routing for investor endpoints
if (isset($_GET['action'])) {
    $controller = new InvestorController();

    switch ($_GET['action']) {
        case 'financial-data':
            $controller->getFinancialData();
            break;
        case 'documents':
            $controller->getDocuments();
            break;
        case 'submit-application':
            $controller->submitPartnershipApplication();
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Action not found']);
    }
} else {
    // Default dashboard view
    $controller = new InvestorController();
    $controller->dashboard();
}
?>