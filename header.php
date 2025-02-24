<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="mystyles.css">
    <link rel="icon" type="image/x-icon" href="https://i.imgur.com/L1o4bPB.png">
    <style>
        .find-us-button {
            position: fixed;
            top: 32px;
            right: 120px;
            z-index: 1000;
        }
    </style>
</head>
<body>
<div class"w3-container">
<div class="w3-bar w3-black w3-padding">
    <a href="index.php" class="w3-bar-item w3-button w3-mobile w3-grey">
        K C <span style="font-size: 12px; color: white;">Apparel</span>
    </a>
    <a href="mens.php" class="w3-bar-item w3-button w3-mobile">Men's</a>
    <a href="womens.php" class="w3-bar-item w3-button w3-mobile">Women's</a>
    <div class="w3-dropdown-hover w3-mobile">
        <button class="w3-button">All <i class="fa fa-caret-down"></i></button>
        <div class="w3-dropdown-content w3-bar-block w3-grey">
            <a href="trending.php" class="w3-bar-item w3-button w3-mobile">Trending</a>
            <a href="clearance.php" class="w3-bar-item w3-button w3-mobile">Clearance</a>
            <a href="about.php" class="w3-bar-item w3-button w3-mobile">About Us</a>
        </div>
    </div>
    <input type="text" class="w3-bar-item w3-input" placeholder="Search..">
    <a href="#" class="w3-bar-item w3-button w3-green">Go</a>
    <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
        <a href="login.php" class="w3-bar-item w3-button loginmargin">
            <i class="fa fa-sign-in"></i> Login
        </a>
    <?php else: ?>
        <a href="logout.php" class="w3-bar-item w3-button loginmargin">
            <i class="fa fa-sign-out"></i> Logout
        </a>
    <?php endif; ?>
    <a href="findus.php"
       class="w3-bar-item w3-button find-us-button w3-round-xlarge w3-khaki mapmargin">
        <i class="w3-margin-right w3-text-black w3-large fa fa-map-marker"></i>Find Us
    </a>
    <a href="cart.php" class="w3-bar-item w3-button w3-right">
        <i class="fa fa-shopping-bag"></i>
        <a href="wish.php" class="w3-bar-item w3-button w3-right">
            <i class="fa fa-heart"></i>
            <a/>