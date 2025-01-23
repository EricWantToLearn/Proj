<?php
session_start(); 
date_default_timezone_set('Asia/Manila');
include 'controls/conn.php';
// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != 1 && $_SESSION['user_id'] != 2)) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Attendance - dos studios</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
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
                        <h1>Employee Attendance Records</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                            <div class="card-body">
                                <table id="activeEmployees" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Date</th>
                                            <th>Time In</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Current Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $current_date = date('Y-m-d');
                                        $query = "SELECT t.*, u.fullname, 
                                        TIME_FORMAT(TIMEDIFF(NOW(), t.time_in), '%H:%i') as duration,
                                        t.date as record_date,
                                        CASE 
                                            WHEN TIME(t.time_in) > '09:50:00' THEN 'Late'
                                            ELSE 'On-time'
                                        END as status,
                                        CASE 
                                            WHEN t.time_out IS NULL AND t.date = CURRENT_DATE THEN 'Currently Timed In'
                                            ELSE 'Timed Out'
                                        END as current_status
                                        FROM time_records t 
                                        JOIN users u ON t.user_id = u.id 
                                        ORDER BY t.date DESC, t.time_in DESC";
                                        $stmt = $conn->prepare($query);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        while ($row = $result->fetch_assoc()) {
                                            $status_class = $row['status'] == 'On-time' ? 'badge-success' : 'badge-warning';
                                            $is_current = $row['record_date'] == $current_date;
                                            
                                            echo "<tr" . ($is_current ? "" : " class='historical-record'") . ">";
                                            echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                                            echo "<td>" . date('M d, Y', strtotime($row['date'])) . "</td>";
                                            echo "<td>" . date('h:i A', strtotime($row['time_in'])) . "</td>";
                                            echo "<td>" . $row['duration'] . " hours</td>";
                                            echo "<td><span class='badge {$status_class}'>" . htmlspecialchars($row['status']) . "</span></td>";
                                            echo "<td><span class='badge " . 
                                                ($row['current_status'] == 'Currently Timed In' ? 'badge-info' : 'badge-secondary') . "'>" . 
                                                htmlspecialchars($row['current_status']) . "</span></td>";
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
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- DataTables & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>

<script>
$(function () {
    $('#activeEmployees').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 10,
        "order": [[1, 'desc'], [2, 'desc']], // Sort by date and time
        "language": {
            "paginate": {
                "previous": "Previous",
                "next": "Next"
            }
        },
        "drawCallback": function(settings) {
            // Move historical records to next pages
            var api = this.api();
            var currentDate = new Date().toISOString().split('T')[0];
            
            // Get current day records
            var currentRecords = api
                .rows()
                .data()
                .filter(function(row) {
                    return row[1].includes(currentDate);
                });
                
            // Put them on first page
            api.page('first').draw('page');
        }
    });
    
    // Check if it's a new day and reload if needed
    function checkNewDay() {
        var currentDate = new Date().toLocaleDateString('en-US', { timeZone: 'Asia/Manila' });
        var storedDate = localStorage.getItem('lastCheckedDate');
        
        if (storedDate !== currentDate) {
            localStorage.setItem('lastCheckedDate', currentDate);
            location.reload();
        }
    }

    // Check every minute
    setInterval(checkNewDay, 60000);

    // Initial check
    checkNewDay();
    
    // Update duration every minute
    setInterval(function() {
        location.reload();
    }, 60000);
});
</script>

</body>
</html>