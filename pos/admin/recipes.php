<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

// Handle delete request
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $adn = "DELETE FROM rpos_ingredients WHERE ing_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();
  if ($stmt) {
    $success = "Deleted" && header("refresh:1; url=ingredients.php");
  } else {
    $err = "Try Again Later";
  }
}

// Handle search request
$search = '';
if (isset($_POST['search'])) {
  $search = $_POST['search'];
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
              <a href="add_ingredient.php" class="btn btn-outline-success">
                <i class="fas fa-carrot"></i>
                Add New Ingredient
              </a>
              <form method="POST" class="form-inline float-right">
                <input type="text" name="search" class="form-control" placeholder="Search Ingredients" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-outline-primary ml-2">Search</button>
              </form>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Size</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM rpos_ingredients";
                  if ($search) {
                    $ret .= " WHERE ing_name LIKE ? OR ing_size LIKE ? OR ing_quantity LIKE ?";
                    $stmt = $mysqli->prepare($ret);
                    $searchTerm = '%' . $search . '%';
                    $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
                  } else {
                    $stmt = $mysqli->prepare($ret);
                  }
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($ing = $res->fetch_object()) {
                  ?>
                    <tr>
                      <td><?php echo $ing->ing_id; ?></td>
                      <td><?php echo $ing->ing_name; ?></td>
                      <td><?php echo $ing->ing_size; ?></td>
                      <td><?php echo $ing->ing_quantity; ?></td>
                      <td>
                        <a href="ingredients.php?delete=<?php echo $ing->ing_id; ?>">
                          <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete
                          </button>
                        </a>
                        <a href="update_ingredient.php?update=<?php echo $ing->ing_id; ?>">
                          <button class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                            Update
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
</body>
</html>
