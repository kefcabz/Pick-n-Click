<?php
session_start();
require '../dbconnect.php';

// Check if user is an admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /Pick-N-Click/src/Main/main.php');
    exit();
}

// Get game ID
if (isset($_GET['id'])) {
    $game_id = $_GET['id'];

    // Delete from DB
    $stmt = $conn->prepare("DELETE FROM games WHERE game_id = ?");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redirect to transfer spinner page
        header("Location: delete_success.php");
        exit();
    } else {
        echo "Game not found or already deleted.";
    }
} else {
    echo "No game ID provided.";
}
?>
