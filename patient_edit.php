<?php
include "db_conn.php";
include "patient_update.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
    $edit_patientId = $_POST["edit"];

    $editSql = "SELECT * FROM all_patient WHERE id = $edit_patientId";
    $editResult = mysqli_query($conn, $editSql);
    $editRow = mysqli_fetch_assoc($editResult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <link rel="stylesheet" href="patient_edit.css">
    <link class="icon" rel="icon" href="kfc-logo.png">
    <script src="https://kit.fontawesome.com/bb02d24289.js" crossorigin="anonymous"></script>
</head>
<body>

    <header>
        <h1>Edit Patient</h1>

        <a href="patient.php"><i class="fa-solid fa-x"></i></a>
    </header>

    <div class="container">
         
    <div class="form-container">
        <form method="post" action="patient_update.php">
            <input type="hidden" name="edit_id" value="<?php echo $editRow['id']; ?>">
        
            <label for="edit_firstName">First Name:</label>
            <input type="text" id="edit_firstName" name="edit_firstName" value="<?php echo $editRow['firstName']; ?>" required>

            <label for="edit_lastName">Last Name:</label>
            <input type="text" id="edit_lastName" name="edit_lastName" value="<?php echo $editRow['lastName']; ?>" required>

            <label for="edit_phone">Phone:</label>
            <input type="text" id="edit_phone" name="edit_phone" value="<?php echo $editRow['phoneNumber']; ?>" required>

            <label for="edit_email">Email:</label>
            <input type="text" id="edit_email" name="edit_email" value="<?php echo $editRow['email']; ?>" required>
            

            <button type="submit">Update</button>
        </div>
        </form>
    </div>
</body>
</html>

<?php
}
?>