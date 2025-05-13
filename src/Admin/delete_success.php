<?php
session_start();
$update_message = $_SESSION['update_message'] ?? 'Game deleted successfully.';
unset($_SESSION['update_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deleting Game...</title>
    <meta http-equiv="refresh" content="3;url=trending.php">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .loading-modal {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            z-index: 9999;
        }
        .loading-content {
            text-align: center;
        }
        .loading-spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div class="loading-modal">
    <div class="loading-content">
        <div class="loading-spinner"></div>
        <h4><?= htmlspecialchars($update_message) ?></h4>
        <p>Redirecting back to Trending Games...</p>
    </div>
</div>

<script>
    setTimeout(() => {
        window.location.href = "/Pick-n-Click/src/explore.php";
    }, 3000);
</script>
</body>
</html>
