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
    <a href="../explore.php" class="btn btn-secondary mb-4">
    ← Back to Explore
</a>
    <h2 class="mb-4">Your Saved Games</h2>
    <form method="POST" action="collection_actions.php">
  <div class="row">
    <?php while ($game = $result->fetch_assoc()): ?>
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="<?= $game['image_url'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <input type="checkbox" name="selected_games[]" value="<?= $game['game_id'] ?>" class="form-check-input float-start mr-3">
            <h5 class="card-title"><?= htmlspecialchars($game['title']) ?></h5>
            <p>Category: <?= htmlspecialchars($game['category']) ?></p>
            <p>Platform: <?= htmlspecialchars($game['platform']) ?></p>
            <p><strong>$<?= number_format($game['price'], 2) ?></strong></p>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <div class="mt-3">
    <button type="submit" name="action" value="remove" class="btn btn-danger">Remove Selected</button>
    <button type="submit" name="action" value="purchase" class="btn btn-success">Proceed to Checkout</button>
  </div>
</form>

</body>
</html>
