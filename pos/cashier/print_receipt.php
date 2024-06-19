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

<body class="m-5">
    <div class="container">
        <div class="row justify-content-center">
            <div id="Invoice" class="col-12 col-md-8 mt-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h2 class="text-primary">The Yellow Owl</h2>
                                <address>
                                    46 B, Pachgaon Rd, Sahajeevan Housing Society,<br>
                                    Ratnappa Kumbhar Nagar, Kolhapur,<br>
                                    Maharashtra 416012<br>
                                    <abbr title="Phone">P: +91 9923101994</abbr>
                                </address>
                            </div>
                            <div class="col-md-6 text-right">
                                <p>
                                    <strong>Date:</strong> <?php echo date('d/M/Y g:i', strtotime($created_at)); ?><br>
                                    <strong>Invoice #:</strong> <?php echo $order_code; ?>
                                </p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12 text-center">
                                <h3>Invoice</h3>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead class="thead-light">
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
                                        <td><em><?php echo $product->prod_name; ?></em></td>
                                        <td class="text-center"><?php echo $product->prod_qty; ?></td>
                                        <td class="text-center">₹<?php echo $product->prod_price; ?></td>
                                        <td class="text-center">₹<?php echo $product->prod_price * $product->prod_qty; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td class="text-right"><strong>Subtotal:</strong></td>
                                    <td class="text-center">₹<?php echo $total_price; ?></td>
                                </tr>
                                <!-- <tr>
                                    <td colspan="2"></td>
                                    <td class="text-right"><strong>Tax (14%):</strong></td>
                                    <td class="text-center">₹<?php echo $total_price * 0.14; ?></td>
                                </tr> -->
                                <tr>
                                    <td colspan="2"></td>
                                    <td class="text-right"><h4><strong>Total:</strong></h4></td>
                                    <td class="text-center text-danger"><h4><strong>₹<?php echo $total_price; ?></strong></h4></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-right">
                        <button id="print" onclick="printContent('Invoice');" class="btn btn-primary">
                            Print <span class="fas fa-print"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<!-- Include jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    @media print {
        body {
            visibility: hidden;
        }
        #Invoice, #Invoice * {
            visibility: visible;
        }
        #Invoice {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .table {
            border-collapse: collapse;
            width: 100%;
        }
        .table, .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            text-align: left;
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-primary {
            color: #007bff !important;
        }
        .card-footer {
            display: none;
        }
    }
    .container {
        max-width: 900px;
    }
    .card {
        border: 1px solid #ddd;
    }
    .card-body {
        padding: 2rem;
    }
    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #ddd;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    h2, h3, h4 {
        margin: 0 0 10px;
    }
    .thead-light th {
        background-color: #f8f9fa;
    }
    address {
        margin-bottom: 1rem;
    }
</style>

<script>
    function printContent(el) {
        document.getElementById('print').style.display='none';

        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>
