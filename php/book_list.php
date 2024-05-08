<?php
// Connect to the database and css
include 'config.php';
include 'header.php';

// Check for search query
$search = $_GET['search'] ?? '';
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql = "SELECT id, title, author FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%'";
} else {
    $sql = "SELECT id, title, author FROM books";
}

$result = $conn->query($sql);

// HTML for listing books and search form
echo "<h1>Book List</h1>";
echo "<form action='book_list.php' method='get'>
    <input type='text' name='search' placeholder='Search by title or author' value='$search'>
    <button type='submit'>Search</button>
</form>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p><a href='book_details.php?id=" . $row['id'] . "'>" . $row['title'] . "</a> by " . $row['author'] . "</p>";
    }
} else {
    echo "No books found.";
}

$conn->close();
?>
