<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require 'dbconnect.php';

$current_username = $_SESSION['username'];
$current_email = $_SESSION['email'];

$new_username = trim($_POST['new_username']);
$new_gmail = trim($_POST['new_gmail']);

$updates = [];
$params = [];
$param_types = '';

// Determine which fields are being updated
if ($new_username !== $current_username) {
    // Check for duplicate username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $new_username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $_SESSION['edit_error'] = "Username already taken.";
        header("Location: edit_profile.php");
        exit();
    }
    $updates[] = "username = ?";
    $params[] = $new_username;
    $param_types .= 's';
    $stmt->close();
}

if ($new_gmail !== $current_email) {
    // Check for duplicate email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $new_gmail);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $_SESSION['edit_error'] = "Email already taken.";
        header("Location: edit_profile.php");
        exit();
    }
    $updates[] = "email = ?";
    $params[] = $new_gmail;
    $param_types .= 's';
    $stmt->close();
}

// If nothing changed
if (empty($updates)) {
    $_SESSION['edit_success'] = "No changes made.";
    header("Location: edit_profile.php");
    exit();
}

// Build dynamic query
$query = "UPDATE users SET " . implode(", ", $updates) . " WHERE username = ?";
$params[] = $current_username;
$param_types .= 's';

$stmt = $conn->prepare($query);
$stmt->bind_param($param_types, ...$params);

if ($stmt->execute()) {
    if ($new_username !== $current_username) {
        $_SESSION['username'] = $new_username;
    }
    if ($new_gmail !== $current_email) {
        $_SESSION['email'] = $new_gmail;
    }
    $_SESSION['edit_success'] = "Profile updated successfully.";
} else {
    $_SESSION['edit_error'] = "Failed to update profile: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: edit_profile.php");
exit();
