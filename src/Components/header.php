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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
    </style>
</head>
<body>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top px-3">
    <a class="navbar-brand text-white fw-bold me-4" href="#">🎮 Pick N Click</a>

    <!-- for small screens -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
        <!-- Left section: links -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex align-items-center">
            <li class="nav-item">
                <a class="nav-link" href="#">A - Z</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Categories</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                    All
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="trending.php">Trending</a></li>
                    <li><a class="dropdown-item" href="clearance.php">Clearance</a></li>
                    <li><a class="dropdown-item" href="about.php">About Us</a></li>
                </ul>
            </li>
        </ul>

        <!-- Middle: search -->
        <form class="d-flex me-3">
            <input class="form-control me-2" type="search" placeholder="Search...">
            <button class="btn btn-success" type="submit">Go</button>
        </form>
        
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
    <a href="Collection/collection.php" class="btn btn-outline-light me-2">
        <i class="fa fa-heart"></i> My Collection
    </a>
<?php endif; ?>

        <!-- Right: profile/login + icons -->
        <div class="d-flex align-items-center">
            <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
                <a href="login.php" class="btn btn-outline-light me-2">
                    <i class="fa fa-sign-in"></i> Login
                </a>
            <?php else: ?>
                <div class="dropdown me-2">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="edit_profile.php">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="./Logout/logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php endif; ?>
            <a href="#" class="btn btn-outline-light me-1"><i class="fa fa-wechat"></i></a>
            <a href="#" class="btn btn-outline-light"><i class="fa fa-search-plus"></i></a>
        </div>
    </div>
</nav>
</body>