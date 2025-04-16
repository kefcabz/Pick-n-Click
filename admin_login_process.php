<?php
global $conn;
session_start();
include 'dbconnect.php'; // Ensure this file exists in the same directory

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $securityA = trim($_POST['securityA']);

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if admin exists
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if ($password === $admin['password'] && strcasecmp($securityA, $admin['securityA']) === 0) {
            // Successful login
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['is_admin'] = true; // Add this line
            $_SESSION['username'] = $username;
            header("Location: ./src/explore.php");
            exit();
        }
        else {
            $_SESSION['error'] = "Incorrect password or security answer.";
            header("Location: ./admin_login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Admin username not found.";
        header("Location: ./admin_login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ./admin_login.php");
    exit();
}
?>
