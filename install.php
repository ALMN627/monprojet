<?php
require_once 'db.php';

echo "<h2>Installation de la base de données</h2>";

// Étape 1 : Création de la base
$sql_create_db = "CREATE DATABASE IF NOT EXISTS my_app_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (mysqli_query($conn, $sql_create_db)) {
    echo "<p style='color:green;'> Base de données 'my_app_db' prête.</p>";
} else {
    die("<p style='color:red;'>Erreur lors de la création de la base : " . mysqli_error($conn) . "</p>");
}


mysqli_select_db($conn, "my_app_db");

// Creer bd 
$tables = [
    "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        role ENUM('admin','client') DEFAULT 'client',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) DEFAULT 0.00,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        total DECIMAL(10,2) DEFAULT 0.00,
        status VARCHAR(50) DEFAULT 'pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )"
];

foreach ($tables as $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green;'> Table créée avec succès.</p>";
    } else {
        echo "<p style='color:red;'> Erreur lors de la création d'une table : " . mysqli_error($conn) . "</p>";
    }
}

// espace admin bd 
$check_admin = mysqli_query($conn, "SELECT * FROM users WHERE username='admin'");
if (mysqli_num_rows($check_admin) == 0) {
    $pass = password_hash('admin123', PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users (username, password_hash, role) VALUES ('admin', '$pass', 'admin')");
    echo "<p style='color:green;'>👑 Admin créé : <b>admin / admin123</b></p>";
} else {
    echo "<p>👑 Admin déjà existant.</p>";
}

echo "<hr><p><a href='test_db.php'>Tester la base</a></p>";
?>
