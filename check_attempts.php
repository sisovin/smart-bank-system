<?php
$pdo = new PDO('mysql:host=localhost;dbname=smart_bank_system', 'root', '');
$stmt = $pdo->query('SELECT * FROM login_attempts WHERE username = "customer1"');
$attempts = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($attempts);
?>