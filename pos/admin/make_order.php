<?php
session_start();
include ('config/config.php');
include ('config/checklogin.php');
include ('config/code-generator.php');

check_login();

$selected_products_array = [];
if (isset($_POST['selected_products'])) {
  $selected_products_array = json_decode($_POST['selected_products'], true);
}

if (isset($_POST['make'])) {
  // Prevent Posting Blank Values
  if (empty($_POST["order_code"]) || empty($_POST["customer_name"]) || empty($_POST['prod_price'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $order_code = $_POST['order_code'];
    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];

    $postStmt = null; // Initialize the statement variable

    // Loop through each product to insert into the database
    foreach ($_POST['prod_id'] as $index => $prod_id) {
      $order_id = bin2hex(random_bytes(5)); // Generate a unique order ID

      $prod_name = $_POST['prod_name'][$index];
      $prod_price = $_POST['prod_price'][$index];
      $prod_qty = $_POST['prod_qty'][$index];

      // Insert Captured information into the database table
      $postQuery = "INSERT INTO rpos_orders (prod_qty, order_id, order_code, customer_id, customer_name, prod_id, prod_name, prod_price) VALUES(?,?,?,?,?,?,?,?)";
      $postStmt = $mysqli->prepare($postQuery);
      // Bind parameters
      $rc = $postStmt->bind_param('ssssssss', $prod_qty, $order_id, $order_code, $customer_id, $customer_name, $prod_id, $prod_name, $prod_price);
      $postStmt->execute();
    }

    // Declare a variable which will be passed to alert function
    if ($postStmt) {
      $success = "Order Submitted" && header("refresh:1; url=payments.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}
require_once ('partials/_head.php');
?>

<body style="font-size:1.2rem;">
  <!-- Sidenav -->
  <?php require_once ('partials/_sidebar.php'); ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php require_once ('partials/_topnav.php'); ?>
    <!-- Header -->
    <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;"
      class="header pb-8 pt-5 pt-md-8">
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
              <h3>Please Fill All Fields</h3>
            </div>
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                  <div class="col-md-4">
                    <label>Customer Name</label>
                    <select style="font-size:1rem;" class="form-control" name="customer_name" id="custName" onChange="getCustomer(this.value)">
                      <option value="">Select Customer Name</option>
                      <?php
                      // Load All Customers
                      $ret = "SELECT * FROM  rpos_customers ";
                      $stmt = $mysqli->prepare($ret);
                      $stmt->execute();
                      $res = $stmt->get_result();
                      while ($cust = $res->fetch_object()) {
                        ?>
                        <option><?php echo $cust->customer_name; ?></option>
                      <?php } ?>
                    </select>
                    <input type="hidden" name="order_id" value="<?php echo $orderid; ?>" class="form-control">
                    <div class="card-header border-0">
                      <a href="add_customer.php" class="btn btn-outline-success">
                        <i class="fas fa-user-plus"></i>
                        Add New Customer
                      </a>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label>Customer ID</label>
                    <input type="text" name="customer_id" readonly id="customerID" class="form-control">
                  </div>
                  <div class="col-md-4">
                    <label>Order Code</label>
                    <input type="text" name="order_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>"
                      class="form-control">
                  </div>
                </div>

                <hr>

                <?php
                if (!empty($selected_products_array)) {
                  foreach ($selected_products_array as $product) {
                    ?>
                    <div class="form-row">
                      <div class="col-md-4">
                        <label>Product Name</label>
                        <input style="font-size:1rem;" type="text" readonly name="prod_name[]" value="<?php echo $product['prod_name']; ?>"
                          class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label>Product Price (₹)</label>
                        <input style="font-size:1rem;" type="text" readonly name="prod_price[]" value="<?php echo $product['prod_price']; ?>"
                          class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label>Product Quantity</label>
                        <input style="font-size:1rem;" type="text" name="prod_qty[]" class="form-control"
                          value="<?php echo $product['quantity']; ?>">
                      </div>
                      <input type="hidden" name="prod_id[]" value="<?php echo $product['prod_id']; ?>" class="form-control">
                    </div>
                    <br>
                    <?php
                  }
                }
                ?>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="make" value="Make Order" class="btn btn-success">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?php require_once ('partials/_footer.php'); ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php require_once ('partials/_scripts.php'); ?>
  <script>
    function getCustomer(val) {
      $.ajax({
        type: "POST",
        url: "get_customer.php",
        data: 'custName=' + val,
        success: function (data) {
          // Set customer ID based on response
          if (data !== 'Customer not found' && data !== 'Invalid request') {
            $("#customerID").val(data);
          } else {
            alert(data);
            $("#customerID").val(''); // Clear the customer ID field if an error occurs
          }
        }
      });
    }
  </script>
</body>

</html>