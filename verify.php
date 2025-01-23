<?php
$total_price = isset($_GET['total_price']) ? $_GET['total_price'] : '';
$package_list = isset($_GET['package_list']) ? $_GET['package_list'] : '';
$booking_date = isset($_GET['booking_date']) ? $_GET['booking_date'] : '';
$booking_time = isset($_GET['booking_time']) ? $_GET['booking_time'] : '';
$studio = isset($_GET['studio']) ? $_GET['studio'] : '';
$queue_id = isset($_GET['queue_id']) ? $_GET['queue_id'] : '';
$comments = isset($_GET['comments']) ? $_GET['comments'] : '';
?>

<?php
session_start();
include 'admin/controls/conn.php'; // Include your database connection file

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
          $start_time = $end_slot + (10 * 60);
          $slot_number++;
      } else {
          break;
      }
  }
  
  return $slots;
}

// Get the pending booking details from session
$pending_booking = isset($_SESSION['pending_booking']) ? $_SESSION['pending_booking'] : null;

// Your existing order success check
$order_success = isset($_GET['order_success']) && $_GET['order_success'] === 'true';

$total_price = $pending_booking['total_price'];
$package_list = $pending_booking['package_list'];
$booking_date = $pending_booking['booking_date'];
$booking_time = $pending_booking['booking_time'];
$time_range = $pending_booking['time_range'];
$studio = $pending_booking['studio'];
$queue_id = $pending_booking['queue_id'];
$comments = $pending_booking['comments'];

// Check if OTP or receipt image has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure queue_id is in session
    if (!isset($_SESSION['queue_id'])) {
        echo "<script>alert('Session expired. Please try again.'); window.location.href='index.php';</script>";
        exit();
    }

    $queue_id = $_SESSION['queue_id'];

    // Verify OTP
    if (isset($_POST['otp'])) {
      $entered_otp = $_POST['otp'];

      // Fetch the OTP from the messages table for the current queue_id
      $otp_stmt = $conn->prepare("SELECT otp FROM messages WHERE queue_id = ?");
      $otp_stmt->bind_param("i", $queue_id);
      $otp_stmt->execute();
      $otp_stmt->bind_result($stored_otp);
      $otp_stmt->fetch();
      $otp_stmt->close();

      // Compare the entered OTP with the stored OTP (case-insensitive)
      if (strcasecmp($entered_otp, $stored_otp) !== 0) {
          echo "<script>alert('Invalid OTP. Please try again.'); window.location.href='verify.php';</script>";
          exit();
      }

      // Get package duration before insert - only if OTP is valid
      $package_query = "SELECT duration FROM packages WHERE package_name = ?";
      $package_stmt = $conn->prepare($package_query);
      $package_name = $package_list;
      $package_stmt->bind_param("s", $package_name);
      $package_stmt->execute();
      $duration_result = $package_stmt->get_result();
      $duration = $duration_result->fetch_assoc()['duration'] ?? 15;
      $package_stmt->close();

      // Insert data into the sales table only if OTP is valid
      $sales_stmt = $conn->prepare("INSERT INTO sales (queue_id, total_price, package_list, booking_date, booking_time, time_range, studio, duration, comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $sales_stmt->bind_param("idsssssis", $queue_id, $total_price, $package_list, $booking_date, $booking_time, $time_range, $studio, $duration, $comments);

      // Execute the sales insert
      if (!$sales_stmt->execute()) {
          echo "<script>alert('Error inserting into sales: " . $sales_stmt->error . "'); window.location.href='index.php';</script>";
          exit();
      }
      $sales_stmt->close();
    }

    // Handle file upload if OTP is correct
    if (isset($_FILES['receipt_image'])) {
        $upload_dir = 'admin/receipts/';
        $allowed_types = array('image/png', 'image/jpeg');
        $file = $_FILES['receipt_image'];

        // Check if file upload is successful
        if ($file['error'] === UPLOAD_ERR_OK) {
            $timestamp = time(); // Get current timestamp
            $date = date("Ymd_His", $timestamp); // Format: YYYYMMDD_HHMMSS
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_file_name = "dosreceipt_{$date}_{$queue_id}.{$extension}";
            $file_path = $upload_dir . $new_file_name;

            // Check file type
            if (!in_array($file['type'], $allowed_types)) {
                echo "<script>alert('Invalid file type. Please upload PNG or JPG.'); window.location.href='verify.php';</script>";
                exit();
            }

            // Move uploaded file to the destination folder
            if (move_uploaded_file($file['tmp_name'], $file_path)) {
              // Update the sales table with the new receipt image location
              $update_stmt = $conn->prepare("UPDATE sales SET receipt_img_location = ? WHERE queue_id = ?");
              $update_stmt->bind_param("si", $file_path, $queue_id);
          
              if ($update_stmt->execute()) {
                  echo "<script>alert('Booking successful!'); window.location.href='index.php';</script>";
          
                  // Close the previous statement
                  $update_stmt->close();
          
                  // Update the queue table status to 'For-Checking'
                  $update_stmt = $conn->prepare("UPDATE queue SET status = 'For-Checking' WHERE queue_id = ?");
                  $update_stmt->bind_param("i", $queue_id);
          
                  if ($update_stmt->execute()) {
                      // Optionally, you could add additional feedback here if needed.
                  } else {
                      echo "<script>alert('Error updating queue status: " . $conn->error . "'); window.location.href='verify.php';</script>";
                  }
          
                  // Close the statement after execution
                  $update_stmt->close();
          
              } else {
                  echo "<script>alert('Error updating receipt image location: " . $conn->error . "'); window.location.href='verify.php';</script>";
              }
          
          } else {
              echo "<script>alert('Error uploading file.'); window.location.href='verify.php';</script>";
          }
          
        } else {
            echo "<script>alert('Please upload a receipt image.'); window.location.href='verify.php';</script>";
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>

<title>dos studios.</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="admin/plugins/fullcalendar/main.css">
  <!-- Theme style -->

  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="" />
  <meta name="keywords" content="" />
  

  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600, 700,900|Oswald:400,700" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <!-- fullCalendar -->

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/fancybox.min.css">

  <link rel="stylesheet" href="css/style.css">
</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="200">
<div class="site-wrap">

<div class="site-mobile-menu site-navbar-target">
  <div class="site-mobile-menu-header">
    <div class="site-mobile-menu-close mt-3">
      <span class="icon-close2 js-menu-toggle"></span>
    </div>
  </div>
  <div class="site-mobile-menu-body"></div>
</div>

<header class="header-bar d-flex d-lg-block align-items-center site-navbar-target" data-aos="fade-right">
  <div class="site-logo">
    <a href="index.php">dos.</a>
  </div>

  <div class="d-inline-block d-lg-none ml-md-0 ml-auto py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle "><span class="icon-menu h3"></span></a></div>

  <div class="main-menu">
    <ul class="js-clone-nav">
      <li><a href="#section-contact" class="nav-link">Reserve</a></li>
    </ul>
    <ul class="social js-clone-nav">
      <li><a href="#"><span class="icon-instagram"></span></a></li>
      <li><a href="#"><span class="icon-facebook"></span></a></li>
      <li><a href="#"><i class="fab fa-tiktok"></i></a></li>
      <li><a href="#"><span class="icon-linkedin"></span></a></li>
    </ul>
  </div>
</header> 
<section class="site-section" id="section-services">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <h2 class="heading" data-aos="fade-up">Overview</h2>
                    <div class="col-md-12 mb-4" data-aos="fade-up">
                        <div class="d-md-flex d-block blog-entry align-items-start">
                            <div>
                                <h2 class="mt-0 mb-2"><a href="#">Total Price:</a></h2>
                                <?php
                                echo "<p>₱" . ($pending_booking ? number_format($pending_booking['total_price'], 2) : '0.00') . "</p>";
                                ?>

                                <h2 class="mt-0 mb-2"><a href="#">Package List:</a></h2>
                                <?php
                                if ($pending_booking) {
                                  echo "<p>" . htmlspecialchars($pending_booking['package_list']) . "</p>";
                                }
                                ?>

                                <h2 class="mt-0 mb-2"><a href="#">Booking Date:</a></h2>
                                <?php
                                echo "<p>" . ($pending_booking ? $pending_booking['booking_date'] : '') . "</p>";
                                ?>

                                <h2 class="mt-0 mb-2"><a href="#">Booking Time:</a></h2>
                                <?php
                                if ($pending_booking) {
                                    echo "<p>" . ($pending_booking['time_range'] ?? 'Unknown Time') . "</p>";
                                }
                                ?>

                                <h2 class="mt-0 mb-2"><a href="#">Studio:</a></h2>
                                <?php
                                if ($pending_booking) {
                                    if ($pending_booking['studio'] == 1) {
                                        echo "<p>Studio 1</p>";
                                    } elseif ($pending_booking['studio'] == 2) {
                                        echo "<p>Studio 2</p>";
                                    } elseif ($pending_booking['studio'] == 3) {
                                        echo "<p>Studio 3</p>";
                                    } elseif ($pending_booking['studio'] == 4) {  
                                        echo "<p>Studio 4</p>";
                                    } elseif ($pending_booking['studio'] == 5) {
                                        echo "<p>Studio 4</p>";
                                    } else {
                                        echo "<p>Unknown Studio</p>";
                                    }
                                }
                                ?>

                                <h2 class="mt-0 mb-2"><a href="#">Comments:</a></h2>
                                <?php
                                if ($pending_booking) {
                                    echo "<p>" . ($pending_booking['comments'] ?? 'No comments') . "</p>";
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <section class="site-section" id="section-contact">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-8">
                <h2 class=" mb-5 heading">Verify</h2>
                    <form action="verify.php" method="POST" enctype="multipart/form-data">
                      <div class="row form-group">
                        <div class="col-md-6 mb-3 mb-md-0">
                          <label for="fname">OTP (Email Code):</label>
                          <input type="text" id="otp" name="otp" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3 mb-md-0">
                          <label for="fname">Receipt</label>
                          <input type="file" name="receipt_image" accept=".png, .jpg, .jpeg" required onchange="showNote()">
                        </div> 

                      </div>
                      <div class="row form-group">
                        <div class="col-md-12">
                          <input type="submit" value="Submit" class="btn btn-primary btn-md">
                          <p id="payment-note" style="display: none; color: #666; font-style: italic; margin-top: 10px; font-size: 0.9em;">
                            After paying wait for a staff member to check your payment to confirm your booking, you may then check your email for your booking confirmation.
                          </p>
                        </div>
                      </div>
                    </form>
                    <div class="row form-group" width="auto">
                    <div class="col-md-4 mb-4" data-aos="fade-up">
                      <br>
                        <h5 style="text-align: center;" data-aos="fade-up"><em>0917-129-1416</em><br><em>0917-146-3563</em></h5>
                        <img src="images/gcash.jpg" alt="Overview Image" class="img-fluid rounded">
                        <h3 style="text-align: center;" data-aos="fade-up">GCASH</h3>
                    </div>
                    <div class="col-md-4 mb-4" data-aos="fade-up">
                      <br>
                        <h5 style="text-align: left;" data-aos="fade-up">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<em>&nbsp;</em><br><em>&nbsp;&nbsp;&nbsp;&nbsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;004150507034</em></h5>
                        <img src="images/bdo.jpg" alt="Overview Image" class="img-fluid rounded" style = "margin-left: 40px;">
                        <h3 style="text-align: left;" data-aos="fade-up">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BDO</h3>
                    </div>
                    <div class="col-md-4 mb-4" data-aos="fade-up">
                      <br>
                      <h5 style="text-align: left;" data-aos="fade-up">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &emsp; &nbsp; &nbsp; &nbsp;&nbsp;  <em>&nbsp;</em><br><em>&nbsp;&nbsp;&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;3909332442</em></h5>
                        <img src="images/bpi.jpg" alt="Overview Image" class="img-fluid rounded" style = "margin-left: 80px;">
                        <h3 style="text-align: left;" data-aos="fade-up">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; BPI</h3>
                    </div>
                              </div>
              </div>
            </div>
          </div>
        </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- jQuery -->
<script src="admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery UI -->
<script src="admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- AdminLTE App -->
<script src="admin/dist/js/adminlte.min.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="admin/plugins/moment/moment.min.js"></script>
<script src="admin/plugins/fullcalendar/main.js"></script>




  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/lozad.min.js"></script>
  <script>alert('Kindly check your email for the OTP verification code.');</script>
  

  <script src="js/jquery.fancybox.min.js"></script>

  <script src="js/main.js"></script>
  <script>
    function showNote() {
      document.getElementById('payment-note').style.display = 'block';
    }
  </script>
</body>
</html>
