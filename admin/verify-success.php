<?php
session_start();

// Check if there's a verification token in the URL
if (isset($_GET['token'])) {
    include 'controls/conn.php';
    
    // Prepare the SQL query to find user with this token
    $stmt = $conn->prepare("SELECT id, verification_token, token_expiry FROM users WHERE verification_token = ?");
    $stmt->bind_param("s", $_GET['token']);
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
                $_SESSION['verification_complete'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['is_verified'] = true;
                
                // Set header to redirect after 3 seconds
                header("refresh:3;url=index.php");
            }
            $updateStmt->close();
        }
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DOS Studios | Verification Success</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card">
        <div class="card-header text-center">
            <a href="index.php" class="h1"><b>dos</b>Studios.</a>
        </div>
        <div class="card-body">
            <div class="text-center">
                <div class="mb-4">
                    <i class="fas fa-check-circle" style="font-size: 48px; color: #28a745;"></i>
                </div>
                <h5 class="mb-3">Email Verified Successfully!</h5>
                <p class="mb-3">Please wait, you will be redirected shortly...</p>
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>