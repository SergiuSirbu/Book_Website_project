<?php
require 'config.php'; // Check the database connection
include 'header.php';

// Check if the form data is posted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']); // Get the username and trim any whitespace
    $password = trim($_POST['password']); // Get the password and trim any whitespace


    if (empty($username) || empty($password)) {
        echo "Username and password are required.";
        exit;
    }

    // Here, the username is checked if it already exists
    $sql = "SELECT id FROM users WHERE username = ?";
    if ($stmt = $conn->prepare($sql)) { 
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            echo "This username is already taken.";
            $stmt->close(); // Close the statement here
        } else {
            $stmt->close(); // Close the previous statement before reusing the variable

            // If the user doesnt exist, insert new user
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            if ($stmt = $conn->prepare($sql)) { // Prepare the insert statement
                // Hash the password before storing it. Basic safety measures
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bind_param("ss", $username, $hashed_password);
                if ($stmt->execute()) {
                    echo "Registration successful.";
                } else {
                    echo "Something went wrong. Please try again later.";
                }
                $stmt->close(); // Close the statement here
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Invalid request method.";
}

$conn->close(); // After everything is done, close the connection
?>
