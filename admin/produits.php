<?php
session_start();
require_once '../db.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    mysqli_query($conn, "INSERT INTO products (name, price) VALUES ('$name', '$price')");
}
$produits = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des Produits</title>
</head>
<body>
  <h2>Gestion des Produits</h2>
  <form method="post">
    <input type="text" name="name" placeholder="Nom du produit" required>
    <input type="number" step="0.01" name="price" placeholder="Prix" required>
    <button type="submit">Ajouter</button>
  </form>

  <h3>Liste des produits</h3>
  <ul>
    <?php while ($p = mysqli_fetch_assoc($produits)): ?>
      <li><?= htmlspecialchars($p['name']) ?> - <?= $p['price'] ?> €</li>
    <?php endwhile; ?>
  </ul>
  <p><a href="index.php">⬅️ Retour Admin</a></p>
</body>
</html>
