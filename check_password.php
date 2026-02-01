<?php
$pdo = new PDO('mysql:host=localhost;dbname=smart_bank_system', 'root', '');
$stmt = $pdo->prepare('SELECT password_hash FROM users WHERE username = ?');
$stmt->execute(['customer1']);
$hash = $stmt->fetchColumn();
echo 'Hash: ' . $hash . PHP_EOL;
echo 'Verify Customer123!: ' . (password_verify('Customer123!', $hash) ? 'true' : 'false') . PHP_EOL;
?>