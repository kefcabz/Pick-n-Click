<?php
// Start the session
session_start();

// Include the database connection file
require "../dbconnect.php";

// Get the username and email from the form
$username = $_POST["username"];
$email2 = $_POST["email2"];

// Prepare the SQL statement to check the credentials
$sql = "SELECT user_ID, username, email, securityQ, securityA FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();


// Check if the user exists
if ($result->num_rows > 0) {
    // Fetch the user record
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $username = $row['username'];
    $securityQ = $row['securityQ'];
    $securityA = $row['securityA'];
    
    // Check that email is correct
    if ($email !== $email2){
        $_SESSION['error'] = "The email does not match the username's profile";
        header("Location: forgotpwd.php");
        exit;
    }

        // Set session variables for the logged-in user
        $_SESSION['resetpwd'] = true;
        $_SESSION['user_ID'] = $row['user_ID']; // Store the user ID in the session
        $_SESSION['username'] = $username;
        $_SESSION['securityQ'] = $securityQ;
        $_SESSION['securityA'] = $securityA;
        
        // Redirect to the reset password page
        header("Location:resetpwd.php");
        exit();
} else {
    // If the user is not found, redirect with an error message
    header("Location: login.php?msg=Email Not Found");
    exit();
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>
