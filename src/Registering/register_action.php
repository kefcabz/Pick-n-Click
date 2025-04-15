<?php
session_start();

// Database connection details
$servername = "localhost";
$db_username = "mahadev";
$db_password = "mahadev";
$dbname = "pick-n-click";

// Connect to database
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gmail = $conn->real_escape_string($_POST['gmail']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['gmail'] = $gmail;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['confirm_password'] = $confirm_password;
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ../../main.php");
        exit;
    }

    // Check for duplicate username or email
    $checkUser = $conn->query("SELECT * FROM users WHERE username = '$username' OR email = '$gmail'");
    if ($checkUser && $checkUser->num_rows > 0) {
        $_SESSION['gmail'] = $gmail;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['confirm_password'] = $confirm_password;
        $_SESSION['error'] = "Username or email already exists.";
        header("Location: ../../main.php");
        exit;
    }

    // Hash and insert
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $gmail, $username, $hashed_password);

    if ($sql->execute()) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: ../welcome.php");
        exit;
    } else {
        echo "Error: " . $sql->error;
    }
}

$conn->close();
?>
