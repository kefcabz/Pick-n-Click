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
        .admin-controls button {
            width: 36px;
            height: 36px;
        }
    </style>
</head>

<body class="game-database-page">

<?php include './Components/header.php'; ?>

<main>
    <div class="container-fluid px-0">
        <h2 class="section-title w3-green text-center py-3 m-0" style="width: 100%;">
            Trending Games
        </h2>

        <div class="row">
            <?php
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
                                <p class="card-text fw-bold">$<?= number_format($game['price'], 2) ?></p>

                                <button class="btn btn-primary mt-2" onclick="addToCollection(<?= $game['game_id'] ?>)">Add to Collection</button>

                                <!-- Admin Edit/Delete Buttons -->
                                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                                    <div class="admin-controls d-none mt-2">
                                        <a href="/Pick-n-Click/src/Admin/add_game.php" class="btn btn-sm btn-outline-success me-1" title="Add Game">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        <a href="/Pick-n-Click/src/Admin/edit_game.php?id=<?= $game['game_id'] ?>" class="btn btn-sm btn-outline-secondary me-1" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="/Pick-n-Click/src/Admin/delete_game.php?id=<?= $game['game_id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this game?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
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

<!-- Toast -->
<div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 9999; margin-top: 10px;">
    <div id="toast-message" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Game added to your collection!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    function addToCollection(gameId) {
        fetch('Collection/add_to_collection.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ game_id: gameId })
        })
            .then(res => res.text())
            .then(msg => {
                const toastEl = document.getElementById('toast-message');
                const toastBody = toastEl.querySelector('.toast-body');

                toastBody.textContent = msg;

                if (msg.includes("already")) {
                    toastEl.classList.remove('bg-success');
                    toastEl.classList.add('bg-warning');
                } else {
                    toastEl.classList.remove('bg-warning');
                    toastEl.classList.add('bg-success');
                }

                const toast = new bootstrap.Toast(toastEl);
                toast.show();

                setTimeout(() => toast.hide(), 3000);
            })
            .catch(err => console.error('Error:', err));
    }

    // Admin Mode Toggle via header button
    document.getElementById('adminModeHeaderBtn')?.addEventListener('click', () => {
        document.querySelectorAll('.admin-controls').forEach(el => {
            el.classList.toggle('d-none');
        });
    });
</script>

</body>
</html>
