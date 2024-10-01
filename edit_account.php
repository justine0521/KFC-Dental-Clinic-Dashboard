<?php
include "db_conn.php";
include "account_update.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
    $edit_accountId = $_POST["edit"];

    $editSql = "SELECT * FROM create_account WHERE id = $edit_accountId";
    $editResult = mysqli_query($conn, $editSql);
    $editRow = mysqli_fetch_assoc($editResult);

    // Check if the logged-in user is an assistant
    $isAssistant = ($editRow['Role'] === 'Assistant');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <link rel="stylesheet" href="edit_account.css">
    <link class="icon" rel="icon" href="kfc-logo.png">
    <script src="https://kit.fontawesome.com/bb02d24289.js" crossorigin="anonymous"></script>
</head>
<body>

    <header>
        <h1>Edit Account</h1>
        <a href="#" onclick="goBack()"><i class="fa-solid fa-x"></i></a>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </header>

    <div class="container">
        <div class="form-container">
            <form method="post" action="account_update.php">
                <input type="hidden" name="edit_id" value="<?php echo $editRow['Id']; ?>">

                <label for="edit_role">Role:</label>
                <select name="edit_role" id="edit_role" required <?php if ($isAssistant) echo 'disabled'; ?>>
                    <option value="Dentist" <?php echo ($editRow['Role'] === 'Dentist') ? 'selected' : ''; ?>>Dentist</option>
                    <option value="Assistant" <?php echo ($editRow['Role'] === 'Assistant') ? 'selected' : ''; ?> <?php if ($isAssistant) echo 'disabled'; ?>>Assistant</option>
                </select>

                <label for="edit_name">Name:</label>
                <input type="text" id="edit_name" name="edit_name" value="<?php echo $editRow['Name']; ?>" required>

                <label for="edit_email">Email:</label>
                <input type="text" id="edit_email" name="edit_email" value="<?php echo $editRow['email']; ?>" required>

                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
}
?>
