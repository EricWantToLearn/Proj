<?php
session_start(); 
date_default_timezone_set('Asia/Manila');
include 'controls/conn.php';
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if user is employee
if ($_SESSION['user_id'] == 1 || $_SESSION['user_id'] == 2) {
    header("Location: index.php");
    exit();
}

// Handle Time In/Out submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $current_date = date('Y-m-d');
    $current_time = date('Y-m-d H:i:s');
    
    if (isset($_POST['time_in'])) {
        // Check if already timed in today
        $check_query = "SELECT * FROM time_records WHERE user_id = ? AND date = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("is", $user_id, $current_date);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            $query = "INSERT INTO time_records (user_id, date, time_in, status) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $status = (date('H:i') >= '09:50') ? 'late' : 'on-time';
            $stmt->bind_param("isss", $user_id, $current_date, $current_time, $status);
            $stmt->execute();
        }
    } elseif (isset($_POST['time_out'])) {
        $query = "UPDATE time_records SET time_out = ?, total_hours = TIMESTAMPDIFF(HOUR, time_in, ?) 
                 WHERE user_id = ? AND date = ? AND time_out IS NULL";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssis", $current_time, $current_time, $user_id, $current_date);
        $stmt->execute();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Time In/Out - dos studios</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <?php include 'sideboard.php'?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Staff Time In/Out</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Time In/Out Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Time Record Actions</h3>
                            </div>
                            <div class="card-body">
                                <?php
                                // Check if already timed in today
                                $user_id = $_SESSION['user_id'];
                                $current_date = date('Y-m-d');
                                $check_query = "SELECT * FROM time_records WHERE user_id = ? AND date = ?";
                                $stmt = $conn->prepare($check_query);
                                $stmt->bind_param("is", $user_id, $current_date);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $record = $result->fetch_assoc();
                                ?>
                                
                                <form method="POST">
                                    <?php if (!$record): ?>
                                        <button type="submit" name="time_in" class="btn btn-success btn-lg">
                                            <i class="fas fa-sign-in-alt mr-2"></i>Time In
                                        </button>
                                    <?php elseif ($record && !$record['time_out']): ?>
                                        <button type="submit" name="time_out" class="btn btn-danger btn-lg">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Time Out
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-secondary btn-lg" disabled>
                                            <i class="fas fa-check mr-2"></i>Completed for Today
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>

                        <!-- Time Records Table -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Time Records History</h3>
                            </div>
                            <div class="card-body">
                                <table id="timeRecordsTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time In</th>
                                            <th>Time Out</th>
                                            <th>Total Hours</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT * FROM time_records WHERE user_id = ? ORDER BY date DESC";
                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param("i", $user_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        
                                        while ($row = $result->fetch_assoc()) {
                                            $status_class = 
                                                $row['status'] == 'on-time' ? 'badge-success' : 
                                                ($row['status'] == 'late' ? 'badge-warning' : 'badge-danger');
                                            
                                            echo "<tr>";
                                            echo "<td>" . date('M d, Y', strtotime($row['date'])) . "</td>";
                                            echo "<td>" . date('h:i A', strtotime($row['time_in'])) . "</td>";
                                            echo "<td>" . ($row['time_out'] ? date('h:i A', strtotime($row['time_out'])) : 'Not yet') . "</td>";
                                            echo "<td>" . ($row['total_hours'] ? number_format($row['total_hours'], 1) : '-') . "</td>";
                                            echo "<td><span class='badge {$status_class}'>" . htmlspecialchars($row['status']) . "</span></td>";
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
        </section>
    </div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- DataTables & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>

<script>
$(function () {
    $('#timeRecordsTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "order": [[0, 'desc']] // Sort by date descending
    });
});
</script>

</body>
</html>