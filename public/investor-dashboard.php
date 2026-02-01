<?php
// investor-dashboard.php - Public entry point for investor dashboard

// Start session for authentication
session_start();

// Include the investor controller
require_once '../app/controllers/InvestorController.php';

// The controller will handle the routing and display logic
?>