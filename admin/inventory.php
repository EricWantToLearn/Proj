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

// Fetch available packages from the database
$packageQuery = $conn->query("SELECT id, package_name FROM packages");

// Handle form submission and insert data into package_products
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $package_id = $_POST['package_id'];
    $product_id = $_POST['product_id'];
    $quantity_needed = $_POST['quantity_needed'];

    // Insert into package_products table
    $stmt = $conn->prepare("INSERT INTO package_products (package_id, product_id, quantity_needed) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $package_id, $product_id, $quantity_needed);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Product added to package successfully!');</script>";
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
  <title>Inventory</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
                        <h1 class="m-0">Inventory</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Inventory</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
      <div class="card">
  <div class="card-body">
  <div class="d-flex justify-content-between align-items-center">
      <h5 class="card-title mb-0">Product List</h5>
      <a href="https://ph.canon/en/consumer/products/search?category=printing&subCategory=consumables&consumableType=PAPER" 
   class="btn btn-primary btn-sm" 
   target="_blank" 
   rel="noopener noreferrer">Order Now</a></div>
    <?php
    // Fetch products from the 'inventory' table
    $result = $conn->query("SELECT * FROM inventory");
    if ($result->num_rows > 0) {
      echo "<table class='table'>";
      echo "<thead><tr>
              <th>Product Type</th>
              <th>Stock Count</th>
              <th>Stock Level</th>
              <th>Restock Recommendation</th>
            </tr></thead>";
      echo "<tbody>";
      while ($row = $result->fetch_assoc()) {
        $stockCount = $row['stock_count'];
        $stockLevel = '';
        $stockClass = '';
        $restockRecommendation = '';

        // Determine stock level
        if ($stockCount > 400) {
          $stockLevel = 'High';
          $stockClass = 'bg-success';
        } elseif ($stockCount > 100) {
          $stockLevel = 'Moderate';
          $stockClass = 'bg-warning';
        } else {
          $stockLevel = 'Low';
          $stockClass = 'bg-danger';
        }

        // Adjust stock count display and class for negative values
        if ($stockCount < 0) {
          $displayStock = "<span style='color: red;'>0</span>";
        } else {
          $displayStock = $stockCount;
        }

        // Determine restock recommendation
        if ($stockCount < 50) {
          $restockRecommendation = '400';
        } elseif ($stockCount < 100) {
          $restockRecommendation = '300';
        } elseif ($stockCount < 200) {
          $restockRecommendation = '200';
        } else {
          $restockRecommendation = 'No need to restock yet';
        }

        // Output the row
        echo "<tr>
                <td>{$row['product_type']}</td>
                <td>{$displayStock}</td>
                <td><span class='badge {$stockClass}'>{$stockLevel}</span></td>
                <td>{$restockRecommendation}</td>
              </tr>";
      }
      echo "</tbody></table>";
    } else {
      echo "<p>No products found in inventory.</p>";
    }
    ?>
  </div>
</div>

      </div>


<!-- Add Product Form -->
<!-- <div class="col-lg-6">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">
        <button class="btn btn-link" data-toggle="collapse" data-target="#addProductCollapse" aria-expanded="true">
          Add Product
        </button>
      </h5>
    </div>
    <div id="addProductCollapse" class="collapse">
      <div class="card-body">
        <form action="add_product.php" method="POST">
          <div class="form-group">
            <label for="product_type">Product Type</label>
            <input type="text" class="form-control" id="product_type" name="product_type" required>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="1" required></textarea>
          </div>
          <div class="form-group">
            <label for="stock_count">Initial Stock Count</label>
            <input type="number" class="form-control" id="stock_count" name="stock_count" required>
          </div>
          <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
      </div>
    </div>
  </div>
</div> -->

<!-- Deduct Products Form -->
<div class="col-lg-6">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">
        <button class="btn btn-link" data-toggle="collapse" data-target="#deductionCollapse" aria-expanded="true">
          Deduction
        </button>
      </h5>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div id="deductionCollapse" class="collapse">
      <div class="card-body">
        <form action="deduct_product.php" method="POST">
          <div class="form-group">
            <label for="product_type">Product Type</label>
            <select class="form-control" id="product_type" name="product_type" required>
            <option value="">Select Product</option>
            <?php
            $result = $conn->query("SELECT id, product_type FROM inventory");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['product_type'] . "</option>";
            }
            ?>
        </select>
          </div>
          <div class="form-group">
            <label for="deduction_count">Deduction Count</label>
            <input type="number" class="form-control" id="deduction_count" name="deduction_count" min="1" required>
          </div>
          <div class="form-group">
            <label for="deduction_reason">Reason</label>
            <input type="text" class="form-control" id="deduction_reason" name="deduction_reason" required>
          </div>
          <button type="submit" class="btn btn-danger">Deduct</button>
        </form>
      </div>
    </div>
  </div>
</div>
  <!-- <div class="card">
            <div class="card-header">
              <h5>Select Package and Add Products</h5>
            </div>
            <div class="card-body">
              <form action="package_products.php" method="POST">
                <div class="form-group">
                  <label for="package_id">Select Package</label>
                  <select name="package_id" id="package_id" class="form-control" required>
                    <?php while ($package = $packageQuery->fetch_assoc()) { ?>
                      <option value="<?= $package['id'] ?>"><?= $package['package_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>

                
                <div class="form-group">
                  <label for="product_id">Select Product</label>
                  <select name="product_id" id="product_id" class="form-control" required>
                    
                  </select>
                </div>

                <div class="form-group">
                  <label for="quantity_needed">Quantity Needed</label>
                  <input type="number" name="quantity_needed" id="quantity_needed" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Add Product</button>
              </form>
            </div>
          </div> -->
          <div class="col-lg-6">
          <div class="card">
    <div class="card-header">
        <h5 class="card-title">
            <button class="btn btn-link" data-toggle="collapse" data-target="#addonsCollapse" aria-expanded="true">
                Add Addons
            </button>
        </h5>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div id="addonsCollapse" class="collapse">
        <div class="card-body">
            <form action="add_addons.php" method="POST">
                <div class="form-group">
                    <label for="product_type">Product Type</label>
                    <select class="form-control" id="product_type" name="product_type" required>
                        <option value="">Select Product</option>
                        <?php
$result = $conn->query("SELECT id, product_type FROM inventory");
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['id'] . "'>" . $row['product_type'] . "</option>";
}
?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                </div>
                <button type="submit" class="btn btn-success">Add to Addons</button>
            </form>
        </div>
    </div>
</div>

</div>
</div>




<!-- Add Stocks Form -->
<div class ="row">
<div class="col-lg-6">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">
        <button class="btn btn-link" data-toggle="collapse" data-target="#addStocksCollapse" aria-expanded="true">
          Add Stocks
        </button>
      </h5>
    </div>
    <div id="addStocksCollapse" class="collapse">
      <div class="card-body">
        <form action="add_stock.php" method="POST">
          <div class="form-group">
              <label for="add_product_type">Product Type</label>
              <!-- Changed the ID to avoid conflict with other forms -->
              <select class="form-control" id="add_product_type" name="product_type" required>
                  <option value="">Select Product</option>
                  <?php
                  $result = $conn->query("SELECT product_type FROM inventory");
                  while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . htmlspecialchars($row['product_type']) . "'>" . 
                          htmlspecialchars($row['product_type']) . "</option>";
                  }
                  ?>
              </select>
          </div>
          <div class="form-group">
              <label for="stocks_added">Stock Count to Add</label>
              <input type="hidden" name="user" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
              <input type="number" class="form-control" id="stocks_added" name="stocks_added" min="1" required>
          </div>
          <button type="submit" class="btn btn-success">Add Stock</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Done Transaction Form -->
<div class="col-lg-6">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">
        <button class="btn btn-link" data-toggle="collapse" data-target="#doneTransactionCollapse" aria-expanded="true">
          Done Transaction
        </button>
      </h5>
    </div>
    <div id="doneTransactionCollapse" class="collapse">
      <div class="card-body">
        <form action="done_transaction.php" method="POST">
          <div class="form-group">
            <label for="product_id">Select Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
              <?php
              // Fetch product types for the dropdown
              $productQuery = $conn->query("SELECT id, product_type FROM inventory");
              while ($product = $productQuery->fetch_assoc()) {
                echo "<option value='{$product['id']}'>{$product['product_type']}</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="quantity">Quantity to Deduct</label>
            <input type="number" name="quantity" id="quantity" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Add New Package Form -->
<div class="col-lg-12">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">        
        <button class="btn btn-link" data-toggle="collapse" data-target="#addPackageCollapse" aria-expanded="true">
          Add New Package
        </button></h5>
    </div>
    <div id="addPackageCollapse" class="collapse">
    <div class="card-body">
      <form action="add_package.php" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="package_name">Package Name</label>
              <input type="text" class="form-control" id="package_name" name="package_name" required>
            </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
            <label for="package_image">Package Image</label>
              <input type="file" class="form-control" id="package_image" name="package_image" accept="image/jpeg,image/jpg" required>
              <small class="form-text text-muted">Upload a JPG image for the package</small>
          </div>
            </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="price">Price</label>
              <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
            <label for="additional_images">Additional Package Images</label>
            <input type="file" class="form-control" id="additional_images" name="additional_images[]" accept="image/jpeg,image/jpg" multiple>
            <small class="form-text text-muted">Upload additional JPG images for the package (optional)</small>
          </div>
            </div>
        </div>
        
        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        
        <div class="form-group">
          <label for="duration">Duration (minutes)</label>
          <input type="number" class="form-control" id="duration" name="duration" required>
        </div>
        
        <div class="form-group">
          <label>Products Used</label>
          <div id="products_container">
            <div class="row product-row mb-2">
              <div class="col-md-6">
                <select class="form-control" name="products[]" required>
                  <option value="">Select Product</option>
                  <?php
                  $products = $conn->query("SELECT id, product_type FROM inventory");
                  while($product = $products->fetch_assoc()) {
                    echo "<option value='".$product['id']."'>".$product['product_type']."</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-4">
                <input type="number" class="form-control" name="quantities[]" placeholder="Quantity" required min="1">
              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-success btn-sm add-product"><i class="fas fa-plus"></i></button>
              </div>
            </div>
          </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Create Package</button>
      </form>
    </div>
                </div>
  </div>
</div>
<!-- Delete Package Form -->
<div class="col-lg-12">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">
        <button class="btn btn-link" data-toggle="collapse" data-target="#deletePackageCollapse" aria-expanded="true">
          Delete Package
        </button>
      </h5>
    </div>
    <div id="deletePackageCollapse" class="collapse">
      <div class="card-body">
        <form action="delete_package.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this package? This action cannot be undone.');">
          <div class="form-group">
            <label for="package_id">Select Package to Delete</label>
            <select class="form-control" id="package_id" name="package_id" required>
              <option value="">Choose a package...</option>
              <?php
              // Fetch all packages
              $packages = $conn->query("SELECT id, package_name, price FROM packages ORDER BY package_name");
              while($package = $packages->fetch_assoc()) {
                echo "<option value='" . $package['id'] . "'>" . $package['package_name'] . " (₱" . number_format($package['price'], 2) . ")</option>";
              }
              ?>
            </select>
          </div>
          <button type="submit" class="btn btn-danger">Delete Package</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>


  <div class="col-lg-6">
  
            </div>
                
  
  
  
  
  
  
      </div>
    </div>
  </div>


    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include 'footer.php' ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
  <!-- jQuery to fetch products based on selected package -->
  <script>
    $(document).ready(function() {
      // When package is selected
      $('#package_id').change(function() {
        var packageId = $(this).val();
        
        // Make AJAX request to fetch products for selected package
        $.ajax({
          url: 'fetch_products.php',
          type: 'POST',
          data: { package_id: packageId },
          success: function(data) {
            $('#product_id').html(data);
          }
        });
      });
    });
  </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle adding more product fields
    document.querySelector('.add-product').addEventListener('click', function() {
        const container = document.getElementById('products_container');
        const newRow = document.createElement('div');
        newRow.className = 'row product-row mb-2';
        newRow.innerHTML = `
            <div class="col-md-6">
                <select class="form-control" name="products[]" required>
                    <option value="">Select Product</option>
                    <?php
                    $products = $conn->query("SELECT id, product_type FROM inventory");
                    while($product = $products->fetch_assoc()) {
                        echo "<option value='".$product['id']."'>".$product['product_type']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="quantities[]" placeholder="Quantity" required min="1">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-product"><i class="fas fa-minus"></i></button>
            </div>
        `;
        container.appendChild(newRow);
        
        // Add remove button functionality
        newRow.querySelector('.remove-product').addEventListener('click', function() {
            newRow.remove();
        });
    });
});
</script>
</body>
</html>
