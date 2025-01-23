<?php
// Start the session
session_start();

// Add this to clear pending verification if user refreshes
if (isset($_SESSION['pending_verification']) && !isset($_POST['username'])) {
  unset($_SESSION['pending_verification']);
  unset($_SESSION['temp_user_id']);
}

// Check if user is verified and should be redirected to index
if (isset($_SESSION['is_verified']) && $_SESSION['is_verified'] && isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit;
}

// Include database connection file
include 'controls/conn.php';
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Require PHPMailer autoload (make sure this path is correct)
require '../vendor/autoload.php';

// Check if there's a verification token in the URL
if (isset($_GET['token'])) {
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
              // Redirect to verification success page
              header("Location: verify-success.php");
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
}

// Initialize variables
$error = '';
$message = '';

// Function to generate verification token
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

// Function to send verification email
function sendVerificationEmail($email, $token) {
  try {
    $mail = new PHPMailer(true);

    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                         //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                               //Enable SMTP authentication
    $mail->Username   = 'dosstudios9@gmail.com';            //SMTP username
    $mail->Password   = 'boagamanxheptvdk';                 //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        //Enable implicit TLS encryption
    $mail->Port       = 465;                                //TCP port to connect to

    //Recipients
    $mail->setFrom('dosstudios9@gmail.com', 'DOS Studios');
    $mail->addAddress($email);

    // Generate verification link
    $verificationLink = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/verify-success.php?token=' . $token;

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'DOS Studios - Login Verification';
    $mail->Body    = '
      Hello,<br><br>
      
      To complete your login verification, please click the link below:<br><br>
      
      <a href="' . $verificationLink . '" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;" target="_self">Verify Login</a><br><br>
      
      Or copy and paste this link in your browser:<br>
      ' . $verificationLink . '<br><br>
      
      This link will expire in 15 minutes.<br><br>
      
      If you did not attempt to log in, please ignore this email.<br><br>
      
      Thank you,<br>
      DOS Studios
  ';
    $mail->AltBody = "Please click the following link to verify your login:\n\n" . $verificationLink;

    return $mail->send();
} catch (Exception $e) {
    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    return false;
}
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT id, password, email, is_verified FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Bind result variables
        $stmt->bind_result($userId, $hashedPassword, $email, $isVerified);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Generate new verification token
            $token = generateToken();
            $expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));
            
            // Update user with new token
            $updateStmt = $conn->prepare("UPDATE users SET verification_token = ?, token_expiry = ? WHERE id = ?");
            $updateStmt->bind_param("ssi", $token, $expiry, $userId);
            $updateStmt->execute();
            
            // Send verification email
            if (sendVerificationEmail($email, $token)) {
                $_SESSION['pending_verification'] = true;
                $_SESSION['temp_user_id'] = $userId;
                $_SESSION['username'] = $username;
                $message = "Please check your email for verification link.";
            } else {
                $error = "Failed to send verification email. Please try again.";
            }
            $updateStmt->close();
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "Invalid username or password!";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>dos studios.</title>

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
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index.php" class="h1"><b>dos</b>Studios.</a>
    </div>
    <div class="card-body">
      <?php if (!isset($_SESSION['pending_verification'])): ?>
        <p class="login-box-msg">Sign in to start your session</p>

        <!-- Display error message if any -->
        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      <?php else: ?>
        <!-- Display verification pending message -->
        <div class="text-center">
          <div class="alert alert-info" role="alert">
            <i class="fas fa-envelope mb-3" style="font-size: 48px;"></i>
            <h5 class="mt-3">Email Verification Required</h5>
            <p><?= $message ?></p>
            <p class="mb-0"><small>The link will expire in 15 minutes.</small></p>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>