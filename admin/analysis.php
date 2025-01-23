<?php
session_start();
include 'controls/conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get current month and year
$currentMonth = date('Y-m');

// Monthly sales change
$salesChangeQuery = "
    SELECT 
        THIS_MONTH.total as current_month_sales,
        LAST_MONTH.total as last_month_sales,
        ((THIS_MONTH.total - LAST_MONTH.total) / LAST_MONTH.total * 100) as percentage_change
    FROM 
        (SELECT COUNT(*) as total FROM sales WHERE DATE_FORMAT(booking_date, '%Y-%m') = '$currentMonth') THIS_MONTH,
        (SELECT COUNT(*) as total FROM sales WHERE DATE_FORMAT(booking_date, '%Y-%m') = DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m')) LAST_MONTH";

// Most popular packages query
$popularPackagesQuery = "
    SELECT 
        package_list AS single_package,
        COUNT(*) AS booking_count
    FROM sales
    WHERE DATE_FORMAT(booking_date, '%Y-%m') = '$currentMonth'
    AND package_list IN ('Special Package', 'Promo Package', 'Basic Package', 'Standard Package', 'Premium Package', 'UNO Package')
    GROUP BY package_list
    ORDER BY single_package";

$popularPackagesResult = $conn->query($popularPackagesQuery);

// Customer service stats
$customerStatsQuery = "
    SELECT 
        COUNT(DISTINCT s.queue_id) as total_customers
    FROM sales s
    JOIN queue q ON s.queue_id = q.queue_id
    WHERE DATE_FORMAT(s.booking_date, '%Y-%m') = '$currentMonth'";

// Studio usage stats
$studioUsageQuery = "
    SELECT 
        CASE 
            WHEN studio = '1' THEN 'Studio 1'
            WHEN studio = '2' THEN 'Studio 2'
        END as studio_name,
        COUNT(*) as usage_count
    FROM sales 
    WHERE DATE_FORMAT(booking_date, '%Y-%m') = '$currentMonth'
    AND studio IN ('1', '2')
    GROUP BY studio
    ORDER BY studio";

$studioUsageResult = $conn->query($studioUsageQuery);

// Execute queries
$salesChangeResult = $conn->query($salesChangeQuery)->fetch_assoc();
$popularPackagesResult = $conn->query($popularPackagesQuery);
$customerStatsResult = $conn->query($customerStatsQuery)->fetch_assoc();

// Initialize all packages with 0 count
$allPackages = [
    'Special Package' => 0,
    'Promo Package' => 0,
    'Basic Package' => 0,
    'Standard Package' => 0,
    'Premium Package' => 0,
    'UNO Package' => 0
];

// Initialize studio data
$studioData = [
    'Studio 1' => 0,
    'Studio 2' => 0
];

// Fill in actual counts
while ($row = $popularPackagesResult->fetch_assoc()) {
    if (array_key_exists($row['single_package'], $allPackages)) {
        $allPackages[$row['single_package']] = (int)$row['booking_count'];
    }
}

while ($row = $studioUsageResult->fetch_assoc()) {
    if (isset($row['studio_name'])) {
        $studioData[$row['studio_name']] = (int)$row['usage_count'];
    }
}


// Convert to arrays for Chart.js
$packageLabels = array_keys($allPackages);
$packageData = array_values($allPackages);

$studioLabels = array_keys($studioData);
$studioUsage = array_values($studioData);

// Debug information
$debugQuery = "SELECT COUNT(*) as total_sales FROM sales WHERE DATE_FORMAT(booking_date, '%Y-%m') = '$currentMonth'";
$debugResult = $conn->query($debugQuery)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Analysis | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Main Sidebar Container -->
    <?php include 'sideboard.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detailed Analysis - <?php echo date('F Y'); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Analysis</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Sales Change Card -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Monthly Sales Performance</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="salesTrendChart" height="200"></canvas>
                                <div class="mt-4 text-center">
                                    <?php
                                    $changeIcon = $salesChangeResult['percentage_change'] >= 0 ? 'fa-arrow-up text-success' : 'fa-arrow-down text-danger';
                                    $changeColor = $salesChangeResult['percentage_change'] >= 0 ? 'text-success' : 'text-danger';
                                    ?>
                                    <h3 class="<?php echo $changeColor; ?>">
                                        <i class="fas <?php echo $changeIcon; ?>"></i>
                                        <?php echo abs(round($salesChangeResult['percentage_change'], 1)); ?>%
                                    </h3>
                                    <p>Change from last month</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Popular Packages</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="packageChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Studio Usage Card -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Studio Usage Analysis</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <canvas id="studioChart" height="200"></canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-primary"><i class="fas fa-camera"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Studio 1</span>
                                                        <span class="info-box-number"><?php echo $studioData['Studio 1']; ?> bookings</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-success"><i class="fas fa-camera"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Studio 2</span>
                                                        <span class="info-box-number"><?php echo $studioData['Studio 2']; ?> bookings</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Customer Service Metrics</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <div class="info-box">
                                                            <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-text">Total Customers</span>
                                                                <span class="info-box-number"><?php echo $customerStatsResult['total_customers']; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<script>
    // Package Distribution Chart
    const packageCtx = document.getElementById('packageChart').getContext('2d');
    const salesCtx = document.getElementById('salesTrendChart').getContext('2d');
    const studioCtx = document.getElementById('studioChart').getContext('2d');
    new Chart(packageCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($packageLabels); ?>,
            datasets: [{
                label: 'Number of Bookings',
                data: <?php echo json_encode($packageData); ?>,
                backgroundColor: [
                    '#007bff', // Package 1
                    '#28a745', // Package 2
                    '#ffc107', // Package 3
                    '#dc3545', // Package 4
                    '#17a2b8', // Package 5
                    '#6c757d'  // Package 6
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Package Distribution'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed.y || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `Selected ${value} times (${percentage}%)`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        stepSize: 1 // Add this to show whole numbers
                    },
                    suggestedMax: 10 // Add this to set a reasonable max value
                }
            }
        }
    });
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Last Month', 'This Month'],
            datasets: [{
                label: 'Number of Sales',
                data: [
                    <?php echo $salesChangeResult['last_month_sales']; ?>,
                    <?php echo $salesChangeResult['current_month_sales']; ?>
                ],
                borderColor: '#007bff',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Sales Trend'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        stepSize: 1
                    }
                }
            }
        }
    });
    new Chart(studioCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($studioLabels); ?>,
            datasets: [{
                data: <?php echo json_encode($studioUsage); ?>,
                backgroundColor: [
                    '#007bff',  // Studio 1 - Blue
                    '#28a745'   // Studio 2 - Green
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Studio Usage Distribution'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${context.label}: ${value} bookings (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
</script>
</body>
</html>