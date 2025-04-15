<?php

// Include the database connection file
require "dbconnect.php";

// Get the username and password from the form
$user = $_POST["user"];
$pwd = $_POST["pwd"];


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Prepare the SQL statement to check the credentials
$sql = "SELECT user_ID, password FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    // Fetch the user record
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];
    $username = $row['username'];
    $hashed_password = $row['password'];  // Assuming the password is stored as a hashed value

    // Verify the password
    if (password_verify($pwd, $hashed_password)) {
        // Set session variables for the logged-in user
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['user_ID'] = $user_id; // Store the user ID in the session
        $_SESSION['username'] = $username;

        // Redirect to the welcome page
        header("Location: welcome.php");
        exit();
    } else {
        // If the password doesn't match, redirect with an error message
        header("Location: login.php?msg=Incorrect Password");
        exit();
    }
} else {
    // If the user is not found, redirect with an error message
    header("Location: login.php?msg=User Not Found");
    exit();
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>