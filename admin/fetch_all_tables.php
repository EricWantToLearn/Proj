<?php
include 'controls/conn.php';

$query = "SELECT queue_id, name, status 
          FROM queue 
          WHERE status IN ('Queue', 'Done', 'Cancelled', 'On-Going', 'For-Checking')
          ORDER BY queue_id DESC";

$result = $conn->query($query);
$bookings = [];

while ($row = $result->fetch_assoc()) {
    $bookings[] = [
        'queue_id' => $row['queue_id'],
        'name' => $row['name'],
        'status' => $row['status']
    ];
}

header('Content-Type: application/json');
echo json_encode($bookings);

$conn->close();
?>