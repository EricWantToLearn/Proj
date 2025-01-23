<?php
session_start();
include 'admin/controls/conn.php'; // Include your database connection file
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'vendor/autoload.php';

function getTimeSlots($duration = 15, $start_from = null) {
    $start_time = $start_from ? $start_from : strtotime('10:00');
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
            $start_time = $end_slot + (5 * 60);
            $slot_number++;
        } else {
            break;
        }
    }
    return $slots;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $booking_date = trim($_POST['booking_date']);
    $booking_time = trim($_POST['booking_time']);
    $time_range = trim($_POST['booking_time_display']);
    $studio = trim($_POST['studio']);
    $comments = trim($_POST['comments']);
   
    // Get the package list from the hidden input
    $package_list = trim($_POST['package_list']); // Now using hiddenpackagelist
    $total_price = (float)$_POST['total_price']; // Retrieve the total price from the form

    // Validation: Check if total_price is 0
        if ($total_price == 0) {
            echo "<script>alert('Cannot proceed, need to select a package.'); window.location.href='verification.php';</script>";
            exit(); // Stop further execution
        }

    // Combine first and last name
    $fullname = $fname . ' ' . $lname;

    // Prepare statement to insert into the queue table with default status 'Queue'
    $queue_stmt = $conn->prepare("INSERT INTO queue (name, status) VALUES (?, 'Saved')");
    $queue_stmt->bind_param("s", $fullname);

    if ($queue_stmt->execute()) {
        // Get the queue_id of the inserted record
        $queue_id = $conn->insert_id;

        function generateRandomCode($length = 6) {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }
            return $code;
        }
        
        $otp = generateRandomCode();

        // Insert email, subject, and message into the messages table
        $message_stmt = $conn->prepare("INSERT INTO messages (email,otp,queue_id) VALUES (?,?,?)");
        $message_stmt->bind_param("ssi", $email,$otp,$queue_id);
        $message_stmt->execute();



        //php-mailer

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'dosstudios9@gmail.com';                     //SMTP username
            $mail->Password   = 'boagamanxheptvdk';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('dosstudios9@gmail.com', 'DOS Studios');
            $mail->addAddress($email);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            // //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'OTP Verification';
            $mail->Body    = 'Hello ' . $fullname . ',<br><br>

                Thank you for booking with us! To proceed with your booking, please use the following One-Time Password (OTP) for verification:<br><br>

                <strong>OTP: ' . $otp . '</strong><br><br>

                Please note that this OTP is valid for the next 10 minutes. Do not share this code with anyone to ensure the security of your account.<br><br>

                If you did not initiate this request, please contact our support team immediately.<br><br>

                Thank you,<br>
                Dos Studios
                ';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        
        $package_duration = 0; // Initialize duration

        // Get the package duration from the database based on the selected package
        $duration_query = "SELECT duration FROM packages WHERE package_name = ?";
        $stmt = $conn->prepare($duration_query);
        $stmt->bind_param("s", $package_list);
        $stmt->execute();
        $duration_result = $stmt->get_result();
        if ($row = $duration_result->fetch_assoc()) {
            $package_duration = $row['duration'];
        }


        // Store the data in session variables
        $timeSlots = getTimeSlots($package_duration);
        $selectedSlot = $booking_time;
        $displayTime = isset($timeSlots[$selectedSlot]) ? $timeSlots[$selectedSlot]['display'] : '';

        $_SESSION['pending_booking'] = [
            'queue_id' => $queue_id,
            'total_price' => $total_price,
            'package_list' => $package_list,
            'booking_date' => $booking_date,
            'booking_time' => $selectedSlot,
            'time_range' => $time_range,
            'studio' => $studio,
            'duration' => $package_duration,
            'comments' => $comments
        ];

        // Close statements
        $message_stmt->close(); 

        // Modify the header redirect to pass only necessary verification info
        header("Location: verify.php?email=" . urlencode($email));
        $_SESSION['queue_id'] = $queue_id;
        exit();
    } else {
        echo "<script>alert('Error saving to queue: " . $conn->error . "'); window.location.href='index.php';</script>";
    }

    $queue_stmt->close();
    $conn->close();
}
?>
