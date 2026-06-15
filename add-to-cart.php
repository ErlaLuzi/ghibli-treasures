<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['username'])) {
    $_SESSION['cart_popup'] = true;
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
$userId = $_SESSION['user_id'];
$productId = intval($_POST['id'] ?? 0);

// Check stock
$stmt = $conn->prepare("SELECT stock, name, price, image FROM products WHERE id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product || $product['stock'] <= 0) {
    $_SESSION['error'] = "Item is out of stock!";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

// Track in session cart
if (!isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'image' => $product['image'],
        'quantity' => 1
    ];
} else {
    $_SESSION['cart'][$productId]['quantity'] += 1;
}

// Add to cart_items (upsert)
$check = $conn->prepare("SELECT quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
$check->bind_param("ii", $userId, $productId);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    $update = $conn->prepare("UPDATE cart_items SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
    $update->bind_param("ii", $userId, $productId);
    $update->execute();
} else {
    $insert = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, 1)");
    $insert->bind_param("ii", $userId, $productId);
    $insert->execute();
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
