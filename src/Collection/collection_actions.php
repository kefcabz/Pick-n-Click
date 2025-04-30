<?php
session_start();
require '../dbconnect.php';

if (!isset($_SESSION['user_ID'])) {
    header("Location: ../Login/login.php");
    exit();
}

$user_id = $_SESSION['user_ID'];
$selected = $_POST['selected_games'] ?? [];
$action = $_POST['action'] ?? '';

if (empty($selected)) {
    $_SESSION['msg'] = "No games selected.";
    header("Location: collection.php");
    exit();
}

if ($action === 'remove') {
    $placeholders = implode(',', array_fill(0, count($selected), '?'));
    $stmt = $conn->prepare("DELETE FROM games_collection WHERE user_id = ? AND game_id IN ($placeholders)");
    $types = str_repeat('i', count($selected) + 1);
    $params = array_merge([$user_id], $selected);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $_SESSION['msg'] = "Selected games removed from collection.";
} elseif ($action === 'purchase') {
    // Example placeholder logic — replace with your actual order flow
    $_SESSION['msg'] = "You selected " . count($selected) . " game(s) to purchase.";
}

header("Location: collection.php");
exit();
