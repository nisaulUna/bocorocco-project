<?php helper('text'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bocorocco - Search Result</title>

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

<div class="container mt-4">

  <!-- Recent Searches -->
  <div class="mb-4">
    <h2 class="fw-bold">Recent Searches</h2>
    <div class="d-flex gap-2 flex-wrap mt-1">
      <?php foreach ($recentTags as $tag): ?>
        <a href="/search?q=<?= urlencode($tag['keyword']) ?>"
           class="tag-badge bg-secondary text-white text-decoration-none">
          <?= esc($tag['keyword']) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Popular Tags -->
  <div class="mb-5">
    <h2 class="fw-bold">Popular</h2>
    <div class="d-flex gap-2 flex-wrap mt-1">
      <?php foreach ($popularTags as $tag): ?>
        <a href="/search?q=<?= urlencode($tag['keyword']) ?>"
           class="tag-badge bg-warning text-dark text-decoration-none fw-semibold">
          <?= esc($tag['keyword']) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Product Results -->
  <?php if (empty($results)): ?>
  <div class="alert alert-warning">Sorry, we couldn’t find any matching products.</div>
  <?php else: ?>
    <div class="row">
      <?php foreach ($results as $product): ?>
        <?php $firstColor = $product['colors'][0]; ?>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-4">
          <div class="card p-2 text-center h-100 position-relative shadow-sm border-0">
            <a href="<?= base_url('product/' . $product['id'] . '/' . $firstColor) ?>"
               class="text-decoration-none text-dark">
              <p class="fw-bold mb-1"><?= $product['name'] ?> (<?= ucfirst($firstColor) ?>)</p>
              <img src="<?= base_url($product['images'][$firstColor]) ?>"
                   class="img-fluid my-2"
                   style="max-height: 180px; object-fit: contain;" />
              <p class="text-muted small mb-1">
                <?= character_limiter($product['description'], 80) ?>
              </p>
              <p class="text-dark fw-semibold mb-0">
                Rp<?= number_format($product['price'], 0, ',', '.') ?>
              </p>
            </a>

            <!-- Add to Cart Button -->
            <form method="post" action="<?= base_url('product/add-to-cart') ?>"
                  class="position-absolute bottom-0 end-0 m-2">
              <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
              <input type="hidden" name="color" value="<?= $firstColor ?>">
              <input type="hidden" name="size" value="<?= $product['sizes'][0] ?>">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" class="btn btn-warning btn-sm rounded-circle shadow-sm btn-cart">
                <i class="bi bi-cart-plus"></i>
              </button>
            </form>

          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
