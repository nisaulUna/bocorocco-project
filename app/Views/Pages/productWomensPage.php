<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Bocorocco - Women’s shoes</title>

  <!-- Bootstrap & icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

  <!-- custom CSS -->
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

  <!-- favicon -->
  <link rel="icon" href="<?= base_url('images/logo.png') ?>" type="image/png">
</head>

<body>

  <?php include(APPPATH . 'Views/Layout/header.php'); ?>

  <!-- hero banner for women’s collection -->
  <div class="container-fluid p-0">
    <div class="position-relative">
      <img 
        src="<?= base_url('images/bannerWomenShoes.png') ?>" 
        alt="banner" 
        class="img-fluid w-100" 
        style="height: auto; object-fit: cover;">
      <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
        <!-- optional CTA or overlay text -->
      </div>
    </div>
  </div>

  <!-- product grid for women’s shoes -->
  <div class="container mt-4" id="productContainer">
    <div class="row">
      <?php foreach ($products as $product): ?>
        <?php foreach ($product['colors'] as $color): ?>
          <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-4">
            <div class="card p-2 text-center h-100 position-relative">

              <!-- product link to detail page -->
              <a href="<?= base_url('product/' . $product['id'] . '/' . $color) ?>" style="text-decoration: none; color: inherit;">
                <p class="mt-2 mb-0 fw-bold"><?= $product['name'] ?> (<?= ucfirst($color) ?>)</p>
                <img src="<?= base_url($product['images'][$color]) ?>" class="img-fluid my-2" alt="<?= $product['name'] ?>">
                <p class="d-block mb-0">Rp<?= number_format($product['price'], 0, ',', '.') ?></p>
              </a>

              <!-- add to cart button -->
              <form method="post" action="<?= base_url('product/add-to-cart') ?>" class="position-absolute bottom-0 end-0 m-2">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="color" value="<?= $color ?>">
                <input type="hidden" name="size" value="<?= $product['sizes'][0] ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-warning btn-sm rounded-circle shadow-sm btn-cart" title="Add to cart">
                  <i class="bi bi-cart-plus"></i>
                </button>
              </form>

            </div>
          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>
  </div>

  <?php include(APPPATH . 'Views/Layout/footer.php'); ?>

</body>
</html>