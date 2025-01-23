<?php
include 'admin/controls/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_date = $_POST['date'];
    $new_duration = isset($_POST['duration']) ? (int)$_POST['duration'] : 15;
    $studio_selected = $_POST['studio'] ?? null;
    
    // Get current time in Asia/Manila timezone
    date_default_timezone_set('Asia/Manila');
    $current_time = strtotime('now');

    // If selected date is today, and current time is past business hours, return no slots
    if ($selected_date === date('Y-m-d')) {
        $business_end = strtotime('19:00');
        if ($current_time >= $business_end) {
            echo json_encode([
                'available_slots' => [],
                'next_available_time' => null
            ]);
            exit;
        }
    }
    
    // Get all bookings for the day
    $query = "SELECT s.time_range, s.studio 
            FROM sales s 
            WHERE s.booking_date = ? AND s.studio = ?
            ORDER BY s.time_range ASC";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $selected_date, $studio_selected);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Store all booked time ranges
    $booked_slots = [];
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['time_range'])) {
            $times = explode(' - ', $row['time_range']);
            if (isset($times[1])) {
                $start = strtotime(trim($times[0]));
                $end = strtotime(trim($times[1]));
                $booked_slots[] = ['start' => $start, 'end' => $end];
            }
        }
    }

    // Get all possible time slots
    $business_start = strtotime('10:00');
    $business_end = strtotime('19:00');
    $available_slots = [];
    $current_time = $business_start;

    // Check each potential slot
    while ($current_time < $business_end) {
        $slot_end = $current_time + ($new_duration * 60);
        
        if ($slot_end > $business_end) {
            break;
        }

        // Skip this slot if it's in the past (for today only)
        if ($selected_date === date('Y-m-d') && $current_time < strtotime('now')) {
            $current_time = $current_time + (10 * 60);
            continue;
        }

        $is_available = true;
        // Check if this slot overlaps with any booked slots
        foreach ($booked_slots as $booked) {
            if (
                ($current_time >= $booked['start'] && $current_time < $booked['end']) ||
                ($slot_end > $booked['start'] && $slot_end <= $booked['end']) ||
                ($current_time <= $booked['start'] && $slot_end >= $booked['end'])
            ) {
                $is_available = false;
                break;
            }
        }

        if ($is_available) {
            $available_slots[] = [
                'start' => date('H:i', $current_time),
                'end' => date('H:i', $slot_end),
                'display' => date('h:ia', $current_time) . ' - ' . date('h:ia', $slot_end)
            ];
        }

        // Move to next potential slot (add buffer time)
        $current_time = $current_time + (10 * 60);
    }

    echo json_encode([
        'available_slots' => $available_slots,
        'next_available_time' => !empty($available_slots) ? $available_slots[0]['display'] : null
    ]);
}
?>