<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
$securityA = isset($_SESSION['securityA']) ? $_SESSION['securityA'] : '';
unset($_SESSION['username'], $_SESSION['password'], $_SESSION['securityA']); // Clear after use
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <?php include'./src/Components/header.php'; ?>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4 text-center w3-text-red">Admin Login</h2>
            <form action="admin_login_process.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter admin username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" value="<?php echo htmlspecialchars($password); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="securityA" class="form-label">What is the name of your first pet?</label>
                    <input type="text" class="form-control" id="securityA" name="securityA" placeholder="Security Answer" value="<?php echo htmlspecialchars($securityA); ?>" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Log In as Admin</button>
                </div>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger text-center">
                        <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<?php include './src/Components/footer.php'; ?>
</body>
</html>
