<?php

global $conn;
require_once '../functions.php';


if (isset($_GET['remove'])) {
    $product_id = (int)$_GET['remove'];
    remove_from_cart($product_id);
    header("Location: panier.php");
    exit;
}

$cart = get_cart($conn);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>🛒 Votre Panier</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #f6f7fb;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #222;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-info {
            flex: 1;
        }

        .item-info h3 {
            margin: 0;
            color: #333;
        }

        .item-info p {
            margin: 5px 0;
            color: #666;
        }

        .remove-btn {
            background: #e74c3c;
            border: none;
            color: #fff;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .remove-btn:hover {
            background: #c0392b;
        }

        .total {
            text-align: right;
            margin-top: 25px;
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }

        .empty {
            text-align: center;
            color: #888;
            font-size: 18px;
            padding: 40px 0;
        }

        .back-btn {
            display: inline-block;
            margin-top: 25px;
            background: #3498db;
            color: #fff;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .back-btn:hover {
            background: #2980b9;
        }

    </style>
</head>
<body>

<header>
    <a href="../index.php" style="text-decoration: none;"><h1 style="color:#ffffff;">🛍️ Mon Panier</h1></a>
</header>

<div class="container">
    <?php if (empty($cart)): ?>
        <p class="empty">Votre panier est vide.</p>
        <div style="text-align:center;">
            <a href="index.php" class="back-btn">← Retour à la boutique</a>
        </div>
    <?php else: ?>
        <?php
        $total = 0;
        foreach ($cart as $item):
            $total += $item['price'] * $item['quantite'];
            ?>
            <div class="cart-item">
                <div class="item-info">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p>Prix : <?= number_format($item['price'], 2, ',', ' ') ?> €</p>
                    <p>Quantité : <?= htmlspecialchars($item['quantite']) ?></p>
                </div>
                <form method="get" style="margin:0;">
                    <input type="hidden" name="remove" value="<?= htmlspecialchars($item['id']) ?>">
                    <button type="submit" class="remove-btn">Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>

        <div class="total">Total : <?= number_format($total, 2, ',', ' ') ?> €</div>

        <div style="text-align:center;">
            <a href="paiement.php" class="back-btn">← Continuer mes achats</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
