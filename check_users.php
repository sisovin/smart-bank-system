<?php
$pdo = new PDO('mysql:host=localhost;dbname=smart_bank_system', 'root', '');
$stmt = $pdo->query('SELECT user_id, username, email, role_id FROM users');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($users);
?>