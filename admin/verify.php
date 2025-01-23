<?php
// Start the session
session_start();

// Include database connection file
include 'controls/conn.php';

$error = '';
$success = false;

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Prepare the SQL query to find user with this token
    $stmt = $conn->prepare("SELECT id, verification_token, token_expiry FROM users WHERE verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Check if token has expired
        if (strtotime($user['token_expiry']) > time()) {
            // Token is valid, update user verification status
            $updateStmt = $conn->prepare("UPDATE users SET is_verified = 1, verification_token = NULL, token_expiry = NULL WHERE id = ?");
            $updateStmt->bind_param("i", $user['id']);
            
            if ($updateStmt->execute()) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['is_verified'] = true;
                unset($_SESSION['pending_verification']);
                unset($_SESSION['temp_user_id']);
                
                // Redirect to admin index
                header("Location: index.php");
                exit;
            } else {
                $error = "Failed to verify user. Please try again.";
            }
            $updateStmt->close();
        } else {
            $error = "Verification link has expired. Please log in again to receive a new verification link.";
        }
    } else {
        $error = "Invalid verification token.";
    }
    $stmt->close();
} else {
    $error = "No verification token provided.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <!-- Your existing CSS -->
</head>
<body>
    <div class="container">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
                <p><a href="login.php">Return to login</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>