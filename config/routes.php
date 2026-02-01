<?php
/**
 * Application Routes Configuration
 * Maps URLs to controllers and methods
 */

return [
    // Public routes
    'GET /' => ['controller' => 'LandingController', 'method' => 'index'],
    'GET /login' => ['controller' => 'AuthController', 'method' => 'login'],
    'POST /login' => ['controller' => 'AuthController', 'method' => 'authenticate'],
    'GET /register' => ['controller' => 'AuthController', 'method' => 'register'],
    'POST /register' => ['controller' => 'AuthController', 'method' => 'store'],

    // Customer routes (protected)
    'GET /dashboard' => ['controller' => 'DashboardController', 'method' => 'index', 'middleware' => ['auth', 'role:customer']],
    'GET /accounts' => ['controller' => 'AccountController', 'method' => 'index', 'middleware' => ['auth', 'role:customer']],
    'GET /accounts/create' => ['controller' => 'AccountController', 'method' => 'create', 'middleware' => ['auth', 'role:customer']],
    'POST /accounts' => ['controller' => 'AccountController', 'method' => 'store', 'middleware' => ['auth', 'role:customer']],
    'GET /transactions' => ['controller' => 'TransactionController', 'method' => 'index', 'middleware' => ['auth', 'role:customer']],
    'POST /transfer' => ['controller' => 'TransactionController', 'method' => 'transfer', 'middleware' => ['auth', 'role:customer']],

    // Staff routes (protected)
    'GET /staff/dashboard' => ['controller' => 'StaffController', 'method' => 'dashboard', 'middleware' => ['auth', 'role:teller']],
    'GET /staff/customers' => ['controller' => 'StaffController', 'method' => 'customers', 'middleware' => ['auth', 'role:teller']],
    'POST /staff/transactions' => ['controller' => 'StaffController', 'method' => 'processTransaction', 'middleware' => ['auth', 'role:teller']],

    // Manager routes (protected)
    'GET /manager/dashboard' => ['controller' => 'ManagerController', 'method' => 'dashboard', 'middleware' => ['auth', 'role:manager']],
    'GET /manager/reports' => ['controller' => 'ManagerController', 'method' => 'reports', 'middleware' => ['auth', 'role:manager']],

    // Investor routes (protected)
    'GET /investor/dashboard' => ['controller' => 'InvestorController', 'method' => 'dashboard', 'middleware' => ['auth', 'role:investor']],
    'GET /api/investor/financial-data' => ['controller' => 'InvestorController', 'method' => 'getFinancialData', 'middleware' => ['auth', 'role:investor']],
    'GET /api/investor/documents' => ['controller' => 'InvestorController', 'method' => 'getDocuments', 'middleware' => ['auth', 'role:investor']],
    'POST /api/investor/partnership-application' => ['controller' => 'InvestorController', 'method' => 'submitPartnershipApplication', 'middleware' => ['auth', 'role:investor']],

    // API routes
    'GET /api/accounts/{id}' => ['controller' => 'ApiController', 'method' => 'getAccount'],
    'GET /api/transactions/{id}' => ['controller' => 'ApiController', 'method' => 'getTransaction'],

    // Logout
    'POST /logout' => ['controller' => 'AuthController', 'method' => 'logout'],
];