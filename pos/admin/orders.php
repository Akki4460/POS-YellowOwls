<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

require_once('partials/_head.php');

// Handle search query
$search_query = '';
if (isset($_POST['search'])) {
  $search_query = $_POST['search'];
}
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
      <!-- Two-column layout -->
      <div class="row">
        <!-- Available Products -->
        <div class="col-md-6">
          <div class="card shadow">
            <div class="card-header border-0">
              Available Products
              <!-- Search Form -->
              <div class="input-group input-group-sm mb-3">
                <input type="text" id="search-input" name="search" class="form-control" placeholder="Search products">
              </div>
            </div>
            <div class="table-responsive">
              <form id="product-selection-form" method="POST" action="make_order.php">
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col"><b>Image</b></th>
                      <th scope="col"><b>Product Code</b></th>
                      <th scope="col"><b>Name</b></th>
                      <th scope="col"><b>Price</b></th>
                    </tr>
                  </thead>
                  <tbody id="product-list">
                    <!-- Products will be dynamically loaded here -->
                    <?php
                    // Fetch categories
                    $ret = "SELECT DISTINCT prod_category FROM rpos_products WHERE prod_category IS NOT NULL AND prod_category != ''";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $categories = [];
                    while ($category = $res->fetch_object()) {
                      $categories[] = $category->prod_category;
                    }

                    // Display categorized products
                    foreach ($categories as $category) {
                      $category_id = str_replace(' ', '-', $category); // Generate a unique ID for each category
                      echo "<tr class='category-row'><td colspan='4' style='background-color: #f8f9fe; font-weight: bold;'>$category <button type='button' class='btn btn-sm btn-link toggle-category' data-category-id='$category_id'>Show/Hide</button></td></tr>";

                      // Fetch products for each category
                      $ret2 = "SELECT * FROM rpos_products WHERE prod_category = ? AND (prod_name LIKE ? OR prod_code LIKE ?)";
                      $stmt2 = $mysqli->prepare($ret2);
                      $search_term = '%' . $search_query . '%';
                      $stmt2->bind_param('sss', $category, $search_term, $search_term);
                      $stmt2->execute();
                      $res2 = $stmt2->get_result();
                      while ($prod = $res2->fetch_object()) {
                        echo "
                          <tr class='product-row $category_id' data-prod-id='$prod->prod_id' data-prod-code='$prod->prod_code' data-prod-name='$prod->prod_name' data-prod-price='$prod->prod_price'>
                            <td><img src='assets/img/products/" . ($prod->prod_img ? $prod->prod_img : 'default.jpg') . "' height='60' width='60' class='img-thumbnail'></td>
                            <td>$prod->prod_code</td>
                            <td>$prod->prod_name</td>
                            <td>$ $prod->prod_price</td>
                          </tr>
                        ";
                      }
                    }

                    // Display uncategorized products under 'Other' category
                    echo "<tr class='category-row'><td colspan='4' style='background-color: #f8f9fe; font-weight: bold;'>Other <button type='button' class='btn btn-sm btn-link toggle-category' data-category-id='Other'>Show/Hide</button></td></tr>";
                    $ret3 = "SELECT * FROM rpos_products WHERE (prod_category IS NULL OR prod_category = '') AND (prod_name LIKE ? OR prod_code LIKE ?)";
                    $stmt3 = $mysqli->prepare($ret3);
                    $stmt3->bind_param('ss', $search_term, $search_term);
                    $stmt3->execute();
                    $res3 = $stmt3->get_result();
                    while ($prod = $res3->fetch_object()) {
                      echo "
                        <tr class='product-row Other' data-prod-id='$prod->prod_id' data-prod-code='$prod->prod_code' data-prod-name='$prod->prod_name' data-prod-price='$prod->prod_price'>
                          <td><img src='assets/img/products/" . ($prod->prod_img ? $prod->prod_img : 'default.jpg') . "' height='60' width='60' class='img-thumbnail'></td>
                          <td>$prod->prod_code</td>
                          <td>$prod->prod_name</td>
                          <td>$ $prod->prod_price</td>
                        </tr>
                      ";
                    }
                    ?>
                  </tbody>
                </table>
                <!-- Submit Button -->
                <div class="row mt-3">
                  <div class="col">
                    <button type="button" id="submit-order-btn" class="btn btn-success">Submit Order</button>
                  </div>
                </div>
                <!-- Hidden Input Field to Store Selected Products -->
                <input type="hidden" name="selected_products" id="selected-products-input">
              </form>
            </div>
          </div>
        </div>
        <!-- Selected Products -->
        <div class="col-md-6">
          <div class="card shadow">
            <div class="card-header border-0">
              Selected Products
            </div>
            <div class="table-responsive">
              <table id="selected-products" class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col"><b>Product Code</b></th>
                    <th scope="col"><b>Name</b></th>
                    <th scope="col"><b>Price</b></th>
                    <th scope="col"><b>Quantity</b></th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Selected products will be displayed here -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php require_once('partials/_scripts.php'); ?>
  <!-- Script for managing product selection and quantity -->
  <script>
    $(document).ready(function() {
      // Handle show/hide functionality for categories
      $('.toggle-category').click(function() {
        var categoryId = $(this).data('category-id');
        $('.' + categoryId).toggle();
      });

      // Handle live search
      $('#search-input').on('input', function() {
        var searchQuery = $(this).val();
        $.ajax({
          url: 'search_products.php',
          method: 'POST',
          data: { search: searchQuery },
          success: function(response) {
            $('#product-list').html(response);
          }
        });
      });

      // Handle row clicks to select or deselect products
      $('#product-selection-form tbody').on('click', 'tr.product-row', function() {
        var productId = $(this).data('prod-id');
        var prodCode = $(this).data('prod-code');
        var prodName = $(this).data('prod-name');
        var prodPrice = $(this).data('prod-price');

        // Check if the product is already in the selected list
        var existingRow = $('#selected-products tbody tr[data-prod-id="' + productId + '"]');

        if (existingRow.length) {
          // If product already selected, increase its quantity
          var quantityCell = existingRow.find('td.quantity');
          var currentQuantity = parseInt(quantityCell.text());
          quantityCell.text(currentQuantity + 1);
        } else {
          // Append the selected product row to the selected products table
          $('#selected-products tbody').append(`
            <tr data-prod-id="${productId}">
              <td>${prodCode}</td>
              <td>${prodName}</td>
              <td>$ ${prodPrice}</td>
              <td class="quantity">1</td>
            </tr>
          `);
        }
      });

      // Handle click on Submit Order button
      $('#submit-order-btn').click(function(e) {
        e.preventDefault(); // Prevent default form submission

        // Create an array to store the selected product IDs
        var selectedProducts = [];

        // Get IDs of selected products
        $('#selected-products tbody tr').each(function() {
          var productId = $(this).data('prod-id');
          selectedProducts.push(productId);
        });

        // Set the value of the hidden input field with the selected product IDs
        $('#selected-products-input').val(selectedProducts.join(','));

        // Submit the form
        $('#product-selection-form').submit();
      });
    });
  </script>
</body>

</html>

