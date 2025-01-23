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
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Starter</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php include 'sideboard.php'?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Transaction History</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Transaction History</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class ="row">
        <div class="col-lg-12">
            <div class="card">
            <div class="card-header">
            <h5 class="m-0">Monthly Sales Report</h5>
            <!-- Export Button -->
            <form action="export_sales.php" method="post">
                <button type="submit" class="btn btn-primary">Export to Excel</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sales ID</th>
                        <th>Booking Date</th>
                        <th>Studio</th>
                        <th>Booking Time</th>
                        <th>Verified By</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get the current month and year
                    $currentMonth = date('m');
                    $currentYear = date('Y');
                    
                    $query = "SELECT s.sales_id, s.booking_date, s.package_list as studio, 
                             s.time_range, u.username as queued_by, s.total_price,
                             DATE_FORMAT(s.booking_date, '%Y-%m-%d') as formatted_date
                             FROM sales s 
                             LEFT JOIN users u ON s.users = u.id
                             WHERE MONTH(s.booking_date) = ? AND YEAR(s.booking_date) = ?
                             ORDER BY s.booking_date DESC";
                    
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('ss', $currentMonth, $currentYear);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result && $result->num_rows > 0) {
                        $totalPrice = 0;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['sales_id']}</td>";
                            echo "<td>{$row['formatted_date']}</td>";
                            echo "<td>{$row['studio']}</td>";
                            echo "<td>{$row['time_range']}</td>";
                            echo "<td>" . ($row['queued_by'] ?? 'Not Assigned') . "</td>";
                            echo "<td>₱" . number_format($row['total_price'], 2) . "</td>";
                            echo "</tr>";
                            $totalPrice += $row['total_price'];
                        }
                        echo "<tr class='table-secondary font-weight-bold'>";
                        echo "<td colspan='5' class='text-right'>Total Sales for " . date('F Y') . ":</td>";
                        echo "<td>₱" . number_format($totalPrice, 2) . "</td>";
                        echo "</tr>";
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No sales records found for this month</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
                </div>
                </div>


        <div class="row">
            
          <div class="col-lg-6">

        <!-- transaction history -->
        <div class="card">
    <div class="card-header">
        <h5 class="m-0">Transaction History</h5>
        <!-- Export Button -->
        <form action="export_to_excel.php" method="post">
            <button type="submit" class="btn btn-primary">Export to Excel</button>
        </form>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT dt.quantity, dt.transaction_date, i.product_type 
                                        FROM done_transaction dt 
                                        JOIN inventory i ON dt.product_id = i.id 
                                        ORDER BY dt.transaction_date DESC");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row['product_type']}</td><td>{$row['quantity']}</td><td>{$row['transaction_date']}</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>




</div>
          <!-- /.col-md-6 -->
<div class="col-lg-6">
<div class="col-lg-12">
<div class="card">
            <div class="card-header">
                <h5 class="m-0">Reject Products</h5>
                <!-- Export Button -->
                <form action="export_rejected_products.php" method="post">
                    <button type="submit" class="btn btn-primary">Export to Excel</button>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product Type</th>
                            <th>Deduction Count</th>
                            <th>Reason</th>
                            <th>Deduction Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch deducted products from the `deduct_product` table
                        $query = "SELECT dp.deduction_count, dp.deduction_reason, dp.deduction_date, i.product_type 
                                  FROM deduct dp 
                                  JOIN inventory i ON dp.product_type = i.product_type";
                        $result = $conn->query($query);

                        // Display each record in the table
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['product_type']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['deduction_count']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['deduction_reason']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['deduction_date']) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
  <div class="col-lg-12">
  <div class="card">
    <div class="card-header">
        <h5 class="m-0">Stocks Transactions</h5>
        <!-- Export Button -->
        <form action="export_stocks_transactions.php" method="post">
            <button type="submit" class="btn btn-primary">Export to Excel</button>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Product Type</th>
                    <th>Stocks Added</th>
                    <th>Transaction Date</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch records from the `stocks` table
                $query = "
                SELECT 
                    stocks.product_type, 
                    stocks.stocks_added, 
                    stocks.transaction_date, 
                    users.username AS user_name 
                FROM stocks 
                INNER JOIN users ON stocks.user = users.id
                ";
                $result = $conn->query($query);

                // Display each record in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['product_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['stocks_added']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['transaction_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</div>

</div>


          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

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
