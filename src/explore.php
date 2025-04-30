<?php
session_start();
require 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PickNClick - Game Database</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="icon" type="image/x-icon" href="https://i.imgur.com/L1o4bPB.png">
    <link rel="stylesheet" href="mystyles.css">
    <?php include './Components/header.php'; ?>
<main>
    <style>
        html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
    background-color: #f4f7fa;
}

main {
    flex: 1;
}

    </style>
</head>
<body class="game-database-page">
<div class="container-fluid px-0">
  <h2 class="section-title w3-green text-center py-3 m-0" style="width: 100%;">Trending Games</h2>

    <div class="row">

<?php
// Fetch games from the database
$sql = "SELECT * FROM games";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0):
    while ($game = $result->fetch_assoc()):
?>
    <div class="col-lg-4 col-md-6 col-sm-12 game-card mb-4">
        <div class="card h-100">
            <img src="<?= htmlspecialchars($game['image_url'] ?? 'https://via.placeholder.com/350x250') ?>" class="card-img-top" style="height: 250px; object-fit: cover;">
            <div class="card-body text-center">
                <h5 class="card-title"><?= htmlspecialchars($game['title']) ?></h5>
                <p class="card-text">Category: <?= htmlspecialchars($game['category'] ?? 'N/A') ?></p>
                <p class="card-text">Platform: <?= htmlspecialchars($game['platform'] ?? 'N/A') ?></p>
                <p class="card-text fw-bold">$<?= htmlspecialchars(number_format(rand(10, 70), 2)) ?></p>

                <!-- Add to Collection form -->
                <form method="POST" action="./Collection/add_to_collection.php">
                    <input type="hidden" name="game_id" value="<?= $game['game_id'] ?>">
                    <button type="submit" class="btn btn-primary mt-2">Add to Collection</button>
                </form>
            </div>
        </div>
    </div>

<?php
    endwhile;
else:
    echo '<p class="text-center">No games found.</p>';
endif;
$conn->close();
?>

    </div>
</div>
</main>
<?php include './Components/footer.php'; ?>

</body>
</html>
