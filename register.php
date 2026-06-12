<?php
require 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");
    $stmt->execute([
        'username' => $username,
        'password' => $password
    ]);

    echo "Registratie succesvol!";
}
?>