<?php
// Start the session
session_start(); 
include 'controls/conn.php';
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Optionally, retrieve additional user information from the database
// For example, fetching the user's full name, email, etc.
?>
<!DOCTYPE html>
<!-- 
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>dos studios.</title>

  <!-- Google Font: Source Sans Pro -->


 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
 <!-- DataTables -->
 <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">




      <?php include 'sideboard.php'?>


          <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Customer's Table</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Customer's Table</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->
      

 



<!-- Main content -->
<section class="content">
      <div class="container-fluid">



        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" id="globalSearch" class="form-control" placeholder="Search bookings by name...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">For-Checking</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                      <thead>
                          <tr>
                              <th>Queue ID</th>
                              <th>Name</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          // Fetch data from the 'queue' table
                          $query = "SELECT queue_id, name, status FROM queue where status = 'For-Checking' ";
                          $result = $conn->query($query);
                          if ($result && $result->num_rows > 0){
                          while ($row = $result->fetch_assoc()) {
                              echo "<tr>";
                              echo "<td><a href='#' data-toggle='modal' data-target='#detailsModal' data-id='" . htmlspecialchars($row['queue_id']) . "'>OR" . htmlspecialchars($row['queue_id']) . "</a></td>";
                              echo "<td>" . htmlspecialchars($row['name']) . "</td>";

                              // Determine the class for the status badge
                              $badgeClass = '';
                              switch ($row['status']) {
                                  case 'Done':
                                      $badgeClass = 'success';
                                      break;
                                  case 'Queue':
                                      $badgeClass = 'warning';
                                      break;
                                  case 'Cancelled':
                                      $badgeClass = 'danger';
                                      break;
                                  case 'On-Going':
                                      $badgeClass = 'info';
                                      break;
                              }

                              echo "<td><span class='badge badge-primary'>" . htmlspecialchars($row['status']) . "</span></td>";
                              echo "<td>";
                              echo "<span class='badge badge-success'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Done'style='color: black;'>Done</a></span> ";
                              echo "<span class='badge badge-warning'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Queue'style='color: black;'>Queue</a></span> ";
                              echo "<span class='badge badge-danger'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Cancelled'style='color: black;'>Cancelled</a></span> ";
                              echo "<span class='badge badge-info'><a href='update_status.php?id=" . $row['queue_id'] . "&status=On-Going'style='color: black;'>On-Going</a></span>";
                              echo "</td>";
                              echo "</tr>";
                          }
                        }
                          else{
                            echo "<td>No Data</td>";
                          }
                          ?>
                      </tbody>
                  </table>


                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                
                
              </div>
              <!-- /.card-footer -->
            </div>    
    </section>
    <!-- Done table --> 
    <section class="content">
      <div class="container-fluid">



            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Done</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                      <thead>
                          <tr>
                              <th>Queue ID</th>
                              <th>Name</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          // Fetch data from the 'queue' table
                          $query = "SELECT queue_id, name, status FROM queue where status = 'Done' ";
                          $result = $conn->query($query);
                          if ($result && $result->num_rows > 0){
                          while ($row = $result->fetch_assoc()) {
                              echo "<tr>";
                              echo "<td><a href='#' data-toggle='modal' data-target='#detailsModal' data-id='" . htmlspecialchars($row['queue_id']) . "'>OR" . htmlspecialchars($row['queue_id']) . "</a></td>";
                              echo "<td>" . htmlspecialchars($row['name']) . "</td>";

                              // Determine the class for the status badge
                              $badgeClass = '';
                              switch ($row['status']) {
                                  case 'Done':
                                      $badgeClass = 'success';
                                      break;
                                  case 'Queue':
                                      $badgeClass = 'warning';
                                      break;
                                  case 'Cancelled':
                                      $badgeClass = 'danger';
                                      break;
                                  case 'On-Going':
                                      $badgeClass = 'info';
                                      break;
                              }

                              echo "<td><span class='badge badge-{$badgeClass}'>" . htmlspecialchars($row['status']) . "</span></td>";
                              echo "<td>";
                              echo "<span class='badge badge-success'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Done'style='color: black;'>Done</a></span> ";
                              echo "<span class='badge badge-warning'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Queue'style='color: black;'>Queue</a></span> ";
                              echo "<span class='badge badge-danger'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Cancelled'style='color: black;'>Cancelled</a></span> ";
                              echo "<span class='badge badge-info'><a href='update_status.php?id=" . $row['queue_id'] . "&status=On-Going'style='color: black;'>On-Going</a></span>";
                              echo "</td>";
                              echo "</tr>";
                          }
                        }
                          else{
                            echo "<td>No Data</td>";
                          }
                          ?>
                      </tbody>
                  </table>


                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                
                
              </div>
              <!-- /.card-footer -->
            </div>    
    </section>
    <!-- /.table -->  
    <!-- Cancelled table --> 
    <section class="content">
      <div class="container-fluid">



            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Cancelled</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                      <thead>
                          <tr>
                              <th>Queue ID</th>
                              <th>Name</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                          // Fetch data from the 'queue' table
                          $query = "SELECT queue_id, name, status FROM queue where status = 'Cancelled' ";
                          $result = $conn->query($query);
                          if ($result && $result->num_rows > 0){
                          while ($row = $result->fetch_assoc()) {
                              echo "<tr>";
                              echo "<td><a href='#' data-toggle='modal' data-target='#detailsModal' data-id='" . htmlspecialchars($row['queue_id']) . "'>OR" . htmlspecialchars($row['queue_id']) . "</a></td>";
                              echo "<td>" . htmlspecialchars($row['name']) . "</td>";

                              // Determine the class for the status badge
                              $badgeClass = '';
                              switch ($row['status']) {
                                  case 'Done':
                                      $badgeClass = 'success';
                                      break;
                                  case 'Queue':
                                      $badgeClass = 'warning';
                                      break;
                                  case 'Cancelled':
                                      $badgeClass = 'danger';
                                      break;
                                  case 'On-Going':
                                      $badgeClass = 'info';
                                      break;
                              }

                              echo "<td><span class='badge badge-{$badgeClass}'>" . htmlspecialchars($row['status']) . "</span></td>";
                              echo "<td>";
                              echo "<span class='badge badge-success'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Done'style='color: black;'>Done</a></span> ";
                              echo "<span class='badge badge-warning'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Queue'style='color: black;'>Queue</a></span> ";
                              echo "<span class='badge badge-danger'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Cancelled'style='color: black;'>Cancelled</a></span> ";
                              echo "<span class='badge badge-info'><a href='update_status.php?id=" . $row['queue_id'] . "&status=On-Going'style='color: black;'>On-Going</a></span>";
                              echo "</td>";
                              echo "</tr>";
                          }
                        }
                          else{
                            echo "<td>No Data</td>";
                          }
                          ?>
                      </tbody>
                  </table>


                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                
                
              </div>
              <!-- /.card-footer -->
            </div>    
    </section>
    <!-- /.table -->                     
    <!-- Queue table --> 
    <section class="content">
      <div class="container-fluid">



            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Queue</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                      <thead>
                          <tr>
                              <th>Queue ID</th>
                              <th>Name</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                          // Fetch data from the 'queue' table
                          $query = "SELECT queue_id, name, status FROM queue where status = 'Queue' ";
                          $result = $conn->query($query);
                          if ($result && $result->num_rows > 0){
                          while ($row = $result->fetch_assoc()) {
                              echo "<tr>";
                              echo "<td><a href='#' data-toggle='modal' data-target='#detailsModal' data-id='" . htmlspecialchars($row['queue_id']) . "'>OR" . htmlspecialchars($row['queue_id']) . "</a></td>";
                              echo "<td>" . htmlspecialchars($row['name']) . "</td>";

                              // Determine the class for the status badge
                              $badgeClass = '';
                              switch ($row['status']) {
                                  case 'Done':
                                      $badgeClass = 'success';
                                      break;
                                  case 'Queue':
                                      $badgeClass = 'warning';
                                      break;
                                  case 'Cancelled':
                                      $badgeClass = 'danger';
                                      break;
                                  case 'On-Going':
                                      $badgeClass = 'info';
                                      break;
                              }

                              echo "<td><span class='badge badge-{$badgeClass}'>" . htmlspecialchars($row['status']) . "</span></td>";
                              echo "<td>";
                              echo "<span class='badge badge-success'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Done'style='color: black;'>Done</a></span> ";
                              echo "<span class='badge badge-warning'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Queue'style='color: black;'>Queue</a></span> ";
                              echo "<span class='badge badge-danger'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Cancelled'style='color: black;'>Cancelled</a></span> ";
                              echo "<span class='badge badge-info'><a href='update_status.php?id=" . $row['queue_id'] . "&status=On-Going'style='color: black;'>On-Going</a></span>";
                              echo "</td>";
                              echo "</tr>";
                          }
                        }
                          else{
                            echo "<td>No Data</td>";
                          }
                          ?>
                      </tbody>
                  </table>


                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                
                
              </div>
              <!-- /.card-footer -->
            </div>    
    </section>
    <!-- /.table -->
    <!-- On-going table --> 
    <section class="content">
      <div class="container-fluid">
            <!-- TABLE: LATEST ORDERS -->
            <div class="card card-dark">
              <div class="card-header border-transparent">
                <h3 class="card-title">On-going</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body bg-dark p-0">
                <div class="table-responsive">
                  <table class="table table-bordered table-dark m-0">
                      <thead>
                          <tr>
                              <th>Queue ID</th>
                              <th>Name</th>
                              <th>Studio</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                          // Fetch data from the 'queue' table including studio
                          $query = "SELECT q.queue_id, q.name, q.status, s.studio 
                                  FROM queue q 
                                  LEFT JOIN sales s ON q.queue_id = s.queue_id 
                                  WHERE q.status = 'On-Going'";
                          $result = $conn->query($query);
                          if ($result && $result->num_rows > 0){
                          while ($row = $result->fetch_assoc()) {
                              echo "<tr>";
                              echo "<td><a href='#' data-toggle='modal' data-target='#detailsModal' data-id='" . htmlspecialchars($row['queue_id']) . "'>OR" . htmlspecialchars($row['queue_id']) . "</a></td>";
                              echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                              
                              // Display studio with descriptive text
                              $studio_display = match($row['studio']) {
                                  '1' => 'Studio 1',
                                  '2' => 'Studio 2',
                                  default => 'Not assigned'
                              };
                              echo "<td>" . htmlspecialchars($studio_display) . "</td>";

                              // Determine the class for the status badge
                              $badgeClass = match($row['status']) {
                                  'Done' => 'success',
                                  'Queue' => 'warning',
                                  'Cancelled' => 'danger',
                                  'On-Going' => 'info',
                                  default => 'secondary'
                              };

                              echo "<td><span class='badge badge-{$badgeClass}'>" . htmlspecialchars($row['status']) . "</span></td>";
                              echo "<td>";
                              echo "<span class='badge badge-success'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Done'style='color: black;'>Done</a></span> ";
                              echo "<span class='badge badge-warning'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Queue'style='color: black;'>Queue</a></span> ";
                              echo "<span class='badge badge-danger'><a href='update_status.php?id=" . $row['queue_id'] . "&status=Cancelled'style='color: black;'>Cancelled</a></span> ";
                              echo "<span class='badge badge-info'><a href='update_status.php?id=" . $row['queue_id'] . "&status=On-Going'style='color: black;'>On-Going</a></span>";
                              echo "</td>";
                              echo "</tr>";
                          }
                        }
                          else{
                            echo "<td colspan='5'>No Data</td>";
                          }
                          ?>
                      </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
              </div>
              <!-- /.card-footer -->
            </div>    
    </section>
    <!-- /.table -->  

  </div>
  <!-- /.content-wrapper -->
<!-- Modal Structure -->
<!-- Modal Structure -->
<!-- Modal Structure -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <div class="order-details">
                    <p><strong>Total Price:</strong> <span id="modal-total-price"></span></p>
                    <p><strong>Package List:</strong> <span id="modal-package-list"></span></p>
                    <p><strong>Booking Date:</strong> <span id="modal-booking-date"></span></p>
                    <p><strong>Booking Time:</strong> <span id="modal-booking-time"></span></p>
                    <p><strong>Status:</strong> <span id="modal-status"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

  <!-- Control Sidebar (optional, can be removed if not needed) -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Settings</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
<?php include 'footer.php' ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#detailsModal').on('show.bs.modal', function(e) {
        var queue_id = $(e.relatedTarget).data('id');
        var modalContent = $('#modalContent');
        
        // Show loading indicator
        modalContent.html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
        
        // AJAX request to fetch modal content
        $.ajax({
            url: 'fetch_modal_data.php',
            type: 'post',
            data: { queue_id: queue_id },
            success: function(response) {
                modalContent.html(response);
            },
            error: function() {
                modalContent.html('<div class="alert alert-danger">Error loading order details.</div>');
            }
        });
    });
});

$(document).ready(function() {
    $('#globalSearch').on('keyup', function() {
        const searchValue = $(this).val().toLowerCase();
        
        if (searchValue.length >= 2) {
            $.ajax({
                url: 'search_customers.php',
                type: 'GET',
                data: { search: searchValue },
                success: function(response) {
                    updateTables(response);
                }
            });
        } else {
            // Reset all tables to their original state
            $.ajax({
                url: 'fetch_all_tables.php',
                type: 'GET',
                success: function(response) {
                    updateTables(response);
                }
            });
        }
    });
    
    function updateTables(response) {
        const groupedBookings = {
            'For-Checking': [],
            'Done': [],
            'Cancelled': [],
            'Queue': [],
            'On-Going': []
        };
        
        response.forEach(booking => {
            if (groupedBookings.hasOwnProperty(booking.status)) {
                groupedBookings[booking.status].push(booking);
            }
        });
        
        Object.keys(groupedBookings).forEach(status => {
            const section = $('section').filter(function() {
                return $(this).find('.card-title').text().trim() === status;
            });
            
            if (section.length > 0) {
                const tbody = section.find('table tbody');
                if (groupedBookings[status].length > 0) {
                    const tableHtml = groupedBookings[status].map(booking => `
                        <tr>
                            <td><a href='#' data-toggle='modal' data-target='#detailsModal' data-id='${booking.queue_id}'>OR${booking.queue_id}</a></td>
                            <td>${booking.name}</td>
                            <td><span class='badge badge-${getBadgeClass(booking.status)}'>${booking.status}</span></td>
                            <td>
                                <span class='badge badge-success'><a href='update_status.php?id=${booking.queue_id}&status=Done' style='color: black;'>Done</a></span>
                                <span class='badge badge-warning'><a href='update_status.php?id=${booking.queue_id}&status=Queue' style='color: black;'>Queue</a></span>
                                <span class='badge badge-danger'><a href='update_status.php?id=${booking.queue_id}&status=Cancelled' style='color: black;'>Cancelled</a></span>
                                <span class='badge badge-info'><a href='update_status.php?id=${booking.queue_id}&status=On-Going' style='color: black;'>On-Going</a></span>
                            </td>
                        </tr>
                    `).join('');
                    tbody.html(tableHtml);
                } else {
                    tbody.html('<tr><td colspan="4" class="text-center">No matching bookings</td></tr>');
                }
            }
        });
    }
    
    function getBadgeClass(status) {
        switch (status) {
            case 'Done': return 'success';
            case 'Queue': return 'warning';
            case 'Cancelled': return 'danger';
            case 'On-Going': return 'info';
            case 'For-Checking': return 'primary';
            default: return 'secondary';
        }
    }
});

</script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>