<?php
session_start();
require '../dbconnect.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_ID'];
$sql = "SELECT g.* FROM games g
        JOIN games_collection c ON g.game_id = c.game_id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Collection</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="p-5">
    <h2 class="mb-4">Your Saved Games</h2>
    <div class="row">
        <?php while ($game = $result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="<?= htmlspecialchars($game['image_url']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($game['title']) ?></h5>
                        <p class="card-text">Category: <?= htmlspecialchars($game['category'] ?? 'N/A') ?></p>
                        <p class="card-text">Platform: <?= htmlspecialchars($game['platform'] ?? 'N/A') ?></p>
                        <p class="card-text fw-bold">
                            <?= is_numeric($game['price']) ? "$" . number_format($game['price'], 2) : htmlspecialchars($game['price']) ?>
                        </p>
                        <!-- Add to cart button will be added here later -->
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
