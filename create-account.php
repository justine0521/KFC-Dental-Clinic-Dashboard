<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="create-account.css">
    <script src="https://kit.fontawesome.com/bb02d24289.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="login-form">
        <div class="container">

        <?php
            include "account_db.php";

            if(isset($_POST["submit"])){
                $role = mysqli_real_escape_string($conn, $_POST["role"]);
                $name = mysqli_real_escape_string($conn, $_POST["name"]);
                $email = mysqli_real_escape_string($conn, $_POST["email"]);
                $pass = md5($_POST["password"]);
                
                $select = "SELECT * FROM create_account WHERE email = '$email' && password = '$pass' ";

                $result = mysqli_query($conn, $select);

                if(mysqli_num_rows($result) > 0){
                    $error[] = 'User already exists';
                } else {
                    $insert = "INSERT INTO create_account(Role, Name, email, password) VALUES('$role', '$name', '$email', '$pass')";
                    
                    if(mysqli_query($conn, $insert)) {
                        session_start();
                        $_SESSION['success_message'] = 'Your account has been created successfully!';
                        header("location:login.php");
                        exit(); 
                    } else {
                        $error[] = 'Error creating account';
                    }
                } 
            }
        ?>
            <header>
                <img src="KFC-Dental-logo-removebg-preview.png" alt="">
            </header>

            <div class="form-container">
                <h1>Create Account</h1>

                <?php 
                if(isset($error)){
                    foreach($error as $error){
                        echo '<span class="error-msg">'.$error.'</span>';
                    };
                        
                };
                
                ?>

                <form action="" method="post" id="myForm" onsubmit="return validateForm()">
                    <select name="role" id="role" required>
                        <option value="Role">Role</option>
                        <option value="Dentist">Dentist</option>
                        <option value="Assistant">Assistant</option>
                    </select>
                    <input type="text" id="name" name="name" placeholder="Name" required >
                    <input type="email" id="email" name="email" placeholder="Email" required >
                    <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Password" required value="<?php echo $password; ?>">
                        <i class="fa-regular fa-eye-slash" id="togglePassword"></i>
                    </div>
                    
                    <br>
                    <button type="submit" name="submit">Create account</button>
                    <br>
                    <br>
                    <p class="create-acc">Already have an account? <a href="login.php" id="create-acc">Login</a></p>
                    <br>
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

    function validateForm() {
    let role = document.getElementById('role').value;

    if (role === 'Role') {
        alert('Please select a Role.');
        return false;
    } else {
        document.getElementById('myForm').submit();
        return true;
    }
    }

</script>

</body>
</html>