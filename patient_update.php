<?php
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_id"])) {
    $edit_id = $_POST["edit_id"];
    $edit_firstName = $_POST["edit_firstName"];
    $edit_lastName = $_POST["edit_lastName"];
    $edit_phone = $_POST["edit_phone"];
    $edit_email = $_POST["edit_email"];

    $updateSql = "UPDATE all_patient 
                  SET firstName = '$edit_firstName', 
                      lastName = '$edit_lastName', 
                      phoneNumber = '$edit_phone', 
                      email = '$edit_email' 
                  WHERE id = $edit_id";

    $result = mysqli_query($conn, $updateSql);

    if ($result) {
        echo "<script>
                alert('Update successful!');
                window.location.href = 'patient.php';
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