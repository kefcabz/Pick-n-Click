<?php
// Database connection details
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "pick-n-click";

// Connect to database
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch user inputs safely
    $gmail = $conn->real_escape_string($_POST['gmail']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check for existing username

    if ($password !== $confirm_password) {
    session_start();
    $_SESSION['gmail'] = $gmail;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['confirm_password'] = $confirm_password;
    echo "<script>alert('Passwords do not match. Please try again.'); window.location.href='register.php';</script>";
    exit;
}
    
    if ($checkUser->num_rows > 0) {
        // Username already exists
        echo "<script>alert('Username already exists, please choose another one.'); window.location.href='register.php';</script>";
        exit;
    }

    // Hash password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database

    $sql = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $gmail, $username, $hashed_password);

    if ($sql->execute()) {
        // Start session and store user data
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;

        // Redirect to a welcome page
        header("Location: welcome.php");
        exit;
    } else {
        echo "Error: " . $sql->error;
    }
}

$conn->close();

?>

