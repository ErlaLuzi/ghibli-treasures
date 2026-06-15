<?php

include 'includes/db_connect.php';
include 'includes/header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
$categories = ['clothing', 'posters', 'plushies', 'figures', 'accessories'];
?>

<link rel="stylesheet" href="css/admin.css">

<main>
    <h2>Product Management</h2>

    <?php if (!empty($_SESSION['success'])): ?>
        <p class="success-msg"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <p class="error-msg"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <div class="admin-container">
        <section class="admin-form" aria-labelledby="add-product-title">
            <h3 id="add-product-title">Add New Product</h3>
            <form action="admin_product_handle.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <input type="text" name="name" placeholder="Product name" required>
                <input type="number" name="price" step="0.01" min="0" placeholder="Price" required>
                <select name="category" required>
                    <option value="">Select category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category ?>"><?= ucfirst($category) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="stock" min="0" placeholder="Stock" required>
                <input type="file" name="image" accept="image/*" required>
                <button type="submit">Add Product</button>
            </form>
        </section>

        <section class="admin-table" aria-labelledby="current-products-title">
            <h3 id="current-products-title">Current Products</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $products->fetch_assoc()): ?>
                        <?php $editFormId = 'edit-product-' . (int) $row['id']; ?>
                        <tr>
                            <td><?= (int) $row['id'] ?></td>
                            <td>
                                <input form="<?= $editFormId ?>" type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
                            </td>
                            <td>
                                <input form="<?= $editFormId ?>" type="number" name="price" step="0.01" min="0" value="<?= htmlspecialchars($row['price']) ?>" required>
                            </td>
                            <td>
                                <select form="<?= $editFormId ?>" name="category" required>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category ?>" <?= $row['category'] === $category ? 'selected' : '' ?>><?= ucfirst($category) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input form="<?= $editFormId ?>" type="number" name="stock" min="0" value="<?= (int) $row['stock'] ?>" required>
                            </td>
                            <td>
                                <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="product-img">
                                <input form="<?= $editFormId ?>" type="file" name="image" accept="image/*">
                            </td>
                            <td class="actions-cell">
                                <form id="<?= $editFormId ?>" action="admin_product_handle.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                                    <button class="action-btn" type="submit">Update</button>
                                </form>
                                <form action="admin_product_handle.php" method="POST" onsubmit="return confirm('Delete this product?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                                    <button class="action-btn delete-btn" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </div>
</main>

<?php include 'includes/footer.php'; ?>