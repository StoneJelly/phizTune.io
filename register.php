<?php

require("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    $genre = $_POST["genre"];
    $password = $_POST["password"];
    
    // Validate and sanitize the data (you can add more validation as per your requirements)
    $firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
    $lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $dob = filter_var($dob, FILTER_SANITIZE_STRING);
    $genre = filter_var($genre, FILTER_SANITIZE_STRING);
    
    // Function to calculate age based on date of birth
    function calculateAge($dob) {
        $birthDate = new DateTime($dob);
        $currentDate = new DateTime();
        $age = $currentDate->diff($birthDate)->y;
        return $age;
    }
    
    $age = calculateAge($dob);
    
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Connect to the database (replace host, username, password, and dbname with your database details)
    
    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO `login`(`first_name`, `last_name`, `email`, `age`, `genre`, `password`) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstName, $lastName, $email, $age, $genre, $hashedPassword);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful
        echo "<script>
                alert('Registration successful. You can now login.');
                window.location.href = 'login.html';
              </script>";
    } else {
        // Registration failed
        echo "Error: " . $stmt->error;
    }
    
    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
