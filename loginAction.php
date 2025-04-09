<?php

require "DBConnect.php";

$user = $_POST["user"];
$pwd = $_POST["pwd"];

$sql = "select user_id from users where username = ? and password = ?";
$result = loginDB($sql, $user, $pwd);
if (gettype($result) == "object") {
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row['logged_in'];
    session_start();
    $_SESSION['logged_in'] = $user_id;
    header("location:loggedin.php");
    exit;
  } else
    header("location:main.php?msg=Login Failed");
} else
  header("location:main.php?msg=". $result);

?>