<?php
$servername = "carsales.adeftsolutions.com";
$username = "carsalesadeft";
$password = "5;X^=wrjf6N;";
$dbname = "carsalesadeft_main";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}
// echo "DB connected successfully";
?>