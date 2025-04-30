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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-5">
    <a href="../explore.php" class="btn btn-secondary mb-4">
    ← Back to Explore
</a>
    <h2 class="mb-4">Your Saved Games</h2>
<form id="collection-form">
  <div class="row" id="game-cards">
    <?php while ($game = $result->fetch_assoc()): ?>
      <div class="col-md-4 game-item" data-game-id="<?= $game['game_id'] ?>">
        <div class="card mb-4">
          <img src="<?= $game['image_url'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <input type="checkbox" name="selected_games[]" value="<?= $game['game_id'] ?>" class="form-check-input float-start me-2">
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
    <button type="button" class="btn btn-danger" onclick="handleAction('remove')">Remove Selected</button>
    <button type="button" class="btn btn-success" onclick="handleAction('purchase')">Proceed to Checkout</button>
  </div>
</form>

<!-- Toast container -->
<div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 9999;">
  <div id="toast" class="toast align-items-center text-white bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body" id="toast-body">Message here</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<script>
function handleAction(action) {
  const checkboxes = document.querySelectorAll('input[name="selected_games[]"]:checked');
  if (checkboxes.length === 0) {
    showToast("No games selected.", true);
    return;
  }

  const selectedIds = Array.from(checkboxes).map(cb => cb.value);
  const formData = new URLSearchParams();
  selectedIds.forEach(id => formData.append("selected_games[]", id));
  formData.append("action", action);

  fetch('collection_actions.php', {
    method: "POST",
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: formData
  })
  .then(res => res.text())
  .then(msg => {
    showToast(msg, false);
    if (action === 'remove') {
      selectedIds.forEach(id => {
        const card = document.querySelector(`[data-game-id="${id}"]`);
        if (card) card.remove();
      });
    }
  });
}

function showToast(message, isError) {
  const toastBody = document.getElementById('toast-body');
  const toastEl = document.getElementById('toast');
  toastBody.textContent = message;
  toastEl.classList.remove('bg-success', 'bg-danger');
  toastEl.classList.add(isError ? 'bg-danger' : 'bg-success');
  const toast = new bootstrap.Toast(toastEl);
  toast.show();
}
</script>
</body>
</html>
