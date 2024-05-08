<?php
include 'config.php'; //Check the database connection for this one
$searchTerm = $_GET['term']; //Get the search term for the query

//This is to prevent SQL injections
$stmt = $conn->prepare("SELECT * FROM books WHERE LOWER(title) LIKE ? OR LOWER(author) LIKE ?");
$searchTerm = '%' . strtolower($searchTerm) . '%';
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt-> get_result();

$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row; //Add each result to the books array
}

echo json_encode($books); // return the array as a json object

$conn->close();
?>