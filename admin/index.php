<?php
// Start the session
session_start();
include 'controls/conn.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Function to fetch count based on query
function fetchCount($conn, $query) {
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    return 0;
}

// Fetch counts for different statuses
$doneCustomers = fetchCount($conn, "SELECT COUNT(queue_id) AS total FROM queue WHERE status = 'Done'");
$queueCustomers = fetchCount($conn, "SELECT COUNT(queue_id) AS total FROM queue WHERE status = 'Queue'");
$forCheckingCount = fetchCount($conn, "SELECT COUNT(queue_id) AS total FROM queue WHERE status = 'For-Checking'");
$totalBookings = fetchCount($conn, "SELECT COUNT(queue_id) AS total FROM queue WHERE status != 'Cancelled'");
$cancelledBookings = fetchCount($conn, "SELECT COUNT(queue_id) AS total FROM queue WHERE status = 'Cancelled'");

// Fetch last 2 years' data for pattern analysis
$lastTwoYearsQuery = "
    SELECT 
        DATE_FORMAT(sales.booking_date, '%m-%d') AS date,
        YEAR(sales.booking_date) as year,
        COUNT(*) as booking_count
    FROM sales 
    INNER JOIN queue ON sales.queue_id = queue.queue_id
    WHERE 
        queue.status = 'Done'
        AND sales.booking_date >= DATE_SUB(CURDATE(), INTERVAL 2 YEAR)
        AND sales.booking_date < CURDATE()
    GROUP BY DATE_FORMAT(sales.booking_date, '%m-%d'), YEAR(sales.booking_date)";

$lastTwoYearsResult = $conn->query($lastTwoYearsQuery);
$historicalPatterns = [];

// Initialize the patterns array
while ($row = $lastTwoYearsResult->fetch_assoc()) {
    $date = $row['date'];
    $year = $row['year'];
    $bookings = $row['booking_count'];
    
    if (!isset($historicalPatterns[$date])) {
        $historicalPatterns[$date] = [
            'years' => 0,
            'total_bookings' => 0
        ];
    }
    
    $historicalPatterns[$date]['years']++;
    $historicalPatterns[$date]['total_bookings'] += $bookings;
}


// Fetch sales data from the past 3 months
$query = "
    SELECT 
        DATE_FORMAT(sales.booking_date, '%Y-%m') AS month, 
        COUNT(*) AS sales_count 
    FROM sales
    INNER JOIN queue ON sales.queue_id = queue.queue_id
    WHERE queue.status = 'Done' 
    AND sales.booking_date >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
    GROUP BY DATE_FORMAT(sales.booking_date, '%Y-%m')
    ORDER BY sales.booking_date ASC";
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[$row['month']] = $row['sales_count'];
}

// Ensure past 3 months have values
$pastMonths = [];
for ($i = 2; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i month"));
    $pastMonths[$month] = isset($data[$month]) ? $data[$month] : 0;
}

// Weighted Moving Average Calculation
$weights = [3, 2, 1]; // Most recent month has highest weight
$totalWeight = array_sum($weights);
$weightedSum = 0;
$index = 0;

foreach ($pastMonths as $month => $sales) {
    $weightedSum += $sales * $weights[$index];
    $index++;
}

$baseAverageSales = $weightedSum / $totalWeight; // Base weighted moving average

// Helper function to count Fridays and Sundays in a given month
function countFridaysAndSundays($month) {
    $fridays = 0;
    $sundays = 0;
    $startDate = strtotime("$month-01");
    $endDate = strtotime("$month-" . date('t', $startDate));

    while ($startDate <= $endDate) {
        if (date('N', $startDate) == 5) $fridays++; // Friday
        if (date('N', $startDate) == 7) $sundays++; // Sunday
        $startDate = strtotime('+1 day', $startDate);
    }

    return [$fridays, $sundays];
}

function countPhilippineHolidays($month) {
    $philippineHolidays = [
        '01-01', // New Year's Day
        '02-14', // Valentine's Day
        '02-25', // EDSA People Power Revolution
        '04-09', // Day of Valor
        '05-01', // Labor Day
        '06-12', // Independence Day
        '08-01', // National Girlfriends Day
        '08-28', // National Heroes Day
        '10-03', // National Boyfriends Day
        '10-31', // Halloween 
        '11-01', // All Saints' Day
        '11-30', // Bonifacio Day
        '12-25', // Christmas Day
        '12-30', // Rizal Day
    ];

    $holidayCount = 0;
    $monthNum = date('m', strtotime($month)); // Get just the month number
    
    echo "<!-- Checking holidays for month: $month (Month number: $monthNum) -->\n";
    foreach ($philippineHolidays as $holiday) {
        $holidayMonth = substr($holiday, 0, 2); // Get the month part of the holiday
        if ($holidayMonth === $monthNum) {
            $holidayCount++;
            echo "<!-- Found holiday for this month: $holiday -->\n";
        }
    }
    
    echo "<!-- Total holidays found: $holidayCount -->\n";
    return $holidayCount;
}

// Predict sales for the next 2 months
$nextMonths = [];
for ($i = 1; $i <= 2; $i++) {
    $nextMonth = date('Y-m', strtotime("+$i month"));
    $predictedSales = $baseAverageSales; // Start with the base average
    
    // Debug information
    echo "<!-- Debug Info for $nextMonth -->\n";
    echo "<!-- Base Average Sales: $baseAverageSales -->\n";
    
    // Count Philippine holidays for the month
    $holidayCount = countPhilippineHolidays($nextMonth);
    echo "<!-- Holiday Count: $holidayCount -->\n";
    
    // Add sales boost based on number of holidays
    $originalSales = $predictedSales;
    if ($holidayCount == 1) {
        $predictedSales *= 1.15; // 15% increase for 1 holiday
        echo "<!-- Applied 15% holiday boost -->\n";
    } elseif ($holidayCount == 2) {
        $predictedSales *= 1.25; // 25% increase for 2 holidays
        echo "<!-- Applied 25% holiday boost -->\n";
    } elseif ($holidayCount >= 3) {
        $predictedSales *= 1.35; // 35% increase for 3 or more holidays
        echo "<!-- Applied 35% holiday boost -->\n";
    }
    echo "<!-- After Holiday Boost: $predictedSales -->\n";
    
    // Count weekend days
    [$fridays, $sundays] = countFridaysAndSundays($nextMonth);
    $totalWeekendDays = $fridays + $sundays;
    echo "<!-- Weekend Days (Fri+Sun): $totalWeekendDays -->\n";
    
    // Add weekend boost
    if ($totalWeekendDays == 4) {
        $predictedSales *= 1.10; // 10% increase for 4 weekends
        echo "<!-- Applied 10% weekend boost -->\n";
    } elseif ($totalWeekendDays == 5) {
        $predictedSales *= 1.20; // 20% increase for 5 weekends
        echo "<!-- Applied 20% weekend boost -->\n";
    }
    echo "<!-- Final Prediction: $predictedSales -->\n";
    
    $nextMonths[$nextMonth] = round($predictedSales);
}


// Define Philippine holidays
$philippineHolidays = [
    '01-01', // New Year's Day
    '02-14', // Valentine's Day
    '02-25', // EDSA People Power Revolution
    '04-09', // Day of Valor
    '05-01', // Labor Day
    '06-12', // Independence Day
    '08-01', // National Girlfriends Day
    '08-28', // National Heroes Day
    '10-03', // National Boyfriends Day
    '10-31', // Halloween 
    '11-01', // All Saints' Day
    '11-30', // Bonifacio Day
    '12-25', // Christmas Day
    '12-30', // Rizal Day
];

// Calculate demand levels for next 30 days
$demandForecast = [];
for ($i = 0; $i <= 30; $i++) {
    $forecastDate = date('Y-m-d', strtotime("+$i days"));
    $datePattern = date('m-d', strtotime($forecastDate));
    
    // Calculate average bookings for this date from historical data
    $predictedBookings = 0;
    if (isset($historicalPatterns[$datePattern])) {
        $avgBookings = $historicalPatterns[$datePattern]['total_bookings'] / 
                      $historicalPatterns[$datePattern]['years'];
        $predictedBookings = round($avgBookings);
    }
    
    // Add weekend boost (2 bookings)
    $isWeekend = date('N', strtotime($forecastDate)) >= 6;
    if ($isWeekend) {
        $predictedBookings += 2;
    }
    
    // Add holiday boost (5 bookings)
    $isHoliday = in_array($datePattern, $philippineHolidays);
    if ($isHoliday) {
        $predictedBookings += 5;
    }
    
    // Categorize based on predicted number of bookings
    if ($predictedBookings >= 7) {
        $category = 'high'; // red
    } elseif ($predictedBookings >= 4) {
        $category = 'moderate'; // orange
    } else {
        $category = 'low'; // green
    }
    
    $demandForecast[$forecastDate] = $category;
}

// Calculate next month's forecast based on weighted average and seasonal factors
$nextMonth = date('Y-m', strtotime('+1 month'));
[$nextMonthFridays, $nextMonthSundays] = countFridaysAndSundays($nextMonth);
$nextMonthHolidays = countPhilippineHolidays($nextMonth);

// Adjust base average for next month's special days
$nextMonthForecast = ceil($baseAverageSales + 
    ($nextMonthFridays * 5) +     // 5 additional customers on Fridays
    ($nextMonthSundays * 3) +     // 3 additional customers on Sundays
    ($nextMonthHolidays * 8));    // 8 additional customers on Holidays


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dos Studios Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.11.3/main.min.css' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Hide dates outside the valid range */
        .fc .fc-day-disabled,
        .fc .fc-day-past:not([data-date]),
        .fc .fc-day-future:not([data-date]) {
            background-color: #f4f4f4 !important;
            opacity: 0.3;
            pointer-events: none;
        }

        /* Style for disabled navigation buttons */
        .fc .fc-prev-button[style*="display: none"],
        .fc .fc-next-button[style*="display: none"] {
            display: none !important;
        }
        .highlight-row {
        background-color: #fff3cd !important;
        transition: background-color 0.5s ease !important;
        }
    </style>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <?php include 'sideboard.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php
                $infoBoxes = [
                    ['icon' => 'fas fa-thumbs-up', 'text' => 'Done Customers', 'count' => $doneCustomers, 'color' => 'info'],
                    ['icon' => 'fas fa-users', 'text' => 'Queue Customers', 'count' => $queueCustomers, 'color' => 'warning'],
                    ['icon' => 'fas fa-dollar-sign', 'text' => 'Sales Today', 'count' => 760, 'color' => 'success'],
                    ['icon' => 'fas fa-check', 'text' => 'For-Checking', 'count' => $forCheckingCount, 'color' => 'orange']
                ];
                foreach ($infoBoxes as $box) {
                    echo "
                        <div class='col-12 col-sm-6 col-md-3'>
                            <div class='info-box'>
                                <span class='info-box-icon bg-{$box['color']} elevation-1'><i class='{$box['icon']}'></i></span>
                                <div class='info-box-content'>
                                    <span class='info-box-text'>{$box['text']}</span>
                                    <span class='info-box-number'>{$box['count']}</span>
                                </div>
                            </div>
                        </div>
                    ";
                }
                ?>
            </div>
            
            <!-- Analysis Link Section -->
            <div class="row mb-4">
                <div class="col-md-12 text-right">
                    <a href="analysis.php" class="btn btn-link">
                        See More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Sales Report Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Customer Report</h5>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#sales-chart-tab" data-toggle="tab">Sales</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#forecast-calendar-tab" data-toggle="tab">Demand Forecast</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#stock-forecast-tab" data-toggle="tab">Stock Level</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="sales-chart-tab">
                                    <canvas id="salesChart" height="60"></canvas>
                                </div>
                                <div class="tab-pane" id="forecast-calendar-tab">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="mr-4 d-flex align-items-center">
                                                <span class="badge" style="width: 20px; height: 20px; background-color: #ffcccc;">&nbsp;</span>
                                                <span>&nbsp;High Demand</span>
                                            </div>
                                            <div class="mr-4 d-flex align-items-center">
                                                <span class="badge" style="width: 20px; height: 20px; background-color: #ffebcc;">&nbsp;</span>
                                                <span>&nbsp;Moderate Demand</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="badge" style="width: 20px; height: 20px; background-color: #ccffcc;">&nbsp;</span>
                                                <span>&nbsp;Low Demand</span>
                                            </div>
                                        </div>
                                    </div>
                                <div id="forecast-calendar"></div>
                            </div>
                                <div class="tab-pane" id="stock-forecast-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php
                                            // Get all paper types and their stock levels
                                            $stockQuery = "SELECT product_type, stock_count FROM inventory";
                                            $stockResult = $conn->query($stockQuery);
                                            
                                            // Debug output
                                            if (!$stockResult) {
                                                echo "Query error: " . $conn->error;
                                            }
                                            
                                            $paperStocks = [];
                                            if ($stockResult && $stockResult->num_rows > 0) {
                                                while($row = $stockResult->fetch_assoc()) {
                                                    $paperStocks[$row['product_type']] = $row['stock_count'];
                                                }
                                            } else {
                                                echo "<!-- No results found in inventory -->";
                                            }

                                            // Use the predicted sales for next month
                                            $nextMonth = date('Y-m', strtotime('+1 month'));
                                            $expectedCustomers = isset($nextMonths[$nextMonth]) ? $nextMonths[$nextMonth] : $baseAverageSales; // Use the weighted average we calculated earlier
                                            
                                            // Paper usage per customer (adjust based on your data)
                                            $paperRequirements = [
                                                "2' x 6'" => 5,    
                                                "4'x4'" => 2,    
                                                "2.6'x4'" => 2,  
                                                "2'x2'" => 3, 
                                                "4'x6'" => 2     
                                            ];
                                            ?>

                                            <div class="alert alert-info mb-4">
                                                <h5><i class="icon fas fa-info"></i> Forecast Information</h5>
                                                Predicted customers for <?php echo date('F Y', strtotime($nextMonth)); ?>: 
                                                <strong><?php echo ceil($expectedCustomers); ?></strong>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Paper Type</th>
                                                            <th>Current Stock</th>
                                                            <th>Stock Level</th>
                                                            <th>Expected Usage</th>
                                                            <th>Required Stock</th>
                                                            <th>Need to Restock</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        if (!empty($paperStocks)):
                                                            $anyNeedToRestock = false;
                                                            foreach($paperStocks as $paperType => $currentStock): 
                                                                // Calculate expected usage based on customer forecast
                                                                $expectedUsage = ceil($expectedCustomers * $paperRequirements[$paperType]);
                                                                $requiredStock = ceil($expectedUsage * 1.3); // 30% buffer
                                                                $needToRestock = max(0, $requiredStock - $currentStock);
                                                                
                                                                // Determine stock level based on inventory thresholds
                                                                if ($currentStock > 400) {
                                                                    $stockLevel = 'High';
                                                                    $stockClass = 'bg-success';
                                                                } elseif ($currentStock > 100) {
                                                                    $stockLevel = 'Moderate';
                                                                    $stockClass = 'bg-warning';
                                                                } else {
                                                                    $stockLevel = 'Low';
                                                                    $stockClass = 'bg-danger';
                                                                }

                                                                if($needToRestock > 0) {
                                                                    $anyNeedToRestock = true;
                                                                    $rowClass = 'table-warning';
                                                                } else {
                                                                    $rowClass = 'table-success';
                                                                }
                                                        ?>
                                                                <tr class="<?php echo $rowClass; ?>">
                                                                    <td><?php echo $paperType; ?></td>
                                                                    <td><?php echo $currentStock; ?></td>
                                                                    <td><span class="badge <?php echo $stockClass; ?>"><?php echo $stockLevel; ?></span></td>
                                                                    <td><?php echo $expectedUsage; ?></td>
                                                                    <td><?php echo $requiredStock; ?></td>
                                                                    <td><?php echo $needToRestock; ?></td>
                                                                    <td>
                                                                        <?php if($needToRestock > 0): ?>
                                                                            <a href="https://ph.canon/en/consumer/products/search?category=printing&subCategory=consumables&consumableType=PAPER" 
                                                                                class="btn btn-primary btn-sm" 
                                                                                target="_blank" 
                                                                                rel="noopener noreferrer">Reorder
                                                                            </a>
                                                                        <?php else: ?>
                                                                            <span class="badge badge-success">Stock Adequate</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                        <?php 
                                                            endforeach;
                                                        else:
                                                        ?>
                                                            <tr>
                                                                <td colspan="7" class="text-center">No inventory records found</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Queue Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">For Checking Bookings</h3>
                </div>
                <div id="bookings-section">
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" id="searchBookings" class="form-control" placeholder="Search by name...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Queue ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Details Modal -->
            <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailsModalLabel">Booking Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Content will be loaded dynamically -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>

<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script>
    const pastMonths = <?php echo json_encode($pastMonths); ?>;
    const nextMonths = <?php echo json_encode($nextMonths); ?>;
    const ctx = document.getElementById('salesChart').getContext('2d');
    const percentageChanges = {};

    // Combine past and next months labels and data
    const labels = [...Object.keys(pastMonths), ...Object.keys(nextMonths)];
    const data = [...Object.values(pastMonths), ...Object.values(nextMonths)];

    // Default color for the line and shaded area
    const defaultBorderColor = 'rgba(75, 192, 192, 1)';
    const defaultBackgroundColor = 'rgba(75, 192, 192, 0.2)';
    const highlightBorderColor = 'rgba(255, 99, 132, 1)';
    const highlightBackgroundColor = 'rgba(255, 99, 132, 0.2)';

    // Arrays to store point-specific colors for the line and shaded area
    let borderColors = new Array(labels.length).fill(defaultBorderColor);
    let backgroundColors = new Array(labels.length).fill(defaultBackgroundColor);
    let pointBorderColors = new Array(labels.length).fill(defaultBorderColor);
    let pointBackgroundColors = new Array(labels.length).fill(defaultBorderColor);

    // Change the color of the last two points
    const lastIndex = labels.length - 1;
    const secondLastIndex = labels.length - 2;

    borderColors[lastIndex] = highlightBorderColor;
    borderColors[secondLastIndex] = highlightBorderColor;
    backgroundColors[lastIndex] = highlightBackgroundColor;
    backgroundColors[secondLastIndex] = highlightBackgroundColor;
    pointBorderColors[lastIndex] = highlightBorderColor;
    pointBorderColors[secondLastIndex] = highlightBorderColor;
    pointBackgroundColors[lastIndex] = highlightBorderColor;
    pointBackgroundColors[secondLastIndex] = highlightBorderColor;

    for (let i = 1; i < labels.length; i++) {
    const currentValue = data[i];
    const previousValue = data[i-1];
    const percentChange = previousValue !== 0 ? 
        ((currentValue - previousValue) / previousValue * 100).toFixed(1) : 
        'N/A';
    percentageChanges[labels[i]] = percentChange;
    }

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales',
                data: data,
                borderColor: borderColors,
                backgroundColor: backgroundColors,
                pointBorderColor: pointBorderColors,
                pointBackgroundColor: pointBackgroundColors,
                borderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8, // Make hover point bigger
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    enabled: true,
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyColor: 'white',
                    bodyFont: {
                        size: 13
                    },
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            const label = context.dataset.label || '';
                            const value = context.parsed.y;
                            const month = context.label;
                            const percentChange = percentageChanges[month];
                            
                            if (percentChange === undefined) {
                                return `${label}: ${value}`;
                            }
                            
                            const changeSymbol = percentChange > 0 ? '▲' : '▼';
                            const changeColor = percentChange > 0 ? '#00ff00' : '#ff0000';
                            return [
                                `${label}: ${value}`,
                                `Change: ${changeSymbol} ${Math.abs(percentChange)}%`
                            ];
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            hover: {
                mode: 'index',
                intersect: false
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('forecast-calendar');
    var today = new Date();
    var thirtyDaysFromNow = new Date(today);
    thirtyDaysFromNow.setDate(today.getDate() + 30);
    
    // Calculate the end of the next month
    var endOfNextMonth = new Date(today.getFullYear(), today.getMonth() + 2, 0);
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 450,
        validRange: {
            start: today,
            end: endOfNextMonth  // Use end of next month instead of validRangeEnd
        },
        events: [
            <?php
            foreach ($demandForecast as $date => $category) {
                $color = match($category) {
                    'high' => '#dc3545',     // red
                    'moderate' => '#fd7e14',  // orange
                    'low' => '#28a745',       // green
                };
                echo "{
                    start: '$date',
                    display: 'background',
                    backgroundColor: '$color'
                },";
            }
            ?>
        ],
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        initialDate: new Date(today.getFullYear(), today.getMonth(), 1),
        showNonCurrentDates: false,
        fixedWeekCount: false,
        customButtons: {
            prev: {
                click: function() {
                    calendar.prev();
                }
            },
            next: {
                click: function() {
                    calendar.next();
                }
            }
        },
        dayCellDidMount: function(arg) {
            // Only disable dates before today
            if (arg.date < today) {
                arg.el.classList.add('fc-day-disabled');
            }
        },
        viewDidMount: function() {
            setTimeout(function() {
                calendar.render();
            }, 0);
        },
        datesSet: function(arg) {
            var currentStart = arg.start;
            var currentEnd = new Date(currentStart);
            currentEnd.setMonth(currentEnd.getMonth() + 1);
            
            // Show/hide prev button
            var prevButton = document.querySelector('.fc-prev-button');
            if (prevButton) {
                prevButton.style.display = currentStart <= today ? 'none' : 'block';
            }
            
            // Show/hide next button based on end of next month
            var nextButton = document.querySelector('.fc-next-button');
            if (nextButton) {
                nextButton.style.display = currentEnd > endOfNextMonth ? 'none' : 'block';
            }

            // Force update of background events
            calendar.getEvents().forEach(function(event) {
                event.setProp('display', 'background');
            });
        }
    });

    // Add tab change handler
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        if (e.target.getAttribute('href') === '#forecast-calendar-tab') {
            calendar.render();
        }
    });

    calendar.render();
});

</script>

<script>

$(document).ready(function() {
    $('.queue-details').click(function(e) {
        e.preventDefault();
        var queueId = $(this).data('queue-id');
        
        // Load modal content via AJAX
        $.ajax({
            url: 'fetch_modal_data.php',
            type: 'POST',
            data: { queue_id: queueId },
            success: function(response) {
                $('#detailsModal .modal-body').html(response);
                $('#detailsModal').modal('show');
            },
            error: function() {
                alert('Error loading booking details');
            }
        });
    });
        // New search functionality
        $('#searchBookings').on('keyup', function() {
        const searchValue = $(this).val().toLowerCase();
        
        $.ajax({
            url: 'fetch_bookings.php',
            type: 'GET',
            data: { search: searchValue },
            success: function(response) {
                const bookings = JSON.parse(response);
                let tableHtml = '';
                
                bookings.forEach(booking => {
                    if (booking.name.toLowerCase().includes(searchValue)) {
                        tableHtml += `
                            <tr>
                                <td><a href='#' class='queue-details' data-toggle='modal' data-target='#detailsModal' data-queue-id='${booking.queue_id}'>OR${booking.queue_id}</a></td>
                                <td>${booking.name}</td>
                                <td><span class='badge badge-primary'>${booking.status}</span></td>
                                <td>
                                    <a href='update_status.php?id=${booking.queue_id}&status=Queue' class='badge badge-warning'>Queue</a>
                                    <a href='update_status.php?id=${booking.queue_id}&status=Cancelled' class='badge badge-danger'>Cancel</a>
                                </td>
                            </tr>
                        `;
                    }
                });
                
                $('table tbody').html(tableHtml);
                
                // Rebind click handlers for queue details
                $('.queue-details').click(function(e) {
                    e.preventDefault();
                    var queueId = $(this).data('queue-id');
                    
                    $.ajax({
                        url: 'fetch_modal_data.php',
                        type: 'POST',
                        data: { queue_id: queueId },
                        success: function(response) {
                            $('#detailsModal .modal-body').html(response);
                            $('#detailsModal').modal('show');
                        },
                        error: function() {
                            alert('Error loading booking details');
                        }
                    });
                });
            }
        });
    });
});

function updateNotifications() {
    $.ajax({
        url: 'check_notifications.php',
        type: 'GET',
        success: function(response) {
            const data = JSON.parse(response);
            const count = data.count;
            
            // Update notification count
            $('.notification-count').text(count > 0 ? count : '');
            
            // Update notifications list
            let notificationHtml = '';
            data.notifications.forEach(notification => {
                notificationHtml += `
                    <a href="#bookings-section" class="dropdown-item" data-notification-id="${notification.id}">
                        <i class="fas fa-envelope mr-2"></i> ${notification.message}
                        <span class="float-right text-muted text-sm">${notification.time}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                `;
            });
            $('.notifications-list').html(notificationHtml);
        }
    });
}

// Check for new notifications every 30 seconds
setInterval(updateNotifications, 30000);

// Initial check
$(document).ready(function() {
    updateNotifications();
    
});

$(document).on('click', '.notifications-list .dropdown-item', function(e) {
    const notificationId = $(this).data('notification-id');
    
    // Mark notification as read
    $.ajax({
        url: 'mark_notification_read.php',
        type: 'POST',
        data: { notification_id: notificationId },
        success: function() {
            updateNotifications();
            
            // Find and highlight the corresponding booking row
            const bookingRow = $(`a[data-queue-id="${notificationId}"]`).closest('tr');
            if (bookingRow.length) {

                // Highlight the row
                bookingRow.addClass('highlight-row');
                setTimeout(() => {
                    bookingRow.removeClass('highlight-row');
                }, 6000);
            }
        }
    });
});

function updateDashboard() {
    $.ajax({
        url: 'fetch_bookings.php',
        type: 'GET',
        success: function(response) {
            const bookings = JSON.parse(response);
            let tableHtml = '';
            
            bookings.forEach(booking => {
                tableHtml += `
                    <tr>
                        <td><a href='#' class='queue-details' data-toggle='modal' data-target='#detailsModal' data-queue-id='${booking.queue_id}'>OR${booking.queue_id}</a></td>
                        <td>${booking.name}</td>
                        <td><span class='badge badge-primary'>${booking.status}</span></td>
                        <td>
                            <a href='update_status.php?id=${booking.queue_id}&status=Queue' class='badge badge-warning'>Queue</a>
                            <a href='update_status.php?id=${booking.queue_id}&status=Cancelled' class='badge badge-danger'>Cancel</a>
                        </td>
                    </tr>
                `;
            });
            
            $('#bookings-section table tbody').html(tableHtml);
            
            // Rebind click handlers for queue details
            $('.queue-details').click(function(e) {
                e.preventDefault();
                var queueId = $(this).data('queue-id');
                
                // Load modal content via AJAX
                $.ajax({
                    url: 'fetch_modal_data.php',
                    type: 'POST',
                    data: { queue_id: queueId },
                    success: function(response) {
                        $('#detailsModal .modal-body').html(response);
                        $('#detailsModal').modal('show');
                    },
                    error: function() {
                        alert('Error loading booking details');
                    }
                });
            });
        }
    });
}

// Update dashboard every 30 seconds
setInterval(updateDashboard, 30000);

// Initial update
$(document).ready(function() {
    updateNotifications();
    updateDashboard();
});
</script>



</body>
</html>
