<?php
// db.php (connexion à la base existante)
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "my_app_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("❌ Erreur de connexion : " . mysqli_connect_error());
}
?>
