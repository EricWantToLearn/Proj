<?php
include 'admin/controls/conn.php';

function getTimeSlots($duration = 15) {
    $start_time = strtotime('10:00');
    $end_time = strtotime('19:00');
    $slots = [];
    $slot_number = 1;
    
    while ($start_time < $end_time) {
        $end_slot = $start_time + ($duration * 60);
        if ($end_slot <= $end_time) {
            $slots[$slot_number] = [
                'start' => date('H:i', $start_time),
                'end' => date('H:i', $end_slot),
                'display' => date('h:ia', $start_time) . ' - ' . date('h:ia', $end_slot)
            ];
            // Changed from 5 minutes to 10 minutes
            $start_time = $start_time + (10 * 60);
            $slot_number++;
        } else {
            break;
        }
    }
    
    return $slots;
}

if (isset($_POST['duration'])) {
    $duration = (int)$_POST['duration'];
    $slots = getTimeSlots($duration);
    echo json_encode($slots);
}
?>