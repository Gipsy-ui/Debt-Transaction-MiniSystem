<?php
$host = "localhost";        // Usually localhost
$user = "root";             // Default username for XAMPP
$pass = "";                 // Leave blank if no password (XAMPP default)
$dbname = "load_business";  // Name of your database

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// If connected successfully (you can delete this line later)
# echo "Connected successfully!";
?>
