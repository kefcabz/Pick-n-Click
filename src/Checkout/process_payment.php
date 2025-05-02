session_start();
require '../dbconnect.php';

$user_id = $_SESSION['user_ID'];
$selected_games = $_POST['selected_games'];  // this is an array of game IDs
$payment_method = $_POST['payment_method'];  // e.g., 'Visa'
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
$payment_id = $stmt->insert_id;  // get the new payment_id for linking
$stmt->close();


$stmt = $conn->prepare("INSERT INTO payment_items (payment_id, game_id, price_at_purchase) VALUES (?, ?, ?)");
foreach ($selected_games as $game_id) {
    // Get the current price
    $price_stmt = $conn->prepare("SELECT price FROM games WHERE game_id = ?");
    $price_stmt->bind_param("i", $game_id);
    $price_stmt->execute();
    $price_result = $price_stmt->get_result()->fetch_assoc();
    $price = $price_result['price'];
    $price_stmt->close();

    // Insert into payment_items
    $stmt->bind_param("iid", $payment_id, $game_id, $price);
    $stmt->execute();
}
$stmt->close();
$conn->close();

header("Location: collection.php?msg=Purchase completed successfully!");
exit();
