<?php
session_start();

// --- Exemple de 15 produits MacBook en promo ---
$macs = [
    ["id" => 101, "nom" => "MacBook Air M2", "prix" => 1299, "image" => "https://placehold.co/400x300?text=MacBook+Pro+13"],
    ["id" => 102, "nom" => "MacBook Pro 14” M3", "prix" => 2199, "image" => "https://placehold.co/400x300?text=MacBook+Pro+13"],
    ["id" => 103, "nom" => "MacBook Air M1", "prix" => 999, "image" => "https://placehold.co/400x300?text=MacBook+Pro+13"],
    ["id" => 104, "nom" => "MacBook Pro 16” M2 Max", "prix" => 3499, "image" => "https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/macbook-pro-16-spacegray-hero-2023?wid=400&hei=400"],
    ["id" => 105, "nom" => "MacBook Air 13” M2", "prix" => 1199, "image" => "https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/macbook-air-13-hero-2022?wid=400&hei=400"],
    ["id" => 106, "nom" => "MacBook Pro 13” M2", "prix" => 1499, "image" => "https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/macbook-pro-13-hero-2022?wid=400&hei=400"],
    ["id" => 107, "nom" => "MacBook Pro 16” M1 Max", "prix" => 3099, "image" => "https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/macbook-pro-16-m1-hero-2021?wid=400&hei=400"],
    ["id" => 108, "nom" => "MacBook Air 11”", "prix" => 899, "image" => "https://placehold.co/400x300?text=MacBook+Air+11"],
    ["id" => 109, "nom" => "MacBook Pro Retina 15”", "prix" => 1899, "image" => "https://placehold.co/400x300?text=MacBook+Pro+15"],
    ["id" => 110, "nom" => "MacBook Air M3", "prix" => 1399, "image" => "https://placehold.co/400x300?text=MacBook+Air+M3"],
    ["id" => 111, "nom" => "MacBook Pro 14” M2 Pro", "prix" => 2499, "image" => "https://placehold.co/400x300?text=MacBook+Pro+14"],
    ["id" => 112, "nom" => "MacBook Pro 16” M3 Max", "prix" => 3999, "image" => "https://placehold.co/400x300?text=MacBook+Pro+16"],
    ["id" => 113, "nom" => "MacBook Air 15”", "prix" => 1599, "image" =>"https://placehold.co/400x300?text=MacBook+Air+15"],
    ["id" => 114, "nom" => "MacBook Pro 13” M1", "prix" => 1299, "image" => "https://placehold.co/400x300?text=MacBook+Pro+13"],
    ["id" => 115, "nom" => "MacBook Pro 15” M2", "prix" => 2799, "image" => "https://placehold.co/400x300?text=MacBook+Pro+15"]
];

// --- Ajout au panier existant ---
if (isset($_POST['ajouter_panier'])) {
    $id = $_POST['produit_id'];
    $_SESSION['panier'][] = [
        'id' => $id,
        'nom' => $_POST['produit_nom'],
        'prix' => $_POST['produit_prix']
    ];
    header("Location: panier.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Promotions MacBook</title>
    <style>
        body {font-family: Arial, sans-serif; padding: 20px;}
        h1 {margin-bottom: 20px;}
        .produit {border: 1px solid #ddd; border-radius: 10px; padding: 15px; width: 250px; display: inline-block; margin: 10px; text-align: center; vertical-align: top;}
        img {width: 200px; height: auto; border-radius: 5px;}
        .btn {background: #4CAF50; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;}
        .btn:hover {background: #45a049;}
    </style>
</head>
<body>

<h1>Promotions sur les MacBook</h1>
<p>Découvrez nos offres spéciales limitées sur les produits Apple.</p>

<?php foreach ($macs as $mac): ?>
    <div class="produit">
        <img src="<?= $mac['image'] ?>" alt="<?= htmlspecialchars($mac['nom']) ?>">
        <h3><?= htmlspecialchars($mac['nom']) ?></h3>
        <p><strong><?= $mac['prix'] ?> €</strong></p>
        <form method="POST">
            <input type="hidden" name="produit_id" value="<?= $mac['id'] ?>">
            <input type="hidden" name="produit_nom" value="<?= htmlspecialchars($mac['nom']) ?>">
            <input type="hidden" name="produit_prix" value="<?= $mac['prix'] ?>">
            <button type="submit" name="ajouter_panier" class="btn">Acheter</button>
        </form>
    </div>
<?php endforeach; ?>

</body>
</html>
