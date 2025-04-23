<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ./Login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            max-width: 500px;
            margin: 80px auto;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #0d6efd;
            color: white;
            border-radius: 12px 12px 0 0;
            text-align: center;
            font-size: 24px;
            padding: 15px 0;
        }

        .btn-primary {
            width: 100%;
        }

        .btn-secondary {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">Edit Profile</div>
    <div class="card-body">
        <?php if (isset($_SESSION['edit_success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['edit_success']; unset($_SESSION['edit_success']); ?></div>
        <?php elseif (isset($_SESSION['edit_error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['edit_error']; unset($_SESSION['edit_error']); ?></div>
        <?php endif; ?>

        <form method="POST" action="edit_profile_action.php">
            <div class="mb-3">
                <label for="new_username" class="form-label">New Username</label>
                <input type="text" name="new_username" class="form-control" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="new_gmail" class="form-label">New Gmail</label>
                <input type="email" name="new_gmail" class="form-control" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="welcome.php" class="btn btn-secondary">← Back to Welcome Page</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
