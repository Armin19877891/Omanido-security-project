<?php
session_start();
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // SAFE: prepared statement
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // password check (works with hashed passwords from register)
    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['user'] = $user;

        header("Location: dashboard.php");
        exit;

    } else {
        $error = "Gebruikersnaam of wachtwoord is onjuist";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="container mx-auto mt-20 p-6 bg-white max-w-sm shadow-md rounded-md">

    <h2 class="text-lg text-center font-bold mb-6">Inloggen</h2>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="post">

        <input type="text" name="username" placeholder="Gebruikersnaam"
               class="w-full border p-2 mb-3">

        <input type="password" name="password" placeholder="Wachtwoord"
               class="w-full border p-2 mb-3">

        <button class="w-full bg-blue-600 text-white p-2">
            Login
        </button>

    </form>

    <a href="register.php" class="block text-center mt-4 text-blue-600">
        Register
    </a>

</div>

</body>
</html>