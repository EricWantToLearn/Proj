<?php
include 'controls/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_type = $_POST['product_type'];
    $stock_count = $_POST['stock_count'];
    $description = $_POST['description'];
    
    $stmt = $conn->prepare("INSERT INTO inventory (product_type, stock_count,description) VALUES (?, ?,?)");
    $stmt->bind_param("sis", $product_type, $stock_count,$description );
    if ($stmt->execute()) {
        echo '<script>history.back();</script>';
    } else {
        echo "<script>alert('Error adding product'); window.location.href='inventory.php';</script>";
    }
    $stmt->close();
    $conn->close();
}
?>
