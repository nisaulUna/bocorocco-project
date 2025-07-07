<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bocorocco - Your Cart</title>

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

<div class="container py-4">
    <h1 class="mb-4 fw-bold">Your Cart</h1>

    <!-- Flash message for success notification -->
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- If cart is empty -->
    <?php if (empty($products)): ?>
        <div class="alert alert-warning">Your cart is empty. Start shopping now!</div>
    <?php else: ?>

        <?php foreach ($products as $product): ?>
            <div class="card mb-3 border-0 shadow-sm rounded-4">
                <div class="row g-0 align-items-center">
                    <div class="col-4 p-2">
                        <!-- Link to product detail -->
                        <a href="<?= base_url('product/' . $product['id'] . '/' . $product['color']) ?>">
                            <img src="<?= base_url($product['images'][$product['color']]) ?>" class="img-fluid rounded-3" alt="<?= $product['name'] ?>">
                        </a>
                    </div>
                    <div class="col-8 p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong><?= $product['name'] ?></strong>
                                <div class="badge bg-warning text-dark mt-1"><?= $product['size'] ?>, <?= ucfirst($product['color']) ?></div>
                                <div class="text-danger fw-bold mt-2">Rp<?= number_format($product['price'], 0, ',', '.') ?></div>
                            </div>
                            <!-- Trigger delete confirmation modal -->
                            <button 
                                class="btn btn-sm btn-light text-danger btn-trigger-delete"
                                data-product-id="<?= $product['id'] ?>"
                                data-color="<?= $product['color'] ?>"
                                data-size="<?= $product['size'] ?>"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal">
                                <i class="bi bi-trash-fill fs-5"></i>
                            </button>
                        </div>

                        <!-- Quantity controls -->
                        <div class="d-flex align-items-center justify-content-end mt-3">
                            <a href="<?= base_url("cart/update/{$product['id']}/{$product['color']}/{$product['size']}/minus") ?>" class="btn btn-outline-dark btn-sm rounded-circle me-2">−</a>
                            <span class="fw-bold"><?= $product['quantity'] ?></span>
                            <a href="<?= base_url("cart/update/{$product['id']}/{$product['color']}/{$product['size']}/plus") ?>" class="btn btn-outline-dark btn-sm rounded-circle ms-2">+</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Display total cost -->
        <?php $total = array_sum(array_map(fn($p) => $p['price'] * $p['quantity'], $products)); ?>
        <div class="text-end mb-3 mt-4">
            <h5>Total: <span class="text-danger">Rp<?= number_format($total, 0, ',', '.') ?></span></h5>
        </div>

        <!-- Checkout button -->
        <div class="text-end">
            <a href="<?= base_url('checkout') ?>" class="btn btn-warning btn-lg w-100 rounded-4 fw-bold">Checkout</a>
        </div>
    <?php endif; ?>
</div>

<!-- Modal for confirming item deletion -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Remove Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to remove this item from your cart?
      </div>
      <div class="modal-footer">
        <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Yes</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Automatically close flash alert after 3 seconds
    setTimeout(() => {
        const alertEl = document.querySelector('.alert');
        if (alertEl) bootstrap.Alert.getOrCreateInstance(alertEl).close();
    }, 3000);

    // Attach dynamic delete link to modal confirmation
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.btn-trigger-delete');
        const confirmBtn = document.getElementById('confirmDeleteBtn');

        deleteButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-product-id');
                const color = btn.getAttribute('data-color');
                const size = btn.getAttribute('data-size');
                confirmBtn.href = `/cart/delete/${id}/${color}/${size}`;
            });
        });
    });
</script>

</body>
</html>
