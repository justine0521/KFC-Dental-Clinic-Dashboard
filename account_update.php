<?php
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_id"])) {
    $edit_id = $_POST["edit_id"];
    $edit_role = $_POST["edit_role"];
    $edit_name = $_POST["edit_name"];
    $edit_email = $_POST["edit_email"];

    $updateSql = "UPDATE create_account 
                  SET Role = '$edit_role', 
                      Name = '$edit_name', 
                      email = '$edit_email' 
                  WHERE id = $edit_id";

    $result = mysqli_query($conn, $updateSql);

    if ($result) {
        echo "<script>
                alert('Update successful!');
                window.location.href = 'dashboard.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Update failed. Please try again.');
                window.history.back();
              </script>";
        exit();
    }
}
?>