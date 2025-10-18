<?php
global $conn;
require_once 'db.php';

echo "<h2>Installation de la base de données</h2>";

$sql_create_db = "CREATE DATABASE IF NOT EXISTS my_app_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (mysqli_query($conn, $sql_create_db)) {
    echo "<p style='color:green;'>Base de données 'my_app_db' prête.</p>";
} else {
    die("<p style='color:red;'>Erreur lors de la création de la base : " . mysqli_error($conn) . "</p>");
}

mysqli_select_db($conn, "my_app_db");

$tables = [
    "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        prenom VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        role ENUM('admin','client') DEFAULT 'client',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        image VARCHAR(255),
        price DECIMAL(10,2) DEFAULT 0.00,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        total DECIMAL(10,2) DEFAULT 0.00,
        status VARCHAR(50) DEFAULT 'pending',
        nom VARCHAR(100) NOT NULL,
        prenom VARCHAR(100) NOT NULL,
        adresse VARCHAR(255) NOT NULL,
        ville VARCHAR(100) NOT NULL,
        code_postal VARCHAR(20) NOT NULL,
        telephone VARCHAR(20) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )",
    "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        subtotal DECIMAL(10,2) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    )"
];

foreach ($tables as $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green;'>Table créée avec succès.</p>";
    } else {
        echo "<p style='color:red;'>Erreur lors de la création d'une table : " . mysqli_error($conn) . "</p>";
    }
}

$check_admin = mysqli_query($conn, "SELECT * FROM users WHERE email='admin@admin.com'");
if (mysqli_num_rows($check_admin) == 0) {
    $pass = password_hash('admin123', PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users (nom,prenom,email, password_hash, role) VALUES ('admin','admin','admin@admin.com', '$pass', 'admin')");
    echo "<p style='color:green;'>👑 Admin créé : <b>admin@admin.com / admin123</b></p>";
} else {
    echo "<p>Admin déjà existant.</p>";
}

$produits = [
    ["name" => "PC Gamer Rizen 5x", "description" => "PC Gamer haute performance avec processeur Rizen 5x", "image" => "https://m.media-amazon.com/images/I/81qnQjkb2IL.jpg", "price" => 1200],
    ["name" => "Souris Mars Gaming", "description" => "Souris gaming RGB ergonomique", "image" => "https://m.media-amazon.com/images/I/61cQTk8UcYL.jpg", "price" => 70],
    ["name" => "PC Gamer Lenovo", "description" => "Ordinateur portable gaming Lenovo", "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQsoFIMfLrYmI2Vdo164SqYq2WSMihXh_Jk4w&s", "price" => 800],
    ["name" => "Clavier Mars Gaming MK124", "description" => "Clavier mécanique RGB blanc", "image" => "https://www.1fodiscount.com/ressources/site/img/product/clavier-gamer-mars-gaming-mk124-rgb-blanc_273208__480.webp", "price" => 120],
    ["name" => "SAMSUNG Galaxy Book4", "description" => "Ordinateur portable SAMSUNG Core i5", "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR5HAR5M5TWr4-6jOKACE7oKDokLHKsxzlnJA&s", "price" => 609.99],
    ["name" => "SAMSUNG Galaxy Book3", "description" => "Laptop SAMSUNG haute performance", "image" => "https://m.media-amazon.com/images/I/71afEgG+J3L._UF1000,1000_QL80_.jpg", "price" => 659],
    ["name" => "PC Gamer MSI", "description" => "PC Gaming MSI ultra puissant", "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStpmx1oTQo7ykJfv2FPnX5F4TNeT7xSWX4uA&s", "price" => 1900],
    ["name" => "HP Bureautique", "description" => "Ordinateur HP pour usage professionnel", "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSEbB0_bIRWxfXpRDV84axgRQVampacVG1fwA&s", "price" => 678],
    ["name" => "HP Core i3", "description" => "Laptop HP avec processeur Intel Core i3", "image" => "https://m.media-amazon.com/images/I/61sRfXgKUeL._UF1000,1000_QL80_.jpg", "price" => 578],
    ["name" => "Casque Gaming Razer", "description" => "Casque audio gaming avec micro", "image" => "https://placehold.co/600x400", "price" => 89.99],
    ["name" => "Écran ASUS 27 pouces", "description" => "Moniteur gaming 144Hz Full HD", "image" => "https://placehold.co/600x400", "price" => 299],
    ["name" => "Webcam Logitech HD", "description" => "Webcam 1080p pour streaming", "image" => "https://placehold.co/600x400", "price" => 79.99],
    ["name" => "Tapis de souris XXL", "description" => "Tapis de souris gaming extra large RGB", "image" => "https://placehold.co/600x400", "price" => 35],
    ["name" => "Chaise Gaming", "description" => "Fauteuil ergonomique pour gamers", "image" => "https://placehold.co/600x400", "price" => 249],
    ["name" => "SSD Samsung 1To", "description" => "Disque SSD NVMe ultra rapide", "image" => "https://placehold.co/600x400", "price" => 129.99]
];

$check_products = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$row = mysqli_fetch_assoc($check_products);
if ($row['total'] == 0) {
    foreach ($produits as $produit) {
        $name = mysqli_real_escape_string($conn, $produit['name']);
        $description = mysqli_real_escape_string($conn, $produit['description']);
        $image = mysqli_real_escape_string($conn, $produit['image']);
        $price = $produit['price'];

        $sql = "INSERT INTO products (name, description, image, price) VALUES ('$name', '$description', '$image', $price)";
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green;'>Produit ajouté : $name</p>";
        } else {
            echo "<p style='color:red;'>Erreur pour : $name - " . mysqli_error($conn) . "</p>";
        }
    }
} else {
    echo "<p>Produits déjà existants dans la base.</p>";
}

echo "<hr><p><a href='client/index.php'>Accéder à l'espace client</a></p>";
?>