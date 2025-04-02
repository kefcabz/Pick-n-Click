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

    // Check for existing username
    $checkUser = $conn->prepare("SELECT * FROM users WHERE username=?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
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
