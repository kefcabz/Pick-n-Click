<?php
// Include your database connection
require '../dbconnect.php';

// Start session to access the logged-in user info
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_ID'];  // Assuming you store user_id in the session

// Query to get the orders (payment history) for the logged-in user
$query = "
    SELECT p.payment_id, p.payment_date, p.total_amount, p.payment_method, p.status
    FROM payment_history p
    WHERE p.user_id = ?
    ORDER BY p.payment_date DESC
";
$stmt = $conn->prepare($query);

// Check if the statement was prepared successfully
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error); // Show error if preparation fails
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$payment_result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-4">
        <button class="btn btn-secondary mb-4" id="backToExplore">← Back to Explore</button>
        <h1 class="text-primary">Your Orders</h1>

        <?php if ($payment_result->num_rows > 0): ?>
            <?php while ($order = $payment_result->fetch_assoc()): ?>
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <strong>Order #<?php echo $order['payment_id']; ?> - <?php echo $order['payment_date']; ?> (<?php echo $order['status'] === 'completed' ? '<span class="text-success">Completed</span>' : '<span class="text-warning">Pending</span>'; ?>)</strong>
                    </div>
                    <div class="card-body">
                        <p><strong class="text-success">Total Amount:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
                        <p><strong>Payment Method:</strong> <span class="text-info"><?php echo $order['payment_method']; ?></span></p>

                        <!-- Query to get the items for this order -->
                        <?php
                        $payment_id = $order['payment_id'];
                        $items_query = "
                            SELECT pi.payment_item_id, g.game_id, g.title, g.author, g.release_date, g.category, g.platform, g.rating, g.image_url, pi.price_at_purchase
                            FROM payment_items pi
                            JOIN games g ON pi.game_id = g.game_id
                            WHERE pi.payment_id = ?
                        ";
                        $items_stmt = $conn->prepare($items_query);

                        if ($items_stmt === false) {
                            die('MySQL prepare error: ' . $conn->error); // Show error if preparation fails
                        }

                        $items_stmt->bind_param("i", $payment_id);
                        $items_stmt->execute();
                        $items_result = $items_stmt->get_result();
                        ?>

                        <?php if ($items_result->num_rows > 0): ?>
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                <?php while ($item = $items_result->fetch_assoc()): ?>
                                    <div class="col">
                                        <div class="card shadow-sm">
                                            <img src="<?php echo $item['image_url']; ?>" alt="Game Image" class="card-img-top" style="height: 200px; object-fit: cover;">
                                            <div class="card-body">
                                                <h5 class="card-title text-dark"><?php echo $item['title']; ?></h5>
                                                <p class="card-text">
                                                    <strong>Author:</strong> <span class="text-muted"><?php echo $item['author']; ?></span><br>
                                                    <strong>Release Date:</strong> <span class="text-secondary"><?php echo $item['release_date']; ?></span><br>
                                                    <strong>Category:</strong> <span class="text-primary"><?php echo $item['category']; ?></span><br>
                                                    <strong>Platform:</strong> <span class="text-warning"><?php echo $item['platform']; ?></span><br>
                                                    <strong class="text-success">Rating:</strong> <span class="text-warning"><?php echo number_format($item['rating'], 1); ?>/5</span><br>
                                                    <strong class="game-price text-danger">Price: $<?php echo number_format($item['price_at_purchase'], 2); ?></strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p>No items found for this order.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You have no orders yet.</p>
        <?php endif; ?>
    </div>

    <script>
// Reusable function/component for showing toasts
document.getElementById('backToExplore').addEventListener('click', function () {
    startOverlayEffect();

    setTimeout(() => {
        window.location.href = "../explore.php";
    }, 700);
});

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
    }, 3000);  // Removes the overlay after 3 seconds
}
</script>
</body>
</html>
