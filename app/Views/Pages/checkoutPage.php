<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bocorocco - Detail Product</title>

  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

  <!-- Favicon -->
  <link rel="icon" href="<?= base_url('images/logo.png') ?>" type="image/png">
</head>
<body>

<?php include(APPPATH . 'Views/Layout/header.php'); ?>

<div class="container my-5">
  <h1 class="mb-4 fw-bold">Checkout</h1>

  <!-- Shipping Address -->
  <div class="mb-4 p-3 bg-light rounded shadow-sm">
    <h5 class="mb-2">Shipping Address</h5>
    <p class="mb-0"><?= $address['full_address'] ?? 'Example Street, South Jakarta' ?></p>
  </div>

  <!-- List of Products in Cart -->
  <div class="mb-4 p-3 bg-light rounded shadow-sm">
    <h5 class="mb-3">Items in Your Cart</h5>
    <?php foreach ($products as $item): ?>
      <div class="d-flex align-items-center mb-3 border-bottom pb-2">
        <img src="<?= base_url($item['images'][$item['color']]) ?>" width="60" class="me-3 rounded">
        <div class="flex-grow-1">
          <a href="<?= base_url('product/' . $item['id']) ?>" class="text-decoration-none fw-semibold text-dark">
            <?= $item['name'] ?> (<?= ucfirst($item['color']) ?> - <?= $item['size'] ?>)
          </a>
          <div class="text-muted small">Rp<?= number_format($item['price'], 0, ',', '.') ?></div>
        </div>
        <!-- Quantity & Delete Controls -->
        <div class="d-flex align-items-center">
          <a href="/cart/add/<?= $item['id'] ?>/<?= $item['color'] ?>/<?= $item['size'] ?>" class="btn btn-outline-secondary btn-sm me-2">
            <i class="bi bi-plus"></i>
          </a>
          <span class="fw-bold"><?= $item['quantity'] ?></span>
          <a href="/cart/delete/<?= $item['id'] ?>/<?= $item['color'] ?>/<?= $item['size'] ?>" class="btn btn-outline-danger btn-sm ms-2">
            <i class="bi bi-trash"></i>
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Payment Method Selection -->
  <div class="mb-4 p-3 bg-light rounded shadow-sm">
    <h5 class="mb-3">Select Payment Method</h5>
    <form id="paymentForm">
      <?php foreach (['BCA', 'BRI', 'Mandiri'] as $bank): ?>
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="payment_method" value="<?= $bank ?>" <?= $bank == 'BCA' ? 'checked' : '' ?>>
          <label class="form-check-label"><?= $bank ?> Virtual Account</label>
        </div>
      <?php endforeach; ?>
    </form>
  </div>

  <!-- Promo Code Input -->
  <div class="mb-4 p-3 bg-light rounded shadow-sm">
    <h5 class="mb-3">Apply Promo Code</h5>
    <form action="/checkout/apply-promo" method="post" class="d-flex flex-wrap gap-2">
      <input type="text" name="promo_code" class="form-control w-50" placeholder="Enter promo code">
      <button class="btn btn-dark">Apply</button>
    </form>
    <?php if (isset($couponMessage)): ?>
      <small class="text-<?= $couponValid ? 'success' : 'danger' ?> d-block mt-2"><?= $couponMessage ?></small>
    <?php endif; ?>
  </div>

  <!-- Summary of Charges -->
  <div class="mb-4 p-3 bg-light rounded shadow-sm">
    <h5 class="mb-3">Cost Summary</h5>
    <ul class="list-group">
      <li class="list-group-item d-flex justify-content-between">
        <span>Subtotal</span>
        <span>Rp<?= number_format($subtotal, 0, ',', '.') ?></span>
      </li>
      <li class="list-group-item d-flex justify-content-between">
        <span>Service Fee</span>
        <span>Rp2.500</span>
      </li>
      <li class="list-group-item d-flex justify-content-between">
        <span>Shipping <?= $inJabodetabek ? '(Jabodetabek)' : '(Outside Jabodetabek)' ?></span>
        <span>Rp<?= number_format($shipping, 0, ',', '.') ?></span>
      </li>
      <li class="list-group-item d-flex justify-content-between fw-bold">
        <span>Total</span>
        <span>Rp<?= number_format($total, 0, ',', '.') ?></span>
      </li>
    </ul>
  </div>

  <!-- Submit Payment Button -->
  <div class="text-end">
    <button class="btn btn-warning px-4 fw-bold" onclick="submitCheckout()">Pay Now</button>
  </div>
</div>

<!-- Modal: Virtual Account Display -->
<div class="modal fade" id="vaPopup" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header">
        <h5 class="modal-title">Virtual Account Number</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="fs-5 fw-bold" id="vaNumber">Loading VA number...</p>
        <button class="btn btn-outline-primary" onclick="copyVA()">Copy</button>
      </div>
    </div>
  </div>
</div>

<?php include(APPPATH . 'Views/Layout/footer.php'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Send payment method and display VA number popup
  function submitCheckout() {
    const method = document.querySelector('input[name="payment_method"]:checked')?.value || 'BCA';
    fetch('/checkout/pay', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `payment_method=${method}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.va) {
        document.getElementById('vaNumber').innerText = data.va;
        const modal = new bootstrap.Modal(document.getElementById('vaPopup'));
        modal.show();
      }
    });
  }

  // Copy VA number to clipboard
  function copyVA() {
    const vaText = document.getElementById('vaNumber').innerText;
    navigator.clipboard.writeText(vaText).then(() => {
      alert("VA number copied!");
    });
  }
</script>

</body>
</html>
