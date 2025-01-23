<?php
// Database connection
include 'controls/conn.php'; // Make sure you have your DB connection here

// Query to fetch the stocks transaction data
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

// Set headers to prompt the user to download the file as CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="Stocks_Transactions.csv"');

// Open the PHP output stream
$output = fopen('php://output', 'w');

// Add the column headers to the CSV
fputcsv($output, ['Product Type', 'Stocks Added', 'Transaction Date', 'User']);

// Fetch data from the result set and write to the CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['product_type'], 
        $row['stocks_added'], 
        $row['transaction_date'], 
        $row['user_name']
    ]);
}

// Close the output stream
fclose($output);
exit;
