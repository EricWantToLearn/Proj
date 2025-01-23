<?php
include 'controls/conn.php';

$queueQuery = "SELECT queue_id, name, status FROM queue WHERE status = 'For-Checking'";
$queueResult = $conn->query($queueQuery);
$bookings = [];

while ($row = $queueResult->fetch_assoc()) {
    $bookings[] = [
        'queue_id' => $row['queue_id'],
        'name' => $row['name'],
        'status' => $row['status']
    ];
}

echo json_encode($bookings);
?>

