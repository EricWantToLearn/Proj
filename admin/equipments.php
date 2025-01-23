<?php
// Start the session
session_start(); 
include 'controls/conn.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Optionally, retrieve additional user information from the database
// For example, fetching the user's full name, email, etc.
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Equipments</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php include 'sideboard.php' ?>

    <!-- Main content -->
<div class="content-wrapper">
  <div class="container-fluid">
    <div class="row">

      <!-- Update Maintenance Form -->
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Update Maintenance</h3>
          </div>
          <div class="card-body">
            <form action="update_maintenance.php" method="POST">
              <div class="form-group">
                <label for="equipment_name">Select Equipment:</label>
                <select id="equipment_name" name="equipment_name" class="form-control" required>
                  <?php
                  include 'controls/conn.php';
                  // Fetch equipment names from the maintenance table
                  $query = "SELECT id, name FROM maintenance";
                  $result = $conn->query($query);
                  while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
                  }
                  $result->close();
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="date_updated">Select Date:</label>
                <input type="date" id="date_updated" name="date_updated" class="form-control" required>
              </div>

              <button type="submit" class="btn btn-primary">Update Maintenance</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Maintenance List Table -->
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Maintenance Records</h3>
          </div>
          <div class="card-body">
            <?php
            $query = "SELECT name, date_updated FROM maintenance";
            $result = $conn->query($query);
            ?>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Equipment Name</th>
      <th>Date Updated</th>
      <th>Maintenance Date</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <?php
      // Compute Maintenance Date based on equipment name
      $maintenance_interval = 0; // Default interval in days
      switch ($row['name']) {
        case '4pcs Double A':
          $maintenance_interval = 3; // 3 days
          break;
        case '8pcs Triple A':
          $maintenance_interval = 10; // 10 days
          break;
        case 'Button cell Battery':
          $maintenance_interval = 7; // 1 week
          break;
        case 'Camera remote':
          $maintenance_interval = 180; // 6 months
          break;
        case 'Light bulb':
          $maintenance_interval = 90; // 3 months
          break;
        case 'Ink (printing)':
          $maintenance_interval = 30; // 1 month
          break;
          case 'Button cell Battery':
            $maintenance_interval = 7; // 1 week
            break;
        default:
          $maintenance_interval = 0; // No maintenance schedule
      }

      // Calculate the Maintenance Date
      $date_updated = new DateTime($row['date_updated']);
      if ($maintenance_interval > 0) {
        $date_updated->add(new DateInterval("P{$maintenance_interval}D"));
      }
      $maintenance_date = $date_updated->format('Y-m-d');
      ?>
      <tr>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['date_updated']); ?></td>
        <td><?php echo ($maintenance_interval > 0) ? htmlspecialchars($maintenance_date) : 'No Maintenance'; ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>


            <?php
            $result->close();
            $conn->close();
            ?>
          </div>
        </div>
      </div>

    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div><!-- /.content-wrapper -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include 'footer.php' ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
