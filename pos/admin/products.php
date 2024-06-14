<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
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
          <div class="card shadow">
            <div class="card-header border-0">
              <a href="add_product.php" class="btn btn-outline-success">
                <i class="fas fa-utensils"></i>
                Add New Product
              </a>
            </div>
            <div class="table-responsive">
              <?php
              // Fetch distinct categories
              $catQuery = "SELECT DISTINCT IFNULL(prod_category, '') AS category FROM rpos_products ORDER BY prod_category DESC";
              $catStmt = $mysqli->prepare($catQuery);
              $catStmt->execute();
              $catRes = $catStmt->get_result();
              $categories = $catRes->fetch_all(MYSQLI_ASSOC);

              foreach ($categories as $category) {
                $catName = $category['category'] ? $category['category'] : 'Uncategorized';
              ?>
                <div class="card shadow mt-4">
                  <div class="card-header border-0 d-flex justify-content-between align-items-center">
                    <h3><?php echo $catName; ?></h3>
                    <div>
                      <button class="btn btn-sm btn-outline-primary toggle-products" data-category="<?php echo $catName; ?>">Show/Hide</button>
                      <select class="form-control filter-category d-inline-block w-auto" data-category="<?php echo $catName; ?>">
                        <option value="all">Show All</option>
                        <option value="low">Price: Low to High</option>
                        <option value="high">Price: High to Low</option>
                      </select>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">Image</th>
                          <th scope="col">Product Code</th>
                          <th scope="col">Name</th>
                          <th scope="col">Price</th>
                          <th scope="col">Actions</th>
                        </tr>
                      </thead>
                      <tbody class="category-products" data-category="<?php echo $catName; ?>">
                        <?php
                        $ret = "SELECT * FROM rpos_products WHERE IFNULL(prod_category, '') = ?";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('s', $category['category']);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($prod = $res->fetch_object()) {
                        ?>
                          <tr>
                            <td>
                              <?php
                              if ($prod->prod_img) {
                                echo "<img src='assets/img/products/$prod->prod_img' height='60' width='60' class='img-thumbnail'>";
                              } else {
                                echo "<img src='assets/img/products/default.jpg' height='60' width='60' class='img-thumbnail'>";
                              }
                              ?>
                            </td>
                            <td><?php echo $prod->prod_code; ?></td>
                            <td><?php echo $prod->prod_name; ?></td>
                            <td>$ <?php echo $prod->prod_price; ?></td>
                            <td>
                              <a href="products.php?delete=<?php echo $prod->prod_id; ?>">
                                <button class="btn btn-sm btn-danger">
                                  <i class="fas fa-trash"></i>
                                  Delete
                                </button>
                              </a>
                              <a href="update_product.php?update=<?php echo $prod->prod_id; ?>">
                                <button class="btn btn-sm btn-primary">
                                  <i class="fas fa-edit"></i>
                                  Update
                                </button>
                              </a>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              <?php } ?>
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
    // Add sorting and toggle functionality
    document.querySelectorAll('.filter-category').forEach(dropdown => {
      dropdown.addEventListener('change', function() {
        const category = this.getAttribute('data-category');
        const order = this.value;
        const tbody = document.querySelector(`tbody[data-category="${category}"]`);

        let rows = Array.from(tbody.rows);

        rows.sort((a, b) => {
          let priceA = parseFloat(a.cells[3].textContent.replace('$', '').trim());
          let priceB = parseFloat(b.cells[3].textContent.replace('$', '').trim());

          if (order === 'low') {
            return priceA - priceB;
          } else if (order === 'high') {
            return priceB - priceA;
          } else {
            return 0;
          }
        });

        rows.forEach(row => tbody.appendChild(row));
      });
    });

    document.querySelectorAll('.toggle-products').forEach(button => {
      button.addEventListener('click', function() {
        const category = this.getAttribute('data-category');
        const tbody = document.querySelector(`tbody[data-category="${category}"]`);
        tbody.classList.toggle('d-none');
      });
    });
  </script>
</body>

</html>
