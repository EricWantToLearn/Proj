<?php
session_start();
include 'controls/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['package_id'])) {
    try {
        // Start transaction
        $conn->begin_transaction();

        // Delete from package_images table first (foreign key constraint)
        $stmt1 = $conn->prepare("DELETE FROM package_images WHERE package_id = ?");
        $stmt1->bind_param("i", $_POST['package_id']);
        $stmt1->execute();

        // Delete from package_products table (foreign key constraint)
        $stmt2 = $conn->prepare("DELETE FROM package_products WHERE package_id = ?");
        $stmt2->bind_param("i", $_POST['package_id']);
        $stmt2->execute();

        // Finally delete from packages table
        $stmt3 = $conn->prepare("DELETE FROM packages WHERE id = ?");
        $stmt3->bind_param("i", $_POST['package_id']);
        $stmt3->execute();

        // Commit transaction
        $conn->commit();
        $_SESSION['success_message'] = "Package deleted successfully!";
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }

    // Close statements
    if (isset($stmt1)) $stmt1->close();
    if (isset($stmt2)) $stmt2->close();
    if (isset($stmt3)) $stmt3->close();

    // Redirect back to inventory page
    header("Location: inventory.php");
    exit();
}
?>