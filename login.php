<?php
    include "account_db.php";

    session_start();

    if(isset($_SESSION['success_message'])) {
        echo '<script>alert("' . $_SESSION['success_message'] . '");</script>';
        unset($_SESSION['success_message']);
    }
    
    if(isset($_POST["submit"])){
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $pass = md5($_POST["password"]);
        
        $select = "SELECT * FROM create_account WHERE email = '$email' && password = '$pass' ";
    
        $result = mysqli_query($conn, $select);

        if ($result === false) {
            die(mysqli_error($conn));
        }

        if(mysqli_num_rows($result) > 0){
            sleep(2);

            $row = mysqli_fetch_assoc($result);
            $user_id = $row['Id'];

            $_SESSION['user_id'] = $user_id;

            header("location:dashboard.php");
            
        } else {
            echo "<script>alert('Login unsuccessful! Invalid Email or Password');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link class="icon" rel="icon" href="kfc-logo.png">
    <script src="https://kit.fontawesome.com/bb02d24289.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <div class="login-form">
        <div class="container">
            <header>
                <img src="KFC-Dental-logo-removebg-preview.png" alt="">
            </header>

            <div class="form-container">
                <h1>Login</h1>

                <form action="" method="post">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <i class="fa-regular fa-eye-slash" id="togglePassword"></i>
                    </div>
                    <a href="forgot-password.php" id="forgot-pass">Forgot password?</a>

                    <button type="submit" name="submit">Login</button>
                    <br>
                    <br>
                    <p class="create-acc"><a href="create-account.php" id="create-acc">Create an Account</a></p>
                    
                </form>
            </div>
        </div>
    </div>


<script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', function(){
        if(password.type === "password"){
            password.type = 'text';
        }else{
            password.type = 'password';
        }
        this.classList.toggle('fa-eye');
        
    });
</script>

</body>
</html>