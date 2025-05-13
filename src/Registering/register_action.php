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
    die(json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error])); //stop and return json
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
        echo json_encode([
            'status' => 'error',
            'message' => "Passwords do not match.",
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'confirm_password' => $confirm_password
        ]);
        exit;
    }

    // Check for duplicate username or email
    $checkUser = $conn->query("SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    if (!$checkUser) {
        echo json_encode(['status' => 'error', 'message' => "Database error: " . $conn->error]);
        exit;
    }

    if ($checkUser->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => "Username or email already exists.",
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'confirm_password' => $confirm_password
        ]);
        exit;
    }

    // Hash and insert
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = $conn->prepare("INSERT INTO users (email, username, password, securityQ, securityA) VALUES (?, ?, ?, ?, ?)");
    if (!$sql) {
        echo json_encode(['status' => 'error', 'message' => "Database prepare error: " . $conn->error]);
        exit;
    }
    $sql->bind_param("sssss", $email, $username, $hashed_password, $securityQ, $securityA);

    if ($sql->execute()) {
        echo json_encode(['status' => 'success', 'message' => "User registered successfully!", 'username' => $username]);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => "Error inserting user: " . $sql->error]);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => "Invalid request method."]);
    exit;
}

$conn->close();
?>
