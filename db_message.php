<?php
$Name = isset($_POST['full-name']) ? $_POST['full-name'] : '';
$Email = isset($_POST['Email']) ? $_POST['Email'] : '';
$Message = isset($_POST['contact-message']) ? $_POST['contact-message'] : '';

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'website_form';

$conn = new mysqli($host, $username, $password, $database);

if (!$conn) {
    die('Connection failed: ' . $conn->connect_error);
}

?>