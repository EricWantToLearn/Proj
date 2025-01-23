<?php
session_start();
include 'controls/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $transaction_date = date("Y-m-d H:i:s"); // Record the transaction date

    // Check if enough stock is available
    $inventoryQuery = $conn->prepare("SELECT stock_count FROM inventory WHERE id = ?");
    $inventoryQuery->bind_param("i", $product_id);
    $inventoryQuery->execute();
    $inventoryResult = $inventoryQuery->get_result();
    $inventoryRow = $inventoryResult->fetch_assoc();

    if ($inventoryRow['stock_count'] >= $quantity) {
        // Deduct stock in inventory
        $new_stock_count = $inventoryRow['stock_count'] - $quantity;
        $updateInventory = $conn->prepare("UPDATE inventory SET stock_count = ? WHERE id = ?");
        $updateInventory->bind_param("ii", $new_stock_count, $product_id);
        $updateInventory->execute();

        // Insert the transaction into done_transaction table
        $insertTransaction = $conn->prepare("INSERT INTO done_transaction (product_id, quantity, transaction_date) VALUES (?, ?, ?)");
        $insertTransaction->bind_param("iis", $product_id, $quantity, $transaction_date);
        $insertTransaction->execute();

        echo '<script>history.back();</script>';
    } else {
        echo "<script>alert('Insufficient stock!'); window.location.href='inventory.php';</script>";
    }

    $inventoryQuery->close();
    $updateInventory->close();
    $insertTransaction->close();
}
?>
