<?php
session_start();
include 'includes/db_connect.php';

$id = intval($_POST['id']);
$action = $_POST['action'] ?? '';
$userId = $_SESSION['user_id'];

if (isset($_SESSION['cart'][$id])) {
    switch ($action) {
        case 'increase':
            $_SESSION['cart'][$id]['quantity']++;
            $conn->query("UPDATE cart_items SET quantity = quantity + 1 WHERE user_id = $userId AND product_id = $id");
            break;
        case 'decrease':
            if ($_SESSION['cart'][$id]['quantity'] > 1) {
                $_SESSION['cart'][$id]['quantity']--;
                $conn->query("UPDATE cart_items SET quantity = quantity - 1 WHERE user_id = $userId AND product_id = $id");
            } else {
                unset($_SESSION['cart'][$id]);
                $conn->query("DELETE FROM cart_items WHERE user_id = $userId AND product_id = $id");
            }
            break;
        case 'remove':
            unset($_SESSION['cart'][$id]);
            $conn->query("DELETE FROM cart_items WHERE user_id = $userId AND product_id = $id");
            break;
    }
}

header('Location: cart.php');
exit;
