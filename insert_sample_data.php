<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=smart_bank_system', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert investor role
    $pdo->exec("INSERT INTO roles (role_name, description) VALUES ('investor', 'Investor with access to investment features') ON DUPLICATE KEY UPDATE role_name = role_name");

    // Insert customer user
    $hash1 = password_hash('Customer123!', PASSWORD_ARGON2ID);
    $pdo->exec("INSERT INTO users (username, email, password_hash, role_id) VALUES ('customer1', 'customer@smartbank.com', '$hash1', 3)");

    // Insert investor user
    $hash2 = password_hash('Investor123!', PASSWORD_ARGON2ID);
    $pdo->exec("INSERT INTO users (username, email, password_hash, role_id) VALUES ('investor1', 'investor@smartbank.com', '$hash2', 4)");

    // Get user IDs
    $stmt = $pdo->query('SELECT user_id FROM users WHERE username IN ("customer1", "investor1") ORDER BY user_id');
    $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Insert customer details
    $pdo->exec("INSERT INTO customers (user_id, first_name, last_name, date_of_birth, address, phone, kyc_status) VALUES ({$userIds[0]}, 'John', 'Doe', '1990-01-01', '123 Main St, City, State 12345', '555-123-4567', 'verified')");

    // Insert investor details
    $pdo->exec("INSERT INTO customers (user_id, first_name, last_name, date_of_birth, address, phone, kyc_status) VALUES ({$userIds[1]}, 'Jane', 'Smith', '1985-05-15', '456 Investment Ave, City, State 67890', '555-987-6543', 'verified')");

    // Get customer IDs
    $stmt = $pdo->query("SELECT customer_id FROM customers WHERE user_id IN ({$userIds[0]}, {$userIds[1]}) ORDER BY customer_id");
    $customerIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Insert accounts
    $pdo->exec("INSERT INTO accounts (account_number, customer_id, account_type, balance, interest_rate) VALUES ('SB0010001', {$customerIds[0]}, 'savings', 5000.00, 2.5)");
    $pdo->exec("INSERT INTO accounts (account_number, customer_id, account_type, balance, interest_rate) VALUES ('SB0010002', {$customerIds[1]}, 'business', 25000.00, 1.0)");

    echo 'Sample customer and investor accounts inserted successfully!' . PHP_EOL;
    echo 'Customer login: customer1 / Customer123!' . PHP_EOL;
    echo 'Investor login: investor1 / Investor123!' . PHP_EOL;

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
?>