<?php
session_start();
include('config/config.php');
include('config/checklogin.php');

check_login();

if (isset($_POST['updateIngredient'])) {
  // Prevent Posting Blank Values
  if (empty($_POST["ing_name"])) {
    $err = "Blank Values Not Accepted";
  } else {
    $update = $_GET['update'];
    $ing_name = $_POST['ing_name'];
    $ing_size = $_POST['ing_size'];
    $ing_quantity = $_POST['ing_quantity'];

    // Update ingredient information in the database
    $updateQuery = "UPDATE rpos_ingredients SET ing_name = ?, ing_size = ?, ing_quantity = ? WHERE ing_id = ?";
    $updateStmt = $mysqli->prepare($updateQuery);

    // Bind parameters
    $updateStmt->bind_param('sssi', $ing_name, $ing_size, $ing_quantity, $update);

    // Execute query
    if ($updateStmt->execute()) {
      $success = "Ingredient Updated" && header("refresh:1; url=ingredients.php");
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
              <?php if (isset($err)) { echo "<div class='alert alert-danger'>$err</div>"; } ?>
              <?php if (isset($success)) { echo "<div class='alert alert-success'>$success</div>"; } ?>
            </div>
            <div class="card-body">
              <?php
              $update = $_GET['update'];
              $ret = "SELECT * FROM rpos_ingredients WHERE ing_id = ?";
              $stmt = $mysqli->prepare($ret);
              $stmt->bind_param('i', $update);
              $stmt->execute();
              $res = $stmt->get_result();
              while ($ing = $res->fetch_object()) {
              ?>
                <form method="POST">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Ingredient Name</label>
                      <input type="text" name="ing_name" value="<?php echo $ing->ing_name; ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label>Ingredient Size</label>
                      <input type="text" name="ing_size" value="<?php echo $ing->ing_size; ?>" class="form-control" >
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Ingredient Quantity</label>
                      <input type="text" name="ing_quantity" value="<?php echo $ing->ing_quantity; ?>" class="form-control" >
                    </div>
                  </div>
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="updateIngredient" value="Update Ingredient" class="btn btn-success">
                    </div>
                  </div>
                </form>
              <?php } ?>
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
