<?php
session_start();
require '../dbconnect.php';

if (!isset($_SESSION['user_ID'])) {
    echo json_encode(["message" => "Not logged in"]);
    exit();
}

$user_id = $_SESSION['user_ID'];
$selected_games = $_POST['selected_games'];  // Array of selected game IDs
$payment_method = $_POST['payment_method'];  // 'Visa', 'MasterCard', etc.
$card_number = $_POST['card_number'];
$card_last4 = substr($card_number, -4);

// Calculate total amount
$total_amount = 0;
$placeholders = implode(',', array_fill(0, count($selected_games), '?'));
$stmt = $conn->prepare("SELECT price FROM games WHERE game_id IN ($placeholders)");
$stmt->bind_param(str_repeat('i', count($selected_games)), ...$selected_games);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $total_amount += $row['price'];
}

// Insert into payment_history
$stmt = $conn->prepare("INSERT INTO payment_history (user_id, total_amount, payment_method, card_last4, status) VALUES (?, ?, ?, ?, 'completed')");
$stmt->bind_param("idss", $user_id, $total_amount, $payment_method, $card_last4);
$stmt->execute();
$payment_id = $stmt->insert_id;  // Get the new payment_id for linking
$stmt->close();

// Insert into payment_items table for each selected game
$stmt = $conn->prepare("INSERT INTO payment_items (payment_id, game_id, price_at_purchase) VALUES (?, ?, ?)");
foreach ($selected_games as $game_id) {
    // Get the current price
    $price_stmt = $conn->prepare("SELECT price FROM games WHERE game_id = ?");
    $price_stmt->bind_param("i", $game_id);
    $price_stmt->execute();
    $price_result = $price_stmt->get_result()->fetch_assoc();
    $price = $price_result['price'];
    $price_stmt->close();

    // Insert into payment_items table
    $stmt->bind_param("iid", $payment_id, $game_id, $price);
    $stmt->execute();
}
$stmt->close();

// Remove selected games from the user's collection
$placeholders = implode(',', array_fill(0, count($selected_games), '?'));
$stmt = $conn->prepare("DELETE FROM games_collection WHERE user_id = ? AND game_id IN ($placeholders)");
$stmt->bind_param(str_repeat('i', count($selected_games) + 1), $user_id, ...$selected_games);
$stmt->execute();

// Return success message
echo json_encode([ 
    "message" => "Your purchase was successful!", 
    "selected_games" => array_map(function($game_id) use ($conn) {
        $stmt = $conn->prepare("SELECT title, price FROM games WHERE game_id = ?");
        $stmt->bind_param("i", $game_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }, $selected_games)
]);

exit();
?>
