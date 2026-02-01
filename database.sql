-- Create Database
CREATE DATABASE IF NOT EXISTS smart_bank_system;
USE smart_bank_system;

-- Users/Roles/Authentication
CREATE TABLE roles (
    role_id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role_id INT DEFAULT 3, -- Default: Customer
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

CREATE TABLE sessions (
    session_id VARCHAR(128) PRIMARY KEY,
    user_id INT NOT NULL,
    token_hash VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Customers & Accounts
CREATE TABLE customers (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(20),
    kyc_status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    kyc_documents JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE accounts (
    account_id INT PRIMARY KEY AUTO_INCREMENT,
    account_number VARCHAR(20) UNIQUE NOT NULL,
    customer_id INT NOT NULL,
    account_type ENUM('savings', 'checking', 'business') DEFAULT 'savings',
    balance DECIMAL(15,2) DEFAULT 0.00,
    interest_rate DECIMAL(5,2) DEFAULT 0.00,
    status ENUM('active', 'frozen', 'closed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE
);

-- Transactions & Double-Entry Accounting
CREATE TABLE transactions (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    transaction_ref VARCHAR(50) UNIQUE NOT NULL,
    from_account_id INT,
    to_account_id INT,
    transaction_type ENUM('deposit', 'withdrawal', 'transfer', 'interest', 'fee') NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    description TEXT,
    status ENUM('pending', 'completed', 'failed', 'reversed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_account_date (from_account_id, created_at),
    INDEX idx_customer_date (to_account_id, created_at),
    FOREIGN KEY (from_account_id) REFERENCES accounts(account_id),
    FOREIGN KEY (to_account_id) REFERENCES accounts(account_id)
);

CREATE TABLE journal_entries (
    entry_id INT PRIMARY KEY AUTO_INCREMENT,
    transaction_id INT NOT NULL,
    account_id INT NOT NULL,
    entry_type ENUM('debit', 'credit') NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (transaction_id) REFERENCES transactions(transaction_id),
    FOREIGN KEY (account_id) REFERENCES accounts(account_id)
);

-- Ledger Tables
CREATE TABLE general_ledger (
    ledger_id INT PRIMARY KEY AUTO_INCREMENT,
    account_id INT NOT NULL,
    debit DECIMAL(15,2) DEFAULT 0.00,
    credit DECIMAL(15,2) DEFAULT 0.00,
    balance DECIMAL(15,2) NOT NULL,
    transaction_date DATE NOT NULL,
    description TEXT,
    FOREIGN KEY (account_id) REFERENCES accounts(account_id)
);

-- Audit & Compliance
CREATE TABLE audit_logs (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action_type VARCHAR(100) NOT NULL,
    table_name VARCHAR(100),
    record_id INT,
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE login_attempts (
    attempt_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    success BOOLEAN DEFAULT FALSE,
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Default Roles
INSERT INTO roles (role_name, description) VALUES
('admin', 'System Administrator with full access'),
('teller', 'Bank teller with transaction processing rights'),
('customer', 'Regular banking customer');

-- Insert Admin User (password: Admin123!)
INSERT INTO users (username, email, password_hash, role_id) VALUES
('admin', 'admin@smartbank.com', '$argon2id$v=19$m=65536,t=4,p=1$T3l2Rm5hNVVpR0VvYzN6dg$qVKkQ5fFpN4O1Xr8jYwS2B7G9H0LzMnb', 1);