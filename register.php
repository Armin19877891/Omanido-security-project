<?php
session_start();
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordcheck = $_POST['passwordcheck'];

    if ($password === $passwordcheck) {

        // Check of username bestaat
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() == 0) {

            // Hash wachtwoord
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO user (username, password, balance, isAdmin) VALUES (?, ?, 100, 0)");
            $stmt->execute([$username, $hashedPassword]);

            $success = "Je account is aangemaakt, je kunt nu inloggen";

        } else {
            $error = "Deze gebruikersnaam is al in gebruik";
        }

    } else {
        $error = "De wachtwoorden komen niet overeen";
    }
}
?>

<!DOCTYPE html>

<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omanido - registreren</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<?php include 'includes/header.php'; ?>

<div class="container mx-auto mt-20 p-6 bg-white max-w-sm shadow-md rounded-md">
    <div class="flex justify-center">
        <img src="img/Omanido1.png" class="mb-6 w-1/2">
    </div>

```
<h2 class="text-lg text-center font-bold mb-6">Registreren bij Omanido</h2>

<?php if (isset($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-4">
        <?= $error ?>
    </div>
<?php endif; ?>

<?php if (isset($success)): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-4">
        <?= $success ?>
    </div>
<?php endif; ?>

<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="mb-4">
        <label>Gebruikersnaam:</label>
        <input type="text" name="username" class="w-full border rounded px-3 py-2">
    </div>

    <div class="mb-4">
        <label>Wachtwoord:</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2">
    </div>

    <div class="mb-6">
        <label>Herhaal wachtwoord:</label>
        <input type="password" name="passwordcheck" class="w-full border rounded px-3 py-2">
    </div>

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">
        Registreren
    </button>

</form>
```

</div>

</body>
</html>
