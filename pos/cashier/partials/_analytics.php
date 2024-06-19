<?php
//1. Customers

// ALL Customers
$query = "SELECT COUNT(*) FROM `rpos_customers`";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($customers);
$stmt->fetch();
$stmt->close();

// // Daily Customers
// $query = "SELECT COUNT(*) FROM `rpos_customers` WHERE DATE(created_at) = CURDATE()";
// $stmt = $mysqli->prepare($query);
// $stmt->execute();
// $stmt->bind_result($customers_daily);
// $stmt->fetch();
// $stmt->close();

// // Monthly Customers
// $query = "SELECT COUNT(*) FROM `rpos_customers` WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
// $stmt = $mysqli->prepare($query);
// $stmt->execute();
// $stmt->bind_result($customers_monthly);
// $stmt->fetch();
// $stmt->close();

// // Yearly Customers
// $query = "SELECT COUNT(*) FROM `rpos_customers` WHERE YEAR(created_at) = YEAR(CURDATE())";
// $stmt = $mysqli->prepare($query);
// $stmt->execute();
// $stmt->bind_result($customers_yearly);
// $stmt->fetch();
// $stmt->close();

//2. Orders
// ALL Orders
// $query = "SELECT COUNT(*) FROM `rpos_orders` ";
$query = "SELECT COUNT(DISTINCT order_code) FROM `rpos_orders`";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($orders);
$stmt->fetch();
$stmt->close();

// Daily Orders
$query = "SELECT COUNT(DISTINCT order_code) FROM `rpos_orders` WHERE DATE(created_at) = CURDATE()";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($orders_daily);
$stmt->fetch();
$stmt->close();

// Monthly Orders
$query = "SELECT COUNT(DISTINCT order_code) FROM `rpos_orders` WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($orders_monthly);
$stmt->fetch();
$stmt->close();

// Yearly Orders
$query = "SELECT COUNT(DISTINCT order_code) FROM `rpos_orders` WHERE YEAR(created_at) = YEAR(CURDATE())";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($orders_yearly);
$stmt->fetch();
$stmt->close();

//3. Products
// Daily Products (If applicable, otherwise products count does not change often)
$query = "SELECT COUNT(*) FROM `rpos_products`";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($products);
$stmt->fetch();
$stmt->close();

// // Daily Products (If applicable, otherwise products count does not change often)
// $query = "SELECT COUNT(*) FROM `rpos_products` WHERE DATE(created_at) = CURDATE()";
// $stmt = $mysqli->prepare($query);
// $stmt->execute();
// $stmt->bind_result($products_daily);
// $stmt->fetch();
// $stmt->close();

// // Monthly Products
// $query = "SELECT COUNT(*) FROM `rpos_products` WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
// $stmt = $mysqli->prepare($query);
// $stmt->execute();
// $stmt->bind_result($products_monthly);
// $stmt->fetch();
// $stmt->close();

// // Yearly Products
// $query = "SELECT COUNT(*) FROM `rpos_products` WHERE YEAR(created_at) = YEAR(CURDATE())";
// $stmt = $mysqli->prepare($query);
// $stmt->execute();
// $stmt->bind_result($products_yearly);
// $stmt->fetch();
// $stmt->close();

//4. Sales
// ALL Sales
$query = "SELECT SUM(pay_amt) FROM `rpos_payments`";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($sales);
$stmt->fetch();
$stmt->close();

// Daily Sales
$query = "SELECT SUM(pay_amt) FROM `rpos_payments` WHERE DATE(created_at) = CURDATE()";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($sales_daily);
$stmt->fetch();
$stmt->close();

// Monthly Sales
$query = "SELECT SUM(pay_amt) FROM `rpos_payments` WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($sales_monthly);
$stmt->fetch();
$stmt->close();

// Yearly Sales
$query = "SELECT SUM(pay_amt) FROM `rpos_payments` WHERE YEAR(created_at) = YEAR(CURDATE())";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($sales_yearly);
$stmt->fetch();
$stmt->close();

