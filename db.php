<?php
// db.php - Database connection file
$servername = "localhost";
$username = "root";
$password = ""; // default password for XAMPP
$dbname = "crud";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}