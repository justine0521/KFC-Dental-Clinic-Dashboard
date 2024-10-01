<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["otp"])) {
        $enteredOTP = $_POST["otp"];

        $storedOTP = $_SESSION["otp"];

        if ($enteredOTP == $storedOTP) {
            echo "OTP verification successful!";
        } else {
            echo "Invalid OTP. Please try again.";
        }
    } else {
        echo "No OTP provided.";
    }
}
?>
