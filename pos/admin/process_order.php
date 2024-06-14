<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

function generateUUID() {
    return bin2hex(random_bytes(16)); // Generates a 32 character hex string
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['customer_name']) && isset($_POST['customer_id']) && isset($_POST['selected_products'])) {
    $customerName = $_POST['customer_name'];
    $customerId = $_POST['customer_id'];
    $orderCode = uniqid(); // Or any other logic to generate a unique order code
    $orderId = generateUUID(); // Generate a unique order ID

    foreach ($_POST['selected_products'] as $productId) {
        $prodQty = $_POST['product_quantity'][$productId];
        
        // Get product details
        $ret = "SELECT * FROM rpos_products WHERE prod_id = ?";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $res = $stmt->get_result();
        $prod = $res->fetch_object();
        
        $prodName = $prod->prod_name;
        $prodPrice = $prod->prod_price;

        // Insert into orders table
        $postQuery = "INSERT INTO rpos_orders (prod_qty, order_id, order_code, customer_id, customer_name, prod_id, prod_name, prod_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $postStmt = $mysqli->prepare($postQuery);
        $postStmt->bind_param('ssssssss', $prodQty, $orderId, $orderCode, $customerId, $customerName, $productId, $prodName, $prodPrice);
        $postStmt->execute();
        $postStmt->close();
    }

    // Redirect to a success page or display a success message
    header("Location: orders.php?success=1");
    exit();
} else {
    // Redirect back to the form with an error message if required fields are missing
    header("Location: order_page.php?error=Missing required fields");
    exit();
}
