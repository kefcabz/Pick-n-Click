<?php

$servername = "localhost";
$username = "mahadev";
$password = "YES";
$dbname = "pick-n-click";
$conn;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>