<!DOCTYPE html>
<?php
session_start();

// Check if the user is logged in (if the session variables are set)
if (!isset($_SESSION['resetpwd']) || $_SESSION['resetpwd'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the user's security question
$securityQ = $_SESSION['securityQ'];  // Should be set during registration
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        .center {
            margin: auto;
            width: 50%;
            padding: 5px;
        }

        body {
            background-color: gray;
            color: black;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: greenyellow;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        input[type="reset"] {
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="reset"]:hover {
            background-color: #e53935;
        }

        .message {
            color: red;
            text-align: center;
        }
    </style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-info alert-dismissible fade show mt-3 mx-auto w-50 text-center" role="alert">
        <?php echo htmlspecialchars($_GET['msg']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="center">
    <h1 class="resetpwd_header"><?php echo htmlspecialchars($securityQ); ?></h1>
    <form class="form-inline" name="resetpwd" action="./resetpwdAction.php" method="post">
        <div class="center">
            <label style="color:greenyellow;">Answer</label>
            <input type="text" class="form-control" required placeholder="Enter your security answer" name="securityA2">
        </div>
        <div class="center">
            <label style="color:greenyellow;">New Password</label>
            <input type="password" class="form-control" required placeholder="Enter new Password" name="password">
        </div>
        <div class="center">
            <label style="color:greenyellow;">Confirm New Password</label>
            <input type="password" class="form-control" required placeholder="Re-enter new Password" name="confirm_password">
        </div>
        <br>
        <div class="center">
            <button type="submit" class="btn">Submit</button>
            <input type="reset" value="Reset" />
        </div>
    </form>
</div>
</body>
</html>
