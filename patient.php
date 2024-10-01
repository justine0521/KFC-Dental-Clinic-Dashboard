
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="patient.css">
    <link class="icon" rel="icon" href="kfc-logo.png">
    <script src="https://kit.fontawesome.com/bb02d24289.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function toggleNav() {
        var nav = document.querySelector('aside nav');
        var header = document.querySelector('.header-wrapper');
        var section = document.querySelector('.section');
        
        nav.classList.toggle('active');
        header.classList.toggle('active')
        section.classList.toggle('active');
        }
    </script>
</head>
<body>
    <div class="container">
        <aside>
        <nav>
                <ul>
                    <div>
                        <a href="dashboard.php" class="logo">
                            <img src="no-bg-KFC-Dental-Clinic.png" alt="KFC Dental Clinic">
                        </a>
                    </div>

                    <li>
                        <a href="dashboard.php">
                            <i class="fa-solid fa-house fa-sm"></i>
                            <span class="nav-item">Home</span>
                        </a>
                    </li>

                    <li>
                        <a href="appointment.php">
                            <i class="fa-regular fa-calendar-check fa-sm"></i>
                            <span class="nav-item">Appointments</span>
                            <i class="fa-solid fa-bell" aria-hidden="true" id="notifi_number">0</i>
                        </a>
                    </li>

                    <li>
                        <a href="patient.php">
                            <i class="fa-solid fa-bed fa-sm"></i>
                            <span class="nav-item">Patient</span>
                        </a>
                    </li>

                    <li>
                        <a href="account.php">
                            <i class="fa-solid fa-user"></i>
                            <span class="nav-item">Account</span>
                        </a>
                    </li>

                    <li>
                        <a href="message.php">
                            <i class="fa-solid fa-message fa-sm"></i>
                            <span class="nav-item">Message</span>
                            <i class="fa-solid fa-bell" aria-hidden="true" id="message_notifi_number">0</i>
                        </a>
                    </li>

                    <!-- <li>
                        <a href="logout.php" class="log-out">
                            <i class="fa-solid fa-right-from-bracket fa-sm"></i>
                            <span class="nav-item">Log out</span>
                        </a>
                    </li> -->
                </ul>
            </nav>
        </aside>

        <main>
            <header>
                <div class="header-wrapper">
                    <div class="hamburger-icon" onclick="toggleNav()">
                        <i class="fas fa-bars"></i>
                    </div>
                    &nbsp; &nbsp; &nbsp; &nbsp; 
                    <h1>All Patient</h1>
                </div>
                

                <div class="input-wrapper">
                    <form action="livesearch.php" method="post" onsubmit="return false;">
                        <label for="live_search">Search:</label>
                        <input type="text" class="form-control" name="input" id="live_search" autocomplete="off" placeholder="Search patient" oninput="searchPatients()">

                    </form>
                </div>
            </header>

            <button class="print-btn" id="print-btn"><i class="fa-solid fa-print"></i>Print</button>
    
            <section class="section">
            <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="id">ID</th>
                                <th class="fname" width="10%">First Name</th>
                                <th class="lname" width="10%">Last Name</th>
                                <th class="phone">Phone</th>
                                <th class="email">Email</th>
                                <th class="date">Date</th>
                                <th class="time">Time</th>
                                <th class="branch">Branch</th>
                                <th class="service">Service</th>
                                <th class="status">Action</th>
                            </tr>
                        </thead>
                        <tbody id="patientTableBody">
                            <?php
                            include "db_conn.php";
                            
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
                                $delete_patientId = $_POST["delete"];

                                $deleteSql = "DELETE FROM all_patient WHERE id = $delete_patientId";
                                mysqli_query($conn, $deleteSql);
                            }

                            $sql = "SELECT * FROM all_patient";
                            $result = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr id="patientRow<?php echo $row['id']; ?>">
                                <td data-label="ID"><?php echo $row['id'] ?></td>
                                    <td data-label="First Name"><?php echo $row['firstName'] ?></td>
                                    <td data-label="Last Name"><?php echo $row['lastName'] ?></td>
                                    <td data-label="Phone"><?php echo $row['phoneNumber'] ?></td>
                                    <td data-label="Email"><?php echo $row['email'] ?></td>
                                    <td data-label="Date"><?php echo $row['date'] ?></td>
                                    <td data-label="Time"><?php echo $row['time'] ?></td>
                                    <td data-label="Branch"><?php echo $row['branch'] ?></td>
                                    <td data-label="Service"><?php echo $row['service'] ?></td>
                                    <td class="action" data-label="Action">
                                        <form method="post" action="patient_edit.php" class="btn" onsubmit="return confirm('Are you sure you want to Edit?');">
                                            <input type="hidden" name="edit" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="edit"><i class="fa-regular fa-pen-to-square"></i></button>
                                        </form>

                                        <form method="post" action="" class="btn" onsubmit="return confirm('Are you sure you want to Delete?');">
                                            <input type="hidden" name="delete" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="delete"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

<script>
    document.getElementById('print-btn').addEventListener('click', function () {
        window.print();
    });

    function loadDoc() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("notifi_number").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "notification_db.php", true);
        xhttp.send();
    }
    loadDoc();

    function loadDoc_message() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("message_notifi_number").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "contact_notif_db.php", true);
        xhttp.send();
    }
    loadDoc_message();

    function searchPatients() {
        var input = document.getElementById("live_search").value.toLowerCase();
        var tableBody = document.getElementById("patientTableBody");
        
        <?php
        $sql = "SELECT * FROM all_patient";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            var id = "<?php echo strtolower($row['id']); ?>";
            var firstName = "<?php echo strtolower($row['firstName']); ?>";
            var lastName = "<?php echo strtolower($row['lastName']); ?>";
            var phone = "<?php echo strtolower($row['phoneNumber']); ?>";
            var email = "<?php echo strtolower($row['email']); ?>";
            var service = "<?php echo strtolower($row['service']); ?>";

            if (id.includes(input)|| firstName.includes(input) || lastName.includes(input) || phone.includes(input) || email.includes(input) || service.includes(input)){
                document.getElementById("patientRow<?php echo $row['id']; ?>").style.display = "";
            } else {
                document.getElementById("patientRow<?php echo $row['id']; ?>").style.display = "none";
            }
        <?php
        }
        ?>
    }
</script>

</body>
</html>