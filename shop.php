<?php
include 'includes/header.php';
include 'includes/db_connect.php';
?>
<?php if (!empty($_SESSION['cart_popup'])): ?>
<div id="popup-overlay">
  <div class="popup-box">
    <span class="close-popup" onclick="document.getElementById('popup-overlay').style.display='none'">&times;</span>
    <h2>⚠ Hold on!</h2>
    <p>You need to <strong>create an account</strong> before adding items to your cart.</p>
    <div class="popup-actions">
      <button onclick="document.getElementById('open-signup-modal').click()">Sign Up</button>
      <button onclick="document.getElementById('open-login-modal').click()">Login</button>
    </div>
  </div>
</div>
<?php unset($_SESSION['cart_popup']); ?>
<?php endif; ?>
<main class="shop-wrapper">
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="error-message"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <section class="shop-header">
        <h1>Browse Our Ghibli-Inspired Collection</h1>
        <form class="shop-filter" method="GET" action="shop.php">
            <input type="text" name="search" placeholder="Search products..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" />
            <select name="category">
                <option value="">All Categories</option>
                <option value="plushies">Plushies</option>
                <option value="clothing">Clothing</option>
                <option value="accessories">Accessories</option>
                <option value="posters">Posters</option>
                <option value="figures">Figures</option>
            </select>
            <button type="submit">Filter</button>
        </form>
    </section>

    <section class="product-grid">
        <?php
        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';

        $query = "SELECT * FROM products WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $query .= " AND name LIKE ?";
            $params[] = "%" . $search . "%";
        }

        if (!empty($category)) {
            $query .= " AND category = ?";
            $params[] = $category;
        }

        $stmt = $conn->prepare($query);
        if (!empty($params)) {
            $types = str_repeat("s", count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        while ($product = $result->fetch_assoc()):
            $imagePath = strpos($product['image'], 'productimages/') === 0 ? $product['image'] : 'productimages/' . $product['image'];
            $isOutOfStock = $product['stock'] <= 0;
        ?>
            <div class="product-card">
                <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p class="price">$<?= number_format($product['price'], 2) ?></p>

                <?php if ($isOutOfStock): ?>
                    <p class="stock-status">Item Out of Stock</p>
                <?php else: ?>
                    <form method="POST" action="add-to-cart.php">
                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                        <input type="hidden" name="price" value="<?= $product['price'] ?>">
                        <input type="hidden" name="image" value="<?= htmlspecialchars($product['image']) ?>">
                        <?php if ($product['stock'] > 0): ?>
                        <button type="submit">Add to Cart</button>
                      <?php else: ?>
                     <button type="button" disabled style="background: crimson; cursor: not-allowed;">Out of Stock</button>
                    <?php endif; ?>
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
