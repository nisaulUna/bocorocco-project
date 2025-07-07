<!-- Footer -->
<footer class="bg-dark text-white mt-5 py-4">
  <div class="container">
    <div class="row small d-flex align-items-start justify-content-between flex-wrap">

      <!-- Brand -->
      <div class="col-md-3 mb-3">
        <h6 class="fw-bold ">Bocorocco</h6>
        <p class="text-muted mb-0">Comfort & style for every step.</p>
      </div>

      <!-- Navigation -->
      <div class="col-md-3 mb-3">
        <h6 class="fw-bold">Navigation</h6>
        <ul class="list-unstyled mb-0">
          <li><a href="<?= base_url('/') ?>" class="text-white text-decoration-none">Home</a></li>
          <li><a href="<?= base_url('/products/mens') ?>" class="text-white text-decoration-none">Men’s Shoes</a></li>
          <li><a href="<?= base_url('/products/womens') ?>" class="text-white text-decoration-none">Women’s Shoes</a></li>
          <li><a href="<?= base_url('/cart') ?>" class="text-white text-decoration-none">Cart</a></li>
          <li><a href="<?= base_url('/checkout') ?>" class="text-white text-decoration-none">Checkout</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-md-4 mb-3">
        <h6 class="fw-bold">Contact</h6>
        <p class="mb-1"><i class="bi bi-geo-alt-fill me-2"></i>123 Shoes St., Jakarta</p>
        <p class="mb-1"><i class="bi bi-telephone-fill me-2"></i>+62 812 3456 7890</p>
        <p class="mb-0"><i class="bi bi-envelope-fill me-2"></i>support@bocorocco.co.id</p>
      </div>

      <!-- Social Media -->
      <div class="col-md-2 mb-3 text-md-end">
        <h6 class="fw-bold">Follow Us</h6>
        <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
        <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
        <a href="#" class="text-white"><i class="bi bi-youtube"></i></a>
      </div>

    </div>

    <hr class="border-secondary mt-3" />

    <div class="text-center text-muted small">
      &copy; <?= date('Y') ?> Bocoroco. All rights reserved.
    </div>
  </div>
</footer>
