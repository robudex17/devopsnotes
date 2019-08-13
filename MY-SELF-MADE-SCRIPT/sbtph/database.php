<?php
$servername = "localhost";
$username = "python";
$password = "sbtph@2018";
$dbname = "sbtphcsd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>