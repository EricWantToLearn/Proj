<?php
include 'controls/conn.php';
session_start();

function getTimeSlots($duration = 15) {
    $start_time = strtotime('10:00');
    $end_time = strtotime('19:00'); // 7:00 PM
    $slots = [];
    $slot_number = 1;
    
    while ($start_time < $end_time) {
        $end_slot = $start_time + ($duration * 60); // Dynamic duration
        if ($end_slot <= $end_time) {
            $slots[$slot_number] = [
                'start' => date('H:i', $start_time),
                'end' => date('H:i', $end_slot),
                'display' => date('h:ia', $start_time) . ' - ' . date('h:ia', $end_slot)
            ];
            $start_time = $end_slot + (10 * 60); // 5 minutes break
            $slot_number++;
        } else {
            break;
        }
    }
    
    return $slots;
}

if (isset($_POST['queue_id'])) {
    $queue_id = $_POST['queue_id'];
    
    $query = "SELECT s.total_price, s.package_list, s.receipt_img_location, 
    s.studio, s.booking_date, s.booking_time, s.time_range, q.status,
    p.duration, s.comments
    FROM sales s 
    LEFT JOIN queue q ON s.queue_id = q.queue_id 
    LEFT JOIN packages p ON p.package_name = s.package_list
    WHERE s.queue_id = ?";
                
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $queue_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // If no data in sales, check session for pending booking
    if (!$row && isset($_SESSION['pending_booking']) && $_SESSION['queue_id'] == $queue_id) {
        $row = $_SESSION['pending_booking'];
        $row['status'] = 'For-Checking'; // Default status for pending bookings
    }

    if ($row) {
        // Get the duration from the database or use default
        $duration = isset($row['duration']) ? $row['duration'] : 15;
        
        // Get time slots with correct duration
        $timeSlots = getTimeSlots($duration);
        $booking_time_display = $row['time_range'] ?? 'Unknown Time';
    
        $formatted_package_list = str_replace('|', ', ', $row['package_list']);
        $studio_display = $row['studio'] == 1 ? 'Studio 1' : ($row['studio'] == 2 ? 'Studio 2' : ($row['studio'] == 3 ? 'Studio 3' : ($row['studio'] == 4 ? 'Studio 4' : ($row['studio'] == 5 ? 'Studio 5' : 'Unknown Studio'))));
        

        // Output HTML content
        echo "<div class='order-details'>";
        echo "<p><strong>Total Price:</strong> ₱" . number_format($row['total_price'], 2) . "</p>";
        echo "<p><strong>Package List:</strong> " . htmlspecialchars($formatted_package_list) . "</p>";
        
        // Only show receipt image for verified bookings
        if (isset($row['receipt_img_location'])) {
            echo "<p><strong>Image:</strong><br>";
            if (!empty($row['receipt_img_location']) && !is_null($row['receipt_img_location'])) {
                $display_path = str_replace('admin/', '', $row['receipt_img_location']);
                echo "<img src='$display_path' alt='Receipt Image' style='max-width: 100%; height: auto;'>";
            } else {
                echo "<span class='text-muted'>No image available yet.</span>";
            }
            echo "</p>";
        }
        
        echo "<p><strong>Studio:</strong> " . htmlspecialchars($studio_display) . "</p>";
        echo "<p><strong>Booking Date:</strong> " . date('F j, Y', strtotime($row['booking_date'])) . "</p>";
        echo "<p><strong>Booking Time:</strong> " . htmlspecialchars($booking_time_display) . "</p>";
        echo "<p><strong>Comments:</strong> " . 
        (!empty($row['comments']) ? htmlspecialchars($row['comments']) : '<span class="text-muted">No comments</span>') . 
        "</p>";
        
        if (isset($row['status'])) {
            $badgeClass = match($row['status']) {
                'Done' => 'success',
                'Queue' => 'warning',
                'Cancelled' => 'danger',
                'On-Going' => 'info',
                'For-Checking' => 'secondary',
                default => 'secondary'
            };
            echo "<p><strong>Status:</strong> <span class='badge badge-" . $badgeClass . "'>" 
                . htmlspecialchars($row['status']) . "</span></p>";
        }
        echo "</div>";
    } else {
        echo "<div class='alert alert-warning'>No details found for this order.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Invalid request.</div>";
}

$stmt->close();
$conn->close();
?>