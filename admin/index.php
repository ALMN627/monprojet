<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil - Mon Projet</title>
</head>
<body>
  <h1>Bienvenue sur Mon Projet</h1>
  <?php if (isset($_SESSION['username'])): ?>
    <p>Bonjour, <b><?= htmlspecialchars($_SESSION['username']) ?></b> !</p>
    <p><a href="logout.php">Se déconnecter</a></p>
    <?php if ($_SESSION['role'] === 'admin'): ?>
      <p><a href="admin/">➡️ Accéder à l’espace admin</a></p>
    <?php else: ?>
      <p><a href="client/">➡️ Accéder à l’espace client</a></p>
    <?php endif; ?>
  <?php else: ?>
    <p><a href="login.php">Se connecter</a> | <a href="register.php">S’inscrire</a></p>
  <?php endif; ?>
</body>
</html>
