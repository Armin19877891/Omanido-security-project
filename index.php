<?php 
session_start();
require 'includes/db.php';

// Tables aanmaken
require 'includes/userTable.php';
require 'includes/transactionTable.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Input ophalen en valideren
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Vul alle velden in.";
    } else {

        // ✅ PREPARED STATEMENT (VEILIG)
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Controleer wachtwoord
        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['user'] = $user;

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Gebruikersnaam of wachtwoord is onjuist.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Omanido</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
<?php include 'includes/header.php'; ?>

<div class="container mx-auto mt-20 p-6 bg-white max-w-sm shadow-md rounded-md">

    <h2 class="text-lg text-center font-bold mb-6">Inloggen</h2>

    <?php if (!empty($error)): ?>
        <div class="text-red-500 mb-4"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Gebruikersnaam"
               class="w-full mb-3 p-2 border rounded" required>

        <input type="password" name="password" placeholder="Wachtwoord"
               class="w-full mb-3 p-2 border rounded" required>

        <button class="bg-blue-500 text-white px-4 py-2 rounded w-full">
            Login
        </button>
    </form>
</div>

</body>
</html>