<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

// Cancel Order
if (isset($_GET['cancel'])) {
    $id = $_GET['cancel'];
    $adn = "DELETE FROM rpos_orders WHERE order_code = ?"; // Assuming order_code is the correct identifier
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Order Cancelled Successfully";
        header("refresh:1; url=payments.php");
        exit; // Exit after header redirect
    } else {
        $err = "Failed to Cancel Order";
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
              <a href="orders.php" class="btn btn-outline-success">
                <i class="fas fa-plus"></i> <i class="fas fa-utensils"></i> Make A New Order
              </a>
            </div>
            <div class="table-responsive p-3">
              <table id="example" class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Order Code</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Products</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT order_code, customer_id, customer_name, GROUP_CONCAT(prod_name SEPARATOR ',<br> ') as products, SUM(prod_price * prod_qty) as total_price, order_status, created_at 
                          FROM rpos_orders 
                          GROUP BY order_code 
                          ORDER BY created_at DESC";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($order = $res->fetch_object()) {
                  ?>
                    <tr>
                      <th class="text-success" scope="row"><?php echo $order->order_code; ?></th>
                      <td><h5><?php echo $order->customer_name; ?></h5></td>
                      <td style="font-weight:bold; font-size:0.9rem;"><?php echo $order->products; ?></td>
                      <td style="font-weight:bold; font-size:1rem;">₹ <?php echo $order->total_price; ?></td>
                      <td><?php if ($order->order_status == '') {
                            echo "<span class='badge badge-danger'>Not Paid</span>";
                          } else {
                            echo "<span class='badge badge-success'>$order->order_status</span>";
                          } ?></td>
                      <td><?php echo date('d/M/Y g:i', strtotime($order->created_at)); ?></td>
                      <td>
                        <form method="POST" action="pay_order.php" style="display: inline;">
                          <input type="hidden" name="order_code" value="<?php echo $order->order_code; ?>">
                          <input type="hidden" name="customer_id" value="<?php echo $order->customer_id; ?>">
                          <input type="hidden" name="customer_name" value="<?php echo $order->customer_name; ?>">
                          <input type="hidden" name="total_price" value="<?php echo $order->total_price; ?>">
                          <input type="hidden" name="order_status" value="<?php echo $order->order_status; ?>">
                         
                          <?php if ($order->order_status == 'paid' || $order->order_status == 'Paid') {
                            echo " <button class='btn btn-sm btn-success' disabled type='submit'>
                            <i class='fas fa-handshake'></i> Pay Order
                          </button>";
                          }else{
                            echo " <button class='btn btn-sm btn-success' type='submit'>
                            <i class='fas fa-handshake'></i> Pay Order
                          </button>";
                          }
                          ?>
                          <!-- <button class="btn btn-sm btn-success" type="submit">
                            <i class="fas fa-handshake"></i> Pay Order
                          </button> -->
                        </form>
                        <a href="payments.php?cancel=<?php echo $order->order_code; ?>">
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
      <!-- Footer -->
      <?php require_once('partials/_footer.php'); ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php require_once('partials/_scripts.php'); ?>
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

      <script>
      $(document).ready(function () {
            $('#example').DataTable({
                dom: 'frtip',
                oLanguage: {
                    oPaginate: {
                        sNext: '<span class="pagination-fa"><i class="fa fa-chevron-right" ></i></span>',
                        sPrevious: '<span class="pagination-fa"><i class="fa fa-chevron-left" ></i></span>'
                    }
                }
      } );
  } );
  </script>
</body>

</html>
