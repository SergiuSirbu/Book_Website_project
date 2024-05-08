<?php //This file was written in the first stages of programming
//It is not used but is uploaded for the sake of completeness
include 'config.php';

$searchTerm = $_GET['query'] ?? ''; // Get the search term from the URL parameter

// Prevent SQL injection by using prepared statements
$stmt = $conn->prepare("SELECT id, title, author FROM books WHERE title LIKE CONCAT('%', ?, '%') OR author LIKE CONCAT('%', ?, '%')");
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div><a href='book_details.php?id=" . $row['id'] . "'>" . $row['title'] . " by " . $row['author'] . "</a></div>";
    }
} else {
    echo "No books found.";
}

$stmt->close();
$conn->close();
?>
<!-- HTML form for searching books -->
<form action="book_search.php" method="get">
    <input type="text" name="query" placeholder="Search for books...">
    <button type="submit">Search</button>
</form>
