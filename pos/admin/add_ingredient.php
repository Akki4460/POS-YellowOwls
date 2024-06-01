<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (isset($_POST['addIngredient'])) {
    // Prevent Posting Blank Values
    if (empty($_POST["ing_name"])) {
        $err = "Blank Values Not Accepted";
    } else {
        $ing_id = $_POST['ing_id'];
        $ing_name = $_POST['ing_name'];
        $ing_size = $_POST['ing_size'];
        $ing_quantity = $_POST['ing_quantity'];

        // Check if ingredient with same name already exists
        $checkQuery = "SELECT * FROM rpos_ingredients WHERE ing_name = ?";
        $checkStmt = $mysqli->prepare($checkQuery);
        $checkStmt->bind_param('s', $ing_name);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Ingredient already exists, concatenate its quantity and size
            $existingIngredient = $checkResult->fetch_assoc();

            $existingQuantity = (int)$existingIngredient['ing_quantity'];
            $existingSize = (float)$existingIngredient['ing_size'];

            $newQuantity = $existingQuantity + (int)$ing_quantity;
            $newSize = $existingSize + (float)$ing_size;

            $updateQuery = "UPDATE rpos_ingredients SET ing_quantity = ?, ing_size = ? WHERE ing_name = ?";
            $updateStmt = $mysqli->prepare($updateQuery);
            $updateStmt->bind_param('sss', $newQuantity, $newSize, $ing_name);
            if ($updateStmt->execute()) {
                $success = "Ingredient Updated";
                header("refresh:1; url=add_ingredient.php");
            } else {
                $err = "Failed to update ingredient";
            }
            $updateStmt->close();
        } else {
            // Ingredient doesn't exist, add a new one
            $postQuery = "INSERT INTO rpos_ingredients (ing_id, ing_name, ing_size, ing_quantity) VALUES (?, ?, ?, ?)";
            if ($postStmt = $mysqli->prepare($postQuery)) {
                $postStmt->bind_param('ssss', $ing_id, $ing_name, $ing_size, $ing_quantity);
                if ($postStmt->execute()) {
                    $success = "Ingredient Added";
                    header("refresh:1; url=add_ingredient.php");
                } else {
                    $err = "Please Try Again Or Try Later";
                }
                $postStmt->close();
            } else {
                $err = "Error preparing statement: " . $mysqli->error;
            }
        }
        $checkStmt->close();
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
              <?php if (isset($err)) { echo "<div class='alert alert-danger'>$err</div>"; } ?>
              <?php if (isset($success)) { echo "<div class='alert alert-success'>$success</div>"; } ?>
            </div>
            <div class="card-body">
              <form method="POST">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Ingredient Name</label>
                    <input type="text" name="ing_name" class="form-control" required>
                    <input type="hidden" name="ing_id" value="<?php echo $ing_id; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Ingredient Size</label>
                    <input type="text" name="ing_size" class="form-control" >
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Ingredient Quantity</label>
                    <input type="text" name="ing_quantity" class="form-control" >
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="addIngredient" value="Add Ingredient" class="btn btn-success">
                  </div>
                </div>
              </form>
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
