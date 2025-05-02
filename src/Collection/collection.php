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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Collection</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-5">

<!-- Back to Explore button -->
<button class="btn btn-secondary mb-4" id="backToExplore">← Back to Explore</button>

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
        <button type="button" class="btn btn-danger" id="removeSelectedBtn">Remove Selected</button>
        <button type="button" class="btn btn-success" id="proceedToCheckoutBtn">Proceed to Checkout</button>
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
// Reusable function for showing toasts
function showToast(message, isError) {
    const toastBody = document.getElementById('toast-body');
    const toastEl = document.getElementById('toast');
    toastBody.textContent = message;
    toastEl.classList.remove('bg-success', 'bg-danger');
    toastEl.classList.add(isError ? 'bg-danger' : 'bg-success');
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
}

// Handle the actions like Remove and Checkout
function handleAction(action) {
    const checkboxes = document.querySelectorAll('input[name="selected_games[]"]:checked');
    if (checkboxes.length === 0) {
        showToast("No games selected.", true); // Show error if no games selected
        return;
    }

    const selectedIds = Array.from(checkboxes).map(cb => cb.value);
    const formData = new URLSearchParams();
    selectedIds.forEach(id => formData.append("selected_games[]", id));
    formData.append("action", action);

    // Start overlay effect
    startOverlayEffect();

    fetch('collection_actions.php', {
        method: "POST",
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: formData
    })
    .then(res => res.json())  // expecting a JSON response
    .then(data => {
        if (action === 'remove') {
            // Remove the selected games from the collection (UI update)
            selectedIds.forEach(id => {
                const card = document.querySelector(`[data-game-id="${id}"]`);
                if (card) card.remove();
            });
            showToast(data.message, false);  // Show success message
        } else if (action === 'purchase') {
            // Populate the checkout modal with the selected games
            const checkoutList = document.getElementById('checkoutList');
            const checkoutTotal = document.getElementById('checkoutTotal');
            let total = 0;

            checkoutList.innerHTML = '';
            data.selected_games.forEach(game => {
                const title = game.title;
                const price = parseFloat(game.price);

                total += price;
                checkoutList.innerHTML += `
                    <li class="list-group-item d-flex justify-content-between">
                        <span>${title}</span>
                        <span>$${price.toFixed(2)}</span>
                    </li>`;
            });

            checkoutTotal.textContent = total.toFixed(2);
            // Show the checkout modal
            new bootstrap.Modal(document.getElementById('checkoutModal')).show();
        }
    })
    .catch(err => {
        showToast("An error occurred. Please try again.", true);  // Show error toast
        console.error(err);
    });
}

// Button events for Remove and Checkout actions
document.getElementById('removeSelectedBtn').addEventListener('click', function () {
    handleAction('remove');
});

document.getElementById('proceedToCheckoutBtn').addEventListener('click', function () {
    handleAction('purchase');
});

// Back to Explore Button with overlay effect
document.getElementById('backToExplore').addEventListener('click', function () {
    startOverlayEffect();

    setTimeout(() => {
        window.location.href = "../explore.php";
    }, 700);
});

// Start the overlay effect for actions (Remove, Checkout, Back to Explore)
function startOverlayEffect() {
    const overlay = document.createElement("div");
    overlay.style.position = "fixed";
    overlay.style.top = 0;
    overlay.style.left = 0;
    overlay.style.width = "100%";
    overlay.style.height = "100%";
    overlay.style.background = "rgba(255,255,255,0.8)";
    overlay.style.display = "flex";
    overlay.style.alignItems = "center";
    overlay.style.justifyContent = "center";
    overlay.style.zIndex = 9999;
    overlay.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status"></div>
            <div class="mt-2">Processing...</div>
        </div>
    `;
    document.body.appendChild(overlay);

    setTimeout(() => {
        overlay.remove();
    }, 2500);  // Removes the overlay after 1 second
}
</script>

<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="paymentForm">
                <div class="modal-body">
                    <h6>Games to Purchase:</h6>
                    <ul id="checkoutList" class="list-group mb-3"></ul>
                    <h5 class="text-end">Total: $<span id="checkoutTotal">0.00</span></h5>

                    <h6 class="mt-4">Payment Information</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="cardType" class="form-label">Type of Card</label>
                            <select class="form-select" id="cardType" required>
                                <option value="">Choose...</option>
                                <option>Visa</option>
                                <option>MasterCard</option>
                                <option>Amex</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="cardNumber" class="form-label">Card Number</label>
                            <input type="text" class="form-control" id="cardNumber" maxlength="16" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fullName" class="form-label">Full Name on Card</label>
                            <input type="text" class="form-control" id="fullName" required>
                        </div>
                        <div class="col-md-3">
                            <label for="securityCode" class="form-label">Security Code</label>
                            <input type="text" class="form-control" id="securityCode" maxlength="4" required>
                        </div>
                        <div class="col-md-3">
                            <label for="expDate" class="form-label">Exp Date</label>
                            <input type="month" class="form-control" id="expDate" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Confirm Purchase</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
