<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['username']) || empty($_SESSION['cart'])) {
    $_SESSION['error'] = "You must be logged in and have items in your cart.";
    header('Location: cart.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'];
$total_amount = 0;

// Calculate total
foreach ($cart as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Insert order
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, created_at) VALUES (?, ?, NOW())");
if (!$stmt) {
    die("Prepare failed (Insert Order): " . $conn->error);
}
$stmt->bind_param("id", $user_id, $total_amount);
$stmt->execute();
$order_id = $stmt->insert_id;

// Insert order items and update stock
foreach ($cart as $id => $item) {
    $product_id = $id;
    $quantity = $item['quantity'];
    $unit_price = $item['price'];

    // Insert order item using `unit_price`
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed (Insert Order Item): " . $conn->error);
    }
    $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $unit_price);
    $stmt->execute();

    // Update stock
    $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?");
    if (!$stmt) {
        die("Prepare failed (Update Stock): " . $conn->error);
    }
    $stmt->bind_param("iii", $quantity, $product_id, $quantity);
    $stmt->execute();
}

// Clear cart
unset($_SESSION['cart']);

// Redirect or show success message
$_SESSION['success'] = "✅ Purchase successful! Your order has been placed.";
header("Location: cart.php");
exit;
