<?php
include 'admin/controls/conn.php';

$start = $_POST['start'];
$end = $_POST['end'];

$query = "SELECT 
            DATE(booking_date) as booking_date,
            COUNT(*) as booking_count,
            GROUP_CONCAT(
                JSON_OBJECT(
                    'time', booking_time,
                    'studio', studio,
                    'package', package_list
                )
            ) as bookings
          FROM sales 
          WHERE booking_date BETWEEN ? AND ?
          GROUP BY DATE(booking_date)";  // Group by date only

$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $start, $end);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'date' => $row['booking_date'],
        'count' => $row['booking_count'],
        'bookings' => json_decode('[' . $row['bookings'] . ']', true)
    ];
}

echo json_encode($events);