<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include 'controls/conn.php';

// Function to send email using PHPMailer
function sendReminderEmail($email, $name, $bookingDate, $timeRange, $studio) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dosstudios9@gmail.com';
        $mail->Password = 'boagamanxheptvdk';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('dosstudios9@gmail.com', 'Dos Studios');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Reminder: Your Upcoming Booking at Dos Studios';
        
        // Format the email body
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #333;'>Booking Reminder</h2>
                <p>Dear {$name},</p>
                <p>This is a friendly reminder about your upcoming booking at Dos Studios:</p>
                <div style='background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0;'>
                    <p><strong>Date:</strong> {$bookingDate}</p>
                    <p><strong>Time:</strong> {$timeRange}</p>
                    <p><strong>Studio:</strong> {$studio}</p>
                </div>
                <p>Please make sure to arrive at least 15 minutes before your scheduled time.</p>
                <p>If you need to make any changes to your booking, please contact us as soon as possible.</p>
                <p style='margin-top: 20px;'>Best regards,<br>Dos Studios Team</p>
            </div>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: {$mail->ErrorInfo}");
        return false;
    }
}

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Get current timestamp and calculate the timestamp for 5 hours from now
$currentTime = new DateTime();
$fiveHoursFromNow = new DateTime();
$fiveHoursFromNow->modify('+5 hours');

// Format dates for SQL query
$currentDate = $currentTime->format('Y-m-d');
$targetTime = $fiveHoursFromNow->format('h:ia'); // Format as '05:00pm'
$targetTime = strtolower($targetTime); // Convert to lowercase for 'pm'

// Debug information
error_log("Current Time: " . $currentTime->format('h:ia'));
error_log("Looking for bookings at: " . $targetTime . " on date: " . $currentDate);

// Query to get bookings that are coming up in the next 5 hours and haven't been reminded yet
$query = "
    SELECT s.queue_id, s.booking_date, s.time_range, s.studio, m.email, q.name,
           SUBSTRING_INDEX(s.time_range, '-', 1) as booking_time
    FROM sales s
    INNER JOIN queue q ON s.queue_id = q.queue_id
    INNER JOIN messages m ON q.queue_id = m.queue_id
    WHERE 
        s.booking_date = ?
        AND SUBSTRING_INDEX(s.time_range, '-', 1) = ?
        AND q.status != 'Cancelled'
        AND NOT EXISTS (
            SELECT 1 FROM reminder_logs r 
            WHERE r.queue_id = s.queue_id
        )
";

// Debug the actual query
$debugQuery = str_replace('?', "'$currentDate'", $query);
$debugQuery = str_replace('?', "'$targetTime'", $debugQuery);
error_log("Debug Query: " . $debugQuery);

try {
    // Create reminder_logs table if it doesn't exist
    $conn->query("
        CREATE TABLE IF NOT EXISTS reminder_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            queue_id INT,
            sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (queue_id) REFERENCES queue(queue_id)
        )
    ");

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $currentDate, $targetTime);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        error_log("Found " . $result->num_rows . " bookings to send reminders for");
        $remindersSent = 0;
        $errors = 0;
        while ($row = $result->fetch_assoc()) {
            error_log("Found booking: Time: " . $row['booking_time'] . ", Studio: " . $row['studio'] . ", Email: " . $row['email']);
            // Get studio name based on studio number
            $studioNames = [
                '1' => 'Studio 1 (8-20 pax) -- 1st Branch',
                '2' => 'Studio 2 (2-5 pax) -- 1st Branch',
                '3' => 'Studio 3 (5-10 pax) -- 2nd Branch',
                '5' => 'Studio 5 (8-20 pax) -- 2nd Branch'
            ];
            $studioName = $studioNames[$row['studio']] ?? "Studio {$row['studio']}";

            // Send reminder email
            if (sendReminderEmail($row['email'], $row['name'], $row['booking_date'], $row['time_range'], $studioName)) {
                // Log successful reminder
                $logStmt = $conn->prepare("INSERT INTO reminder_logs (queue_id) VALUES (?)");
                $logStmt->bind_param("i", $row['queue_id']);
                $logStmt->execute();
                $remindersSent++;
                error_log("Successfully sent reminder to: " . $row['email']);
            } else {
                $errors++;
                error_log("Failed to send reminder to: " . $row['email']);
            }
        }

        // Log the results
        $timestamp = date('Y-m-d H:i:s');
        error_log("[$timestamp] Reminder script completed. Sent: $remindersSent, Errors: $errors");
    } else {
        error_log("No bookings found for time " . $targetTime . " on date " . $currentDate);
        // Let's see what bookings exist for today
        $debugStmt = $conn->prepare("SELECT DISTINCT time_range FROM sales WHERE booking_date = ?");
        $debugStmt->bind_param("s", $currentDate);
        $debugStmt->execute();
        $debugResult = $debugStmt->get_result();
        while ($row = $debugResult->fetch_assoc()) {
            error_log("Found booking time: " . $row['time_range']);
        }
    }

} catch (Exception $e) {
    error_log("Error in reminder script: " . $e->getMessage());
}
