<?php
include 'controls/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_type = $_POST['product_type'];  // This is the ID from the form
    $deduction_count = $_POST['deduction_count'];
    $deduction_reason = $_POST['deduction_reason'];

    // First get the product_type string from inventory using the ID
    $get_product_type = $conn->prepare("SELECT product_type FROM inventory WHERE id = ?");
    $get_product_type->bind_param("i", $product_type);
    $get_product_type->execute();
    $result = $get_product_type->get_result();
    $row = $result->fetch_assoc();
    $product_type_string = $row['product_type'];

    // Check if enough stock is available
    $check_stock_query = $conn->prepare("SELECT stock_count FROM inventory WHERE id = ?");
    $check_stock_query->bind_param("i", $product_type);
    $check_stock_query->execute();
    $check_stock_result = $check_stock_query->get_result();
    $row = $check_stock_result->fetch_assoc();

    if ($row && $row['stock_count'] >= $deduction_count) {
        // Insert into the deduct table using product_type string
        $stmt = $conn->prepare("INSERT INTO deduct (product_type, deduction_count, deduction_reason) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $product_type_string, $deduction_count, $deduction_reason);
        $stmt->execute();

        // Update the stock count in the inventory table using ID
        $update_stmt = $conn->prepare("UPDATE inventory SET stock_count = stock_count - ? WHERE id = ?");
        $update_stmt->bind_param("ii", $deduction_count, $product_type);
        $update_stmt->execute();

        echo '<script>history.back();</script>';
    } else {
        echo "<script>alert('Insufficient stock to deduct'); window.location.href='inventory.php';</script>";
    }

    $stmt->close();
    $update_stmt->close();
    $conn->close();
}
?>