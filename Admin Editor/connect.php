<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Establish a connection to the MySQL database
$conn = new mysqli('localhost', 'root', '', 'user_database'); // Update database name if different

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debugging (Optional): Uncomment the following line to confirm successful connection
// echo "Database connection established successfully!";
?>
