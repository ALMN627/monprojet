<?php
// functions.php - helpers d'auth et utilitaires
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in() {
    return !empty($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: /client/login.php');
        exit;
    }
}

function require_admin() {
    if (!is_logged_in() || !is_admin()) {
        header('Location: /client/login.php');
        exit;
    }
}

// Tentative de connexion
function attempt_login($username, $password) {
    global $conn;
    $stmt = $conn->prepare('SELECT id, username, password_hash, role FROM users WHERE username = ? LIMIT 1');
    if (!$stmt) return false;
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $row = $res->fetch_assoc()) {
        if (password_verify($password, $row['password_hash'])) {
            // réussite
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            return true;
        }
    }
    return false;
}

function logout() {
    if (session_status() === PHP_SESSION_ACTIVE) {
        $_SESSION = [];
        session_destroy();
    }
}
?>
