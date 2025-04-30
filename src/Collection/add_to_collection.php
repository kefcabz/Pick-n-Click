<?php
session_start();
require '../dbconnect.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_ID'];
$game_id = intval($_POST['game_id']);

// Prevent duplicates
$check = $conn->prepare("SELECT * FROM games_collection WHERE user_id = ? AND game_id = ?");
$check->bind_param("ii", $user_id, $game_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    $stmt = $conn->prepare("INSERT INTO games_collection (user_id, game_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $game_id);
    $stmt->execute();
    $stmt->close();
}

$check->close();
$conn->close();
header("Location: explore.php?msg=Game+added+to+your+collection");
exit();
?>
