<?php
session_start();

// Save form input values from session (if available)
$gmail = isset($_SESSION['gmail']) ? $_SESSION['gmail'] : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
$confirm_password = isset($_SESSION['confirm_password']) ? $_SESSION['confirm_password'] : '';

// Clear them from session after using
unset($_SESSION['gmail'], $_SESSION['username'], $_SESSION['password'], $_SESSION['confirm_password']);
?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger" role="alert">
        <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']); 
        ?>
    </div>
<?php endif; ?>

<form action="src/Registering/register_action.php" method="POST">
    <div class="mb-3">
        <label for="gmail" class="form-label">Gmail address</label>
        <input type="email" class="form-control" id="gmail" name="gmail" placeholder="name@gmail.com" value="<?php echo htmlspecialchars($gmail); ?>" required>
    </div>
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Create Password" value="<?php echo htmlspecialchars($password); ?>" required>
    </div>
    <div class="mb-3">
        <label for="confirm-password" class="form-label">Confirm Your Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter your Password" value="<?php echo htmlspecialchars($confirm_password); ?>" required>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Create New Account</button>
    </div>
</form>
