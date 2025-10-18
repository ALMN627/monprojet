<?php
global $conn;
require_once 'db.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Cet email existe déjà.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($conn, "INSERT INTO users (nom, prenom, email, password_hash, role) VALUES ('$nom', '$prenom', '$email', '$hash', 'client')");
            $message = "Compte créé avec succès !";

            header("Location: login.php?message=$message");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="styleform.css">
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
<div class="container">
    <form id="register-form" class="form" action="register.php" method="POST">
        <h2>Inscription</h2>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirmez le mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" required>


        <?php if($error): ?>
            <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>

        <p><a href="login.php"> Se connecter</a></p>

        <button type="submit">S'inscrire</button>
    </form>
</div>
</body>
</html>