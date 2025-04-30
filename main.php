<?php
session_start();
?>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(to right, #ff7e5f, #feb47b);
        margin: 0;
        padding: 0;
    }

    .w3-bar {
        background-color: #222;
        color: #fff;
        padding: 10px 0;
    }

    .w3-bar-item {
        color: #fff;
        font-size: 16px;
        padding: 10px 20px;
        text-transform: uppercase;
    }

    .w3-bar-item:hover {
        background-color: #ff7e5f;
    }

    .hero-section {
        background: url('https://your-image-link.jpg') no-repeat center center/cover;
        height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
    }

    .hero-text h1 {
        font-size: 50px;
        font-weight: bold;
        text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.5);
    }

    .categories-section {
        text-align: center;
        padding: 50px 0;
    }

    .categories-section h2 {
        font-size: 32px;
        margin-bottom: 30px;
        color: #333;
    }

    .category-btn {
        background-color: #ff7e5f;
        color: white;
        padding: 20px 40px;
        margin: 10px;
        font-size: 18px;
        border-radius: 5px;
        transition: background-color 0.3s;
        text-transform: uppercase;
    }

    .category-btn:hover {
        background-color: #feb47b;
    }

    footer {
        background-color: #222;
        color: #fff;
        padding: 20px 0;
        text-align: center;
    }

    .footer-link {
        color: #ff7e5f;
        text-decoration: none;
        font-weight: bold;
    }

    .footer-link:hover {
        color: #feb47b;
    }

    .modal-content {
        padding: 20px;
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="https://i.imgur.com/L1o4bPB.png">
    <title>Pick N Click - Game Database</title>
</head>
<body>

<div class="w3-bar w3-blue">
    <a href="#" class="w3-bar-item w3-button w3-white">
        Pick N Click
    </a>
    <a href="mens.php" class="w3-bar-item w3-button">A - Z</a>
    <a href="womens.php" class="w3-bar-item w3-button">Categories</a>
    <div class="w3-dropdown-hover">
        <button class="w3-button">All <i class="fa fa-caret-down"></i></button>
        <div class="w3-dropdown-content w3-bar-block">
            <a href="trending.php" class="w3-bar-item w3-button">Trending</a>
            <a href="clearance.php" class="w3-bar-item w3-button">Clearance</a>
            <a href="about.php" class="w3-bar-item w3-button">About Us</a>
        </div>
    </div>
    <input type="text" class="w3-bar-item w3-input" placeholder="Search..">
    <a href="" class="w3-bar-item w3-button w3-green">Go</a>
    <div class="w3-right">
        <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
            <a href="./src/Login/login.php" class="w3-bar-item w3-button"><i class="fa fa-sign-in"></i> Login</a>
            <button onclick="openSignupModal()" class="w3-bar-item w3-button w3-yellow">
                <i class="fa fa-user-plus"></i> Sign Up
            </button>
        <?php else: ?>
            <a href="./src/Logout/logout.php" class="w3-bar-item w3-button"><i class="fa fa-sign-out"></i> Logout</a>
        <?php endif; ?>
    </div>
</div>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-text">
        <h1>Welcome to Pick N Click</h1>
    </div>
</div>

<!-- Game Categories -->
<div class="categories-section">
    <h2>Browse by Category</h2>
    <div>
        <a href="./src/explore.php" class="category-btn">Trending</a>
        <a href="#" class="category-btn">Shooter</a>
        <a href="#" class="category-btn">MOBA</a>
        <a href="#" class="category-btn">Action</a>
        <a href="#" class="category-btn">RPG</a>
        <a href="#" class="category-btn">Strategy</a>
    </div>
</div>

<!-- Sign Up Modal -->
<div id="signupModal" class="w3-modal">
    <div class="w3-modal-content w3-card-4" style="max-width: 600px;">
        <header class="w3-container w3-blue">
            <span onclick="document.getElementById('signupModal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            <h3>Sign Up</h3>
        </header>
        <div id="signupContent" class="w3-container w3-padding">
            Loading form...
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>© 2024 Pick N Click | <a href="about.php" class="footer-link">About Us</a> | <a href="contact.php" class="footer-link">Contact</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Function to open the sign-up modal and load the form content
    function openSignupModal() {
        // Show the modal
        document.getElementById('signupModal').style.display = 'block';

        // Load the signup form dynamically
        fetch('./src/Registering/register.php')
            .then(response => response.text())
            .then(html => {
                // Inject the form content into the modal
                document.getElementById('signupContent').innerHTML = html;
            })
            .catch(error => {
                console.error('Error loading signup form:', error);
            });
    }

    // Close the modal if clicked outside
    window.onclick = function(event) {
        var modal = document.getElementById('signupModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>
