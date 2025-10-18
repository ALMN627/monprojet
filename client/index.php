<?php
global $conn;
require_once '../functions.php';

if (isset($_GET['ajouter'])) {
    $product_id = $_GET['id'];

    add_to_cart($product_id);

    header('Location: index.php');
    exit;
}

$cartLength = get_cart_count();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Shop</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
<nav class="navbar">
    <div class="logo"><h1>E-Shop</h1></div>
    <ul class="menu">
        <li><a href="#" class="active">Accueil</a></li>
        <li><a href="#">Nouveautés</a></li>
        <?php if (is_logged_in()): ?>
            <li><a href="../logout.php">Se déconnecter</a></li>
            <li><a href="index.php" class="text-primary"><?= get_user_name() ?></a></li>
        <?php endif; ?>
        <?php if (!is_logged_in()): ?>
            <li><a href="../login.php">Se connecter</a></li>
        <?php endif; ?>
        <li><a href="panier.php" class="fa-solid fa-cart-shopping"><?= $cartLength ?></a></li>
    </ul>
</nav>

<section class="content">
    <h1>Nouveautés</h1>
    <p>Notre nouveau catalogue avec les technologies les plus avancées</p>
    <a href="promo_mac.php">
        <button class="btn">Découvrir</button>
    </a>
</section>

<h1 class="produits_texte">Nos meilleures ventes</h1>
<section class="section_produits">
    <div class="produits">
        <?php
        $produits = getAllProducts($conn);

        foreach ($produits as $produit): ?>
            <div class="carte">
                <div class="img"><img src="<?= $produit['image'] ?>" alt="<?= htmlspecialchars($produit['name']) ?>"></div>
                <div class="desc"><?= htmlspecialchars($produit['description']) ?></div>
                <div class="titre"><?= htmlspecialchars($produit['name']) ?></div>
                <div class="box">
                    <div class="prix">$<?= $produit['price'] ?></div>
                    <a href="index.php?ajouter=1&id=<?= urlencode($produit['id']) ?>&prix=<?= $produit['price'] ?>"
                       class="achat"
                       onclick="return confirm('Voulez-vous ajouter ce produit à votre panier ?');">
                        Acheter
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
</body>
</html>
