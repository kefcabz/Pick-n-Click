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
        .loginmargin {
            margin-left: 700px;
        }
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        .w3-container {
            padding: 0;
        }

        .w3-bar {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .loginmargin {
            margin-left: 700px;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    if (isset($_SESSION['usertype'])) {
      $usertype = $_SESSION['usertype'];
      if ($usertype == 1) {
        $homepage = "admin.php";
        $signupPage = "register.php";
      } else if ($usertype == 2) {
        $homepage = "staff.php";
        $signupPage = "signup.php";
      } else {
        $homepage = "welcome.php";
        $signupPage = "signup.php";
      }
    } else {
      $homepage = "index.php";
      $signupPage = "signup.php";
    }
    ?>
    
<div class="w3-container">
    <div class="w3-bar w3-blue w3-padding">
        <a href="main.php" class="w3-bar-item w3-button w3-mobile w3-white">
            Pick N Click <span style="font-size: 12px; color: white;"></span>
        </a>
        <a href="mens.php" class="w3-bar-item w3-button w3-mobile">A - Z</a>
        <a href="womens.php" class="w3-bar-item w3-button w3-mobile">Categories</a>
        <div class="w3-dropdown-hover w3-mobile">
            <button class="w3-button">All <i class="fa fa-caret-down"></i></button>
            <div class="w3-dropdown-content w3-bar-block w3-grey">
                <a href="trending.php" class="w3-bar-item w3-button w3-mobile">Trending</a>
                <a href="clearance.php" class="w3-bar-item w3-button w3-mobile">Clearance</a>
                <a href="about.php" class="w3-bar-item w3-button w3-mobile">About Us</a>
            </div>
        </div>
        <input type="text" class="w3-bar-item w3-input" placeholder="Search..">
        <a href="" class="w3-bar-item w3-button w3-green">Go</a>
        <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
            <a href="login.php" class="w3-bar-item w3-button loginmargin">
                <i class="fa fa-sign-in"></i> Login
            </a>
            <a href="register.php" class="w3-bar-item w3-button w3-right">
                <i class="fa fa-register"></i> Register
            </a>
        <?php else: ?>
            <a href="logout.php" class="w3-bar-item w3-button loginmargin">
                <i class="fa fa-sign-out"></i> Logout
            </a>
        <?php endif; ?>
    </div>
</div>
