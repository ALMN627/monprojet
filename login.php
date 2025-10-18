<?php
session_start();
require_once 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id'];

        if ($user['role'] === 'admin') {
            header("Location: admin/");
        } else {
            header("Location: client/");
        }
        exit;
    } else {
        $message = "❌ Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
</head>
<body>
  <h2>Connexion</h2>
  <form method="post">
    <label>Nom d’utilisateur :</label><br>
    <input type="text" name="username" required><br><br>
    <label>Mot de passe :</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">Se connecter</button>
  </form>
  <p style="color:red;"><?= $message ?></p>
  <p><a href="index.php">⬅️ Retour</a></p>
</body>
</html>
