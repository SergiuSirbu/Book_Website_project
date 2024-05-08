<?php
// Database connection
include 'config.php';

// Fetch book details
$bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($bookId) {
    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
}

// Check if a user is logged in and handle review submission
session_start(); // Start session to use session variables
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['username'], $_POST['comment'])) {
    $userName = $_SESSION['username']; // Use username from session
    $comment = strip_tags($_POST['comment']);
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : null;

    if (!empty($comment) && $rating >= 1 && $rating <= 5) {
        $stmt = $conn->prepare("INSERT INTO reviews (book_id, user_name, comment, rating) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $bookId, $userName, $comment, $rating);
        if ($stmt->execute()) {
            echo "Review submitted successfully.";
        } else {
            echo "Failed to submit review.";
        }
    } else {
        echo "Please fill in all fields correctly.";
    }
}

// Fetch reviews
$reviewStmt = $conn->prepare("SELECT * FROM reviews WHERE book_id = ? ORDER BY created_at DESC");
$reviewStmt->bind_param("i", $bookId);
$reviewStmt->execute();
$reviews = $reviewStmt->get_result();

// Close the connection
$bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $bookId);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_favorite']) && isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $stmt = $conn->prepare("INSERT IGNORE INTO favorites (user_id, book_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $bookId);
    $stmt->execute();
    $stmt->close();
    echo "<p>Added to favorites!</p>";
}

$conn->close();
// HTML output
if (isset($book)) {
    echo "<h1>" . htmlspecialchars($book['title']) . "</h1>";
    echo "<p>Author: " . htmlspecialchars($book['author']) . "</p>";
}

// Review form for logged-in users
if (isset($_SESSION['username'])) {
    echo "<h2>Leave a review</h2>";
    echo "<form method='post'>
        <textarea name='comment' placeholder='Your review' required></textarea><br>
        <label>Rating: </label><input type='number' name='rating' min='1' max='5' required><br>
        <button type='submit'>Submit Review</button>
    </form>";
} else {
    echo "<p>You must be logged in to leave a review.</p>";
}

// Display reviews
echo "<h2>Reviews</h2>";
if ($reviews->num_rows > 0) {
    while ($review = $reviews->fetch_assoc()) {
        echo "<p><strong>" . htmlspecialchars($review['user_name']) . ":</strong> " . htmlspecialchars($review['comment']) . "<br>Rating: " . intval($review['rating']) . "</p>";
    }
} else {
    echo "No reviews yet.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($book['title']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($book['title']); ?></h1>
    <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
    <?php if (isset($_SESSION['id'])): ?>
        <form method="post">
            <button type="submit" name="add_favorite">Add to Favorites</button>
        </form>
    <?php endif; ?>
</body>
</html>

