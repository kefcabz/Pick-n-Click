<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PickNClick - Game Database</title>
    <link rel="stylesheet" href="mystyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="icon" type="image/x-icon" href="https://i.imgur.com/L1o4bPB.png">
    <link rel="stylesheet" href="mystyles.css">
    <?php include 'header.php'; ?>
    <style>
        body {
            background-color: #f4f7fa; /* Light grey background for the entire page */
        }
    </style>
    <script>
    </script>
</head>
<body class="game-database-page">
<div id="notification" class="notification"></div>

<!-- Trending Games Section -->
<section id="games" class="game-section py-5">
    <h2 class="section-title w3-green text-center mb-5">Trending Games</h2>
    <div class="container">
        <div class="row">
            <!-- Example Game 1 -->
            <div class="col-lg-4 col-md-6 col-sm-12 game-card">
                <img src="https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/202970/header.jpg?t=1654830020" alt="Game 1" class="game-image" style="width: 350px; height: 250px; align-items: center">
                <h3 class="game-name">CALL OF DUTY BLACK OPS 2</h3>
                <p class="game-price">$59.99</p>
                <button type="button" class="add-to-collection-button btn btn-primary" onclick="addToCollection('Game 1', 14.99, 'https://example.com/game1.jpg')">Add to Collection</button>
            </div>

            <!-- Example Game 2 -->
            <div class="col-lg-4 col-md-6 col-sm-12 game-card">
                <img src="https://cdn.wccftech.com/wp-content/uploads/2015/06/Rainbow-Six.jpg" alt="Game 2" class="game-image" style="width: 350px; height: 250px; align-items: center">
                <h3 class="game-name">TOM CLANCY'S RAINBOW SIX SIEGE</h3>
                <p class="game-price">$4.99</p>
                <button type="button" class="add-to-collection-button btn btn-primary" onclick="addToCollection('Game 2', 24.99, 'https://example.com/game2.jpg')">Add to Collection</button>
            </div>

            <!-- Example Game 3 -->
            <div class="col-lg-4 col-md-6 col-sm-12 game-card">
                <img src="https://shadow.tech/app/uploads/2024/12/GTA5_KEYART.jpg" alt="Game 3" class="game-image" style="width: 350px; height: 250px; align-items: center">
                <h3 class="game-name">GRAND THEFT AUTO V</h3>
                <p class="game-price">$19.99</p>
                <button type="button" class="add-to-collection-button btn btn-primary" onclick="addToCollection('Game 3', 39.99, 'https://example.com/game3.jpg')">Add to Collection</button>
            </div>

            <!-- Example Game 4 -->
            <div class="col-lg-4 col-md-6 col-sm-12 game-card">
                <img src="https://cdn2.unrealengine.com/social-image-chapter4-s3-3840x2160-d35912cc25ad.jpg" alt="Game 4" class="game-image" style="width: 350px; height: 250px; align-items: center">
                <h3 class="game-name">FORTNITE</h3>
                <p class="game-price">FREE</p>
                <button type="button" class="add-to-collection-button btn btn-primary" onclick="addToCollection('Game 4', 69.99, 'https://example.com/game4.jpg')">Add to Collection</button>
            </div>

            <!-- Example Game 5 -->
            <div class="col-lg-4 col-md-6 col-sm-12 game-card">
                <img src="https://www.pluggedin.com/wp-content/uploads/2020/01/minecraft-review-image-1024x587.jpg" alt="Game 5" class="game-image" style="width: 350px; height: 250px; align-items: center">
                <h3 class="game-name">MINECRAFT</h3>
                <p class="game-price">$12.99</p>
                <button type="button" class="add-to-collection-button btn btn-primary" onclick="addToCollection('Game 5', 29.99, 'https://example.com/game5.jpg')">Add to Collection</button>
            </div>

            <!-- Example Game 6 -->
            <div class="col-lg-4 col-md-6 col-sm-12 game-card">
                <img src="https://cdn2.unrealengine.com/01-1920x1080-1920x1080-88255a697e4f.jpg" alt="Game 6" class="game-image" style="width: 350px; height: 250px; align-items: center">
                <h3 class="game-name">MARVEL RIVALS</h3>
                <p class="game-price">FREE</p>
                <button type="button" class="add-to-collection-button btn btn-primary" onclick="addToCollection('Game 6', 79.99, 'https://example.com/game6.jpg')">Add to Collection</button>
            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
</body>
</html>
