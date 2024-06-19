<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');
check_login();

if (isset($_POST['pay'])) {
  if (empty($_POST["pay_code"]) || empty($_POST["pay_amt"]) || empty($_POST['pay_method'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $pay_code = $_POST['pay_code'];
    $order_code = $_POST['order_code'];
    $customer_id = $_POST['customer_id'];
    $pay_amt  = $_POST['pay_amt'];
    $pay_method = $_POST['pay_method'];
    $pay_id = $_POST['pay_id'];
    $order_status = "paid"; // Set the order status to "Paid"

    // Insert payment information into the database
    $postQuery = "INSERT INTO rpos_payments (pay_id, pay_code, order_code, customer_id, pay_amt, pay_method) VALUES(?,?,?,?,?,?)";
    $upQry = "UPDATE rpos_orders SET order_status =? WHERE order_code =?";

    $postStmt = $mysqli->prepare($postQuery);
    $upStmt = $mysqli->prepare($upQry);

    // Bind parameters
    $rc = $postStmt->bind_param('ssssss', $pay_id, $pay_code, $order_code, $customer_id, $pay_amt, $pay_method);
    $rc = $upStmt->bind_param('ss', $order_status, $order_code);

    $postStmt->execute();
    $upStmt->execute();

    if ($upStmt && $postStmt) {
      $success = "Paid" && header("refresh:1; url=receipts.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
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
        <div class="header-body"></div>
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
                  <div class="col-md-6">
                    <label>Payment ID</label>
                    <input type="text" name="pay_id" readonly value="<?php echo $payid; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Payment Code</label>
                    <input type="text" name="pay_code" value="<?php echo $mpesaCode; ?>" class="form-control">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Amount (₹)</label>
                    <?php
                    $order_code = $_POST['order_code'];
                    $customer_id = $_POST['customer_id'];
                    $ret = "SELECT * FROM rpos_orders WHERE order_code = '$order_code'";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $total_amt = 0;
                    while ($order = $res->fetch_object()) {
                      $total_amt += ($order->prod_price * $order->prod_qty);
                    }
                    ?>
                    <input type="text" name="pay_amt" readonly value="<?php echo $total_amt; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Payment Method</label>
                    <select class="form-control" name="pay_method">
                      <option selected>Cash</option>
                      <option>Online</option>
                    </select>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="hidden" name="order_code" value="<?php echo $order_code; ?>">
                    <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
                    <input type="submit" name="pay" value="Pay Order" class="btn btn-success">
                  </div>
                </div>
              </form>
              <hr>
              <h3>Order Details</h3>
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col"><b>Product Name</b></th>
                    <th scope="col"><b>Quantity</b></th>
                    <th scope="col"><b>Price</b></th>
                    <th scope="col"><b>Total</b></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM rpos_orders WHERE order_code = '$order_code'";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($order = $res->fetch_object()) {
                    $total = ($order->prod_price * $order->prod_qty);
                  ?>
                    <tr>
                      <td><?php echo $order->prod_name; ?></td>
                      <td><?php echo $order->prod_qty; ?></td>
                      <td>₹<?php echo $order->prod_price; ?></td>
                      <td>₹<?php echo $total; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
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
</body>
</html>
