<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'client') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Espace Client</title>
</head>
<body>
  <h1>👋 Bonjour <?= htmlspecialchars($_SESSION['username']) ?></h1>
  <p>Bienvenue dans votre espace client.</p>
  <p><a href="../logout.php">Se déconnecter</a></p>
</body>
</html>
