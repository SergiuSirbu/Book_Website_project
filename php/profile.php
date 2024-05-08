<?php
include 'config.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['id']) || !isset($_SESSION['username'])) {
    header("location: /book-website/login.html");
    exit;
}

// This here is to fetch user data
$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Profile</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Profile of <?php echo htmlspecialchars($user['username']); ?></h1>
        <nav>
            <ul>
                <li><a href="welcome.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>User Information</h2>
        <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
    </main>
    <footer>
        <p></p>
    </footer>
</body>
</html>
