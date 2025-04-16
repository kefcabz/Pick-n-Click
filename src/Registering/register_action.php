<?php
session_start();

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "pick-n-click";

// Connect to database
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $securityQ = $_POST['securityQ'];
    $securityA = $_POST['securityA'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['confirm_password'] = $confirm_password;
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ../../main.php");
        exit;
    }

    // Check for duplicate username or email
    $checkUser = $conn->query("SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    if ($checkUser && $checkUser->num_rows > 0) {
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['confirm_password'] = $confirm_password;
        $_SESSION['error'] = "Username or email already exists.";
        header("Location: ../../main.php");
        exit;
    }

    // Hash and insert
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = $conn->prepare("INSERT INTO users (email, username, password, securityQ, securityA) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("sssss", $email, $username, $hashed_password, $securityQ, $securityA);

    if ($sql->execute()) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        header("Location: ../welcome.php");
        exit;
    } else {
        echo "Error: " . $sql->error;
    }
}

$conn->close();
?>
