<?php
include 'controls/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipment_id = $_POST['equipment_name'];
    $date_updated = $_POST['date_updated'];

    // Update the date_updated column in the maintenance table
    $stmt = $conn->prepare("UPDATE maintenance SET date_updated = ? WHERE id = ?");
    $stmt->bind_param("si", $date_updated, $equipment_id);

    if ($stmt->execute()) {
        echo '<script>alert("Maintenance date updated successfully!"); window.location.href="index.php";</script>';
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
