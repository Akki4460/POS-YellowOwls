<?php
// include('config/config.php');

// if (isset($_GET['customer_name'])) {
//     $customerName = $_GET['customer_name'];
//     $ret = "SELECT * FROM rpos_customers WHERE customer_name = ?";
//     $stmt = $mysqli->prepare($ret);
//     $stmt->bind_param('s', $customerName);
//     $stmt->execute();
//     $res = $stmt->get_result();
//     $cust = $res->fetch_assoc();

//     echo json_encode($cust);
// }
?>

<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

// Check if the customer name is passed
if (isset($_POST['custName'])) {
  $customer_name = $_POST['custName'];

  // Prepare a query to get the customer ID based on the customer name
  $query = "SELECT customer_id FROM rpos_customers WHERE customer_name = ?";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('s', $customer_name);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $customer = $result->fetch_assoc();
    echo $customer['customer_id'];
  } else {
    echo 'Customer not found';
  }
} else {
  echo 'Invalid request';
}
?>
