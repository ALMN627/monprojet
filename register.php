<?php
require_once 'db.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Vérifie si l'utilisateur existe déjà
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $message = "⚠️ Ce nom d’utilisateur existe déjà.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users (username, password_hash, role) VALUES ('$username', '$hash', 'client')");
        $message = "✅ Compte créé avec succès ! <a href='login.php'>Connectez-vous</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
</head>
<body>
  <h2>Créer un compte</h2>
  <form method="post">
    <label>Nom d’utilisateur :</label><br>
    <input type="text" name="username" required><br><br>
    <label>Mot de passe :</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">S’inscrire</button>
  </form>
  <p><?= $message ?></p>
  <p><a href="index.php">⬅️ Retour</a></p>
</body>
</html>
