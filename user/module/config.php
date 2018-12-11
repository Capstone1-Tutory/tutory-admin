<?php
$servername = "0.tcp.ngrok.io:11218";
$username = "tutory";
$password = "tutory";
$databasename="ONLINE_TUTOR_SYSTEM";
// Create connection
$conn = new mysqli($servername, $username, $password, $databasename);
mysqli_set_charset($conn, 'UTF8');

// Check connection
if ($conn->connect_error) {
    die("Connection database failed: " . $conn->connect_error);
} 