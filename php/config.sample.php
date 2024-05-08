<?php
// Database configuration
$host = 'localhost';
$dbname = 'your_database_name';
$user = getenv('DB_USER');  // Use environment variable
$password = getenv('DB_PASSWORD');  // Use environment variable


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
