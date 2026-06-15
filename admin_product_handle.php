<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Unauthorized access.";
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $name = trim($_POST['name'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $category = trim($_POST['category'] ?? '');
    $stock = intval($_POST['stock'] ?? 0);
    $imagePath = '';

    // Image upload
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "productimages/";
        $fileName = basename($_FILES['image']['name']);
        $fileName = time() . "_" . $fileName;
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        } else {
            $_SESSION['error'] = "Image upload failed.";
            header("Location: admin_dashboard.php");
            exit;
        }
    }

    switch ($action) {
        case 'add':
            if ($imagePath) {
                $stmt = $conn->prepare("INSERT INTO products (name, price, image, category, stock) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sdssi", $name, $price, $imagePath, $category, $stock);
                $stmt->execute();
                $_SESSION['success'] = "Product added.";
            }
            break;

        case 'edit':
            $id = intval($_POST['id']);
            if ($imagePath !== '') {
                $stmt = $conn->prepare("UPDATE products SET name=?, price=?, image=?, category=?, stock=? WHERE id=?");
                $stmt->bind_param("sdssii", $name, $price, $imagePath, $category, $stock, $id);
            } else {
                $stmt = $conn->prepare("UPDATE products SET name=?, price=?, category=?, stock=? WHERE id=?");
                $stmt->bind_param("sdsii", $name, $price, $category, $stock, $id);
            }
            $stmt->execute();
            $_SESSION['success'] = "Product updated.";
            break;

        case 'delete':
            $id = intval($_POST['id']);
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $_SESSION['success'] = "Product deleted.";
            break;

        default:
            $_SESSION['error'] = "Invalid action.";
            break;
    }

    header("Location: admin_dashboard.php");
    exit;
}
?>
