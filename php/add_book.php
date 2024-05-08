<?php
session_start();
require 'config.php';
require 'header.php';

// Redirect user to login page if not logged in
if (!isset($_SESSION['id'])) {
    header("location: login.html");
    exit;
}

// Handle the book submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $published_date = $_POST['published_date'] ?? '';
    $summary = $_POST['summary'] ?? '';

    if ($title && $author) {  // Basic validation
        $stmt = $conn->prepare("INSERT INTO books (title, author, genre, published_date, summary) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $author, $genre, $published_date, $summary);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "<p>Book added successfully!</p>";
        } else {
            echo "<p>Error adding book.</p>";
        }
        $stmt->close();
    } else {
        echo "<p>Title and author are required.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add a New Book</title>
</head>
<body>
    <h1>Add a New Book</h1>
    <form action="add_book.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required><br>
        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre"><br>
        <label for="published_date">Published Date:</label>
        <input type="date" id="published_date" name="published_date"><br>
        <label for="summary">Summary:</label>
        <textarea id="summary" name="summary"></textarea><br>
        <button type="submit">Add Book</button>
    </form>
</body>
</html>
