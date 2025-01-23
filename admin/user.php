<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Optionally, retrieve additional user information from the database
// For example, fetching the user's full name, email, etc.
// Include database connection file
include 'controls/conn.php';

// Initialize variables
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $name = $_POST['txtName'];
    $username = $_POST['txtUserName'];
    $password = $_POST['txtPassword'];
    $email = $_POST['txtEmail'];

    // Check if fields are not empty
    if (!empty($username) && !empty($password) && !empty($email)) {
        // Check if the username or email already exists
        $checkStmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $checkStmt->bind_param("ss", $username, $email);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            // Username or email exists
            $error = "Username or email already exists!";
        } else {
            // Hash the password before storing
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute the insert query with is_verified set to 0
            $stmt = $conn->prepare("INSERT INTO users (fullname, username, password, email, is_verified) VALUES (?, ?, ?, ?, 0)");
            $stmt->bind_param("ssss", $name, $username, $hashedPassword, $email);

            if ($stmt->execute()) {
                $success = "User registered successfully!";
            } else {
                $error = "Error: " . $conn->error;
            }
            $stmt->close();
        }
        $checkStmt->close();
    } else {
        $error = "Please fill in all fields.";
    }

   
}

// Fetch users from the database
$users = [];
if ($conn) {
    $stmt = $conn->prepare("SELECT id, fullname, username FROM users");
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch all user records
    while ($row = $result->fetch_assoc()) {
        $users[] = $row; // Store each row in the users array
    }
    $stmt->close();
} else {
    $error = "Database connection failed!";
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>dos studios.</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->

   
      <?php include 'sideboard.php'?>

          <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Add User</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->



    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Register</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <form method="POST" action="user.php">
                <label for="txtName">Name:</label>
                <input type="text" class="form-control" id="txtName" name="txtName" required>
              </div>
              <div class="form-group">
                <label for="txtEmail">Email:</label>
                <input type="email" class="form-control" id="txtEmail" name="txtEmail" required>
              </div>
              <div class="form-group">
                <label for="txtUserName">Username:</label>
                <input type="text" class="form-control" id="txtUserName" name="txtUserName" required>
              </div>
              <div class="form-group">
                <label for="txtPassword">Password:</label>
                <input type="password" class="form-control" id="txtPassword" name="txtPassword" required>
              </div>
            </div>
            <!-- /.card-body -->
            <button type="submit" class="btn btn-primary">Register</button>
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <!-- JavaScript alert for showing error/success -->
        <script>
            <?php if (!empty($error)) { ?>
                alert("<?php echo $error; ?>");
            <?php } elseif (!empty($success)) { ?>
                alert("<?php echo $success; ?>");
            <?php } ?>
        </script>
          <!-- /.card -->
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Names</h3>

              
            </div>
            <div class="card-body p-0">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include 'footer.php' ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
