<head>
    <!-- Your existing head content -->
    
    <style>
        .notifications-menu .dropdown-menu {
            width: 300px;
        }

        .navbar-badge {
            font-size: 0.6rem;
            padding: 2px 4px;
            position: absolute;
            right: 5px;
            top: 9px;
        }

        .notifications-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .dropdown-item {
            white-space: normal;
            padding: 0.5rem 1rem;
        }
        .highlight-row {
        background-color: #fff3cd !important;
        transition: background-color 0.5s ease;
        }
    </style>
</head>
  
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search (optional, can be removed if not needed) -->

      <!-- User Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="logout.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </li>
      <li class="nav-item dropdown notifications-menu">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge notification-count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header"><span class="notification-count">0</span> Notifications</span>
                <div class="dropdown-divider"></div>
                <div class="notifications-list">
                    <!-- Notifications will be inserted here -->
                </div>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>



    </ul>
  </nav>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/dos.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">dos<b>Studios</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form (optional, can be removed if not needed) -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      
<!------------Sidebar Menu----------->
<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Folder Start-->
          <?php
            $id = $_SESSION['user_id'];           
            if ($id == 1 || $id == 2 || $id == 8){
              echo "          <li class=\"nav-item menu-open\">
              <a href=\"#\" class=\"nav-link \">               
                <p>
                 Owner Settings
                  <i class=\"right fas fa-angle-left\"></i>
                </p>
              </a>
              <ul class=\"nav nav-treeview\">
                <li class=\"nav-item\">
                  <a href=\"user.php\" class=\"nav-link\">
                    <i class=\"far fa-circle nav-icon\"></i>
                    <p>Add User</p>
                  </a>
                </li>
              </ul>
                            <ul class=\"nav nav-treeview\">
                <li class=\"nav-item\">
                  <a href=\"admin-attendance.php\" class=\"nav-link\">
                    <i class=\"far fa-circle nav-icon\"></i>
                    <p>Employee Running Time</p>
                  </a>
                </li>
              </ul>
              <ul class=\"nav nav-treeview\">
                <li class=\"nav-item\">
                  <a href=\"daily-summary.php\" class=\"nav-link\">
                    <i class=\"far fa-circle nav-icon\"></i>
                    <p>Daily Summary</p>
                  </a>
                </li>
              </ul>
              <ul class=\"nav nav-treeview\">
                <li class=\"nav-item\">
                  <a href=\"monthly-summary.php\" class=\"nav-link\">
                    <i class=\"far fa-circle nav-icon\"></i>
                    <p>Monthly Summary</p>
                  </a>
                </li>
              </ul>
            </li>";
            }
              
              ?>

          <?php
            $id = $_SESSION['user_id'];           
            if ($id != 1 && $id != 2) { // Only show for non-admin users (employees)
              echo '<li class="nav-item">
                    <a href="staff-time.php" class="nav-link">
                      <i class="nav-icon fas fa-clock"></i>
                      <p>
                        Time In/Out
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="staff-time.php" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Staff Time In/Out</p>
                        </a>
                      </li>
                    </ul>
                  </li>';
            }
          ?>
      

          

          <!-- Folder End -->
          <!-- Folder Start-->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link ">            
              <p>
                Customers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="customers_table.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer's Table</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Folder End -->
          <!-- Folder Start-->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link ">            
              <p>
                Inventory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="inventory.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General Inventory</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="transaction_history.php#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transaction History</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="equipments.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Maintenance</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Folder End -->
          
        </ul>
      </nav>
<!----------Sidebar Menu End----------->
      </div>
    <!-- /.sidebar -->
  </aside>

