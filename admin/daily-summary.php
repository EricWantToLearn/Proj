<?php
session_start(); 
date_default_timezone_set('Asia/Manila');
include 'controls/conn.php';
if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != 1 && $_SESSION['user_id'] != 2)) {
    header("Location: index.php");
    exit;
}

// Get the selected date (default to today if not set)
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$prev_date = date('Y-m-d', strtotime($selected_date . ' -1 day'));
$next_date = date('Y-m-d', strtotime($selected_date . ' +1 day'));
$today = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daily Summary - dos studios</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <style>
        .date-navigation {
            font-size: 1.2em;
            margin: 0 15px;
        }
        .nav-arrows {
            color: #007bff;
            cursor: pointer;
            padding: 5px 10px;
            text-decoration: none;
        }
        .nav-arrows:hover {
            color: #0056b3;
        }
        .today-btn {
            margin-left: 15px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include 'sideboard.php'?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daily Attendance Summary</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="?date=<?php echo $prev_date; ?>" class="nav-arrows">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                        <span class="date-navigation">
                                            <?php echo date('F d, Y', strtotime($selected_date)); ?>
                                        </span>
                                        <?php if (strtotime($selected_date) < strtotime($today)): ?>
                                            <a href="?date=<?php echo $next_date; ?>" class="nav-arrows">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="?date=<?php echo $today; ?>" class="btn btn-primary btn-sm today-btn">
                                            Today
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="dailySummary" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Time In</th>
                                            <th>Time Out</th>
                                            <th>Total Hours</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT t.*, u.fullname,
                                                 CASE 
                                                     WHEN t.time_out IS NOT NULL 
                                                     THEN TIME_FORMAT(TIMEDIFF(t.time_out, t.time_in), '%H:%i')
                                                     ELSE TIME_FORMAT(TIMEDIFF(NOW(), t.time_in), '%H:%i')
                                                 END as duration,
                                                 CASE 
                                                     WHEN TIME(t.time_in) > '09:50:00' THEN 'Late'
                                                     ELSE 'on-time'
                                                 END as attendance_status
                                                 FROM time_records t 
                                                 JOIN users u ON t.user_id = u.id 
                                                 WHERE t.date = ?
                                                 ORDER BY t.time_in ASC";
                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param("s", $selected_date);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        while ($row = $result->fetch_assoc()) {
                                            $status_class = $row['attendance_status'] == 'on-time' ? 'badge-success' : 'badge-warning';
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                                            echo "<td>" . date('h:i A', strtotime($row['time_in'])) . "</td>";
                                            echo "<td>" . ($row['time_out'] ? date('h:i A', strtotime($row['time_out'])) : 'Still Working') . "</td>";
                                            echo "<td>" . $row['duration'] . " hours</td>";
                                            echo "<td><span class='badge {$status_class}'>" . htmlspecialchars($row['attendance_status']) . "</span></td>";
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

<!-- REQUIRED SCRIPTS -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>

<script>
$(function () {
    $('#dailySummary').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 10,
        "order": [[0, 'asc']] // Sort by employee name by default
    });

    // Auto-refresh every minute to update durations
    setInterval(function() {
        if ('<?php echo $selected_date; ?>' === '<?php echo date('Y-m-d'); ?>') {
            location.reload();
        }
    }, 60000);
});
</script>

</body>
</html>