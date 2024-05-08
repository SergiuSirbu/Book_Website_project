<?php
session_start();
require 'config.php';
require 'header.php';

if (isset($_SESSION['userId']) && isset($_POST['bookId'])) {
    $userId = $_SESSION['userId'];
    $bookId = $_POST['bookId'];
    
    // This is for checking if book is already in favorites
    $checkStmt = $conn->prepare("SELECT * FROM favorites WHERE user_id = ? AND book_id = ?");
    $checkStmt->bind_param("ii", $userId, $bookId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows > 0) {
        echo json_encode(['message' => 'Book is already in your favorites!']);
    } else {
        // here it inserts into favorites table
        $insertStmt = $conn->prepare("INSERT INTO favorites (user_id, book_id) VALUES (?, ?)");
        $insertStmt->bind_param("ii", $userId, $bookId);
        
        if ($insertStmt->execute()) {
            echo json_encode(['message' => 'Book added to favorites!']);
        } else {
            echo json_encode(['message' => 'Error adding book to favorites.']);
        }
    }
} else {
    echo json_encode(['message' => 'User not logged in or missing book ID.']);
}

$conn->close();
?>