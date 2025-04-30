<?php
session_start();
require '../dbconnect.php';

if (!isset($_SESSION['user_ID'])) {
    echo "Not logged in";
    exit();
}

$user_id = $_SESSION['user_ID'];
$selected = $_POST['selected_games'] ?? [];
$action = $_POST['action'] ?? '';

if (empty($selected)) {
    echo "No games selected.";
    exit();
}

if ($action === 'remove') {
    $placeholders = implode(',', array_fill(0, count($selected), '?'));
    $stmt = $conn->prepare("DELETE FROM games_collection WHERE user_id = ? AND game_id IN ($placeholders)");
    $types = str_repeat('i', count($selected) + 1);
    $params = array_merge([$user_id], $selected);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    echo "Selected games removed successfully!";
} elseif ($action === 'purchase') {
    echo "You selected " . count($selected) . " game(s) to purchase.";
}
exit();
