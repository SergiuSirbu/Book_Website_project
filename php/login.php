<?php
session_start();
include 'config.php';
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['message'] = "Username and password are required.";
        header("location: /book-website/login.html");
        exit;
    }

    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $username, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                header("location: /book-website/php/welcome.php");
                exit;
            } else {
                $_SESSION['message'] = "Invalid password.";
                header("location: /book-website/login.html");
                exit;
            }
        } else {
            $_SESSION['message'] = "Invalid username.";
            header("location: /book-website/login.html");
            exit;
        }
    } else {
        $_SESSION['message'] = "Login error: " . $conn->error;
        header("location: /book-website/login.html");
        exit;
    }
} else {
    $_SESSION['message'] = "Please use the login form to submit credentials.";
    header("location: /book-website/login.html");
    exit;
}
?>
