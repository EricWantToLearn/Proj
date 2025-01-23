<?php
include 'admin/controls/conn.php';

$date = $_POST['date'];
$query = "SELECT s.time_range, s.studio
          FROM sales s 
          INNER JOIN queue q ON s.queue_id = q.queue_id
          WHERE s.booking_date = ? AND q.status != 'Cancelled'
          ORDER BY s.time_range ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$studio1_bookings = [];
$studio2_bookings = [];
$studio3_bookings = [];
$studio4_bookings = [];
$studio5_bookings = [];

while ($row = $result->fetch_assoc()) {
    switch($row['studio']) {
        case '1':
            $studio1_bookings[] = $row;
            break;
        case '2':
            $studio2_bookings[] = $row;
            break;
        case '3':
            $studio3_bookings[] = $row;
            break;
        case '4':
            $studio4_bookings[] = $row;
            break;
        case '5':
            $studio5_bookings[] = $row;
            break;
    }
}

// Output HTML with tabs
echo '<ul class="nav nav-tabs" id="studioTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="studio1-tab" data-toggle="tab" href="#studio1" role="tab">Studio 1</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="studio2-tab" data-toggle="tab" href="#studio2" role="tab">Studio 2</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="studio3-tab" data-toggle="tab" href="#studio3" role="tab">Studio 3</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="studio4-tab" data-toggle="tab" href="#studio4" role="tab">Studio 4</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="studio5-tab" data-toggle="tab" href="#studio5" role="tab">Studio 5</a>
        </li>
    </ul>';

echo '<div class="tab-content" id="studioTabsContent">';

// Function to generate tab content
function generateStudioTab($bookings, $studioNum, $isActive = false) {
    $activeClass = $isActive ? ' show active' : '';
    echo '<div class="tab-pane fade' . $activeClass . '" id="studio' . $studioNum . '" role="tabpanel">';
    if (!empty($bookings)) {
        echo "<ul class='list-group mt-2'>";
        foreach ($bookings as $booking) {
            echo "<li class='list-group-item'>";
            echo "<strong>Time:</strong> " . htmlspecialchars($booking['time_range']);
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p class='text-center mt-2'>No bookings for Studio " . $studioNum . " on this date.</p>";
    }
    echo '</div>';
}

// Generate content for each studio
generateStudioTab($studio1_bookings, 1, true);
generateStudioTab($studio2_bookings, 2);
generateStudioTab($studio3_bookings, 3);
generateStudioTab($studio4_bookings, 4);
generateStudioTab($studio5_bookings, 5);

echo '</div>';

$stmt->close();
$conn->close();
?>