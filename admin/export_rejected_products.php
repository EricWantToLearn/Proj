<?php
// Database connection
include 'controls/conn.php'; // Make sure you have your DB connection here

// Query to fetch the rejected product data
$query = "SELECT dp.deduction_count, dp.deduction_reason, dp.deduction_date, i.product_type 
          FROM deduct dp 
          JOIN inventory i ON dp.product_type = i.product_type";
$result = $conn->query($query);

// Set headers to prompt the user to download the file
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="Reject_Products.csv"');

// Open the PHP output stream
$output = fopen('php://output', 'w');

// Add the column headers to the CSV
fputcsv($output, ['Product Type', 'Deduction Count', 'Reason', 'Deduction Date']);

// Fetch data from the result set and write to the CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [$row['product_type'], $row['deduction_count'], $row['deduction_reason'], $row['deduction_date']]);
}

// Close the output stream
fclose($output);
exit;
