<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['id']) || !isset($_SESSION['username'])) {
    header("location: /book-website/login.html");
    exit;
}

// If there is a message in the session, prepare to display it.
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
// Clear the message after reading it to avoid repetition on refresh.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <nav>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="book_list.php">Search</a></li>
                <li><a href ="favorites.php">Favorites</a></li>
                <li><a href="add_book.php">Add Book</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php if ($message): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <h2>Hi, Welcome to my book website project</h2>
        <p>In this project I try to build a simple book website.</p>
    </main>
    <footer>
        <p></p>
    </footer>
</body>
</html>
