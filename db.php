<?php
// db.php (connexion à la base existante)
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "my_app_db";

$conn = mysqli_connect($host, $user, $pass);
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

try {
    mysqli_select_db($conn, "my_app_db");
} catch (Exception $exception) {
}

