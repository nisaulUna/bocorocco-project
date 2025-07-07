<?php helper('text'); ?>
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
  <div class="row g-4">
    
    <!-- Product Image Section -->
    <div class="col-lg-6 col-md-12 text-center">
      <img id="mainImage" src="<?= base_url($product['images'][$selectedColor]) ?>" class="img-fluid rounded product-image-border" alt="<?= $product['name'] ?>">
      <?php if (count($product['colors']) > 1): ?>
        <div class="d-flex justify-content-center gap-2 mt-3">
          <?php foreach ($product['colors'] as $index => $color): ?>
            <img 
              src="<?= base_url($product['images'][$color]) ?>"
              class="thumbnail-img <?= $color == $selectedColor ? 'active' : '' ?>"
              onclick="changeImage(this, '<?= base_url($product['images'][$color]) ?>', '<?= $color ?>')">
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Product Info Section -->
    <div class="col-lg-6 col-md-12">
      <div class="product-card-box">
        <h4><?= $product['name'] ?></h4>
        <p><?= $product['description'] ?></p>
        <h5 class="text-danger">Rp<?= number_format($product['price'], 0, ',', '.') ?></h5>

        <form action="/product/add-to-cart" method="post">
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <input type="hidden" name="color" id="colorInput" value="<?= $selectedColor ?>">
          <input type="hidden" name="size" id="sizeInput">

          <!-- Color Selection -->
          <div class="mb-3">
            <label class="form-label">Color</label><br>
            <?php foreach ($product['colors'] as $color): ?>
              <div class="text-center me-2 d-inline-block" style="width: 48px;">
                <span class="color-dot <?= $color == $selectedColor ? 'active' : '' ?>"
                      style="background-color: <?= $colorMap[$color] ?? '#ccc' ?>"
                      data-color="<?= $color ?>"></span>
                <div class="small mt-1 text-capitalize" style="font-size: 0.75rem;">
                  <?= $color ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- Size Selection -->
          <div class="mb-3">
            <label class="form-label">Size</label><br>
            <?php foreach ($product['sizes'] as $size): ?>
              <button type="button" class="size-btn" data-size="<?= $size ?>"><?= $size ?></button>
            <?php endforeach; ?>
          </div>

          <!-- Action Buttons -->
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-warning" id="addToCartBtn">Add to Cart</button>
            <button type="submit" class="btn btn-dark" id="buyNowBtn">Buy Now</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Recommendation Section -->
  <div class="container mt-5">
    <h4 class="fw-bold mb-4">Best-Selling Recommendation</h4>
    <div class="row">
      <?php foreach ($recommended as $item): ?>
        <?php $firstColor = $item['colors'][0]; ?>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-4">
          <div class="card p-2 text-center h-100 position-relative">
            <a href="<?= base_url('product/' . $item['id'] . '/' . $firstColor) ?>" class="text-decoration-none text-dark">
              <p class="mt-2 mb-0 fw-bold"><?= $item['name'] ?> (<?= ucfirst($firstColor) ?>)</p>
              <img src="<?= base_url($item['images'][$firstColor]) ?>" class="img-fluid my-2" />
              <p class="mb-0">Rp<?= number_format($item['price'], 0, ',', '.') ?></p>
            </a>

            <!-- Quick Add to Cart -->
            <form method="post" action="<?= base_url('product/add-to-cart') ?>" class="position-absolute bottom-0 end-0 m-2">
              <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
              <input type="hidden" name="color" value="<?= $firstColor ?>">
              <input type="hidden" name="size" value="<?= $item['sizes'][0] ?>">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" class="btn btn-warning btn-sm rounded-circle shadow-sm btn-cart">
                <i class="bi bi-cart-plus"></i>
              </button>
            </form>

          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>

<?php include(APPPATH . 'Views/Layout/footer.php'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Change main image and selected color
  function changeImage(el, src, color) {
    document.getElementById('mainImage').src = src;
    document.getElementById('colorInput').value = color;
    document.querySelectorAll('.thumbnail-img').forEach(img => img.classList.remove('active'));
    el.classList.add('active');
  }

  // Handle color selection click
  document.querySelectorAll('.color-dot').forEach(dot => {
    dot.addEventListener('click', function() {
      document.querySelectorAll('.color-dot').forEach(d => d.classList.remove('active'));
      this.classList.add('active');
      document.getElementById('colorInput').value = this.dataset.color;
    });
  });

  // Handle size selection click
  document.querySelectorAll('.size-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      document.getElementById('sizeInput').value = this.dataset.size;
    });
  });

  // Validate color and size before submit
  function validateSelection(event) {
    const color = document.getElementById('colorInput').value;
    const size = document.getElementById('sizeInput').value;

    if (!color) {
      alert('Please select a color first.');
      event.preventDefault();
      return;
    }
    if (!size) {
      alert('Please select a size first.');
      event.preventDefault();
      return;
    }
  }

  document.getElementById('addToCartBtn').addEventListener('click', validateSelection);
  document.getElementById('buyNowBtn').addEventListener('click', validateSelection);
</script>

</body>
</html>