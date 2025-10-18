<?php
require_once '../functions.php';

require_login();

global $conn;

$cart = get_cart($conn);
$message = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($cart)) {
        $message = "Votre panier est vide.";
    } else {
        $user = get_user();
        $user_id = $user['id'];
        $nom = $user['nom'];
        $prenom = $user['prenom'];
        $adresse = trim($_POST['adresse']);
        $ville = trim($_POST['ville']);
        $code_postal = trim($_POST['code_postal']);
        $telephone = trim($_POST['telephone']);

        $total = get_cart_total($cart);

        mysqli_begin_transaction($conn);

        try {
            $sql_order = "INSERT INTO orders (user_id, total, status, nom, prenom, adresse, ville, code_postal, telephone) 
                          VALUES ('$user_id', '$total', 'pending', '$nom', '$prenom', '$adresse', '$ville', '$code_postal', '$telephone')";

            if (!mysqli_query($conn, $sql_order)) {
                throw new Exception("Erreur lors de la création de la commande");
            }

            $order_id = mysqli_insert_id($conn);

            foreach ($cart as $item) {
                $product_id = $item['id'];
                $quantity = $item['quantite'];
                $price = $item['price'];
                $subtotal = $price * $quantity;

                $sql_line = "INSERT INTO order_items (order_id, product_id, quantity, price, subtotal) 
                             VALUES ('$order_id', '$product_id', '$quantity', '$price', '$subtotal')";

                if (!mysqli_query($conn, $sql_line)) {
                    throw new Exception("Erreur lors de l'ajout des produits");
                }
            }

            mysqli_commit($conn);

            clear_cart();

            $success = true;
            $message = "Votre commande a été enregistrée avec succès. Numéro de commande : #" . $order_id;

        } catch (Exception $e) {
            mysqli_rollback($conn);
            $message = "Erreur lors du traitement de votre commande : " . $e->getMessage();
        }
    }
}

$total = get_cart_total($cart);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement - Finaliser la commande</title>
    <link rel="stylesheet" href="../paiement.css">
</head>
<body>

<div class="container">
    <h1>Finaliser votre commande</h1>

    <?php if ($message): ?>
        <div class="message <?= $success ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
        <?php if ($success): ?>
            <div class="actions">
                <a href="index.php" class="btn btn-primary">Retour à la boutique</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!$success): ?>
        <?php if (empty($cart)): ?>
            <p class="empty-cart">Votre panier est vide.</p>
            <a href="index.php" class="btn btn-primary">Retour à la boutique</a>
        <?php else: ?>

            <div class="checkout-layout">
                <div class="order-summary">
                    <h2>Récapitulatif de la commande</h2>

                    <?php foreach ($cart as $item): ?>
                        <div class="summary-item">
                            <div class="item-details">
                                <h3><?= htmlspecialchars($item['name']) ?></h3>
                                <p>Quantité : <?= htmlspecialchars($item['quantite']) ?></p>
                            </div>
                            <div class="item-price">
                                <?= number_format($item['price'] * $item['quantite'], 2, ',', ' ') ?> EUR
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="summary-total">
                        <strong>Total à payer :</strong>
                        <strong><?= number_format($total, 2, ',', ' ') ?> EUR</strong>
                    </div>
                </div>

                <div class="payment-form">
                    <h2>Informations de livraison</h2>

                    <form method="POST" action="paiement.php">
                        <div class="form-group">
                            <label for="adresse">Adresse *</label>
                            <input type="text" id="adresse" name="adresse" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="code_postal">Code postal *</label>
                                <input type="text" id="code_postal" name="code_postal" required>
                            </div>

                            <div class="form-group">
                                <label for="ville">Ville *</label>
                                <input type="text" id="ville" name="ville" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="telephone">Téléphone *</label>
                            <input type="tel" id="telephone" name="telephone" required>
                        </div>

                        <div class="payment-method">
                            <h3>Méthode de paiement</h3>
                            <div class="method-option">
                                <input type="radio" id="offline" name="payment_method" value="offline" checked>
                                <label for="offline">
                                    <strong>Paiement à la livraison</strong>
                                    <span>Payez en espèces ou par carte lors de la réception de votre commande</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="panier.php" class="btn btn-secondary">Retour au panier</a>
                            <button type="submit" class="btn btn-primary">Confirmer la commande</button>
                        </div>
                    </form>
                </div>
            </div>

        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>