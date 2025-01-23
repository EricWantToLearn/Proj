<?php
include 'controls/conn.php';

if(isset($_POST['notification_id'])) {
    $notification_id = intval($_POST['notification_id']);
    $query = "UPDATE queue SET notification_read = 1 WHERE queue_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $notification_id);
    $stmt->execute();
    echo json_encode(['success' => true]);
}
?>