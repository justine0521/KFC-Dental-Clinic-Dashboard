<?php
    include "account_db.php";

    sleep(2);
    session_start();
    session_unset();
    session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link class="icon" rel="icon" href="kfc-logo.png">
    <title>Logging Out</title>
</head>
<body>

<script>
 
            window.location.href = "login.php";
   
</script>

</body>
</html>

