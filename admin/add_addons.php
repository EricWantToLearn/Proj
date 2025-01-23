
<?php
include 'controls/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_type'];
    
    $quantity = $_POST['quantity'];

    // Check if enough stock is available
    $check_stock_query = $conn->prepare("SELECT stock_count FROM inventory WHERE id = ?");
    $check_stock_query->bind_param("s", $product_id);
    $check_stock_query->execute();
    $check_stock_result = $check_stock_query->get_result();
    $row = $check_stock_result->fetch_assoc();

    if ($row && $row['stock_count'] >= $quantity) {
        // Insert into the deduct table
        $stmt = $conn->prepare("INSERT INTO addons (product_type, quantity) VALUES (?, ?)");
        $stmt->bind_param("si", $product_id, $quantity);
        $stmt->execute();

        // Update the stock count in the inventory table
        $update_stmt = $conn->prepare("UPDATE inventory SET stock_count = stock_count - ? WHERE id = ?");
        $update_stmt->bind_param("is", $quantity, $product_id);
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