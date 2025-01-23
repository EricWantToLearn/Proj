<?php
include 'controls/conn.php';

$query = "SELECT COUNT(*) as count FROM queue WHERE status = 'For-Checking' AND notification_read = 0";
$result = $conn->query($query);
$row = $result->fetch_assoc();

$notificationsQuery = "SELECT queue_id, name, created_at 
                      FROM queue 
                      WHERE status = 'For-Checking' AND notification_read = 0 
                      ORDER BY created_at DESC 
                      LIMIT 5";
$notifications = $conn->query($notificationsQuery);

$notificationsList = [];
while($notification = $notifications->fetch_assoc()) {
    $notificationsList[] = [
        'id' => $notification['queue_id'],
        'message' => "New booking from " . $notification['name'],
        'time' => date('M d, H:i', strtotime($notification['created_at']))
    ];
}

echo json_encode([
    'count' => $row['count'],
    'notifications' => $notificationsList
]);
?>