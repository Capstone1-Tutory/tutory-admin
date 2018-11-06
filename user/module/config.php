<?php
$servername = "localhost";
$username = "root";
$password = "";
$databasename="online_tutor_system";
// Create connection
$conn = new mysqli($servername, $username, $password, $databasename);
mysqli_set_charset($conn, 'UTF8');

// Check connection
if ($conn->connect_error) {
    die("Connection database failed: " . $conn->connect_error);
} 

?>
