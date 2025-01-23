<?php
// Include your database connection file
include 'controls/conn.php';

// Check if both 'id' and 'status' are passed in the URL
if (isset($_GET['id']) && isset($_GET['status'])) {
    $queue_id = intval($_GET['id']);  // Convert id to integer for security
    $status = $_GET['status'];

    // Ensure that the status is a valid option (to prevent malicious changes)
    $valid_statuses = ['Done', 'Queue', 'Cancelled', 'On-Going','For-Checking'];
    if (in_array($status, $valid_statuses)) {
        try {
            // Start transaction
            $conn->begin_transaction();

            // Prepare the update query for queue status
            $stmt = $conn->prepare("UPDATE queue SET status = ? WHERE queue_id = ?");
            $stmt->bind_param("si", $status, $queue_id);

            // Execute the query and check if successful
            if ($stmt->execute()) {
                // If status is 'Done', process the transaction
                if ($status == 'Done') {
                    // Step 1: Fetch the package_list from sales table
                    $query = "SELECT package_list FROM sales WHERE queue_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $queue_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        // Step 2: Split the package_list by "|"
                        $packages = explode("|", $row['package_list']);

                        // Step 3: For each package, get and process the products
                        foreach ($packages as $package) {
                            if (!empty($package)) {  // Skip empty package names
                                // Get products used in this package
                                $packageQuery = $conn->prepare("SELECT product_used FROM packages WHERE package_name = ?");
                                $packageQuery->bind_param("s", $package);
                                $packageQuery->execute();
                                $packageResult = $packageQuery->get_result();
                                
                                if ($packageRow = $packageResult->fetch_assoc()) {
                                    // Step 4: Split and count products
                                    $products = explode("/", $packageRow['product_used']);
                                    $productCounts = array_count_values($products);
                                    
                                    // Step 5: Update inventory for each product
                                    foreach ($productCounts as $productId => $quantity) {
                                        // First check if there's enough stock
                                        $checkStock = $conn->prepare("SELECT stock_count FROM inventory WHERE id = ?");
                                        $checkStock->bind_param("i", $productId);
                                        $checkStock->execute();
                                        $stockResult = $checkStock->get_result();
                                        $stockRow = $stockResult->fetch_assoc();
                                        
                                        if ($stockRow['stock_count'] >= $quantity) {
                                            // Update inventory
                                            $updateQuery = "UPDATE inventory SET stock_count = stock_count - ? WHERE id = ?";
                                            $updateStmt = $conn->prepare($updateQuery);
                                            $updateStmt->bind_param("ii", $quantity, $productId);
                                            $updateStmt->execute();
                                            
                                            // Record the transaction
                                            $transactionQuery = "INSERT INTO done_transaction (product_id, quantity, transaction_date) VALUES (?, ?, NOW())";
                                            $transactionStmt = $conn->prepare($transactionQuery);
                                            $transactionStmt->bind_param("ii", $productId, $quantity);
                                            $transactionStmt->execute();
                                        } else {
                                            throw new Exception("Insufficient stock for product ID: " . $productId);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // If we get here, commit the transaction
                $conn->commit();
                
                // Redirect back to the original page after the update
                echo '<script>history.back();</script>';
                exit;
            } else {
                throw new Exception("Error updating record: " . $conn->error);
            }
        } catch (Exception $e) {
            // An error occurred, rollback the transaction
            $conn->rollback();
            echo "Error: " . $e->getMessage();
            exit;
        } finally {
            // Close all statements
            if (isset($stmt)) $stmt->close();
            if (isset($packageQuery)) $packageQuery->close();
            if (isset($updateStmt)) $updateStmt->close();
            if (isset($transactionStmt)) $transactionStmt->close();
            if (isset($checkStock)) $checkStock->close();
        }
    } else {
        echo "Invalid status.";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>