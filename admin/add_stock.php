<?php
include 'controls/conn.php';
session_start(); // Add session start

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate inputs
    if (empty($_POST['product_type']) || empty($_POST['stocks_added']) || empty($_POST['user'])) {
        echo "<script>alert('All fields are required'); window.location.href='inventory.php';</script>";
        exit;
    }

    $product_type = $_POST['product_type'];
    $stocks_added = (int)$_POST['stocks_added'];
    $transaction_date = date("Y-m-d");
    $user = (int)$_POST['user'];

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Insert into the stocks table
        $stmt = $conn->prepare("INSERT INTO stocks (product_type, stocks_added, transaction_date, user) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sisi", $product_type, $stocks_added, $transaction_date, $user);
        
        if (!$stmt->execute()) {
            throw new Exception("Error inserting into stocks table");
        }

        // Update the stock count in the inventory table
        $update_stmt = $conn->prepare("UPDATE inventory SET stock_count = stock_count + ? WHERE product_type = ?");
        $update_stmt->bind_param("is", $stocks_added, $product_type);
        
        if (!$update_stmt->execute()) {
            throw new Exception("Error updating inventory");
        }

        // If we get here, commit the transaction
        $conn->commit();
        echo "<script>alert('Stock added successfully!'); window.location.href='inventory.php';</script>";

    } catch (Exception $e) {
        // An error occurred, rollback the transaction
        $conn->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='inventory.php';</script>";
    } finally {
        // Close statements
        if (isset($stmt)) $stmt->close();
        if (isset($update_stmt)) $update_stmt->close();
        $conn->close();
    }
}
?>