<?php
session_start();
include '../dbconnect.php'; // Adjust path if needed

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $securityA = trim($_POST['securityA']);

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if ($password === $admin['password'] && strcasecmp($securityA, $admin['securityA']) === 0) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['is_admin'] = true;
            $_SESSION['username'] = $username;
            // No redirect here – show welcome popup below
        } else {
            $_SESSION['error'] = "Incorrect password or security answer.";
            header("Location: ./admin_login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Admin username not found.";
        header("Location: ./admin_login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ./admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Access</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- W3.CSS & Bootstrap -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="mystyles.css">

    <?php include '../Components/header.php'; ?>

    <style>
        body {
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .popup-container {
            margin: 100px auto;
            max-width: 600px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .popup-header {
            font-size: 30px;
            font-weight: bold;
            color: #222;
            margin-bottom: 20px;
        }

        .popup-text {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }

        .btn-custom {
            background-color: #ff6f61;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 18px;
            border-radius: 8px;
            margin: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #e85c50;
            color: white;
        }
    </style>
</head>
<body>

<div class="popup-container">
    <h1 class="popup-header">Welcome, Admin <?php echo htmlspecialchars($_SESSION['username']); ?>! 🔐</h1>
    <p class="popup-text">You have successfully logged in. Choose where to go next:</p>

    <a href="../explore.php" class="btn-custom">Trending Games</a>
    <a href="main.php" class="btn-custom">Main Page</a>
</div>

<?php include '../Components/footer.php'; ?>
</body>
</html>
