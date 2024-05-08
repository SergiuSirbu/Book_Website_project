<?php
session_start();
require 'config.php';
require 'header.php';

if (!isset($_SESSION['id'])) {
    header("location: login.html");
    exit;
}

$userId = $_SESSION['id'];
$stmt = $conn->prepare("SELECT b.id, b.title, b.author FROM books b JOIN favorites f ON b.id = f.book_id WHERE f.user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Favorites</title>
</head>
<body>
    <h1>Your Favorite Books</h1>
    <?php while ($book = $result->fetch_assoc()): ?>
        <p><a href="book_details.php?id=<?php echo $book['id']; ?>"><?php echo htmlspecialchars($book['title']); ?> by <?php echo htmlspecialchars($book['author']); ?></a></p>
    <?php endwhile; ?>
</body>
</html>
