<?php
// Investor Dashboard - Main landing page after investor login
require_once '../../config/constants.php';
require_once '../../config/database.php';

// Check if user is logged in and is an investor
// This would typically be handled by middleware, but for now we'll assume authentication

$pageTitle = 'Investor Dashboard - SmartBank';
require_once '../templates/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-blue: #1E3A8A;
            --secondary-green: #10B981;
            --accent-gold: #F59E0B;
            --neutral-gray: #6B7280;
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #2D4A9E 100%);
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .metric-card {
            transition: transform 0.2s ease-in-out;
        }

        .metric-card:hover {
            transform: translateY(-2px);
        }

        .sidebar-active {
            background-color: var(--primary-blue);
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Mobile Menu Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar fixed left-0 top-0 h-full w-64 bg-white shadow-lg z-50 transform lg:transform-none lg:static lg:inset-0">
        <div class="gradient-bg p-6">
            <div class="flex items-center space-x-3">
                <i class="fas fa-building text-white text-2xl"></i>
                <div>
                    <h1 class="text-white font-bold text-lg">SmartBank</h1>
                    <p class="text-blue-200 text-sm">Investor Portal</p>
                </div>
            </div>
        </div>

        <nav class="mt-6">
            <div class="px-4 space-y-2">
                <a href="#overview" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors" onclick="showSection('overview')">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard Overview</span>
                </a>

                <a href="#performance" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors" onclick="showSection('performance')">
                    <i class="fas fa-chart-bar"></i>
                    <span>Financial Performance</span>
                </a>

                <a href="#opportunities" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors" onclick="showSection('opportunities')">
                    <i class="fas fa-handshake"></i>
                    <span>Investment Opportunities</span>
                </a>

                <a href="#market" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors" onclick="showSection('market')">
                    <i class="fas fa-chart-pie"></i>
                    <span>Market Analysis</span>
                </a>

                <a href="#compliance" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors" onclick="showSection('compliance')">
                    <i class="fas fa-shield-alt"></i>
                    <span>Compliance & Security</span>
                </a>

                <a href="#partnership" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors" onclick="showSection('partnership')">
                    <i class="fas fa-users"></i>
                    <span>Partnership Portal</span>
                </a>

                <a href="#reports" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors" onclick="showSection('reports')">
                    <i class="fas fa-file-alt"></i>
                    <span>Reports & Documents</span>
                </a>
            </div>
        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-4 border-t">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-blue-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">John Investor</p>
                    <p class="text-xs text-gray-500">Accredited Investor</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content lg:ml-64 min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Investor Dashboard</h2>
                            <p class="text-sm text-gray-600">Welcome back, John. Here's your investment overview.</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Market Indicators -->
                        <div class="hidden md:flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-chart-line text-green-500"></i>
                                <span class="text-sm font-medium">S&P 500: +1.2%</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-building text-blue-500"></i>
                                <span class="text-sm font-medium">SMBK: +0.8%</span>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="relative">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                <i class="fas fa-plus"></i>
                                <span class="hidden sm:inline">Quick Actions</span>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden">
                                <div class="py-1">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Download Report</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Schedule Meeting</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Contact Team</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="p-4 sm:p-6 lg:p-8">
            <!-- Overview Section -->
            <div id="overview-section" class="dashboard-section">
                <!-- Key Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="metric-card bg-white rounded-lg p-6 card-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Portfolio Value</p>
                                <p class="text-2xl font-bold text-gray-900">$2.4M</p>
                                <p class="text-sm text-green-600 flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    +12.5% YTD
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="metric-card bg-white rounded-lg p-6 card-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Annual Revenue</p>
                                <p class="text-2xl font-bold text-gray-900">$45.2M</p>
                                <p class="text-sm text-green-600 flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    +8.3% YoY
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-chart-line text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="metric-card bg-white rounded-lg p-6 card-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Customer Growth</p>
                                <p class="text-2xl font-bold text-gray-900">24.8K</p>
                                <p class="text-sm text-green-600 flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    +15.2% MoM
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-users text-yellow-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="metric-card bg-white rounded-lg p-6 card-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Risk Rating</p>
                                <p class="text-2xl font-bold text-gray-900">AA</p>
                                <p class="text-sm text-green-600 flex items-center">
                                    <i class="fas fa-shield-alt mr-1"></i>
                                    Stable
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Revenue Growth Chart -->
                    <div class="bg-white rounded-lg p-6 card-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue Growth Trend</h3>
                        <canvas id="revenueChart" width="400" height="200"></canvas>
                    </div>

                    <!-- Market Share Chart -->
                    <div class="bg-white rounded-lg p-6 card-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Market Position</h3>
                        <canvas id="marketChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg p-6 card-shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity & Updates</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Q4 Financial Report Published</p>
                                <p class="text-xs text-gray-600">Comprehensive financial results and market analysis now available</p>
                                <p class="text-xs text-gray-500 mt-1">2 hours ago</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-handshake text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">New Partnership Announced</p>
                                <p class="text-xs text-gray-600">Strategic alliance with leading fintech company for digital transformation</p>
                                <p class="text-xs text-gray-500 mt-1">1 day ago</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-chart-line text-yellow-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Market Analysis Updated</p>
                                <p class="text-xs text-gray-600">Latest industry trends and competitive landscape analysis</p>
                                <p class="text-xs text-gray-500 mt-1">3 days ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Section -->
            <div id="performance-section" class="dashboard-section hidden">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Financial Performance</h2>
                    <p class="text-gray-600">Detailed analysis of revenue, profitability, and financial health</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg p-6 card-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue Breakdown</h3>
                        <canvas id="revenueBreakdownChart" width="300" height="200"></canvas>
                    </div>

                    <div class="bg-white rounded-lg p-6 card-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Profit Margins</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Net Profit Margin</span>
                                <span class="font-semibold">18.5%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 18.5%"></div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Operating Margin</span>
                                <span class="font-semibold">22.3%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 22.3%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg p-6 card-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Key Ratios</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">ROE</span>
                                <span class="font-semibold text-green-600">14.2%</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">ROA</span>
                                <span class="font-semibold text-green-600">1.8%</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Debt/Equity</span>
                                <span class="font-semibold text-blue-600">0.45</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Current Ratio</span>
                                <span class="font-semibold text-blue-600">1.32</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Investment Opportunities Section -->
            <div id="opportunities-section" class="dashboard-section hidden">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Investment Opportunities</h2>
                    <p class="text-gray-600">Explore partnership models and investment vehicles</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg p-6 card-shadow border-l-4 border-blue-500">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-handshake text-blue-500 text-2xl mr-3"></i>
                            <h3 class="text-lg font-semibold text-gray-900">Strategic Partnership</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Joint venture opportunities in fintech innovation and digital banking solutions.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500">Investment Range</span>
                            <span class="font-semibold text-blue-600">$5M - $25M</span>
                        </div>
                        <button class="mt-4 w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            Learn More
                        </button>
                    </div>

                    <div class="bg-white rounded-lg p-6 card-shadow border-l-4 border-green-500">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-chart-line text-green-500 text-2xl mr-3"></i>
                            <h3 class="text-lg font-semibold text-gray-900">Private Equity</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Direct investment in bank expansion, technology upgrades, and market penetration.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500">Investment Range</span>
                            <span class="font-semibold text-green-600">$10M - $50M</span>
                        </div>
                        <button class="mt-4 w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                            Learn More
                        </button>
                    </div>

                    <div class="bg-white rounded-lg p-6 card-shadow border-l-4 border-yellow-500">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-building text-yellow-500 text-2xl mr-3"></i>
                            <h3 class="text-lg font-semibold text-gray-900">Real Estate Partnership</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Investment in branch network expansion and commercial property development.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500">Investment Range</span>
                            <span class="font-semibold text-yellow-600">$15M - $75M</span>
                        </div>
                        <button class="mt-4 w-full bg-yellow-600 text-white py-2 px-4 rounded-lg hover:bg-yellow-700 transition-colors">
                            Learn More
                        </button>
                    </div>
                </div>

                <!-- Investment Calculator -->
                <div class="mt-8 bg-white rounded-lg p-6 card-shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Investment Calculator</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Investment Amount</label>
                            <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="$10,000">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Time Horizon (Years)</label>
                            <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="5">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Expected Return (%)</label>
                            <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="12">
                        </div>
                    </div>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Calculate Returns
                    </button>
                </div>
            </div>

            <!-- Market Analysis Section -->
            <div id="market-section" class="dashboard-section hidden">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Market Analysis</h2>
                    <p class="text-gray-600">Industry trends, competitive landscape, and economic indicators</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-lg p-6 card-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Industry Growth Trends</h3>
                        <canvas id="industryChart" width="400" height="250"></canvas>
                    </div>

                    <div class="bg-white rounded-lg p-6 card-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Competitive Position</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium">SmartBank Market Share</span>
                                <span class="font-semibold">8.5%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-blue-500 h-3 rounded-full" style="width: 8.5%"></div>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium">Digital Banking Adoption</span>
                                <span class="font-semibold">92%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-green-500 h-3 rounded-full" style="width: 92%"></div>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium">Customer Satisfaction</span>
                                <span class="font-semibold">4.8/5</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-yellow-500 h-3 rounded-full" style="width: 96%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Market Insights -->
                <div class="bg-white rounded-lg p-6 card-shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Market Insights</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-trending-up text-green-500 mr-2"></i>
                                <span class="font-medium text-gray-900">Digital Banking Growth</span>
                            </div>
                            <p class="text-sm text-gray-600">Digital banking transactions expected to reach $8.2T globally by 2025</p>
                        </div>

                        <div class="p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-mobile-alt text-blue-500 mr-2"></i>
                                <span class="font-medium text-gray-900">Mobile Banking</span>
                            </div>
                            <p class="text-sm text-gray-600">78% of banking customers use mobile apps for primary banking needs</p>
                        </div>

                        <div class="p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-shield-alt text-yellow-500 mr-2"></i>
                                <span class="font-medium text-gray-900">Security Investment</span>
                            </div>
                            <p class="text-sm text-gray-600">Banks investing $150B+ annually in cybersecurity and compliance</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compliance & Security Section -->
            <div id="compliance-section" class="dashboard-section hidden">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Compliance & Security</h2>
                    <p class="text-gray-600">Regulatory compliance, security measures, and risk management</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg p-6 card-shadow text-center">
                        <i class="fas fa-lock text-3xl text-blue-500 mb-3"></i>
                        <h3 class="font-semibold text-gray-900 mb-2">PCI DSS</h3>
                        <p class="text-sm text-gray-600">Level 1 Compliant</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Certified</span>
                    </div>

                    <div class="bg-white rounded-lg p-6 card-shadow text-center">
                        <i class="fas fa-file-contract text-3xl text-green-500 mb-3"></i>
                        <h3 class="font-semibold text-gray-900 mb-2">ISO 27001</h3>
                        <p class="text-sm text-gray-600">Information Security</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Certified</span>
                    </div>

                    <div class="bg-white rounded-lg p-6 card-shadow text-center">
                        <i class="fas fa-gavel text-3xl text-yellow-500 mb-3"></i>
                        <h3 class="font-semibold text-gray-900 mb-2">AML/KYC</h3>
                        <p class="text-sm text-gray-600">Anti-Money Laundering</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Compliant</span>
                    </div>

                    <div class="bg-white rounded-lg p-6 card-shadow text-center">
                        <i class="fas fa-user-shield text-3xl text-purple-500 mb-3"></i>
                        <h3 class="font-semibold text-gray-900 mb-2">GDPR</h3>
                        <p class="text-sm text-gray-600">Data Protection</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Compliant</span>
                    </div>
                </div>

                <!-- Security Metrics -->
                <div class="bg-white rounded-lg p-6 card-shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Security Metrics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600 mb-2">99.99%</div>
                            <p class="text-sm text-gray-600">System Uptime</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-2">0</div>
                            <p class="text-sm text-gray-600">Security Breaches (Last 24 Months)</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-600 mb-2">24/7</div>
                            <p class="text-sm text-gray-600">Security Monitoring</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partnership Portal Section -->
            <div id="partnership-section" class="dashboard-section hidden">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Partnership Portal</h2>
                    <p class="text-gray-600">Due diligence tools and partnership application process</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Due Diligence Access -->
                    <div class="bg-white rounded-lg p-6 card-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Due Diligence Documents</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-pdf text-red-500"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">Financial Statements 2023</p>
                                        <p class="text-sm text-gray-600">Audited financial reports</p>
                                    </div>
                                </div>
                                <button class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>

                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-pdf text-red-500"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">Business Plan 2024-2026</p>
                                        <p class="text-sm text-gray-600">Strategic growth plan</p>
                                    </div>
                                </div>
                                <button class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>

                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-pdf text-red-500"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">Risk Assessment Report</p>
                                        <p class="text-sm text-gray-600">Comprehensive risk analysis</p>
                                    </div>
                                </div>
                                <button class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Partnership Application -->
                    <div class="bg-white rounded-lg p-6 card-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Partnership Application</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Partnership Type</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>Strategic Partnership</option>
                                    <option>Private Equity Investment</option>
                                    <option>Real Estate Partnership</option>
                                    <option>Technology Collaboration</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Investment Amount</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="$">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Message to Investment Team</label>
                                <textarea rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tell us about your interest..."></textarea>
                            </div>

                            <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                Submit Application
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports & Documents Section -->
            <div id="reports-section" class="dashboard-section hidden">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Reports & Documents</h2>
                    <p class="text-gray-600">Access financial reports, prospectuses, and legal documents</p>
                </div>

                <div class="bg-white rounded-lg card-shadow">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Document Library</h3>
                                <p class="text-sm text-gray-600">Secure access to all investment documents</p>
                            </div>
                            <div class="mt-4 sm:mt-0 flex space-x-3">
                                <input type="text" placeholder="Search documents..." class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <select class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>All Types</option>
                                    <option>Financial Reports</option>
                                    <option>Legal Documents</option>
                                    <option>Market Analysis</option>
                                    <option>Presentations</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-200">
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                                    <div>
                                        <h4 class="text-lg font-medium text-gray-900">Annual Report 2023</h4>
                                        <p class="text-sm text-gray-600">Complete annual financial and operational report</p>
                                        <p class="text-xs text-gray-500 mt-1">Updated: Dec 31, 2023 • Size: 2.4 MB</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-800 p-2">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-blue-600 hover:text-blue-800 p-2">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <i class="fas fa-file-powerpoint text-orange-500 text-2xl"></i>
                                    <div>
                                        <h4 class="text-lg font-medium text-gray-900">Investor Presentation Q4 2023</h4>
                                        <p class="text-sm text-gray-600">Quarterly investor update and strategic outlook</p>
                                        <p class="text-xs text-gray-500 mt-1">Updated: Jan 15, 2024 • Size: 8.7 MB</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-800 p-2">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-blue-600 hover:text-blue-800 p-2">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <i class="fas fa-file-excel text-green-500 text-2xl"></i>
                                    <div>
                                        <h4 class="text-lg font-medium text-gray-900">Financial Projections 2024-2026</h4>
                                        <p class="text-sm text-gray-600">Detailed financial forecasts and assumptions</p>
                                        <p class="text-xs text-gray-500 mt-1">Updated: Feb 1, 2024 • Size: 1.2 MB</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-800 p-2">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-blue-600 hover:text-blue-800 p-2">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');

            if (window.innerWidth < 1024) {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('hidden');
            }
        }

        // Section navigation
        function showSection(sectionId) {
            // Hide all sections
            const sections = document.querySelectorAll('.dashboard-section');
            sections.forEach(section => section.classList.add('hidden'));

            // Remove active class from all sidebar links
            const links = document.querySelectorAll('.sidebar-link');
            links.forEach(link => link.classList.remove('sidebar-active'));

            // Show selected section
            document.getElementById(sectionId + '-section').classList.remove('hidden');

            // Add active class to clicked link
            event.target.closest('.sidebar-link').classList.add('sidebar-active');

            // Close sidebar on mobile after selection
            if (window.innerWidth < 1024) {
                toggleSidebar();
            }
        }

        // Initialize default active section
        document.addEventListener('DOMContentLoaded', function() {
            const defaultLink = document.querySelector('.sidebar-link');
            if (defaultLink) {
                defaultLink.classList.add('sidebar-active');
            }
        });

        // Chart.js initialization
        const revenueChart = new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue ($M)',
                    data: [32, 35, 38, 36, 41, 39, 44, 42, 46, 43, 48, 45.2],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return '$' + value + 'M';
                            }
                        }
                    }
                }
            }
        });

        const marketChart = new Chart(document.getElementById('marketChart'), {
            type: 'doughnut',
            data: {
                labels: ['SmartBank', 'Competitor A', 'Competitor B', 'Others'],
                datasets: [{
                    data: [8.5, 12.3, 9.8, 69.4],
                    backgroundColor: [
                        'rgb(59, 130, 246)',
                        'rgb(156, 163, 175)',
                        'rgb(209, 213, 219)',
                        'rgb(229, 231, 235)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        const revenueBreakdownChart = new Chart(document.getElementById('revenueBreakdownChart'), {
            type: 'pie',
            data: {
                labels: ['Digital Banking', 'Traditional Services', 'Investment Products', 'Other Services'],
                datasets: [{
                    data: [45, 30, 15, 10],
                    backgroundColor: [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(156, 163, 175)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        const industryChart = new Chart(document.getElementById('industryChart'), {
            type: 'bar',
            data: {
                labels: ['2020', '2021', '2022', '2023', '2024E', '2025E'],
                datasets: [{
                    label: 'Digital Banking Market Size ($T)',
                    data: [3.2, 4.1, 5.8, 7.2, 8.9, 11.2],
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value + 'T';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>