<?php
global $conn;
session_start();
require_once 'functions.php';

$error = "";
$message = isset($_GET['message']) ? $_GET['message'] : "";

if (is_logged_in()) {
    header("Location: client/");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (attempt_login($email, $password)) {
        if ($_SESSION['role'] === 'admin') {
            header("Location: admin/");
        } else {
            header("Location: client/");
        }
        exit;
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styleform.css">
    <title>Connexion</title>
</head>
<body>

<div class="container">
    <form id="login-form" class="form" action="login.php" method="POST">
        <h2>Connexion</h2>


        <?php if ($message): ?>
            <p style="color:green;"><?= $message ?></p>
        <?php endif; ?>

        <label for="login-email">Email :</label>
        <input type="email" id="login-email" name="email" required>

        <label for="login-password">Mot de passe :</label>
        <input type="password" id="login-password" name="password" required>

        <?php if ($error): ?>
            <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>

        <p><a href="index.php"> Accueil</a></p>
        <p><a href="register.php"> S'inscrire</a></p>

        <button type="submit">Se connecter</button>
    </form>
</div>


</body>
</html>
