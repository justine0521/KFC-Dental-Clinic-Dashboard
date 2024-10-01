<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer-master/PHPMailer-master/src/Exception.php';
require 'PHPMailer/PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/PHPMailer-master/src/SMTP.php';

session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Invalid email format';
    } else {
        if (emailExistsInDatabase($email)) {
            $otp = generateOTP();

            $_SESSION["otp"] = $otp;

            sendEmail($email, $otp);

            echo '<script>alert("OTP sent successfully on your email!");</script>';
            echo '<script>setTimeout(function(){ window.location.href = "otp_verification.php"; }, 1000);</script>';
        } else {
            echo '<script>alert("Invalid Email! Email does not exist.");</script>';
        }
    }
}

function emailExistsInDatabase($email) {
  include "db_conn.php";

  $sanitizedEmail = mysqli_real_escape_string($conn, $email);

  $query = "SELECT COUNT(*) as count FROM create_account WHERE email = '$sanitizedEmail'";
  $result = mysqli_query($conn, $query);

  if ($result) {
      $row = mysqli_fetch_assoc($result);
      $count = $row['count'];

      return $count > 0;
  } else {
      echo "Error: " . mysqli_error($conn);
      return false;
  }
}

function generateOTP() {
    return rand(100000, 999999);
}

function sendEmail($email, $otp) {
  $mail = new PHPMailer(true);

  try {
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'bakajustineto17@gmail.com';
      $mail->Password   = 'cdsb fnpf bkvx mtvd';
      $mail->SMTPSecure = 'tls';
      $mail->Port       = 587;

      $mail->setFrom('justinesantos2105@gmail.com', 'KFC Dental Clinic');
      $mail->addAddress($email);

      $mail->isHTML(true);
      $mail->Subject = 'OTP for Password Reset';
      $mail->Body    = 'Your OTP is: ' . $otp;

      $mail->send();
      return true;
  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      return false;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password</title>
    <link rel="stylesheet" href="forgot-password.css">
    <link class="icon" rel="icon" href="kfc-logo.png">
</head>
<body>

<div class="form-container">
    <div class="logo-container">
        Forgot Password
    </div>

    <form class="form" action="" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required="">
        </div>

        <button class="form-submit-btn" type="submit" name="submit">Send Email</button>
    </form>

    <p class="signup-link">
        Don't have an account?
        <a href="create-account.php" class="signup-link link"> Sign up now</a>
    </p>
</div>

</body>
</html>
