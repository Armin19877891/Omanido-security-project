<?php
session_start();
include 'includes/db.php';

//Tables aanmaken
include 'includes/userTable.php';
include 'includes/transactionTable.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Gebruik prepared statement
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user'] = $user;

        header("location: dashboard.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omanido</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<?php include 'includes/header.php'; ?>

<div class="container mx-auto mt-20 p-6 bg-white max-w-sm shadow-md rounded-md">
    <div class="flex justify-center">
        <img src="img/Omanido1.png" alt="Omanido Logo" class="mb-6 w-1/2">
    </div>
    <h2 class="text-lg text-center font-bold mb-6">Inloggen bij Omanido</h2>

```
<?php if (isset($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= $error ?>
    </div>
<?php endif; ?>

<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="mb-4">
        <label class="block text-sm font-medium">Gebruikersnaam:</label>
        <input type="text" name="username" class="w-full border rounded px-3 py-2">
    </div>

    <div class="mb-6">
        <label class="block text-sm font-medium">Wachtwoord:</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2">
    </div>

    <input type="submit" value="Inloggen" class="w-full bg-blue-600 text-white py-2 rounded">
</form>

<a href="register.php" class="block text-center text-blue-600 mt-4">
    Nog geen account? Registreer hier
</a>
```

</div>

</body>
</html>
