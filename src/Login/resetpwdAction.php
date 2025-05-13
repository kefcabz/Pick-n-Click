<?php
session_start();

// Check if the user is logged in (if the session variables are set)
if (!isset($_SESSION['resetpwd']) || $_SESSION['resetpwd'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$securityA = $_SESSION['securityA'];
$username = $_SESSION['username'];


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
    $securityA2 = $_POST['securityA2'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: resetpwd.php");
        exit;
    }
    
    // Check that security answer is correct
    if ($securityA !== $securityA2){
        $_SESSION['error'] = "Security Answer is not correct.";
        header("Location: resetpwd.php");
        exit;
    }

    // Hash and insert
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = '$hashed_password' WHERE username = '$username'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Password updated successfully";
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        header("Location: ../welcome.php");
        exit;
    } else {
      echo "Error: " . $sql->error;
    }

    
    $_SESSION['resetpwd'] = false;
}

$conn->close();
?>
