<?php
session_start();
require '../dbconnect.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: main.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "Game ID is missing.";
    exit();
}

$game_id = $_GET['id'];
$sql = "SELECT * FROM games WHERE game_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $game_id);
$stmt->execute();
$result = $stmt->get_result();
$game = $result->fetch_assoc();

if (!$game) {
    echo "Game not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Game - PickNClick</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        .edit-game-container {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            display: flex; justify-content: center; align-items: center;
            background-color: rgba(0, 0, 0, 0.5); z-index: 9999;
        }
        .edit-game-form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px; border-radius: 10px;
            max-width: 600px; width: 100%;
        }
    </style>
</head>
<body>
<div class="edit-game-container">
    <div class="edit-game-form">
        <h1>Edit Game: <?= htmlspecialchars($game['title']) ?></h1>

        <form method="POST" action="edit_success.php">
            <input type="hidden" name="game_id" value="<?= $game['game_id'] ?>">

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($game['title']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" name="price" step="0.01" value="<?= htmlspecialchars($game['price']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Image URL</label>
                <input type="text" class="form-control" name="image_url" value="<?= htmlspecialchars($game['image_url']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Platform</label>
                <input type="text" class="form-control" name="platform" value="<?= htmlspecialchars($game['platform']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <input type="text" class="form-control" name="category" value="<?= htmlspecialchars($game['category']) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Game</button>
        </form>
    </div>
</div>
</body>
</html>
