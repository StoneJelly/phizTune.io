<?php
// Start a session
session_start();
require("conn.php");

// Get the current date and time
$currentDate = date("d-m-Y");

?>
<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Validate and sanitize the data (you can add more validation as per your requirements)
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT password, age, genre, first_name FROM login WHERE email = ?");
    $stmt->bind_param("s", $email);
    
    // Execute the statement
    $stmt->execute();
    
    // Bind the result
    $stmt->bind_result($hashedPassword, $age, $genre, $first_name);
    
    // Fetch the result
    $stmt->fetch();
    
    // Verify the password
    if (password_verify($password, $hashedPassword)) {
        // Login successful

        // Store email, age, and current date in session variables
        $_SESSION['email'] = $email;
        $_SESSION['age'] = $age;
        $_SESSION['genre'] = $genre;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['login_date'] = $currentDate;
        
        // Redirect to home.php
        header("Location: home.php");
        exit(); // Terminate the current script to ensure the redirect happens
    } else {
        // Login failed
        echo "Invalid email or password";
    }
    
    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
