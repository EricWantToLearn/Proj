<?php
// Start the session
session_start();
include 'controls/conn.php';

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');
$monthName = date('F Y');

// Set headers for Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Monthly_Sales_Report_' . $monthName . '.xls"');

// Query to fetch monthly sales data
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

// Start the HTML output with styles
echo '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    .header {
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        padding: 10px;
    }
    .total-row {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    .text-right {
        text-align: right;
    }
</style>
</head>
<body>';

// Add header
echo '<div class="header">DOS Studios<br>Monthly Sales Report - ' . $monthName . '</div>';

// Create the table
echo '<table>
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
    <tbody>';

$totalPrice = 0;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $totalPrice += $row['total_price'];
        echo '<tr>';
        echo '<td>' . $row['sales_id'] . '</td>';
        echo '<td>' . $row['formatted_date'] . '</td>';
        echo '<td>' . $row['studio'] . '</td>';
        echo '<td>' . $row['time_range'] . '</td>';
        echo '<td>' . ($row['queued_by'] ?? 'Not Assigned') . '</td>';
        echo '<td class="text-right">₱' . number_format($row['total_price'], 2) . '</td>';
        echo '</tr>';
    }
    
    // Add total row
    echo '<tr class="total-row">';
    echo '<td colspan="5" class="text-right">Total Sales for ' . $monthName . ':</td>';
    echo '<td class="text-right">₱' . number_format($totalPrice, 2) . '</td>';
    echo '</tr>';
} else {
    echo '<tr><td colspan="6" style="text-align: center;">No sales records found for this month</td></tr>';
}

echo '</tbody></table>';
echo '</body></html>';

exit;
?>