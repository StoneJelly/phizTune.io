<?php
// Retrieve the form data
require("conn.php");
// Get the session variables

$email = $_SESSION['email'];
$age = $_SESSION['age'];
$genre = $_SESSION['genre']

$finalEmotion = $_POST['finalEmotion'];

// Connect to the MySQL database

$sql = "INSERT INTO emotions (`email`, `age`, `emotion`) VALUES ('$email','$age','$finalEmotion')";
if ($conn->query($sql) === TRUE) {
    echo 'Data inserted successfully.' . "<br>";
} else {
    echo 'Error inserting data: ' . $conn->error;
}

$conn->close();

// Display contents from different tables based on the final emotion and age
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$table = '';

if ($finalEmotion === 'Happy') {
    if ($age >= 18) {
        $table = 'enghappy18,malayhappy18,tamilhappy18,chinhappy18';
    } else {
        $table = 'enghappy,malayhappy,tamilhappy,chinhappy';
    }
} elseif ($finalEmotion === 'Sad') {
    if ($age >= 18) {
        $table = 'enghappy18,malayhappy18,tamilhappy18,chinhappy18';
    } else {
        $table = 'enghappy,malayhappy,tamilhappy,chinhappy';
    }
} elseif ($finalEmotion === 'Angry') {
    if ($age >= 18) {
        $table = 'engmelody18,malaymelody18,tamilmelody18,chinmelody18';
    } else {
        $table = 'engmelody,malaymelody,tamilmelody,chinmelody';
    }
} elseif ($finalEmotion === 'Surprised') {
    if ($age >= 18) {
        $table = 'engrock18,malayrock18,tamilrock18,chinrock18';
    } else {
        $table = 'engrock,malayrock,tamilrock,chinrock';
    }
} elseif ($finalEmotion === 'Disgust') {
    if ($age >= 18) {
        $table = 'engmelody18,malaymelody18,tamilmelody18,chinmelody18';
    } else {
        $table = 'engmelody,malaymelody,tamilmelody,chinmelody';
    }
} elseif ($finalEmotion === 'Tear') {
    if ($age >= 18) {
        $table = 'enghappy18,malayhappy18,tamilhappy18,chinhappy18';
    } else {
        $table = 'enghappy,malayhappy,tamilhappy,chinhappy';
    }
} elseif ($finalEmotion === 'Neutral') {
    if ($age >= 18) {
        $table = 'enghappy18,malayhappy18,tamilhappy18,chinhappy18';
    } else {
        $table = 'enghappy,malayhappy,tamilhappy,chinhappy';
    }
}

$tables = explode(",", $table);

foreach ($tables as $tableName) {
    $sql = "SELECT * FROM `$tableName`";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Display song from table
                echo '<a href="' . $row["song"] . '">' . $row["song"] . '</a><br>';
            }
        } else {
            echo "No song found.";
        }
    } else {
        echo "Error retrieving data: " . $conn->error;
    }
}

$conn->close();
?>
