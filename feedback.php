<?php
session_start();
require("conn.php");

if (isset($_POST['submit'])) {

    $first_name = $_SESSION['first_name'];
    $email = $_SESSION['email'];
    $message = $_POST['message'];

    
    $sql = "INSERT INTO feedback (`name`, `email`, `message`) VALUES ('$first_name','$email','$message')";
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('Location: aboutus.html');
        exit;
    } else {
        echo 'Error inserting data: ' . $conn->error;
    }

    $conn->close();
}
?>
