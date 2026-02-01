-- Insert Investor Role if not exists
INSERT INTO roles (role_name, description) VALUES
('investor', 'Investor with access to investment features')
ON DUPLICATE KEY UPDATE role_name = role_name;

-- Insert Customer User (password: Customer123!)
INSERT INTO users (username, email, password_hash, role_id) VALUES
('customer1', 'customer@smartbank.com', '$argon2id$v=19$m=65536,t=4,p=1$examplehash', 3);

-- Insert Investor User (password: Investor123!)
INSERT INTO users (username, email, password_hash, role_id) VALUES
('investor1', 'investor@smartbank.com', '$argon2id$v=19$m=65536,t=4,p=1$examplehash', 4);

-- Get user IDs (assuming auto increment starts from 2 for customer, 3 for investor)
-- Insert Customer Details
INSERT INTO customers (user_id, first_name, last_name, date_of_birth, address, phone, kyc_status) VALUES
(2, 'John', 'Doe', '1990-01-01', '123 Main St, City, State 12345', '555-123-4567', 'verified');

-- Insert Investor Details (investors might also be in customers table)
INSERT INTO customers (user_id, first_name, last_name, date_of_birth, address, phone, kyc_status) VALUES
(3, 'Jane', 'Smith', '1985-05-15', '456 Investment Ave, City, State 67890', '555-987-6543', 'verified');

-- Insert Customer Account
INSERT INTO accounts (account_number, customer_id, account_type, balance, interest_rate) VALUES
('SB0010001', 1, 'savings', 5000.00, 2.5);

-- Insert Investor Account
INSERT INTO accounts (account_number, customer_id, account_type, balance, interest_rate) VALUES
('SB0010002', 2, 'business', 25000.00, 1.0);

-- Insert Sample Transactions
INSERT INTO transactions (transaction_ref, to_account_id, transaction_type, amount, description, status) VALUES
('TXN001', 1, 'deposit', 5000.00, 'Initial deposit', 'completed');

INSERT INTO transactions (transaction_ref, to_account_id, transaction_type, amount, description, status) VALUES
('TXN002', 2, 'deposit', 25000.00, 'Investment deposit', 'completed');