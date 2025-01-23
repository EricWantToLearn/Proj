<?php
// Database connection
include 'controls/conn.php'; // Make sure you have your DB connection here

// Query to fetch the transaction data
$result = $conn->query("SELECT dt.quantity, dt.transaction_date, i.product_type 
                        FROM done_transaction dt 
                        JOIN inventory i ON dt.product_id = i.id 
                        ORDER BY dt.transaction_date DESC");

// Set headers to prompt the user to download the file as an Excel file
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Transaction_History.xls"');

// Open the PHP output stream
$output = fopen('php://output', 'w');

// Start the HTML table with basic formatting
echo '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">';
echo '<tr style="background-color:#f2f2f2; font-weight:bold;">';  // Header row with background color
echo '<td>Product</td>';
echo '<td>Quantity</td>';
echo '<td>Date</td>';
echo '</tr>';

// Fetch data from the result set and write to the table
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['product_type']) . '</td>';
    echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
    echo '<td>' . htmlspecialchars($row['transaction_date']) . '</td>';
    echo '</tr>';
}

// Close the table
echo '</table>';

// Exit to prevent further output
exit;
?>
