<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

$order_code = $_GET['order_code'];

// Retrieve order details including product information
$ret = "SELECT * FROM rpos_orders WHERE order_code = ?";
$stmt = $mysqli->prepare($ret);
$stmt->bind_param('s', $order_code);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    // Fetching order details
    $order = $res->fetch_object();
    $customer_name = $order->customer_name;
    $created_at = $order->created_at;

    // Fetching all products for the order and calculating total price
    $ret_products = "SELECT prod_name, prod_qty, prod_price FROM rpos_orders WHERE order_code = ?";
    $stmt_products = $mysqli->prepare($ret_products);
    $stmt_products->bind_param('s', $order_code);
    $stmt_products->execute();
    $res_products = $stmt_products->get_result();

    $total_price = 0; // Initialize total price
    while ($product = $res_products->fetch_object()) {
        $total_price += $product->prod_price * $product->prod_qty;
    }
} else {
    // Handle case where order with given order_code does not exist
    echo "Order not found.";
    exit;
}

require_once('partials/_head.php');
?>

<body>
    <div class="container">
        <div class="row">
            <div id="Invoice" class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <address>
                            <strong>CodeAstro Lounge</strong><br>
                            127-0-0-1<br>
                            4151 Willow Oaks Lane, Sugartown<br>
                            (+000) 337-337-3069
                        </address>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                        <p>
                            <em>Date: <?php echo date('d/M/Y g:i', strtotime($created_at)); ?></em>
                        </p>
                        <p>
                            <em class="text-success">Invoice #: <?php echo $order_code; ?></em>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="text-center">
                        <h2>Invoice</h2>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $res_products->data_seek(0); // Reset result pointer to fetch again
                        while ($product = $res_products->fetch_object()) : ?>
                            <tr>
                                <td class="col-md-9"><em><?php echo $product->prod_name; ?></em></td>
                                <td class="col-md-1" style="text-align: center"><?php echo $product->prod_qty; ?></td>
                                <td class="col-md-1 text-center">₹<?php echo $product->prod_price; ?></td>
                                <td class="col-md-1 text-center">₹<?php echo $product->prod_price * $product->prod_qty; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td class="text-right"><strong>Subtotal:</strong></td>
                            <td class="text-center">₹<?php echo $total_price; ?></td>
                        </tr>
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td class="text-right"><strong>Tax (14%):</strong></td>
                            <td class="text-center">₹<?php echo $total_price * 0.14; ?></td>
                        </tr>
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td class="text-right"><h4><strong>Total:</strong></h4></td>
                            <td class="text-center text-danger"><h4><strong>₹<?php echo $total_price + ($total_price * 0.14); ?></strong></h4></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                <button id="print" onclick="printContent('Invoice');" class="btn btn-success btn-lg text-justify btn-block">
                    Print <span class="fas fa-print"></span>
                </button>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    function printContent(el) {
        var restorepage = $('body').html();
        var printcontent = $('#' + el).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    }
</script>
