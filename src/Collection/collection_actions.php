<?php
session_start();
require '../dbconnect.php';

if (!isset($_SESSION['user_ID'])) {
    echo json_encode(["message" => "Not logged in"]);
    exit();
}

$user_id = $_SESSION['user_ID'];
$selected = $_POST['selected_games'] ?? [];
$action = $_POST['action'] ?? '';

if (empty($selected)) {
    echo json_encode(["message" => "No games selected."]);
    exit();
}

// Remove selected games from the user's collection
if ($action === 'remove') {
    $placeholders = implode(',', array_fill(0, count($selected), '?'));
    $stmt = $conn->prepare("DELETE FROM games_collection WHERE user_id = ? AND game_id IN ($placeholders)");
    $types = str_repeat('i', count($selected) + 1);
    $params = array_merge([$user_id], $selected);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    echo json_encode(["message" => "Selected games removed successfully!"]);
} elseif ($action === 'purchase') {
    // Get the details of the selected games for purchase
    $games = [];
    $total_amount = 0;
    
    foreach ($selected as $game_id) {
        $stmt = $conn->prepare("SELECT title, price FROM games WHERE game_id = ?");
        $stmt->bind_param("i", $game_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $game = $result->fetch_assoc();
            $games[] = $game;
            $total_amount += $game['price']; // Add the price to the total
        }
    }

    // Return games and total price
    echo json_encode([
        "message" => "You selected " . count($selected) . " game(s) to purchase.",
        "selected_games" => $games,
        "total_amount" => $total_amount // Include the total amount
    ]);
    exit();
}

exit();
?>
