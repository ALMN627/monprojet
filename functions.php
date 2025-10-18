<?php
// functions.php - helpers d'auth et utilitaires
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in()
{
    return !empty($_SESSION['user_id']);
}

function is_admin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function require_login()
{
    if (!is_logged_in()) {
        header('Location: /login.php');
        exit;
    }
}

function require_admin()
{
    if (!is_logged_in() || !is_admin()) {
        header('Location: /client/login.php');
        exit;
    }
}

// Tentative de connexion
function attempt_login($email, $password)
{
    global $conn;
    $stmt = $conn->prepare('SELECT id, email, password_hash, role FROM users WHERE email = ? LIMIT 1');
    if (!$stmt) return false;
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $row = $res->fetch_assoc()) {
        if (password_verify($password, $row['password_hash'])) {
            // réussite
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            return true;
        }
    }
    return false;
}

function get_user()
{
    if (!is_logged_in()) return false;

    global $conn;
    $stmt = $conn->prepare('SELECT id, email, nom, prenom, password_hash, role FROM users WHERE id = ? LIMIT 1');
    if (!$stmt) return false;
    $stmt->bind_param('s', $_SESSION['user_id']);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $row = $res->fetch_assoc()) {
        return $row;
    }
    return false;
}

function get_user_name()
{
    if (!is_logged_in()) return "";
    $user = get_user();
    if (!$user) return "";
    return $user['nom'] . " " . $user['prenom'];
}

function logout()
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        $_SESSION = [];
        session_destroy();
    }
}

function getAllProducts($conn)
{
    $products = [];
    $result = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }

    return $products;
}

function getProductById($conn, $id)
{
    $id = mysqli_real_escape_string($conn, $id);
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

function getProductsByIds($conn, array $ids)
{
    $products = [];

    $ids = array_filter($ids, function ($id) {
        return is_numeric($id);
    });

    if (empty($ids)) {
        return $products;
    }

    $idsList = implode(',', array_map('intval', $ids));
    $query = "SELECT * FROM products WHERE id IN ($idsList)";

    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }

    return $products;
}

function get_session_cart()
{
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
}

function save_cart_to_session($cart)
{
    $_SESSION['cart'] = array_values(array_map(function ($item) {
        return [
            'product_id' => (int)(isset($item['product_id']) ? $item['product_id'] : $item['id']),
            'quantite' => (int)$item['quantite']
        ];
    }, $cart));
}

function add_to_cart($product_id, $quantity = 1)
{
    $cart = get_session_cart();

    $index = array_search($product_id, array_column($cart, 'product_id'));

    if ($index !== false) {
        $cart[$index]['quantite'] += $quantity;
    } else {
        $cart[] = [
            'product_id' => (int)$product_id,
            'quantite' => (int)$quantity
        ];
    }

    save_cart_to_session($cart);
    return true;
}

function get_cart_count()
{
    $cart = get_session_cart();
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['quantite'];
    }
    return $total;
}

function get_cart($conn)
{
    $cart = get_session_cart();

    if (empty($cart)) {
        return [];
    }

    $productIds = array_column($cart, 'product_id');
    $products = getProductsByIds($conn, $productIds);

    $validIds = array_column($products, 'id');

    $cart = array_values(array_filter($cart, function ($item) use ($validIds) {
        return in_array((int)$item['product_id'], $validIds);
    }));

    save_cart_to_session($cart);

    return array_map(function ($item) use ($cart) {
        $index = array_search($item['id'], array_column($cart, 'product_id'));
        $item['quantite'] = ($index !== false) ? $cart[$index]['quantite'] : 0;
        return $item;
    }, $products);
}


function remove_from_cart($product_id)
{
    $cart = get_session_cart();

    $cart = array_filter($cart, function ($item) use ($product_id) {
        return (int)$item['product_id'] !== (int)$product_id;
    });

    save_cart_to_session($cart);
    return true;
}

function update_cart_quantity($product_id, $quantity)
{
    $cart = get_session_cart();

    $index = array_search($product_id, array_column($cart, 'product_id'));

    if ($index !== false) {
        if ($quantity <= 0) {
            unset($cart[$index]);
        } else {
            $cart[$index]['quantite'] = (int)$quantity;
        }
        save_cart_to_session($cart);
        return true;
    }

    return false;
}

function clear_cart()
{
    $_SESSION['cart'] = [];
    return true;
}

function is_in_cart($product_id)
{
    $cart = get_session_cart();
    $index = in_array($product_id, array_column($cart, 'product_id'));
    return $index !== false;
}

function get_cart_item_quantity($product_id)
{
    $cart = get_session_cart();
    $index = array_search($product_id, array_column($cart, 'product_id'));

    if ($index !== false) {
        return $cart[$index]['quantite'];
    }

    return 0;
}

function get_cart_total($cart)
{
    $total = 0;

    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantite'];
    }

    return $total;
}


function dd(...$vars)
{
    echo '<pre>';
    foreach ($vars as $v) {
        print_r($v);
    }
    echo '</pre>';
    die;
}