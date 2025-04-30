<?php
session_start();

// Check if the user is logged in (if the session variables are set)
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the user's username
$username = $_SESSION['username'];  // Should be set during registration
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="mystyles.css">
    <?php include '../src/Components/header.php'; ?>
    <title>Welcome to Pick N Click</title>
    <style>
        .welcome-container {
            margin: 100px auto;
            max-width: 600px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .welcome-header {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .welcome-text {
            font-size: 20px;
            color: #444;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .btn-action {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 12px 25px;
            font-size: 18px;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-action:hover {
            background-color: #555;
            color: #fff;
        }
    </style>
</head>
<body class="w3-orange">

<div class="welcome-container">
    <h1 class="welcome-header">Welcome to Pick N Click, <?php echo htmlspecialchars($username); ?>! 🎮</h1>
    <p class="welcome-text">Thank you for creating an account with us. Your journey into the world of gaming begins here! Explore our catalog of games across all consoles and find the perfect title to add to your collection.</p>
    <a href="Main/main.php" class="btn-action">Explore the Catalog</a>
    <a href="explore.php" class="btn-action">Explore Trending Games</a>
</div>
<?php include '../src/Components/footer.php'; ?>
</body>
</html>
