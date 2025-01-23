<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();


require '../vendor/autoload.php';
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
                }elseif ($status === 'Queue') {
                    // Get user from database
                    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
                    $stmt->bind_param("s", $_SESSION['username']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc();
                    
                    if ($user && isset($user['id'])) {
                        $user_id = $user['id'];
                        
                        // Update sales record with user ID
                        $updateSalesQuery = "UPDATE sales SET users = ? WHERE queue_id = ?";
                        $updateSalesStmt = $conn->prepare($updateSalesQuery);
                        $updateSalesStmt->bind_param("ii", $user_id, $queue_id);
                        $updateSalesStmt->execute();
                    }
    
                    // Fetch data from the database
                    $queryQueue = "SELECT name FROM queue WHERE queue_id = ?";
                    $queryMessages = "SELECT email FROM messages WHERE queue_id = ?";
                    $querySales = "SELECT total_price, package_list, booking_date, time_range FROM sales WHERE queue_id = ?";
    
                    $stmtQueue = $conn->prepare($queryQueue);
                    $stmtQueue->bind_param("i", $queue_id);
                    $stmtQueue->execute();
                    $stmtQueue->bind_result($name);
                    $stmtQueue->fetch();
                    $stmtQueue->close();
    
                    $stmtMessages = $conn->prepare($queryMessages);
                    $stmtMessages->bind_param("i", $queue_id);
                    $stmtMessages->execute();
                    $stmtMessages->bind_result($email);
                    $stmtMessages->fetch();
                    $stmtMessages->close();
    
                    $stmtSales = $conn->prepare($querySales);
                    $stmtSales->bind_param("i", $queue_id);
                    $stmtSales->execute();
                    $stmtSales->bind_result($total_price, $package_list, $booking_date, $time_range);
                    $stmtSales->fetch();
                    $stmtSales->close();
    
                    // Send email
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'dosstudios9@gmail.com';
                        $mail->Password = 'boagamanxheptvdk';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = 465;
    
                        $mail->setFrom('dosstudios9@gmail.com', 'DOS Studios');
                        $mail->addAddress($email);
    
                        $mail->isHTML(true);
                        $mail->Subject = 'Booking Details';
                        $mail->Body = "
                            <h1>Booking Confirmation</h1>
                            <p>Dear $name, here are your booking details:</p>
                            <ul>
                                <li><strong>Total Price:</strong> $total_price</li>
                                <li><strong>Package List:</strong> $package_list</li>
                                <li><strong>Booking Date:</strong> $booking_date</li>
                                <li><strong>Booking Time:</strong> $time_range</li>
                            </ul>
                            <br>
                            <p>Here are IMPORTANT reminders for your appointment:</p>
                            <ol>
                                <li> Please be at the studio 10-15 mins prior to your scheduled appointment. Time will not be adjusted if you're late as there will be next customer scheduled after.🕑</li>
                                <li> Make sure that your furbabies are wearing diapers to prevent any unwanted events inside our studio🐶🐱</li>
                                <li> For props—fire hazardous materials, drugs, firecrackers, and other materials that may cause excessive waste are not allowed inside the studio❌</li>
                                <li> There’s a dressing room inside the studio where you can change your outfit.💃</li>
                                <li> Any damage of equipments inside the studio will be shouldered by the last user. Please make sure to handle equipments with care.</li>
                                <li> NO FOOD AND DRINKS allowed.</li>
                                <li> After your shoot, our staff will ask you if we can take a quick video of you posting a hard copy photo in our memory wall (Pls see our FB/IG Stories as a sample). If you are okay with this, you also give us consent to post your pictures on our Social Media Pages. If not, kindly inform our Staff on your day of shoot. </li>
                            </ol>
                            <p>Reminders:</p>
                            <ul>
                                <li>!! DP is NON-REFUNDABLE.</li>
                                <li>!! 1 Reschedule is allowed 3 days before the scheduled date. (Rescheduling is NOT ALLOWED less than 3 days before the scheduled date and your DP will be forfeited)</li>
                                <li>!! For more details about rescheduling, kindly message us on our facebook page with your reciept.</li>
                            </ul>
                            <p>Note:</p>
                            <ul>
                            <li><strong>There's NO available parking lot.</strong></li>
                            </ul>
                            <p>See you! 😊</p>";
    
                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Mailer Error: {$mail->ErrorInfo}";
                    }
                } elseif ($status === 'Cancelled') {
                    // Delete the record from sales table
                    $deleteSalesQuery = "DELETE FROM sales WHERE queue_id = ?";
                    $deleteSalesStmt = $conn->prepare($deleteSalesQuery);
                    $deleteSalesStmt->bind_param("i", $queue_id);
                    $deleteSalesStmt->execute();
                    
                    // Delete the record from queue table
                    $deleteQueueQuery = "DELETE FROM queue WHERE queue_id = ?";
                    $deleteQueueStmt = $conn->prepare($deleteQueueQuery);
                    $deleteQueueStmt->bind_param("i", $queue_id);
                    $deleteQueueStmt->execute();
                }

                // If we get here, commit the transaction
                $conn->commit();
                
                // Redirect back to the referring page after successful status update
                $referrer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
                header('Location: ' . $referrer);
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