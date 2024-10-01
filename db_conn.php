<?php
$firstName = isset($_POST['fname']) ? $_POST['fname'] : '';
$lastName = isset($_POST['lname']) ? $_POST['lname'] : '';
$phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$date = isset($_POST['pref-date']) ? $_POST['pref-date'] : '';
$time = isset($_POST['time']) ? $_POST['time'] : '';
$branch = isset($_POST['branch']) ? $_POST['branch'] : '';
$service = isset($_POST['service']) ? $_POST['service'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'website_form';

$conn = new mysqli($host, $username, $password, $database);

if (!$conn) {
    die('Connection failed: ' . $conn->connect_error);
}

?>