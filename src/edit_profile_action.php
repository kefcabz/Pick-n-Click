<?php
session_start();
global $conn;
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require '../dbconnect.php';

$current_username = $_SESSION['username'];
$new_username = trim($_POST['new_username']);
$new_gmail = trim($_POST['new_gmail']);

// check for duplicate username/email
$check = $conn->query("SELECT * FROM users WHERE (username = '$new_username' OR email = '$new_gmail') AND username != '$current_username'");
if ($check && $check->num_rows > 0) {
    $_SESSION['edit_error'] = "Username or email already taken.";
    header("Location: ./edit_profile.php");
    exit();
}

$stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE username = ?");
$stmt->bind_param("sss", $new_username, $new_gmail, $current_username);

if ($stmt->execute()) {
    $_SESSION['username'] = $new_username;
    $_SESSION['edit_success'] = "Profile updated successfully.";
} else {
    $_SESSION['edit_error'] = "Failed to update profile: " . $stmt->error;
}

$stmt->close();
$conn->close();
$_SESSION['username'] = $new_username;
$_SESSION['email'] = $new_gmail;
header("Location: ./edit_profile.php");
exit();
