<?php helper('text'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Bocorocco - Main Page</title>

  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

  <!-- favicon -->
  <link rel="icon" href="<?= base_url('images/logo.png') ?>" type="image/png">

</head>
<body>

<?php include(APPPATH . 'Views/Layout/header.php'); ?>

<!-- Hero Banner -->
<div class="container-fluid p-0">
  <div class="position-relative">
    <img src="<?= base_url('images/banner.png') ?>" alt="Banner" class="img-fluid w-100" />
    <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
      <a href="#productContrainer" class="btn btn-warning fw-bold px-5 py-3 fs-4">Shop Now</a>
    </div>
  </div>
</div>

<div class="container mt-4" id="productContrainer">

  <!-- What’s New Carousel -->
  <div id="whatsNewCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
    <h1 class="mb-3 text-start fw-bold">What’s New</h1>
    <div class="carousel-inner">
      <?php foreach ($whatsNew as $index => $product): ?>
        <?php 
          $color = $product['colors'][0];
          $image = $product['images'][$color];
          $isActive = ($index === 0) ? 'active' : '';
          $shortDesc = character_limiter($product['description'], 150);
        ?>
        <div class="carousel-item <?= $isActive ?> py-5" style="background-color: #809fc4; min-height: 300px;">
          <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center gap-4 px-4 px-md-5">
            <div class="position-relative">
              <div class="rounded-circle bg-light opacity-25 position-absolute top-50 start-50 translate-middle background-circle"></div>
              <img src="<?= base_url($image) ?>" class="img-fluid position-relative" style="max-width: 280px; z-index: 2;" alt="<?= $product['name'] ?>">
            </div>
            <div class="text-white text-end ps-md-4 pe-md-2" style="max-width: 600px;">
              <h3 class="fw-bold"><?= $product['name'] ?></h3>
              <p class="mb-2 des">" <?= trim($shortDesc) ?> "</p>
              <p class="fw-semibold text-dark">Rp<?= number_format($product['price'], 0, ',', '.') ?></p>
              <a href="<?= base_url('product/' . $product['id'] . '/' . $color) ?>" class="btn fw-bold px-4 py-2" style="background-color: #ffc107;">More Details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#whatsNewCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#whatsNewCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  <!-- Best-Selling Collection -->
  <div id="bestSellingCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
    <h1 class="mb-3 text-end fw-bold">Best-Selling Collection</h1>
    <div class="carousel-inner">
      <?php foreach ($bestSelling as $index => $product): ?>
        <?php foreach ($product['colors'] as $color): ?>
          <?php 
            $image = $product['images'][$color];
            $isActive = ($index === 0) ? 'active' : '';
            $shortDesc = character_limiter($product['description'], 150);
          ?>
          <div class="carousel-item <?= $isActive ?> py-5" style="background-color: #809fc4; min-height: 300px;">
            <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center gap-4 px-4 px-md-5">
              <div class="position-relative">
                <div class="rounded-circle bg-light opacity-25 position-absolute top-50 start-50 translate-middle background-circle"></div>
                <img src="<?= base_url($image) ?>" class="img-fluid position-relative" style="max-width: 280px; z-index: 2;" alt="<?= $product['name'] ?>">
              </div>
              <div class="text-white text-end ps-md-4 pe-md-2" style="max-width: 600px;">
                <h3 class="fw-bold"><?= $product['name'] ?></h3>
                <p class="mb-2 des">" <?= trim($shortDesc) ?> "</p>
                <p class="fw-semibold text-dark">Rp<?= number_format($product['price'], 0, ',', '.') ?></p>
                <a href="<?= base_url('product/' . $product['id'] . '/' . $color) ?>" class="btn fw-bold px-4 py-2" style="background-color: #ffc107;">More Details</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#bestSellingCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bestSellingCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  <!-- More Men’s Section -->
  <div class="slider-section">
    <h5 class="d-flex justify-content-between align-items-center">
      <span>More Men’s</span>
      <div class="slider-controls">
        <a href="/products/mens" class="text-warning text-decoration-none me-2">View All</a>
        <button id="menPrevBtn" class="btn btn-sm btn-outline-dark">&lt;</button>
        <span id="menSliderCounter">1/<?= ceil(count($moreMen)/3) ?></span>
        <button id="menNextBtn" class="btn btn-sm btn-outline-dark">&gt;</button>
      </div>
    </h5>
    <div id="menSlider" class="slider-container">
      <?php foreach ($moreMen as $product): ?>
        <?php foreach ($product['colors'] as $color): ?>
          <div class="card p-2 text-center mx-2 position-relative">
            <a href="<?= base_url('product/' . $product['id'] . '/' . $color) ?>" style="text-decoration: none; color: inherit;">
              <p class="mt-2 mb-0 fw-bold"><?= $product['name'] ?> (<?= ucfirst($color) ?>)</p>
              <img src="<?= base_url($product['images'][$color]) ?>" class="img-fluid" />
              <p class="d-block">Rp<?= number_format($product['price'], 0, ',', '.') ?></p>
            </a>
            <form method="post" action="<?= base_url('product/add-to-cart') ?>" class="position-absolute bottom-0 end-0 m-2">
              <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
              <input type="hidden" name="color" value="<?= $color ?>">
              <input type="hidden" name="size" value="<?= $product['sizes'][0] ?>">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" class="btn btn-warning btn-sm rounded-circle shadow-sm btn-cart">
                <i class="bi bi-cart-plus"></i>
              </button>
            </form>
          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- More Women’s Section -->
  <div class="slider-section">
    <h5 class="d-flex justify-content-between align-items-center">
      <span>More Women’s</span>
      <div class="slider-controls">
        <a href="/products/womens" class="text-warning text-decoration-none me-2">View All</a>
        <button id="womenPrevBtn" class="btn btn-sm btn-outline-dark">&lt;</button>
        <span id="womenSliderCounter">1/<?= ceil(count($moreWomen)/3) ?></span>
        <button id="womenNextBtn" class="btn btn-sm btn-outline-dark">&gt;</button>
      </div>
    </h5>
    <div id="womenSlider" class="slider-container">
      <?php foreach ($moreWomen as $product): ?>
        <?php foreach ($product['colors'] as $color): ?>
          <div class="card p-2 text-center mx-2 position-relative">
            <a href="<?= base_url('product/' . $product['id'] . '/' . $color) ?>" style="text-decoration: none; color: inherit;">
              <p class="mt-2 mb-0 fw-bold"><?= $product['name'] ?> (<?= ucfirst($color) ?>)</p>
              <img src="<?= base_url($product['images'][$color]) ?>" class="img-fluid" />
              <p class="d-block">Rp<?= number_format($product['price'], 0, ',', '.') ?></p>
            </a>
            <form method="post" action="<?= base_url('product/add-to-cart') ?>" class="position-absolute bottom-0 end-0 m-2">
              <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
              <input type="hidden" name="color" value="<?= $color ?>">
              <input type="hidden" name="size" value="<?= $product['sizes'][0] ?>">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" class="btn btn-warning btn-sm rounded-circle shadow-sm btn-cart">
                <i class="bi bi-cart-plus"></i>
              </button>
            </form>
          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>
  </div>

</div>

<?php include(APPPATH . 'Views/Layout/footer.php'); ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    function setupSlider(sliderId, prevId, nextId, counterId) {
      const slider = document.getElementById(sliderId);
      const prevBtn = document.getElementById(prevId);
      const nextBtn = document.getElementById(nextId);
      const counter = document.getElementById(counterId);
      const cards = slider.children;

      let currentIndex = 1;
      let cardWidth = cards[0].offsetWidth + 16;
      let visibleCount = Math.floor(slider.clientWidth / cardWidth);
      let maxIndex = Math.ceil(cards.length / visibleCount);

      function updateSlider() {
        const totalWidth = cards.length * cardWidth;
        const visibleWidth = slider.clientWidth;
        const shouldShowControls = totalWidth > visibleWidth;

        prevBtn.style.display = nextBtn.style.display = counter.style.display = shouldShowControls ? 'inline-block' : 'none';

        slider.scrollTo({
          left: (currentIndex - 1) * cardWidth * visibleCount,
          behavior: 'smooth'
        });

        counter.textContent = `${currentIndex}/${maxIndex}`;
      }

      prevBtn.onclick = () => {
        if (currentIndex > 1) {
          currentIndex--;
          updateSlider();
        }
      };

      nextBtn.onclick = () => {
        if (currentIndex < maxIndex) {
          currentIndex++;
          updateSlider();
        }
      };

      window.addEventListener('resize', () => {
        cardWidth = cards[0].offsetWidth + 16;
        visibleCount = Math.floor(slider.clientWidth / cardWidth);
        maxIndex = Math.ceil(cards.length / visibleCount);
        currentIndex = Math.min(currentIndex, maxIndex);
        updateSlider();
      });

      updateSlider();
    }

    setupSlider('menSlider', 'menPrevBtn', 'menNextBtn', 'menSliderCounter');
    setupSlider('womenSlider', 'womenPrevBtn', 'womenNextBtn', 'womenSliderCounter');
  });

  // Hide description on small screens
  $(document).ready(function () {
    function checkWindowSize() {
      if ($(window).width() <= 1053) {
        $('.carousel-item .des').hide();
      } else {
        $('.carousel-item .des').show();
      }
    }

    checkWindowSize();
    $(window).resize(checkWindowSize);
  });
</script>

</body>
</html>