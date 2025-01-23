<?php
include 'controls/conn.php';

// Check if the package_id is set
if (isset($_POST['package_id'])) {
    $package_id = $_POST['package_id'];

    // Query to get products related to the selected package
    $query = "SELECT product_id, product_name FROM products WHERE package_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $package_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Generate the options for the product dropdown
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['product_id']}'>{$row['product_name']}</option>";
    }
    $stmt->close();
}
?>
