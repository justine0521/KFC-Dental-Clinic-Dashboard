<?php
include "db_conn.php";

if ($conn->ping()) {
    $eightAMTimestamp = date('Y-m-d') . ' 08:00:00';

    $cleanupSql = "DELETE FROM total_patient WHERE created_at < '$eightAMTimestamp'";
    $cleanupResult = mysqli_query($conn, $cleanupSql);

    if ($cleanupResult) {
        echo "";
    } else {
        echo "Total patient reset failed: " . mysqli_error($conn);
    }

    mysqli_close($conn);

    include "db_conn.php";

} else {
    echo "Connection to the database is closed. Please check your connection.";
}
?>
