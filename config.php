<?php
$host = "localhost";       
$user = "root";            
$pass = "";               
$dbname = "load_business"; 


$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// If connected successfully (you can delete this line later)
# echo "Connected successfully!";
?>
