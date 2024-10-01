<?php
session_start();

if (isset($_SESSION["otp"])) {
    $otpFromSession = $_SESSION["otp"];

    if (isset($_POST['submit'])) {
        $enteredOTP = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'] . $_POST['otp5'] . $_POST['otp6'];

        if ($enteredOTP == $otpFromSession) {
            echo '<script>alert("OTP verified!");</script>';
            echo '<script>setTimeout(function(){ window.location.href = "new_password.php"; }, 1000);</script>';
        } else {
            echo '<script>alert("Invalid OTP! Please try again.");</script>';
        }
    }
} else {
    echo '<script>alert("OTP not found in the session.");</script>';
    echo '<script>window.location.href = "forgot-password.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="otp_verification.css">
    <link class="icon" rel="icon" href="kfc-logo.png">
    <script src="https://kit.fontawesome.com/bb02d24289.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="form-wrapper">
        <form action="" method="post" id="otpForm"> 
            <div class="title">
                <p>OTP</p>
                <a href="forgot-password.php"><i class="fa-solid fa-x"></i></a>
            </div> 
            <div class="title2">Verification Code</div> 
            <p class="message">We have sent a verification code to your Email Address</p> 
    
            <div class="inputs"> 
                <input id="input1" type="text" maxlength="1" name="otp1"> 
                <input id="input2" type="text" maxlength="1" name="otp2"> 
                <input id="input3" type="text" maxlength="1" name="otp3"> 
                <input id="input4" type="text" maxlength="1" name="otp4"> 
                <input id="input5" type="text" maxlength="1" name="otp5"> 
                <input id="input6" type="text" maxlength="1" name="otp6">
            </div> 

            <button type="submit" class="action" name="submit">Verify</button> 
        </form>
    </div>
</body>
</html>
