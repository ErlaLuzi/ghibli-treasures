<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ghibli Treasures</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/login.css">
    <?php if ($page === 'index') echo '<link rel="stylesheet" href="css/home.css">'; ?>
    <?php if ($page === 'shop') echo '<link rel="stylesheet" href="css/shop.css">'; ?>
    <?php if ($page === 'cart') echo '<link rel="stylesheet" href="css/cart.css">'; ?>
    <?php if ($page === 'admin_dashboard') echo '<link rel="stylesheet" href="css/admin.css">'; ?>
    <?php if ($page === 'admin_manage_users') echo '<link rel="stylesheet" href="css/admin_users.css">'; ?>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header class="main-header">
    <div class="logo">
        <a href="index.php" class="logo-link">🏯 <span>Ghibli Treasures</span></a>
    </div>
    <form class="header-search" action="shop.php" method="get">
        <input type="text" name="search" placeholder="What are you looking for?" />
    </form>
    <nav class="navbar">
        <a href="index.php" class="nav-btn"><i class="fas fa-home"></i> Home</a>
        <div class="dropdown">
            <a href="shop.php" class="nav-btn dropdown-toggle"><i class="fas fa-store"></i> Shop</a>
            <div class="dropdown-menu">
                <a href="shop.php">Shop All</a>
                <a href="shop.php?category=clothing">Clothing</a>
                <a href="shop.php?category=posters">Posters</a>
                <a href="shop.php?category=plushies">Plushies</a>
                <a href="shop.php?category=figures">Figures</a>
                <a href="shop.php?category=accessories">Accessories</a>
                <div class="dropdown-search">
                    <form action="shop.php" method="get">
                        <input type="text" name="search" placeholder="Search merch..." />
                    </form>
                </div>
            </div>
        </div>
        <a href="cart.php" class="nav-btn"><i class="fas fa-shopping-cart"></i> Cart</a>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="admin_dashboard.php" class="nav-btn"><i class="fas fa-box"></i> Manage Products</a>
            <a href="admin_manage_users.php" class="nav-btn"><i class="fas fa-users-cog"></i> Manage Users</a>
        <?php endif; ?>

        <?php if (isset($_SESSION['username'])): ?>
            <div class="dropdown">
                <a href="#" class="nav-btn dropdown-toggle" onclick="event.preventDefault();">
                    <i class="fas fa-user"></i> Welcome, <?= htmlspecialchars($_SESSION['username']) ?>
                </a>
                <div class="dropdown-menu">
                    <a href="logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        <?php else: ?>
            <div class="dropdown">
                <a href="#" class="nav-btn dropdown-toggle" onclick="event.preventDefault();">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item" id="open-login-modal">Login</a>
                    <a href="#" class="dropdown-item" id="open-signup-modal">Sign Up</a>
                </div>
            </div>
        <?php endif; ?>
    </nav>
</header>

<!-- Login/Sign-Up Modal -->
<div id="login-modal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2 id="modal-title" class="modal-title">Login</h2>

        <!-- LOGIN FORM -->
        <form method="POST" action="handle-login.php" id="login-form" class="auth-form">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <div class="form-footer">
                <button type="submit">Login</button>
                <a href="#" id="switch-to-signup">Don't have an account?</a>
            </div>
        </form>

        <!-- SIGNUP FORM -->
        <form method="POST" action="handle-signup.php" id="signup-form" class="auth-form hidden">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="tel" name="phone" placeholder="Phone Number" required />
            <div class="form-footer">
                <button type="submit">Sign Up</button>
                <a href="#" id="switch-to-login">Already have an account?</a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('open-login-modal')?.addEventListener('click', (e) => {
    e.preventDefault();
    document.getElementById('login-form').classList.remove('hidden');
    document.getElementById('signup-form').classList.add('hidden');
    document.getElementById('modal-title').textContent = "Login";
    document.getElementById('login-modal').style.display = 'block';
});

document.getElementById('open-signup-modal')?.addEventListener('click', (e) => {
    e.preventDefault();
    document.getElementById('login-form').classList.add('hidden');
    document.getElementById('signup-form').classList.remove('hidden');
    document.getElementById('modal-title').textContent = "Sign Up";
    document.getElementById('login-modal').style.display = 'block';
});

document.querySelector('.close-btn')?.addEventListener('click', () => {
    document.getElementById('login-modal').style.display = 'none';
});

document.getElementById('switch-to-signup')?.addEventListener('click', (e) => {
    e.preventDefault();
    document.getElementById('login-form').classList.add('hidden');
    document.getElementById('signup-form').classList.remove('hidden');
    document.getElementById('modal-title').textContent = "Sign Up";
});

document.getElementById('switch-to-login')?.addEventListener('click', (e) => {
    e.preventDefault();
    document.getElementById('signup-form').classList.add('hidden');
    document.getElementById('login-form').classList.remove('hidden');
    document.getElementById('modal-title').textContent = "Login";
});

window.addEventListener('click', (e) => {
    if (e.target === document.getElementById('login-modal')) {
        document.getElementById('login-modal').style.display = 'none';
    }
});
</script>
