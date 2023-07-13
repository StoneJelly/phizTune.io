<?php
session_start();

// Clear all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login.html
header("Location: login.html");
exit();
?>
