<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="appointment.css">
    <link class="icon" rel="icon" href="kfc-logo.png">
    <script src="https://kit.fontawesome.com/bb02d24289.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
        <aside>
            <nav>
                <ul>
                    <div><a href="dashboard.php" class="logo"><img src="no-bg-KFC-Dental-Clinic.png" alt="KFC Dental Clinic"></a></div>

                    <li><a href="dashboard.php">
                            <i class="fa-solid fa-house fa-sm"></i>
                            <span class="nav-item">Home</span>
                        </a></li>

                    <li><a href="appointment.php">
                            <i class="fa-regular fa-calendar-check fa-sm"></i>
                            <span class="nav-item">Appointments</span>

                            <i class="fa-solid fa-bell" aria-hidden="true" id="notifi_number">0</i>
                        </a></li>

                    <li><a href="patient.php">
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

                    <li><a href="message.php">
                            <i class="fa-solid fa-message fa-sm"></i>
                            <span class="nav-item">Message</span>

                            <i class="fa-solid fa-bell" aria-hidden="true" id="message_notifi_number">0</i>
                        </a>
                    </li>

                    <!-- <li><a href="logout.php" class="log-out">
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
                    <h1>Appointments</h1>
                </div>

                <button id="printButton"><i class="fa-solid fa-print"></i>Print</button>
                
            </header>

            <section class="section">

                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="id">ID</th>
                                <th class="fname" style="width: 10%">First Name</th>
                                <th class="lname" style="width: 10%">Last Name</th>
                                <th class="phone">Phone</th>
                                <th class="email">Email</th>
                                <th class="date" style="width: 10%">Date</th>
                                <th class="time" style="width: 8%">Time</th>
                                <th class="branch">Branch</th>
                                <th class="service">Service</th>
                                <th class="status">Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            use PHPMailer\PHPMailer\PHPMailer;
                            use PHPMailer\PHPMailer\Exception;
                            use PHPMailer\PHPMailer\SMTP;
                            
                            require 'PHPMailer/PHPMailer-master/PHPMailer-master/src/Exception.php';
                            require 'PHPMailer/PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
                            require 'PHPMailer/PHPMailer-master/PHPMailer-master/src/SMTP.php';

                            include "db_conn.php";
                            
                            function sendEmail($to, $subject, $message) {
                                $mail = new PHPMailer(true);
                            
                                try {
                                    $mail->SMTPDebug = SMTP::DEBUG_OFF;
                                    $mail->isSMTP();
                                    $mail->Host       = 'smtp.gmail.com';
                                    $mail->SMTPAuth   = true;
                                    $mail->Username   = 'justinesantos2105@gmail.com';
                                    $mail->Password   = 'rpot wjte bhlb yifn';  
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                    $mail->Port       = 587;
                            
                                    $mail->setFrom('justinesantos2105@gmail.com', 'KFC Dental Clinic');
                                    $mail->addAddress($to);
                            
                                    $mail->isHTML(false); 
                                    $mail->Subject = $subject;
                                    $mail->Body    = $message;
                            
                                    $mail->send();
                                } catch (Exception $e) {
                                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                }
                            }
                            
                            $sql = "SELECT * FROM appointments ORDER BY date ASC, time ASC";
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
                                            <input type="hidden" name="accept" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="accept">Accept</button>
                                        </form>
                                        <form method="post" class="btn" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return confirm('Are you sure you want to Decline?');">
                                            <input type="hidden" name="decline" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="decline">Decline</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }

                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                if (isset($_POST["accept"])) {
                                    $acceptedAppointmentId = $_POST["accept"];

                                    $fetchSql = "SELECT * FROM appointments WHERE id = $acceptedAppointmentId";
                                    $fetchResult = mysqli_query($conn, $fetchSql);

                                    if ($fetchResult && $fetchRow = mysqli_fetch_assoc($fetchResult)) {

                                        $to = $fetchRow['email'];
                                        $subject = "APPOINTMENT APPROVE";
                                        $message = "Your appointment has been approved. Thank you for choosing our service.";
                                        sendEmail($to, $subject, $message);

                                        $insertSql = "INSERT INTO dashboard (id, firstName, lastName, phoneNumber, email, date, time, branch, service, status)
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
                                                            'Accepted'
                                                        )";
                                        mysqli_query($conn, $insertSql);

                                        $deleteSql = "DELETE FROM appointments WHERE id = $acceptedAppointmentId";
                                        mysqli_query($conn, $deleteSql);
                                    }
                                } elseif (isset($_POST["decline"])) {
                                    $declinedAppointmentId = $_POST["decline"];

                                    $fetchSql = "SELECT * FROM appointments WHERE id = $declinedAppointmentId";
                                    $fetchResult = mysqli_query($conn, $fetchSql);

                                    if ($fetchResult && $fetchRow = mysqli_fetch_assoc($fetchResult)) {

                                        $to = $fetchRow['email'];
                                        $subject = "APPOINTMENT DECLINE";
                                        $message = "We regret to inform you that your appointment has been declined. If you have any questions, please contact us.";
                                        sendEmail($to, $subject, $message);

                                        $deleteSql = "DELETE FROM appointments WHERE id = $declinedAppointmentId";
                                        mysqli_query($conn, $deleteSql);
                                    }
                                }
                            }

                            ?>

                        </tbody>
                    </table>
                </div>
            </section>

        </main>

    </div>

    <script>
        document.getElementById('printButton').addEventListener('click', function () {
        window.print();
        });

        function toggleNav() {
        var nav = document.querySelector('aside nav');
        var header = document.querySelector('.header-wrapper');
        var section = document.querySelector('.section');
        
        nav.classList.toggle('active');
        header.classList.toggle('active')
        section.classList.toggle('active');
        }

        function loadDoc() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("notifi_number").innerHTML = this.responseText;
                    document.getElementById("appointment_number").innerHTML = this.responseText;
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
