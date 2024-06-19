<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $adn = "DELETE FROM rpos_products WHERE prod_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $stmt->close();
  if ($stmt) {
    $success = "Deleted" && header("refresh:1; url=products.php");
  } else {
    $err = "Try Again Later";
  }
}

require_once('partials/_head.php');
?>

<body>
  <!-- Sidenav -->
  <?php require_once('partials/_sidebar.php'); ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php require_once('partials/_topnav.php'); ?>
    <!-- Header -->
    <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--8">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card shadow mb-3">
            <div class="card-header border-0">
              <a href="add_product.php" class="btn btn-outline-success">
                <i class="fas fa-utensils"></i>
                Add New Product
              </a>
            </div>
            </div>
            <div class="row">
              <?php
              // Fetch distinct categories
              $catQuery = "SELECT DISTINCT IFNULL(prod_category, '') AS category FROM rpos_products ORDER BY prod_category DESC";
              $catStmt = $mysqli->prepare($catQuery);
              $catStmt->execute();
              $catRes = $catStmt->get_result();
              $categories = $catRes->fetch_all(MYSQLI_ASSOC);

              $half = ceil(count($categories) / 2);
              $categories1 = array_slice($categories, 0, $half);
              $categories2 = array_slice($categories, $half);

              function renderCategoryCards($categories, $mysqli) {
                foreach ($categories as $category) {
                  $catName = $category['category'] ? $category['category'] : 'Uncategorized';
              ?>
                  <div class="col-12 mb-4">
                    <div class="card shadow">
                      <div class="card-header d-flex justify-content-between align-items-center">
                        <h3><?php echo $catName; ?></h3>
                        <button class="btn btn-sm btn-outline-primary toggle-products" data-category="<?php echo $catName; ?>">Show/Hide</button>
                      </div>
                      <div class="card-body category-products" data-category="<?php echo $catName; ?>">
                        <div class="row">
                          <?php
                          $ret = "SELECT * FROM rpos_products WHERE IFNULL(prod_category, '') = ?";
                          $stmt = $mysqli->prepare($ret);
                          $stmt->bind_param('s', $category['category']);
                          $stmt->execute();
                          $res = $stmt->get_result();
                          while ($prod = $res->fetch_object()) {
                          ?>
                            <div class="col-sm-6 col-md-4 col-lg-4 mb-3">
                              <div class="card h-100">
                                <?php
                                if ($prod->prod_img) {
                                  echo "<img src='assets/img/products/$prod->prod_img' class='card-img-top' alt='$prod->prod_name'>";
                                } else {
                                  echo "<img src='assets/img/products/default.jpg' class='card-img-top' alt='Default Image'>";
                                }
                                ?>
                                <div class="card-body p-2">
                                  <h4 class="card-title mb-1"><?php echo $prod->prod_name; ?></h4>
                                  <p class="card-text small mb-2">Code: <?php echo $prod->prod_code; ?></p>
                                  <p class="card-text  mb-2">Price: ₹ <?php echo $prod->prod_price; ?></p>
                                  <div class="d-flex justify-content-between">
                                    <a href="products.php?delete=<?php echo $prod->prod_id; ?>" class="btn btn-sm btn-danger">
                                      <i class="fas fa-trash"></i> Delete
                                    </a>
                                    <a href="update_product.php?update=<?php echo $prod->prod_id; ?>" class="btn btn-sm btn-primary">
                                      <i class="fas fa-edit"></i> Update
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
              <?php }
              }
              ?>
              <div class="col-lg-6">
                <?php renderCategoryCards($categories1, $mysqli); ?>
              </div>
              <div class="col-lg-6">
                <?php renderCategoryCards($categories2, $mysqli); ?>
              </div>
            </div>
          
        </div>
      </div>
      <!-- Footer -->
      <?php require_once('partials/_footer.php'); ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php require_once('partials/_scripts.php'); ?>
  <script>
    // Add toggle functionality
    document.querySelectorAll('.toggle-products').forEach(button => {
      button.addEventListener('click', function() {
        const category = this.getAttribute('data-category');
        const productsContainer = document.querySelector(`.category-products[data-category="${category}"]`);
        productsContainer.classList.toggle('d-none');
      });
    });
  </script>
</body>

</html>
