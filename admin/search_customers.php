<?php
include 'controls/conn.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Modified query to search by name and group by status
$query = "SELECT queue_id, name, status 
          FROM queue 
          WHERE LOWER(name) LIKE LOWER(?) 
          AND status IN ('Queue', 'Done', 'Cancelled', 'On-Going', 'For-Checking')
          ORDER BY queue_id DESC";

$stmt = $conn->prepare($query);
$searchTerm = "%" . $search . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];

while ($row = $result->fetch_assoc()) {
    if (stripos($row['name'], $search) !== false) {
        $bookings[] = [
            'queue_id' => $row['queue_id'],
            'name' => $row['name'],
            'status' => $row['status']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($bookings);

$stmt->close();
$conn->close();
?>