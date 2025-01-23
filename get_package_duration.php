<?php
include 'admin/controls/conn.php';

if (isset($_POST['package_id'])) {
    $package_id = $_POST['package_id'];
    
    // Remove 'reg_' or 'temp_' prefix if present
    $package_id = preg_replace('/^(reg_|temp_)/', '', $package_id);
    
    $query = "SELECT duration FROM packages WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $package_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    echo json_encode(['duration' => $data['duration'] ?? 15]);
    $stmt->close();
}
$conn->close();
?>