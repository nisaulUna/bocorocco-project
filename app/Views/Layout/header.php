<!-- Header -->
<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-white" href="/main">Bocorocco</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
      aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link" href="/main">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">About Us</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Shoes
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/products/womens">Women's Shoes</a></li>
            <li><a class="dropdown-item" href="/products/mens">Men's Shoes</a></li>
          </ul>
        </li>
      </ul>

      <form class="d-flex me-3" method="get" action="/search" role="search">
        <input class="form-control me-2 bg-white text-dark" type="search" name="q" placeholder="Search..."
          aria-label="Search" />
        <button class="btn btn-outline-light" type="submit">
          <i class="bi bi-search text-white"></i>
        </button>
      </form>

      <ul class="navbar-nav flex-row gap-3">
        <li class="nav-item">
          <a class="nav-link" href="/profile" title="Profile"><i class="bi bi-person text-white"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/cart" title="Cart"><i class="bi bi-bag text-white"></i></a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Highlight menu aktif -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
  const path = window.location.pathname;
  const navLinks = document.querySelectorAll('.navbar .nav-link');

  navLinks.forEach(link => {
    const href = link.getAttribute('href');
    if (href === path || (path.includes('mens') && href.includes('mens')) || (path.includes('womens') && href.includes('womens'))) {
      link.classList.add('active');
    }
  });
});

</script>
