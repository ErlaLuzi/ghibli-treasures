<?php include 'includes/header.php'; ?>

<main class="login-page">
  <?php if (!empty($_SESSION['error'])): ?>
    <div class="error-message"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

    <button id="open-login" class="open-btn">Login / Sign Up</button>

    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>

            <div class="form-toggle">
                <button id="show-login" class="active">Login</button>
                <button id="show-signup">Sign Up</button>
            </div>

            <!-- Login Form -->
            <form method="POST" action="handle-login.php">

                <h2>Login</h2>
                <input type="text" name="username" placeholder="Username" required />
                <input type="password" name="password" placeholder="Password" required />
                <div class="form-footer">
                    <button type="submit">Login</button>
                    <a href="#">Forgot Password?</a>
                </div>
            </form>

            <!-- Sign Up Form -->
            <form method="POST" action="handle-login.php">

                <h2>Sign Up</h2>
                <input type="text" name="username" placeholder="Username" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="tel" name="phone" placeholder="Phone Number" required />
                <button type="submit">Create Account</button>
            </form>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
