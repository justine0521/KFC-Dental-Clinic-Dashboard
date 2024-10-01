<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link class="icon" rel="icon" href="kfc-logo.png">
    <script src="https://kit.fontawesome.com/bb02d24289.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <div class="container">
        <aside>    
            <nav class="menu">
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
                    <span><p>Clinic Dashboard</p></span>
                </div>

                <div class="user-profile">
                    <div class="profile"><i class="fa-solid fa-user"></i></div>

                    <div class="dropdown">
                        <div class="dropdown-content">

                        <?php
                            session_start();

                            include "account_db.php";

                            $user_id = $_SESSION['user_id'];

                            $stmt = $conn->prepare("SELECT * FROM create_account WHERE Id = ?");
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {

                                $row = $result->fetch_assoc();
                                ?>
                                <form method="post" action="edit_account.php" onsubmit="return confirm('Do you want to edit your account?');">
                                    <input type="hidden" name="edit" value="<?php echo $row['Id']; ?>">
                                    <button type="submit" class="edit"><i class="fa-regular fa-pen-to-square"></i>Edit Profile</button>
                                </form>
                                <?php
                            } else {
                                header("Location: account.php?error=account_not_found");
                                exit();
                            }
                        ?>

                            <a href="logout.php" id="profile-delete"><i class="fa-solid fa-right-from-bracket fa-sm"></i>Logout</a>
                        </div>
                    </div>
                </div>

            </header>
    
            <section class="section">
                <div class="container2">
                    <div class="cards">
                        <div class="cards-wrapper">
                            <span><p id="appointment_number">0</p></span>
                            <P>Appointment today</P>
                        </div>

                        <div class="icon-wrapper">
                            <i class="fa-regular fa-calendar-check fa-sm"></i>
                        </div>
                    </div>

                    <a href="message.php" id="cardformessage">
                        <div class="cards">
                            <div class="cards-wrapper">
                                <span><p id="message_number">0</p></span>
                                <P>Messages</P>
                            </div>

                            <div class="icon-wrapper">
                                <i class="fa-solid fa-message fa-sm"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="container2">
                    <div class="cards">
                        <div class="cards-wrapper">
                            <span><p id="total_patient_number">0</p></span>
                            <P>Total Patient today</P>
                        </div>

                        <div class="icon-wrapper">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>
                    
                <a href="patient.php" id="cardforpatient">
                    <div class="cards">
                        <div class="cards-wrapper">
                            <span><p id="all_patient_number">0</p></span>
                            <P> All Patient</P>
                        </div>

                        <div class="icon-wrapper">
                            <i class="fa-solid fa-bed fa-sm"></i>
                        </div>
                    </div>
                </a>
                </div>

            <div class="table-container">
                <table class="table" >
                    <thead>
                        <tr id="row">
                            <th class="id">ID</th>
                            <th class="fname" width="10%">First Name</th>
                            <th class="lname" width="10%">Last Name</th>
                            <th class="phone">Phone</th>
                            <th class="email">Email</th>
                            <th class="date">Date</th>
                            <th class="time">Time</th>
                            <th class="branch">Branch</th>
                            <th class="service">Service</th>
                            <th class="status">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include "db_conn.php";
                            include "clear_total_patient.php";

                            $sql = "SELECT * FROM dashboard ORDER BY date ASC, time ASC" ;
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                <td data-label="ID"><?php echo $row['id'] ?></td>
                                    <td data-label="First Name"><?php echo $row['firstName'] ?></td>
                                    <td data-label="Last Name"><?php echo $row['lastName'] ?></td>
                                    <td data-label="Phone"><?php echo $row['phoneNumber'] ?></td>
                                    <td data-label="Email"><?php echo $row['email'] ?></td>
                                    <td data-label="Date"><?php echo $row['date'] ?></td>
                                    <td data-label="Time"><?php echo $row['time'] ?></td>
                                    <td data-label="Branch"><?php echo $row['branch'] ?></td>
                                    <td data-label="Service"><?php echo $row['service'] ?></td>
                                    <td class="action" data-label="Status">
                                        <form method="post" class="btn" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <input type="hidden" name="done" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="done">Done</button>
                                        </form>
                                        <form method="post" class="btn" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <input type="hidden" name="unattended" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="unattended">Unattended</button>
                                        </form>
                                    </td>
                                </tr>
                                
                                <?php
                            }
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["done"])) {
                                $doneAppointmentId = $_POST["done"];
                            
                                $fetchSql = "SELECT * FROM dashboard WHERE id = $doneAppointmentId";
                                $fetchResult = mysqli_query($conn, $fetchSql);
                            
                                if ($fetchResult && $fetchRow = mysqli_fetch_assoc($fetchResult)) {

                                    $insertAllPatientSql = "INSERT INTO all_patient (id, firstName, lastName, phoneNumber, email, date, time, branch, service, status)
                                                            VALUES (
                                                                '{$fetchRow['id']}',
                                                                '{$fetchRow['firstName']}',
                                                                '{$fetchRow['lastName']}',
                                                                '{$fetchRow['phoneNumber']}',
                                                                '{$fetchRow['email']}',
                                                                '{$fetchRow['date']}',
                                                                '{$fetchRow['time']}',
                                                                '{$fetchRow['branch']}',
                                                                '{$fetchRow['service']}',
                                                                'Done'
                                                            )";

                                    $insertTotalPatientSql = "INSERT INTO total_patient (id, firstName, lastName, phoneNumber, email, date, time, branch, service, status)
                                                            VALUES (
                                                                '{$fetchRow['id']}',
                                                                '{$fetchRow['firstName']}',
                                                                '{$fetchRow['lastName']}',
                                                                '{$fetchRow['phoneNumber']}',
                                                                '{$fetchRow['email']}',
                                                                '{$fetchRow['date']}',
                                                                '{$fetchRow['time']}',
                                                                '{$fetchRow['branch']}',
                                                                '{$fetchRow['service']}',
                                                                'Done'
                                                            )";
                                    $insertTotalPatientResult = mysqli_query($conn, $insertTotalPatientSql);
                                    $insertTotalPatientResult = mysqli_query($conn, $insertAllPatientSql);

                                    $deleteSql = "DELETE FROM dashboard WHERE id = $doneAppointmentId";
                                    $deleteResult = mysqli_query($conn, $deleteSql);
                                }
                                    } elseif (isset($_POST["unattended"])) {
                                        $unattendedAppointmentId = $_POST["unattended"];

                                        $deleteSql = "DELETE FROM dashboard WHERE id = $unattendedAppointmentId";
                                        $deleteResult = mysqli_query($conn, $deleteSql);
                                    }
                                ?>
                    </tbody>
                </table>
            </div>
            </section>
        </main>
    </div>

    <script>
        function toggleNav() {
        var nav = document.querySelector('aside nav');
        var header = document.querySelector('.header-wrapper');
        var section = document.querySelector('.section');
        
        nav.classList.toggle('active');
        header.classList.toggle('active')
        section.classList.toggle('active');
        }

        // Optional: If you want to close the dropdown when clicking outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropdown-toggle')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === 'block') {
                        openDropdown.style.display = 'none';
                    }
                }
            }
        }

        function loadDoc_all_patient() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("all_patient_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "update_all_patient.php", true);
            xhttp.send();
        }
        loadDoc_all_patient();

        function loadDoc_total_patient() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("total_patient_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "update_total_patient.php", true);
            xhttp.send();
        }
        loadDoc_total_patient();

        function loadDoc_dashboard() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("appointment_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "dashboard_notif_db.php", true);
            xhttp.send();
        }
        loadDoc_dashboard();

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
                    document.getElementById("message_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "contact_notif_db.php", true);
            xhttp.send();
        }
        loadDoc_message();
    </script>
  
</body>
</html>
