<?php
session_start(); // Démarre la session

// Vérifie si on a cliqué sur un lien "Ajouter au panier"
if (isset($_GET['ajouter'])) {
    $nom = $_GET['nom'];   // Nom du produit
    $prix = $_GET['prix']; // Prix du produit


    // Si le panier n'existe pas encore, on le crée
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Vérifie si le produit est déjà dans le panier
    $existe = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['nom'] === $nom) {
            $item['quantite']++;
            $existe = true;
            break;
        }
    }

    // Si le produit n'existe pas encore, on l'ajoute
    if (!$existe) {
        $_SESSION['cart'][] = [
            'nom' => $nom,
            'prix' => $prix,
            'quantite' => 1
        ];
    }
    // Redirige pour éviter d'ajouter deux fois si on recharge la page
    header('Location: index.php');

    exit;
}

    $cartLength = 0;

    if($_SESSION['cart'] != null ){
      
    foreach ($_SESSION['cart'] as &$item) {
        $cartLength += $item["quantite"] ;
      $_SESSION['cartLength'] = $cartLength;

    }
  }
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>E-Shop</title>
</head>
<body>
    <nav class="navbar">
        <div class="logo"><h1>E-Shop</h1></div>
        <ul class="menu">
            <li><a href="#" class="active">Accueil</a></li>
            <li><a href="#">Nouveautés</a></li>
            <li><a href="#">Solde</a></li>
            <li><a href="form.php" class="fa-solid fa-user"></a></li>
            <li><a href="panier.php" class="fa-solid fa-cart-shopping"><?php echo $cartLength; ?></a></li>
        </ul>
    </nav>
    <section class="content">
        <h1>Nouveautés
        <p>Notre nouveaux catalogue avec les technologies les plus avancées</p>
      <a href="promo_mac.php">
  <button class="btn">Découvrir</button>
</a>

</a>

</button>
    </section>

    <h1 class="produits_texte">Nos meilleurs ventes</h1>
    <section class="section_produits">
        <div class="produits">
            <div class="carte">
                <div class="img"><img src="image/hp1.jpg"></div>
                <div class="desc">Rizen 5x</div>
                <div class="titre">PC Gamer</div>
                <div class="box">
                <div class="prix">$1200</div>
                <a href="index.php?ajouter=1&nom=Rizen%20PC%20Gamer&prix=659"
                    class="achat"
                    onclick="return confirm('Voulez-vous ajouter ce produit à votre panier ?');">
                    Acheter
                </a>
                </div>

            </div>
            <div class="carte">
                <div class="img"><img src="https://m.media-amazon.com/images/I/61cQTk8UcYL.jpg"></div>
                <div class="desc">Souris</div>
                <div class="titre">Mars Gaming</div>
                <div class="box">
                <div class="prix">$70</div>
                <a href="index.php?ajouter=1&nom=Souris%20Mars%20Gaming&prix=659"
                    class="achat"
                    onclick="return confirm('Voulez-vous ajouter ce produit à votre panier ?');">
                    Acheter
                </a>
                </div>

            </div>
            <div class="carte">
                <div class="img"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQsoFIMfLrYmI2Vdo164SqYq2WSMihXh_Jk4w&s"></div>
                <div class="desc">Lenovo</div>
                <div class="titre">Gamer</div>
               <div class="box">
                <div class="prix">$800</div>
                <a href="index.php?ajouter=1&nom=Lenovo%20Gamer&prix=659"
                    class="achat"
                    onclick="return confirm('Voulez-vous ajouter ce produit à votre panier ?');">
                    Acheter
                </a>
                </div>

            </div>
            <div class="produits">
                <div class="carte">
                <div class="img"><img src="https://www.1fodiscount.com/ressources/site/img/product/clavier-gamer-mars-gaming-mk124-rgb-blanc_273208__480.webp"></div>
                <div class="desc">Clavier Mars</div>
                <div class="titre">Gaming MK124</div>
                <div class="box">
                <div class="prix">$120</div>
                <a href="index.php?ajouter=1&nom=Clavier%20Mars%20Gaming%20MK124&prix=659"
                    class="achat"
                    onclick="return confirm('Voulez-vous ajouter ce produit à votre panier ?');">
                    Acheter
                </a>
                </div>

            </div><div class="carte">
                <div class="img"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR5HAR5M5TWr4-6jOKACE7oKDokLHKsxzlnJA&s"></div>
                <div class="desc">SAMSUNG Core5</div>
                <div class="titre">Galaxy Book4</div>
                <div class="box">
                <div class="prix">$609,99</div>
                <a href="index.php?ajouter=1&nom=SAMSUNG%20Core5%20Galaxy%20Book4&prix=659"
                    class="achat"
                    onclick="return confirm('Voulez-vous ajouter ce produit à votre panier ?');">
                    Acheter
                </a>
                </div>

            </div>
            <div class="carte">
                <div class="img"><img src="https://m.media-amazon.com/images/I/71afEgG+J3L._UF1000,1000_QL80_.jpg"></div>
                <div class="desc">SAMSUNG BOOK3</div>
                <div class="titre">Galaxy </div>
                <div class="box">
                <div class="prix">$659</div>
                <a href="index.php?ajouter=1&nom=SAMSUNG%20BOOK3%20Galaxy&prix=659"
                    class="achat"
                    onclick="return confirm('Voulez-vous ajouter ce produit à votre panier ?');">
                    Acheter
                </a>
                </div>

            </div>
            <div class="produits">
            <div class="carte">
                <div class="img"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStpmx1oTQo7ykJfv2FPnX5F4TNeT7xSWX4uA&s"></div>
                <div class="desc">MSI</div>
                <div class="titre">PC Gamer</div>
                <div class="box">
                <div class="prix">$1900</div>
                <a href="index.php?ajouter=1&nom=MSI%20PC%20Gamer&prix=659"
                    class="achat"
                    onclick="return confirm('Voulez-vous ajouter ce produit à votre panier ?');">
                    Acheter
                </a>
                </div>

            </div>
            <div class="produits">
            <div class="carte">
                <div class="img"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSEbB0_bIRWxfXpRDV84axgRQVampacVG1fwA&s"></div>
                <div class="desc">HP</div>
                <div class="titre">Bureautique</div>
             <div class="box">
            <div class="prix">$678</div>
            <a href="index.php?ajouter=1&nom=HP%20Bureautique&prix=659"
                class="achat"
                onclick="return confirm('Voulez-vous ajouter ce produit à votre panier ?');">
                Acheter
            </a>
            </div>

            </div>
            <div class="produits">
            <div class="carte">
                <div class="img"><img src="https://m.media-amazon.com/images/I/61sRfXgKUeL._UF1000,1000_QL80_.jpg"></div>
                <div class="desc">HP </div>
                <div class="titre">Core i3</div>
               <div class="box">
                <div class="prix">$578</div>
                <a href="index.php?ajouter=1&nom=HP%20Core%20i3&prix=659"
                    class="achat"
                    onclick="return confirm('Voulez-vous ajouter ce produit à votre panier ?');">
                    Acheter
                </a>
                </div>

            </div>
            
        </div>
    </section>
    
</body>
</html>