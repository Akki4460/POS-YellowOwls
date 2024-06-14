<?php
include('config/config.php');

// Initialize variables
$html = '';
$categories = [];

// Determine if there is a search query
if (isset($_POST['search'])) {
  $search_query = $_POST['search'];

  // Build SQL query based on search query
  if (!empty($search_query)) {
    $search_term = '%' . $search_query . '%';
    $ret = "SELECT * FROM rpos_products WHERE (prod_category IS NOT NULL AND prod_category != '' AND prod_category LIKE ?) OR (prod_name LIKE ?) OR (prod_code LIKE ?)";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('sss', $search_term, $search_term, $search_term);
  } else {
    // If search query is empty, fetch all products categorized by their categories
    $ret = "SELECT * FROM rpos_products WHERE prod_category IS NOT NULL AND prod_category != ''";
    $stmt = $mysqli->prepare($ret);
  }

} else {
  // Default case: fetch all products categorized by their categories
  $ret = "SELECT * FROM rpos_products WHERE prod_category IS NOT NULL AND prod_category != ''";
  $stmt = $mysqli->prepare($ret);
}

// Execute query
$stmt->execute();
$res = $stmt->get_result();

// Build HTML for products and categories
while ($prod = $res->fetch_object()) {
  // Prepare category ID and ensure it is unique
  $categoryId = str_replace(' ', '-', $prod->prod_category);
  $categories[$categoryId] = $prod->prod_category; // Store category for display later

  // Build product HTML
  $html .= "
    <tr class='product-row $categoryId' data-prod-id='$prod->prod_id' data-prod-code='$prod->prod_code' data-prod-name='$prod->prod_name' data-prod-price='$prod->prod_price'>
      <td><img src='assets/img/products/" . ($prod->prod_img ? $prod->prod_img : 'default.jpg') . "' height='60' width='60' class='img-thumbnail'></td>
      <td>$prod->prod_code</td>
      <td>$prod->prod_name</td>
      <td>$ $prod->prod_price</td>
    </tr>
  ";
}

// Build HTML for categories
foreach ($categories as $categoryId => $categoryName) {
  $html .= "
    <tr class='category-row'>
      <td colspan='4' style='background-color: #f8f9fe; font-weight: bold;'>$categoryName <button type='button' class='btn btn-sm btn-link toggle-category' data-category-id='$categoryId'>Show/Hide</button></td>
    </tr>
  ";
}

echo $html;
?>
