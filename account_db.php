<?php

    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'website_form';

    $conn = new mysqli($host, $username, $password, $database);

    if (!$conn) {
        die('Connection failed: ' . $conn->connect_error);
    }

?>