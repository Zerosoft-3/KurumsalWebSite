<?php
include 'config.php';

// Create a new Database instance
$query = new Database();

// Fetch categories, products, and product images from the database
$categories = $query->select('category');
$products = $query->select('products');
$product_images = $query->select('product_images');

// Group products by their category ID
$grouped_products = [];
foreach ($products as $product) {
  $grouped_products[$product['category_id']][] = $product;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Products</title>
  <meta name="description" content="Product listings and details">
  <meta name="keywords" content="products, online store, shopping">
  <link href="favicon.ico" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="portfolio-page">

  <?php include 'includes/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="container">
        <nav class="breadcrumbs">
          <ol>
            <li><a href="./">Home</a></li>
            <li class="current">Products</li>
          </ol>
        </nav>
        <h1>Products</h1>
      </div>
    </div><!-- End Page Title -->

    <!-- Products Section -->
    <section id="portfolio" class="portfolio section">
      <div class="container">
        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

          <!-- Products Category -->
          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All</li>
            <?php foreach ($categories as $category): ?>
              <li data-filter=".filter-category-<?= $category['id'] ?>"><?= $category['category_name'] ?></li>
            <?php endforeach; ?>
          </ul><!-- End Products Category -->

          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
            <?php foreach ($grouped_products as $category_id => $products): ?>
              <?php foreach ($products as $product): ?>
                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-category-<?= $category_id ?>">
                  <div class="portfolio-content h-100">
                    <a href="product-details.php?id=<?= $product['id'] ?>">
                      <?php
                      $image_url = '';
                      // Fetch the image URL for the current product
                      foreach ($product_images as $image) {
                        if ($image['product_id'] == $product['id']) {
                          $image_url = $image['image_url'];
                          break;
                        }
                      }
                      ?>
                      <img src="assets/img/product/<?= $image_url ?>" class="img-fluid" alt="<?= $product['product_name'] ?>">
                      <div class="portfolio-info">
                        <h4><?= $product['product_name'] ?></h4>
                        <p><?= $product['description'] ?></p>
                      </div>
                    </a>
                  </div>
                </div><!-- End Portfolio Item -->
              <?php endforeach; ?>
            <?php endforeach; ?>

          </div><!-- End Portfolio Container -->

        </div>
      </div>
    </section><!-- /Portfolio Section -->

  </main>

  <?php include 'includes/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>