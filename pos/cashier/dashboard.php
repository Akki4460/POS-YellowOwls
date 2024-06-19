<?php
session_start();
include ('config/config.php');
include ('config/checklogin.php');
check_login();
require_once ('partials/_head.php');
require_once ('partials/_analytics.php');
?>

<body>
  <!-- Sidenav -->
  <?php
  require_once ('partials/_sidebar.php');
  ?>

  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->

    <?php
    require_once ('partials/_topnav.php');
    ?>


    <!-- Header -->
    <!-- Header -->
    <div style="background-image: url(assets/img/theme/bg.png); background-size: cover;"
      class="header pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Customers</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $customers; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Products</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $products; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                        <i class="fas fa-utensils"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Orders</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $orders; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-concierge-bell"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>
                      <span class="h2 font-weight-bold mb-0">₹ <?php echo $sales; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                        <i class="fas fa-rupee-sign"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- Page content -->
    <div class="container-fluid mt--7">
    <div class="row mt-5 display-3">
  <div class="col-xl-12 mb-5 mb-xl-0">
    <div class="card shadow">
      <div class="card-header border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="mb-0">Recent Orders</h3>
          </div>
          <div class="col text-right">
            <a href="orders_reports.php" class="btn btn-sm btn-primary">See all</a>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <!-- Projects table -->
        <table class="table table-hover align-items-center table-flush">
          <thead class="thead-light">
            <tr>
              <th class="text-success" scope="col"><b>Code</b></th>
              <th scope="col"><b>Customer</b></th>
              <th class="text-success" scope="col"><b>Products</b></th>
              <th scope="col"><b>Total Price</b></th>
              <th scop="col"><b>Status</b></th>
              <th class="text-success" scope="col"><b>Date</b></th>
              <th scope="col"><b>Action</b></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $ret = "SELECT order_code, customer_id, customer_name, GROUP_CONCAT(prod_name SEPARATOR ' | ') as products, SUM(prod_price * prod_qty) as total_price, order_status, created_at 
                    FROM rpos_orders 
                    GROUP BY order_code 
                    ORDER BY created_at DESC 
                    LIMIT 7";
            $stmt = $mysqli->prepare($ret);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($order = $res->fetch_object()) {
            ?>
              <tr>
                <th class="text-success" scope="row"><?php echo htmlspecialchars($order->order_code); ?></th>
                <td><?php echo htmlspecialchars($order->customer_name); ?></td>
                <td class="text-success"><h4 class="text-success"><?php echo htmlspecialchars($order->products); ?></h4></td>
                <td><h4>₹<?php echo htmlspecialchars($order->total_price); ?></h4></td>
                <td><?php echo ($order->order_status == '') ? "<span class='badge badge-danger'>Not Paid</span>" : "<span class='badge badge-success'>$order->order_status</span>"; ?></td>
                <td class="text-success"><?php echo date('d/M/Y g:i', strtotime($order->created_at)); ?></td>
                <td>
                  <form method="POST" action="pay_order.php" style="display: inline;">
                    <input type="hidden" name="order_code" value="<?php echo htmlspecialchars($order->order_code); ?>">
                    <input type="hidden" name="customer_id" value="<?php echo $order->customer_id; ?>">
                    <input type="hidden" name="customer_name" value="<?php echo htmlspecialchars($order->customer_name); ?>">
                    <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($order->total_price); ?>">
                    <input type="hidden" name="order_status" value="<?php echo htmlspecialchars($order->order_status); ?>">
                    
                    <?php if (strtolower($order->order_status) == 'paid') { ?>
                      <button class='btn btn-sm btn-success' disabled type='submit'>
                        <i class='fas fa-handshake'></i> Pay Order
                      </button>
                    <?php } else { ?>
                      <button class='btn btn-sm btn-success' type='submit'>
                        <i class='fas fa-handshake'></i> Pay Order
                      </button>
                    <?php } ?>
                  </form>
                  <a href="payments.php?cancel=<?php echo htmlspecialchars($order->order_code); ?>">
                    <button class="btn btn-sm btn-danger">
                      <i class="fas fa-window-close"></i> Cancel Order
                    </button>
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

      <div class="row mt-5 display-3">
        <div class="col-xl-12">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Recent Payments</h3>
                </div>
                <div class="col text-right">
                  <a href="payments_reports.php" class="btn btn-sm btn-primary">See all</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="text-success" scope="col"><b>Code</b></th>
                    <th scope="col"><b>Amount</b></th>
                    <th class='text-success' scope="col"><b>Order Code</b></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM   rpos_payments   ORDER BY `rpos_payments`.`created_at` DESC LIMIT 7 ";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($payment = $res->fetch_object()) {
                    ?>
                    <tr>
                      <th class="text-success" scope="row">
                        <?php echo $payment->pay_code; ?>
                      </th>
                      <td><h4>
                        ₹<?php echo $payment->pay_amt; ?>
                        </h4></td>
                      <td class='text-success'>
                        <?php echo $payment->order_code; ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
    <div class="row mt-5 display-3">
        <!-- Sales Section -->
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-primary">Sales</h2>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Daily Sales</h5>
                                    <h3 class="card-text text-success">₹ <?php echo $sales_daily == null ? '0' : $sales_daily; ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Monthly Sales</h5>
                                    <h3 class="card-text text-success">₹ <?php echo $sales_monthly ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Yearly Sales</h5>
                                    <h3 class="card-text text-success">₹ <?php echo $sales_yearly ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Section -->
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-primary">Orders</h2>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Daily Orders</h5>
                                    <h3 class="card-text text-warning"><?php echo $orders_daily == null ? '0' : $orders_daily; ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Monthly Orders </h5>
                                    <h3 class="card-text text-warning"><?php echo $orders_monthly ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Yearly Orders</h5>
                                    <h3 class="card-text text-warning"><?php echo $orders_yearly ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

      <!-- Footer -->
      <?php require_once ('partials/_footer.php'); ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once ('partials/_scripts.php');
  ?>
</body>

</html>