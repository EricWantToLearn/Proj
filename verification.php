<?php
include 'admin/controls/conn.php';
$current_date = date('Y-m-d');

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


// Debug query to check temporary packages
$debug_query = "SELECT * FROM temporary_packages 
                WHERE '$current_date' BETWEEN start_date AND end_date";
$debug_result = $conn->query($debug_query);

// Print debug information
echo "<!-- Debug Info:\n";
echo "Current Date: " . $current_date . "\n";
echo "Number of temporary packages found: " . $debug_result->num_rows . "\n";
while($row = $debug_result->fetch_assoc()) {
    echo "Package: " . $row['package_name'] . 
         " (Valid: " . $row['start_date'] . " to " . $row['end_date'] . ")\n";
}

$order_success = isset($_GET['order_success']) && $_GET['order_success'] === 'true';
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
  <style>

        /* Hide scrollbar by default but maintain space for it */
        .packages-scroll {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 20px 0;
        gap: 20px;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* IE and Edge */
    }

    /* Hide scrollbar for Chrome, Safari and Opera by default */
    .packages-scroll::-webkit-scrollbar {
        width: 8px;
        height: 8px;
        display: none;
    }

    /* Show scrollbar on hover */
    .packages-scroll:hover {
        scrollbar-width: thin; /* Firefox */
        -ms-overflow-style: auto;  /* IE and Edge */
    }

    .packages-scroll:hover::-webkit-scrollbar {
        display: block;
    }

    /* Style the scrollbar */
    .packages-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .packages-scroll::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .packages-scroll::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .package-card {
        flex: 0 0 auto; /* Don't allow cards to shrink or grow */
        width: 300px; /* Fixed width for each card */
        border: 1px solid #f5eedc;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: transform 0.2s;
        background: black;
    }

    .package-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .package-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .price {
        font-weight: bold;
        color: #28a745;
        display: none;
    }

    .selected {
    border: 3px solid #28a745;
  }
  .modal-dialog {
    max-width: 1000px; 
    margin: 1.75rem auto;
  }

  .modal-content {
    border-radius: 15px;
    overflow: hidden;
  }
  .modal-header {
      background-color: #f8f9fa;
      border-bottom: 2px solid #ff6b6b;
  }

  .slideshow-container {
      position: relative;
      width: 100%;
      height: 500px; 
      overflow: hidden;
  }

  .slideshow-images {
      width: 100%;
      height: 100%;
  }

  .slideshow-images img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      transition: opacity 1s ease-in-out;
      border-radius: 10px !important;
  }

  .prev-btn, .next-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0, 0, 0, 0.5);
      color: white;
      border: none;
      padding: 10px 15px;
      cursor: pointer;
      transition: opacity 0.3s ease-in-out; 
  }

  .prev-btn { left: 10px; }
  .next-btn { right: 10px; }

  .prev-btn:hover, .next-btn:hover {
      background: rgba(0, 0, 0, 0.8);
  }
  .package-name {
    font-size: 50px;
    padding-top: 20px;
  }
  .package-description {
    text-align: left !important;
    padding-top: 40px;
    font-size: 25px;
    padding-left: 50px;
    line-height: 1.8;
  }
  .package-price {
    font-size: 30px;
    padding-top: 20px;
  }
  .temporary-package {
    position: relative;
    border: 2px solid #ff6b6b;
  }

  .temporary-badge {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #ff6b6b;
      color: white;
      padding: 5px 10px;
      border-radius: 15px;
      font-size: 0.8em;
      font-weight: bold;
  }
  .package-validity {
    background-color: #fff3f3;
    padding: 10px 15px;
    border-radius: 5px;
    margin-top: 15px;
  }

  .package-validity i {
      margin-right: 5px;
  }
  .booking-step {
    margin-bottom: 30px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    border-color: #fff3f3;
    transition: all 0.3s ease;
  }

  .booking-step.active {
    opacity: 1 !important;
    pointer-events: all !important;
    border-color: #fff3f3;
  }

  .fc {
    max-width: 1200px;
    margin: 0 auto;
  }

  .fc-daygrid-day-number {
      font-weight: bold;
      color: #333;
  }

  .fc-daygrid-day {
      transition: background-color 0.3s ease;
  }

  .fc-daygrid-day:hover {
      cursor: pointer;
      background-color: rgba(0,0,0,0.1) !important;
  }
  .fc .fc-day-disabled {
    background-color: #f4f4f4;
    opacity: 0.6;
    cursor: not-allowed;
    }
    /* Make the today and month buttons smaller */
  .fc-today-button, .fc-dayGridMonth-button {
      font-size: 0.8em !important;
      padding: 5px 10px !important; /* Adjust padding to make button smaller */
  }

  /* Make the prev/next buttons smaller */
  .fc-prev-button, .fc-next-button {
      font-size: 0.8em !important;
      padding: 5px 10px !important;
  }

  /* Adjust the month title size */
  .fc-toolbar-title {
      font-size: 1.2em !important; /* Adjust this value as needed */
  }

  /* Make all toolbar buttons smaller */
  .fc-button {
      font-size: 0.8em !important;
      padding: 5px 10px !important;
  }
  .fc .fc-toolbar-title {
        font-size: 2em !important; /* Increase this value to make it larger */
        font-weight: bold !important; /* Optional: make it bold */
    }
  </style>
</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="200" style="background-color: #FFFFFF;">
<div class="site-wrap">

<div class="site-mobile-menu site-navbar-target">
  <div class="site-mobile-menu-header">
    <div class="site-mobile-menu-close mt-3">
      <span class="icon-close2 js-menu-toggle"></span>
    </div>
  </div>
  <div class="site-mobile-menu-body"></div>
</div>

<header class="header-bar d-flex d-lg-block align-items-center site-navbar-target" data-aos="fade-right" style="background-color: #FFFFFF;">
  <div class="site-logo">
    <a href="index.php">dos.</a>
  </div>

  <div class="d-inline-block d-lg-none ml-md-0 ml-auto py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle "><span class="icon-menu h3"></span></a></div>

  <div class="main-menu">
    <ul class="js-clone-nav">
      <li><a href="#section-contact" class="nav-link">Reserve</a></li>
    </ul>
    <ul class="social js-clone-nav">
        <li>
            <a href="https://instagram.com/dos.studiosph" target="_blank" rel="noopener">
                <span class="icon-instagram"></span>
            </a>
        </li>
        <li>
            <a href="https://facebook.com/dosstudiosph" target="_blank" rel="noopener">
                <span class="icon-facebook"></span>
            </a>
        </li>
        <li>
            <a href="https://tiktok.com/@dos.studiosph" target="_blank" rel="noopener">
                <i class="fab fa-tiktok"></i>
            </a>
        </li>
    </ul>
  </div>
</header> 
<section class="content">
  <div class="container-fluid" style="max-width: 80%; margin: 0 auto;">
    <div class="row">
      <div class="col-md-2"> <!-- Reduced col width -->
        <div class="sticky-top mb-1"> <!-- Smaller margin bottom -->
          <div class="card" style="padding: 5px; display: none;"> <!-- Reduced padding -->
            <div class="card-header" style="padding: 5px;">
              <h4 class="card-title" style="font-size: 1rem;">Draggable Events</h4> <!-- Smaller font -->
            </div>
            <div class="card-body" style="padding: 5px; ">
              <!-- The events -->
              <div id="external-events">
                <div class="external-event bg-success" style="font-size: 0.9rem; padding: 3px;">Lunch</div>
                <div class="external-event bg-warning" style="font-size: 0.9rem; padding: 3px;">Go home</div>
                <div class="external-event bg-info" style="font-size: 0.9rem; padding: 3px;">Do homework</div>
                <div class="external-event bg-primary" style="font-size: 0.9rem; padding: 3px;">Work on UI design</div>
                <div class="external-event bg-danger" style="font-size: 0.9rem; padding: 3px;">Sleep tight</div>
              </div>
            </div>
          </div>

          
        </div>
      </div>

<div class="col-12 col-md-8 mx-auto"> <!-- Responsive column -->
  <div class="card card-primary" style="border-radius: 30px; margin-top: 30px; padding: 20px; font-size: 0.6em;">
    <div class="card-body p-0"> <!-- Adjusted height for calendar -->
      <!-- The Calendar -->
      <div id="calendar"></div>
    </div>
  </div>
</div>

      <!-- <div id="accordion">
          <div class="card card-primary">
            <div class="card-header">
              <h4 class="card-title w-100">
                <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                  Collapsible Group Item #1
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="collapse show" data-parent="#accordion">
              <div class="card-body">
              <div class="row">
              <div class="col-md-2"> 
        <div class="sticky-top mb-1"> 
          <div class="card" style="padding: 5px; display: none;"> 
            <div class="card-header" style="padding: 5px;">
              <h4 class="card-title" style="font-size: 1rem;">Draggable Events</h4> 
            </div>
            <div class="card-body" style="padding: 5px; ">
             
              <div id="external-events">
                <div class="external-event bg-success" style="font-size: 0.9rem; padding: 3px;">Lunch</div>
                <div class="external-event bg-warning" style="font-size: 0.9rem; padding: 3px;">Go home</div>
                <div class="external-event bg-info" style="font-size: 0.9rem; padding: 3px;">Do homework</div>
                <div class="external-event bg-primary" style="font-size: 0.9rem; padding: 3px;">Work on UI design</div>
                <div class="external-event bg-danger" style="font-size: 0.9rem; padding: 3px;">Sleep tight</div>
              </div>
            </div>
          </div>

          
        </div>
      </div> 
              <div class="col-md-10"> 
              <div class="card card-primary" style="padding: 5px;">
                <div class="card-body p-0" > 
                 
                  <div id="calendar"></div>
                </div>
              </div>
            </div>
              </div>
              </div>
            </div>
          </div>

        </div>
    </div> -->
  </div>
</section>


    <section class="site-section" id="section-contact">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-8">
                    <form action="submit.php" method="POST">


      <!-- Step 1: Package Selection -->
      <div class="booking-step" id="step1">
        <h3>Choose your package</h3>
        <div class="packages-scroll">
        <?php
                            include 'admin/controls/conn.php';
                            $current_date = date('Y-m-d');
                            $query = "SELECT 
                            CASE 
                                WHEN tp.id IS NOT NULL THEN CONCAT('temp_', tp.id)
                                ELSE CONCAT('reg_', p.id)
                            END as unique_id,
                            COALESCE(tp.image_name_location, p.image_name_location) as image_name_location,
                            COALESCE(tp.price, p.price) as price,
                            COALESCE(tp.package_name, p.package_name) as package_name,
                            COALESCE(tp.description, p.description) as description,
                            COALESCE(tp.duration, p.duration) as duration,
                            CASE 
                                WHEN tp.id IS NOT NULL THEN 1 
                                ELSE 0 
                            END as is_temporary,
                            tp.start_date,
                            tp.end_date,
                            CASE 
                                WHEN tp.id IS NOT NULL THEN GROUP_CONCAT(tpi.image_path)
                                ELSE GROUP_CONCAT(pi.image_path)
                            END as additional_images
                        FROM packages p
                        LEFT JOIN package_images pi ON p.id = pi.package_id
                        LEFT JOIN (
                            SELECT * FROM temporary_packages 
                            WHERE STR_TO_DATE('$current_date', '%Y-%m-%d') BETWEEN 
                                STR_TO_DATE(start_date, '%Y-%m-%d') AND 
                                STR_TO_DATE(end_date, '%Y-%m-%d')
                        ) tp ON p.id = tp.id
                        LEFT JOIN temporary_packages_images tpi ON tp.id = tpi.temp_package_id
                        GROUP BY 
                            CASE 
                                WHEN tp.id IS NOT NULL THEN tp.id
                                ELSE p.id
                            END";
                            $result = $conn->query($query);

                            while ($row = $result->fetch_assoc()) {
                              $additional_images = !empty($row['additional_images']) ? explode(',', $row['additional_images']) : [];
                              $all_images = array_merge([$row['image_name_location']], $additional_images);
                              $images_json = json_encode($additional_images);
                              
                              // Check if it's a temporary package
                              $is_temporary = strpos($row['unique_id'], 'temp_') === 0;
                              $package_class = $is_temporary ? 'package-card temporary-package' : 'package-card';

                              echo '<div class="' . $package_class . '" data-package-id="' . $row['unique_id'] . '">
                              <input type="radio" name="selected_package" value="' . $row['unique_id'] . '" class="package-radio" style="display: none;">
                              <img src="' . htmlspecialchars($row['image_name_location']) . '" 
                                  alt="' . htmlspecialchars($row['package_name']) . '"
                                  class="img-fluid package-image"
                                  data-toggle="modal"
                                  data-target="#packageModal"
                                  data-package-name="' . htmlspecialchars($row['package_name']) . '"
                                  data-package-price="' . htmlspecialchars($row['price']) . '"
                                  data-package-desc="' . htmlspecialchars($row['description']) . '"
                                  data-package-images=\'' . $images_json . '\'>
                              <h6 class="mt-0 mb-2">' . '<br>'. htmlspecialchars($row['package_name']) . '</h6>
                              <div class="price">₱' . htmlspecialchars($row['price']) . '</div>
                              ' . ($is_temporary ? '<span class="temporary-badge">Limited Time Only!</span>' : '') . '
                          </div>';
                            }
                            ?>
                          </div>
        </div>
      </div>

      <!-- Step 2: Date and Studio -->
      <div class="booking-step" id="step2" style="opacity: 0.5; pointer-events: none;">
        <h3>Step 2: Select Date and Studio</h3>
        <div class="row form-group">
          <div class="col-md-12">
            <label for="booking_date">Date</label> 
            <input type="date" id="booking_date" name="booking_date" class="form-control" required disabled>
          </div>
          <div class="col-md-12">
            <label for="studio">Select Studio</label> 
            <select id="studio" name="studio" class="form-control" required disabled>
              <option value="" disabled selected>Select Studio</option>
              <option value="1">Studio 1 (8-20 pax) -- 1st Branch</option>
              <option value="2">Studio 2 (2-5 pax) -- 1st Branch</option>
              <option value="3">Studio 3 (5-10 pax) -- 2nd Branch</option>
              <option value="4" disabled>Studio 4 Currently Unavailable</option>
              <option value="5">Studio 5 (8-20 pax) -- 2nd Branch</option>
            </select>
            <br>
            <button type="button" id="mainBranchBtn" class="btn btn-sm" style="background-color: black; color: white;" onclick="window.open('https://www.google.com/maps/place/Dos+Studios+Self-Shoot+Photography+Manila/@14.6009346,120.9906249,20.5z/data=!4m14!1m7!3m6!1s0x3397c90d8f3b25cb:0x2739653551e99d20!2sDos+Studios+U-Belt!8m2!3d14.6019959!4d120.9879866!16s%2Fg%2F11wqh5p_db!3m5!1s0x8d9ce4ff4ccc554f:0x9f6f3c1fb40bf729!8m2!3d14.6010554!4d120.9906344!16s%2Fg%2F11twyk_0gm?entry=ttu&g_ep=EgoyMDI0MTIxMC4wIKXMDSoASAFQAw%3D%3D', '_blank')">
                <i class="fa fa-map-marker-alt" style="color: white;"></i> &nbsp; 1st Branch
              </button>
              <button type="button" id="subBranchBtn" class="btn btn-sm ml-2" style="background-color: black; color: white;" onclick="window.open('https://www.google.com/maps/place/Dos+Studios+U-Belt/@14.602005,120.9874763,19z/data=!4m6!3m5!1s0x3397c90d8f3b25cb:0x2739653551e99d20!8m2!3d14.6019959!4d120.9879866!16s%2Fg%2F11wqh5p_db?entry=ttu&g_ep=EgoyMDI0MTIxMC4wIKXMDSoASAFQAw%3D%3D', '_blank')">
                <i class="fa fa-map-marker-alt" style ="color: white;"></i> &nbsp;2nd Branch
            </button>
          </div>
        </div>
      </div>

      <!-- Step 3: Time Frame -->
      <div class="booking-step" id="step3" style="opacity: 0.5; pointer-events: none;">
        <h3>Step 3: Select Time Frame</h3>
        <div class="col-md-12">
          <label for="booking_time">Select a Time Frame</label> 
          <select id="booking_time" name="booking_time" class="form-control" required disabled>
            <option value="" disabled selected>Time Frame</option>
          </select>
        </div>
      </div>

      <!-- Step 4: Personal Information -->
      <div class="booking-step" id="step4" style="opacity: 0.5; pointer-events: none;">
        <h3>Step 4: Personal Information</h3>
        <div class="row form-group">
          <div class="col-md-6">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" class="form-control" required disabled>
          </div>
          <div class="col-md-6">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" class="form-control" required disabled>
          </div>
          <div class="col-md-12">
            <label for="email">Email</label> 
            <input type="email" id="email" name="email" class="form-control" required disabled>
          </div>
          <div class="col-md-12">
            <label for="comments">Comments (Optional)</label>
            <textarea id="comments" name="comments" class="form-control" rows="3" placeholder="Add any special requests or notes here" disabled></textarea>
          </div>
        </div>
      </div>
            <!-- Step 5: Submit -->
      <div class="booking-step" id="step5" style="opacity: 0.5; pointer-events: none;">
        <h3>Step 5: Confirm Booking</h3>
        <div class="row form-group">
          <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-success btn-lg">Confirm Booking</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
            <!-- Package Modal -->
            <div class="modal fade" id="packageModal" tabindex="-1" role="dialog" aria-labelledby="packageModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="packageModalLabel">Package Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <!-- Left side - Package Description -->
                      <div class="col-md-6">
                        <h3 class="package-name" style="text-align: center;"></h3>
                        <div class="package-description"></div>
                        <div class="package-price mt-3" style="text-align: center;"></div>
                      </div>
                      
                      <!-- Right side - Image Slideshow -->
                      <div class="col-md-6">
                        <div class="slideshow-container">
                          <div class="slideshow-images">
                            <!-- Images will be inserted here via JavaScript -->
                          </div>
                          <button type = "button" class="prev-btn">❮</button>
                          <button type = "button" class="next-btn">❯</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="selectPackageBtn">Select Package</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal fade" id="bookingsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Booked Schedules <span id="selectedDate"></span></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="bookingsList"></div>
            </div>
        </div>
    </div>
</div>


        <!-- Hidden input to store selected package -->
        <input type="hidden" id="selectedPackage" name="selected_package" value="">


                  <!-- Total Price Display -->

        <input type="hidden" id="hiddenTotalPrice" name="total_price">
        <input type="hidden" id="hiddenpackagelist" name="package_list" value="">
        <input type="hidden" id="selected_time_slot" name="booking_time" value="">
        <input type="hidden" id="selected_time_display" name="booking_time_display" value="">
    </div>
                          </form>
                      <!-- <div class="row form-group">
                        <div class="col-md-12">
                          <label for="subject">Subject</label> 
                          <input type="text" id="subject" name="subject" class="form-control" required>
                        </div>
                      </div>

                      <div class="row form-group mb-5">
                        <div class="col-md-12">
                          <label for="message">Message</label> 
                          <textarea name="message" id="message" cols="30" rows="7" class="form-control" required></textarea>
                        </div>
                      </div> -->


                    


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

<!-- Page specific script -->


<?php


// Get current date to only fetch future bookings
$current_date = date('Y-m-d');

// Prepare query to fetch future bookings along with the studio column
$query = "SELECT s.booking_date, s.booking_time, s.time_range, s.studio, p.duration 
          FROM sales s 
          LEFT JOIN packages p ON FIND_IN_SET(p.package_name, REPLACE(s.package_list, '|', ','))
          LEFT JOIN queue q ON s.queue_id = q.queue_id
          WHERE s.booking_date >= ? AND (q.status IS NULL OR q.status != 'Cancelled')";

// Prepare and execute the statement
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $current_date);
$stmt->execute();
$result = $stmt->get_result();

// Get dynamic time slot
$timeSlots = getTimeSlots();
$time_slots = [];
foreach ($timeSlots as $key => $slot) {
    $time_slots[$key] = $slot['display'];
}

// Create an array to store the events
$events = [];

while ($row = $result->fetch_assoc()) {
    $date = $row['booking_date'];
    $time_range = $row['time_range'] ?? 'Reserved';
    $studio = $row['studio'];
    $duration = $row['duration'] ?: 15;


    // Determine color based on studio value
    if ($studio == 1) {
        $color = '#FFD700'; // Yellow
    } elseif ($studio == 2) {
        $color = '#FFA500'; // Orange
    } else {
        $color = '#f56954'; // Default color (red) for any other value
    }

    // Prepare data for the calendar event
    $events[] = [
        'title' => $time_range . '(Reserved)',
        'start' => $date,
        'backgroundColor' => $color,
        'borderColor' => $color,
        'allDay' => true
    ];
}
// Then modify the closing part (around line 650-653):
  if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>

<!-- JavaScript -->
<script src="plugins/jquery/jquery.min.js"></script>
<script>
$(document).ready(function() {
    let selectedDuration = 15;
    
    // When a package is selected
    $('.package-card').click(function() {
        const packageId = $(this).data('package-id');
        $.ajax({
            url: 'get_package_duration.php',
            type: 'POST',
            data: { package_id: packageId },
            success: function(response) {
                const data = JSON.parse(response);
                selectedDuration = data.duration;
                checkAvailability();
            }
        });
    });

    // When date changes
    $('#booking_date').change(function() {
        checkAvailability();
    });
    
    function checkAvailability() {
    const selectedDate = $('#booking_date').val();
    const selectedStudio = $('#studio').val();
    
    if (selectedDate && selectedStudio) {
        $.ajax({
            url: 'check_availability.php',
            type: 'POST',
            data: { 
                date: selectedDate,
                duration: selectedDuration,
                studio: selectedStudio
            },
            dataType: 'json',
            success: function(response) {
                const selectElement = $('#booking_time');
                selectElement.empty();
                selectElement.append('<option value="" disabled selected>Time Frame</option>');
                
                // Only show available time slots
                Object.entries(response.available_slots).forEach(([key, slot]) => {
                    selectElement.append(`<option value="${key}">${slot.display}</option>`);
                  });
              }
          });
      }
  }

    // Trigger checkAvailability when either date or studio changes
    $('#booking_date, #studio').change(function() {
        checkAvailability();
    });
});
</script>


<script>
  

  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (https://fullcalendar.io/docs/event-object)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
      itemSelector: '.external-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText,
          backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
        };
      }

    });
    function countBookingsForDate(date, events) {
    const formattedDate = date.toISOString().split('T')[0]; // Convert to YYYY-MM-DD
    return events.filter(event => {
        const eventDate = event.start.toString().split('T')[0]; // Handle both Date and string formats
        return eventDate === formattedDate;
    }).length;
}

    var calendar = new Calendar(calendarEl, {
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth'
    },
    height: 500,
    initialView: 'dayGridMonth',
    themeSystem: 'bootstrap',
    validRange: {
        start: new Date() // Disables all dates before today
    },
    dateClick: function(info) {
        // Fetch bookings for the clicked date
        $.ajax({
            url: 'get_bookings.php',
            type: 'POST',
            data: {
                date: info.dateStr
            },
            success: function(response) {
                $('#bookingsList').html(response);
                $('#bookingsModal').modal('show');
            }
        });
    },
    dayCellDidMount: function(arg) {
        // Color coding based on number of bookings
        let bookingsCount = countBookingsForDate(arg.date, calendar.getEvents());
        if (bookingsCount > 5) {
            arg.el.style.backgroundColor = 'rgba(0, 100, 0, 0.2)'; // Red for many bookings
        } else if (bookingsCount > 2) {
            arg.el.style.backgroundColor = 'rgba(34, 139, 34, 0.2)'; // Yellow for moderate
        } else {
            arg.el.style.backgroundColor = 'rgba(144, 238, 144, 0.2)'; // Green for few/no bookings
        }
    }
});

    calendar.render();
    // $('#calendar').fullCalendar()

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    // Color chooser button
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      // Save color
      currColor = $(this).css('color')
      // Add color effect to button
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color'    : currColor
      })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      // Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      // Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.text(val)
      $('#external-events').prepend(event)

      // Add draggable funtionality
      ini_events(event)

      // Remove event from text input
      $('#new-event').val('')
    })
  })
</script>

<script>
$(document).ready(function() {
    // Handle package card click
    $('.package-card').click(function() {
        // Remove selection from all packages
        $('.package-card').removeClass('selected');
        $('.package-radio').prop('checked', false);
        
        // Add selection to clicked package
        $(this).addClass('selected');
        $(this).find('.package-radio').prop('checked', true);
        
        // Update hidden fields
        const packageId = $(this).data('package-id');
        const packageName = $(this).find('h6').text();
        const packagePrice = $(this).find('.price').text().replace('₱', '');
        
        $('#hiddenTotalPrice').val(packagePrice);
        $('#hiddenpackagelist').val(packageName);
    });

    // Form submission validation
    $('#packageForm').submit(function(e) {
        if (!$('.package-radio:checked').length) {
            e.preventDefault();
            alert('Please select a package before proceeding.');
        }
    });
});
</script>

<script>
    function changeValue(input, delta) {
        const newValue = Math.max(0, parseInt(input.value) + delta);
        input.value = newValue;
        
        // Get package price from data attribute
        const price = parseFloat(input.dataset.price);
        const packageName = input.dataset.name;
        
        // Update total price
        const totalPrice = price * newValue;
        $('#hiddenTotalPrice').val(totalPrice);
        if($('#txtTotalPrice').length) {
            $('#txtTotalPrice').val(totalPrice.toFixed(2));
        }
        
        // Update package list
        if(newValue > 0) {
            $('#hiddenpackagelist').val(packageName);
        } else {
            $('#hiddenpackagelist').val('');
        }
    }

    function updateTotalPrice() {
        let totalPrice = 0;

        document.querySelectorAll('.package-quantity').forEach(input => {
            const quantity = parseInt(input.value);
            const price = parseFloat(input.dataset.price);

            totalPrice += price * quantity;
        });

        // Update both visible and hidden total price fields
        document.getElementById('txtTotalPrice').value = totalPrice.toFixed(2);
        document.getElementById('hiddenTotalPrice').value = totalPrice.toFixed(2);
    }

    // Automatically update hidden total price field before submitting
    function updateHiddenTotalPrice() {
        document.getElementById('hiddenTotalPrice').value = document.getElementById('txtTotalPrice').value;
    }

    // Event listeners to update the price
    document.querySelectorAll('.package-quantity').forEach(input => {
        input.addEventListener('input', updateTotalPrice);
    });
    function updateHiddenPackageList() {
    const packageList = [];
    
    // Loop through each package and get its name if the quantity is more than 0
    document.querySelectorAll('.package-quantity').forEach((input) => {
        const quantity = parseInt(input.value);
        if (quantity > 0) {
            const packageName = input.closest('div').previousElementSibling.querySelector('h2').dataset.packageName;
            packageList.push(`${packageName} x ${quantity}`);
        }
    });

    // Join the package names with '|'
    document.getElementById('hiddenpackagelist').value = packageList.join(' | ');
}
function updatePackageList() {
    // Get all package quantity inputs
    const quantityInputs = document.querySelectorAll('.package-quantity');
    let packageList = [];

    quantityInputs.forEach(input => {
        // Get the current value and check if it's greater than 0
        const quantity = parseInt(input.value, 10);
        if (quantity > 0) {
            // Get the corresponding package name and add it to the list
            const packageName = input.getAttribute('data-name');
            packageList.push(packageName);
        }
    });

    // Concatenate package names with '|'
    const concatenatedPackages = packageList.join(' | ');

    // Set the value of the hidden input
    document.getElementById('hiddenpackagelist').value = concatenatedPackages;
}

// Add event listener to all quantity inputs to call updatePackageList when they change
document.querySelectorAll('.package-quantity').forEach(input => {
    input.addEventListener('input', updatePackageList);
  });
   
    // Initialize the total price on page load
    updateTotalPrice();

</script>

<script>

$(document).ready(function() {
    let currentSlide = 0;
    let currentImages = [];
    let currentPackageId = null;

    $('.package-card').click(function() {
        // Remove selection from all packages
        $('.package-card').removeClass('selected');
        $('.package-radio').prop('checked', false);
        
        // Add selection to clicked package
        $(this).addClass('selected');
        $(this).find('.package-radio').prop('checked', true);
        
        // Get package details from data attributes
        const packageName = $(this).find('h6').text().trim();
        const packagePrice = $(this).find('img').data('package-price');
        const currentQuantity = parseInt($('.package-quantity[data-name="' + packageName + '"]').val()) || 0;
        
        // Calculate total price based on quantity
        const totalPrice = packagePrice * Math.max(0, currentQuantity);
        
        // Update hidden fields
        $('#hiddenTotalPrice').val(totalPrice);
        $('#hiddenpackagelist').val(packageName);
        
        // Update visible total price if it exists
        if($('#txtTotalPrice').length) {
            $('#txtTotalPrice').val(totalPrice.toFixed(2));
        }
    });

    // Handle modal display
    $('#packageModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const packageName = button.data('package-name');
        const packagePrice = button.data('package-price');
        const packageDesc = button.data('package-desc');
        const packageImages = button.data('package-images');
        currentPackageId = button.closest('.package-card').data('package-id');
        
        // Reset current slide
        currentSlide = 0;
        currentImages = packageImages;
        
        const modal = $(this);
        modal.find('.package-name').text(packageName);
        
        // Clean up the description text
        const cleanDesc = packageDesc
            .split('\n')
            .map(line => line.trim())
            .filter(line => line !== '')
            .map(line => `• ${line}`)
            .join('<br>');
        
        modal.find('.package-description').html(cleanDesc);
        modal.find('.package-price').text('₱' + packagePrice);
        
        // Load images into slideshow
        const slideshowContainer = modal.find('.slideshow-images');
        slideshowContainer.empty();
        if (Array.isArray(currentImages)) {
            currentImages.forEach((img, index) => {
                slideshowContainer.append(`<img src="${img}" style="display: ${index === 0 ? 'block' : 'none'}">`);
            });
        }
    });

    // Handle select package button click
    $('#selectPackageBtn').click(function() {
        const packageCard = $(`.package-card[data-package-id="${currentPackageId}"]`);
        packageCard.click();
        $('#packageModal').modal('hide');
    });

    // Previous/Next button handlers
    $('.prev-btn').click(function() {
        if (currentImages.length > 0) {
            currentSlide = (currentSlide - 1 + currentImages.length) % currentImages.length;
            updateSlideshow();
        }
    });

    $('.next-btn').click(function() {
        if (currentImages.length > 0) {
            currentSlide = (currentSlide + 1) % currentImages.length;
            updateSlideshow();
        }
    });

    function updateSlideshow() {
        $('.slideshow-images img').hide();
        $($('.slideshow-images img')[currentSlide]).show();
    }

    // Form submission validation
    $('#packageForm').submit(function(e) {
        if (!$('.package-radio:checked').length) {
            e.preventDefault();
            alert('Please select a package before proceeding.');
        }
    });
});
</script>

<script>
    $(document).ready(function() {
      // Form submission validation
      $('#packageForm').submit(function(e) {
          // Check if a package card is selected
          const selectedPackage = $('.package-card.selected').length;
          const hiddenPrice = $('#hiddenTotalPrice').val();
          const hiddenPackageList = $('#hiddenpackagelist').val();
          
          if (!selectedPackage || !hiddenPrice || !hiddenPackageList) {
              e.preventDefault();
              alert('Please select a package before proceeding.');
              return false;
          }
          return true;
      });

      // Package card click handler
      $('.package-card').click(function() {
          // Remove selection from all packages
          $('.package-card').removeClass('selected');
          
          // Add selection to clicked package
          $(this).addClass('selected');
          
          // Get package details
          const packageName = $(this).find('h6').text().trim();
          const packagePrice = $(this).find('img').data('package-price');
          
          // Update hidden fields
          $('#hiddenTotalPrice').val(packagePrice);
          $('#hiddenpackagelist').val(packageName);
          
          // Make sure radio is selected
          $(this).find('.package-radio').prop('checked', true);
      });
  });
</script>

<script>
$(document).ready(function() {
    // When a package is clicked
    $('.package-card').click(function() {
        const packageId = $(this).data('package-id');
        console.log('Selected package:', packageId); // Debug log
        
        // Fetch package duration and update time slots
        $.ajax({
            url: 'get_package_duration.php',
            type: 'POST',
            data: { package_id: packageId },
            success: function(response) {
                console.log('Duration response:', response); // Debug log
                const data = JSON.parse(response);
                updateTimeSlots(data.duration);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Debug log
            }
        });
    });
});

function updateTimeSlots(duration) {
    console.log('Updating time slots with duration:', duration); // Debug log
    $.ajax({
        url: 'get_time_slots.php',
        type: 'POST',
        data: { duration: duration },
        success: function(response) {
            console.log('Time slots response:', response); // Debug log
            const timeSlots = JSON.parse(response);
            const selectElement = $('#booking_time');
            selectElement.empty();
            selectElement.append('<option value="" disabled selected>Time Frame</option>');
            
            Object.entries(timeSlots).forEach(([key, slot]) => {
                selectElement.append(`<option value="${key}">${slot.display}</option>`);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error:', error); // Debug log
        }
    });
} 
</script>

<script>
      $(document).ready(function() {
    // Step 1: Package Selection
    $('.package-card').click(function() {
        // Reset all subsequent steps
        $('#step2, #step3, #step4, #step5').removeClass('active').css({
            'opacity': '0.5',
            'pointer-events': 'none'
        });
        
        // Reset all form inputs in subsequent steps
        $('#booking_date, #studio, #booking_time, #fname, #lname, #email, #comments').val('').prop('disabled', true);

        // Enable Step 2 after package selection
        $('#step2').css({
        'opacity': '1',
        'pointer-events': 'auto'
        });
        $('#booking_date, #studio').prop('disabled', false);
    });

  // Step 2: Date and Studio Selection
  $('#booking_date, #studio').change(function() {
      if ($('#booking_date').val() && $('#studio').val()) {
          // Reset subsequent steps
          $('#step3, #step4, #step5').removeClass('active').css({
              'opacity': '0.5',
              'pointer-events': 'none'
          });
          
          // Reset form inputs in subsequent steps
          $('#booking_time, #fname, #lname, #email, #comments').val('').prop('disabled', true);
          
          // Enable Step 3
          $('#step3').css({
              'opacity': '1',
              'pointer-events': 'auto'
          });
          $('#booking_time').prop('disabled', false);
          checkAvailability();
      }
    });

  $('#booking_time').change(function() {
    if ($(this).val()) {
        // Get the selected time slot's display text
        const selectedDisplay = $(this).find('option:selected').text();
        
        // Store both the slot number and display text in hidden fields
        $('#selected_time_slot').val($(this).val());
        $('#selected_time_display').val(selectedDisplay);
        
        // Reset subsequent steps
        $('#step4, #step5').removeClass('active').css({
            'opacity': '0.5',
            'pointer-events': 'none'
        });
        
        // Reset form inputs in subsequent steps
        $('#fname, #lname, #email, #comments').val('').prop('disabled', true);
        
        // Enable Step 4
        $('#step4').css({
            'opacity': '1',
            'pointer-events': 'auto'
        });
        $('#fname, #lname, #email, #comments').prop('disabled', false);
    }
  });

  // Step 4: Personal Information
  $('#fname, #lname, #email').on('input', function() {
      if ($('#fname').val() && $('#lname').val() && $('#email').val()) {
          // Enable Step 5
          $('#step5').css({
              'opacity': '1',
              'pointer-events': 'auto'
          });
          $('button[type="submit"]').prop('disabled', false);
      } else {
          // Disable Step 5
          $('#step5').css({
              'opacity': '0.5',
              'pointer-events': 'none'
          });
          $('button[type="submit"]').prop('disabled', true);
      }
  });
});
</script>

<script>

document.addEventListener('DOMContentLoaded', function() {
    // Get today's date in YYYY-MM-DD format
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    let yyyy = today.getFullYear();
    let currentDate = yyyy + '-' + mm + '-' + dd;

    // Set the minimum date to today
    document.getElementById('booking_date').setAttribute('min', currentDate);
});

</script>





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
  

  <script src="js/jquery.fancybox.min.js"></script>

  <script src="js/main.js"></script>
</body>
</html>
