<!-- /*
* Template Name: Snap
* Template Author: Untree.co
* Tempalte URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<?php

$order_success = isset($_GET['order_success']) && $_GET['order_success'] === 'true';
?>



<!doctype html>
<html lang="en">
<head>
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








  <title>dos studios.</title>


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
    <main class="main-content">
  <!-- Main content -->
  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="sticky-top mb-3">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Draggable Events</h4>
                </div>
                <div class="card-body">
                  <!-- the events -->
                  <div id="external-events">
                    <div class="external-event bg-success">Lunch</div>
                    <div class="external-event bg-warning">Go home</div>
                    <div class="external-event bg-info">Do homework</div>
                    <div class="external-event bg-primary">Work on UI design</div>
                    <div class="external-event bg-danger">Sleep tight</div>

                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Create Event</h3>
                </div>
                <div class="card-body">
                  <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                    <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                    </ul>
                  </div>
                  <!-- /btn-group -->
                  <div class="input-group">
                    <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                    <div class="input-group-append">
                      <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                    </div>
                    <!-- /btn-group -->
                  </div>
                  <!-- /input-group -->
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary">
              <div class="card-body p-0">
                <!-- THE CALENDAR -->


              
                <div id="calendar"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
        <section class="site-section" id="section-contact">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-8">
                <h2 class=" mb-5 heading">Reserve now</h2>
                    <form action="submit.php" method="POST">
                      <div class="row form-group">
                        <div class="col-md-6 mb-3 mb-md-0">
                          <label for="fname">First Name</label>
                          <input type="text" id="fname" name="fname" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                          <label for="lname">Last Name</label>
                          <input type="text" id="lname" name="lname" class="form-control" required>
                        </div>
                      </div>

                      <div class="row form-group">
                        <div class="col-md-12">
                          <label for="email">Email</label> 
                          <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-12">
                          <label for="email">Date</label> 
                          <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                      </div>
                  <!-- package photo -->
                  <!-- <div class="col-md-12 mb-4" data-aos="fade-up">
                    <div class="d-md-flex d-block blog-entry align-items-start">
                      <div class="mr-0 mr-md-5 mb-3 img-wrap"> 
                        <a href="[image_name_loc]" class="d-block photo-item" data-fancybox="package">
                          <img src="[image_name_loc]" alt="Image" class="img-fluid mb-0">
                        </a>
                      </div>
                      <div>
                        <h2 class="mt-0 mb-2">[Package Name]</h2>
                        <div class="meta mb-3">[Package Price]</div>
                        <div class="meta mb-3">[Package Description]</div>

                        <button onclick="changeValue(this.nextElementSibling, -1)">-</button>
                        <input type="number" value="1" min="1">
                        <button onclick="changeValue(this.previousElementSibling, 1)">+</button>
                      </div>
                    </div>
                  </div> -->
                  <?php
                  include 'admin/controls/conn.php';
                  $query = "SELECT id, image_name_location, price, package_name, description FROM packages";
                  $result = $conn->query($query);

                  while ($row = $result->fetch_assoc()) {
                      echo '<div class="col-md-12 mb-4" data-aos="fade-up">
                              <div class="d-md-flex d-block blog-entry align-items-start">
                                  <div class="mr-0 mr-md-5 mb-3 img-wrap"> 
                                      <a href="' . htmlspecialchars($row['image_name_location']) . '" class="d-block photo-item" data-fancybox="package">
                                          <img src="' . htmlspecialchars($row['image_name_location']) . '" alt="Image" class="img-fluid mb-0">
                                      </a>
                                  </div>
                                  <div>
                                      <h2 class="mt-0 mb-2" data-package-name="' . htmlspecialchars($row['package_name']) . '">' . htmlspecialchars($row['package_name']) . '</h2>
                                      <div class="meta mb-3">P' . htmlspecialchars($row['price']) . '</div>
                                      <div class="meta mb-3">' . htmlspecialchars($row['description']) . '</div>

                                      <button type="button" onclick="changeValue(this.nextElementSibling, -1)"style="background-color: transparent; border: none; color: inherit; font-size: inherit;">-</button>
                                      <input type="text" value="0" min="0" class="package-quantity" data-id="' . $row['id'] . '" data-price="' . $row['price'] . '" data-name="' . htmlspecialchars($row['package_name']) . '" style="background-color: transparent; border: none; outline: none; color: inherit; font-size: inherit; width: 50px; text-align: center;" oninput="this.value = this.value.replace(/[^0-9]/g, \'\');">
                                      <button type="button" onclick="changeValue(this.previousElementSibling, 1)"style="background-color: transparent; border: none; color: inherit; font-size: inherit;" >+</button>
                                  </div>
                              </div>
                          </div>';
                  }

                  $conn->close();
                  ?>

                  <!-- Total Price Display -->
                  <div>
                  Total Price: P<input type="number" id="txtTotalPrice" readonly value="0" style="background-color: transparent; border: none; outline: none; color: inherit; font-size: inherit;">

        <input type="hidden" id="hiddenTotalPrice" name="total_price">
        <input type="hidden" id="hiddenpackagelist" name="package_list" value="">
    </div>




    

  

                      


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

                      <div class="row form-group">
                        <div class="col-md-12">
                          <input type="submit" value="Submit" class="btn btn-primary btn-md">
                        </div>
                      </div>
                    </form>
                    


              </div>
            </div>
          </div>
        </section>

        <div class="row justify-content-center">
          <div class="col-md-12 text-center py-5">
            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a> Distributed By <a href="https://themewagon.com">ThemeWagon</a><!-- License information: https://untree.co/license/ -->
            </p>
          </div>
        </div>
      </div>
    </main>

  </div> <!-- .site-wrap -->


<!-- fullCalendar 2.2.5 -->
<script src="admin/plugins/moment/moment.min.js"></script>
<script src="admin/plugins/fullcalendar/main.js"></script>
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

    var calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      themeSystem: 'bootstrap',
      //Random default events
      events: [
        {
          title          : 'All Day Event',
          start          : new Date(y, m, 1),
          backgroundColor: '#f56954', //red
          borderColor    : '#f56954', //red
          allDay         : true
        },
        {
          title          : 'Long Event',
          start          : new Date(y, m, d - 5),
          end            : new Date(y, m, d - 2),
          backgroundColor: '#f39c12', //yellow
          borderColor    : '#f39c12' //yellow
        },
        {
          title          : 'Meeting',
          start          : new Date(y, m, d, 10, 30),
          allDay         : false,
          backgroundColor: '#0073b7', //Blue
          borderColor    : '#0073b7' //Blue
        },
        {
          title          : 'Lunch',
          start          : new Date(y, m, d, 12, 0),
          end            : new Date(y, m, d, 14, 0),
          allDay         : false,
          backgroundColor: '#00c0ef', //Info (aqua)
          borderColor    : '#00c0ef' //Info (aqua)
        },
        {
          title          : 'Birthday Party',
          start          : new Date(y, m, d + 1, 19, 0),
          end            : new Date(y, m, d + 1, 22, 30),
          allDay         : false,
          backgroundColor: '#00a65a', //Success (green)
          borderColor    : '#00a65a' //Success (green)
        },
        {
          title          : 'Click for Google',
          start          : new Date(y, m, 28),
          end            : new Date(y, m, 29),
          url            : 'https://www.google.com/',
          backgroundColor: '#3c8dbc', //Primary (light-blue)
          borderColor    : '#3c8dbc' //Primary (light-blue)
        }
      ],
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function(info) {
        // is the "remove after drop" checkbox checked?
        if (checkbox.checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
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

    <!-- Include Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize the calendar here if using a calendar library
            // $('#calendar').fullCalendar(); // Example for FullCalendar
        });
    </script>














  <script>
    function changeValue(input, delta) {
        input.value = Math.max(0, parseInt(input.value) + delta);
        updateTotalPrice();
        updatePackageList();
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

  

  <script src="js/jquery.fancybox.min.js"></script>

  <script src="js/main.js"></script>
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
  

  <script src="js/jquery.fancybox.min.js"></script>

  <script src="js/main.js"></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  </body>
</html>
