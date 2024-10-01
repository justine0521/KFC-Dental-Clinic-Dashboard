<?php
include "db_conn.php";

function updatePassword($conn, $email, $password) {
    $hashedPassword = md5($password);

    $query = "UPDATE create_account SET password = '$hashedPassword' WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    } else {
        if (emailExistsInDatabase($conn, $email)) {

            if ($password == $password2) {
                $updateResult = updatePassword($conn, $email, $password);

                if ($updateResult) {
                    echo "<script>alert('Password changed successfully!');</script>";
                    echo "<script>setTimeout(function(){ window.location.href = 'login.php'; }, 1000);</script>";
                    exit();
                } else {
                    echo "<script>alert('Error updating password. Please try again.');</script>";
                }
            } else {
                echo "<script>alert('Passwords do not match!');</script>";
            }
        } else {
            echo "<script>alert('Email does not exist in the database');</script>";
        }
    }
}

function emailExistsInDatabase($conn, $email) {
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

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
    <link rel="stylesheet" href="new_password.css">
    <link class="icon" rel="icon" href="kfc-logo.png">
    <script src="https://kit.fontawesome.com/bb02d24289.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="form-container">
    <div class="logo-container">
        <p>Reset account password</p>
    </div>

    <form class="form" action="" method="post">
        <div class="form-group">
            <div class="email-wrapper">
                <label>Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required="">
            </div>

            <div class="password-wrapper">
                <label for="password">Password</label>
                <input type="password" id="pass" name="password" placeholder="Enter your new password" required="">
                <i class="fa-regular fa-eye-slash toggle-password" data-target="pass"></i>
            </div>

            <div class="password-wrapper">
                <label for="password">Confirm password</label>
                <input type="password" id="pass2" name="password2" placeholder="Confirm password" required="">
                <i class="fa-regular fa-eye-slash toggle-password" data-target="pass2"></i>
            </div>
        </div>

        <button class="form-submit-btn" type="submit" name="submit" id="submit">Reset password</button>
    </form>

</div>

<script>
    const toggleButtons = document.querySelectorAll('.toggle-password');

    toggleButtons.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
            this.classList.toggle('fa-eye');
        });
    });
</script>

</body>
</html>