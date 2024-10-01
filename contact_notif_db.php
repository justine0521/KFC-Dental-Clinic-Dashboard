<?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'website_form';

    $conn = new mysqli($host, $username, $password, $database);

    if (!$conn) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $sql = "SELECT * FROM contact";
    $result = $conn->query($sql);

     echo $result->num_rows;

     $conn->close();
?>