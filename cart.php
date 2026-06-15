<?php
include 'includes/header.php';
include 'includes/db_connect.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<main class="cart-wrapper">
  <?php if (!empty($_SESSION['error'])): ?>
    <div class="error-message"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <h1>Your Shopping Cart</h1>

  <?php if (empty($cart)): ?>
      <p class="empty-cart">Your cart is empty.</p>
  <?php else: ?>
      <div class="cart-items">
          <?php foreach ($cart as $id => $item):
              $subtotal = $item['quantity'] * $item['price'];
              $total += $subtotal;
          ?>
              <div class="cart-item">
                  <img src="<?= htmlspecialchars($item['image']) ?>" alt="" class="cart-thumb">
                  <div class="cart-details">
                      <h3><?= htmlspecialchars($item['name']) ?></h3>
                      <p>$<?= number_format($item['price'], 2) ?></p>
                  </div>
                  <form class="cart-controls" method="post" action="update-cart.php">
                      <input type="hidden" name="id" value="<?= $id ?>">
                      <button type="submit" name="action" value="decrease">−</button>
                      <span><?= $item['quantity'] ?></span>
                      <button type="submit" name="action" value="increase">+</button>
                      <button type="submit" name="action" value="remove" class="remove-btn">Remove</button>
                  </form>
              </div>
          <?php endforeach; ?>
      </div>

      <div class="cart-summary">
          <h3>Subtotal: $<?= number_format($total, 2) ?></h3>
          <button class="pay-now-btn" id="open-payment-modal">Pay Now</button>
      </div>
  <?php endif; ?>
</main>

<!-- PAYMENT MODAL -->
<div id="payment-modal" class="modal">
  <div class="modal-content payment-content">
    <span class="close-btn">&times;</span>
    <h2>Enter Payment Details</h2>
    <form class="payment-form" id="payment-form" action="process-payment.php" method="POST">
      <input type="text" name="fullname" placeholder="Full Name" required>
      <input type="text" name="cardnumber" placeholder="Card Number" maxlength="16" required>
      <div class="split-row">
          <input type="text" name="expiry" placeholder="MM/YY" required>
          <input type="text" name="cvv" placeholder="CVV" maxlength="4" required>
      </div>
      <input type="email" name="email" placeholder="Billing Email" required>

      <div id="payment-message" class="message-box"></div>

      <div class="modal-actions">
          <button type="submit" class="confirm-btn">Confirm Payment</button>
          <button type="button" class="cancel-btn" id="cancel-payment">Cancel</button>
      </div>
    </form>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
const modal = document.getElementById('payment-modal');
const openBtn = document.getElementById('open-payment-modal');
const closeBtn = document.querySelector('.close-btn');
const cancelBtn = document.getElementById('cancel-payment');

openBtn.addEventListener('click', () => modal.style.display = 'block');
closeBtn.addEventListener('click', () => modal.style.display = 'none');
cancelBtn.addEventListener('click', () => modal.style.display = 'none');

window.addEventListener('click', (e) => {
  if (e.target === modal) modal.style.display = 'none';
});

const paymentForm = document.getElementById('payment-form');
const messageBox = document.getElementById('payment-message');

paymentForm.addEventListener('submit', function(e) {
  const fields = paymentForm.querySelectorAll('input');
  let allFilled = true;

  fields.forEach(field => {
    if (!field.value.trim()) allFilled = false;
  });

  if (!allFilled) {
    e.preventDefault();
    messageBox.textContent = 'Please fill in all fields.';
    messageBox.className = 'message-box error';
  }
});
</script>
