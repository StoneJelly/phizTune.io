<?php

    $servername = 'localhost'; // Replace with your server name
    $username = 'root'; // Replace with your MySQL username
    $password = '1234'; // Replace with your MySQL password
    $dbname = 'lagu'; // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

?>