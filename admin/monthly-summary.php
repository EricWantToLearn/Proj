<?php
session_start(); 
date_default_timezone_set('Asia/Manila');
include 'controls/conn.php';
if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != 1 && $_SESSION['user_id'] != 2)) {
    header("Location: index.php");
    exit;
}

// Get the selected month (default to current month if not set)
$selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
$prev_month = date('Y-m', strtotime($selected_month . ' -1 month'));
$next_month = date('Y-m', strtotime($selected_month . ' +1 month'));
$current_month = date('Y-m');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monthly Summary - dos studios</title>

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
        .month-navigation {
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
        .current-month-btn {
            margin-left: 15px;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
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
                        <h1>Monthly Attendance Summary</h1>
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
                                        <a href="?month=<?php echo $prev_month; ?>" class="nav-arrows">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                        <span class="month-navigation">
                                            <?php echo date('F Y', strtotime($selected_month . '-01')); ?>
                                        </span>
                                        <?php if (strtotime($selected_month . '-01') < strtotime($current_month . '-01')): ?>
                                            <a href="?month=<?php echo $next_month; ?>" class="nav-arrows">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="?month=<?php echo $current_month; ?>" class="btn btn-primary btn-sm current-month-btn">
                                            Current Month
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="monthlySummary" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Days Present</th>
                                            <th>Days Late</th>
                                            <th>Total Days</th>
                                            <th>Total Hours</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT 
                                                u.fullname,
                                                SUM(CASE WHEN t.status = 'On-time' THEN 1 ELSE 0 END) as days_present,
                                                SUM(CASE WHEN t.status = 'Late' THEN 1 ELSE 0 END) as days_late,
                                                COUNT(DISTINCT t.date) as total_days,
                                                SUM(CASE 
                                                    WHEN t.time_out IS NOT NULL 
                                                    THEN TIMESTAMPDIFF(HOUR, t.time_in, t.time_out)
                                                    ELSE TIMESTAMPDIFF(HOUR, t.time_in, NOW())
                                                END) as total_hours
                                                FROM users u
                                                LEFT JOIN time_records t ON u.id = t.user_id 
                                                    AND DATE_FORMAT(t.date, '%Y-%m') = ?
                                                WHERE u.id NOT IN (1,2)
                                                GROUP BY u.id, u.fullname
                                                ORDER BY u.fullname";
                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param("s", $selected_month);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        $total_days_present = 0;
                                        $total_days_late = 0;
                                        $total_days = 0;
                                        $total_hours = 0;

                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                                            echo "<td>" . $row['days_present'] . "</td>";
                                            echo "<td>" . $row['days_late'] . "</td>";
                                            echo "<td>" . $row['total_days'] . "</td>";
                                            echo "<td>" . number_format($row['total_hours'], 1) . "</td>";
                                            echo "</tr>";

                                            // Add to totals
                                            $total_days_present += $row['days_present'];
                                            $total_days_late += $row['days_late'];
                                            $total_days += $row['total_days'];
                                            $total_hours += $row['total_hours'];
                                        }

                                        // Add total row
                                        echo "<tr class='total-row'>";
                                        echo "<td>Total</td>";
                                        echo "<td>" . $total_days_present . "</td>";
                                        echo "<td>" . $total_days_late . "</td>";
                                        echo "<td>" . $total_days . "</td>";
                                        echo "<td>" . number_format($total_hours, 1) . "</td>";
                                        echo "</tr>";
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
    $('#monthlySummary').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 10,
        "order": [[0, 'asc']], // Sort by employee name by default
        "drawCallback": function (settings) {
            // Move the total row to the bottom of the current page
            var api = this.api();
            var totalRow = $(api.table().node()).find('tr.total-row');
            $(api.table().node()).find('tbody').append(totalRow);
        }
    });

    // Auto-refresh if viewing current month
    if ('<?php echo $selected_month; ?>' === '<?php echo date('Y-m'); ?>') {
        setInterval(function() {
            location.reload();
        }, 60000);
    }
});
</script>

</body>
</html>