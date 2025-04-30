<?php
session_start();

// Check for an error message
$errorMessage = '';
if (isset($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
}

// Save form input values from session
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
$confirm_password = isset($_SESSION['confirm_password']) ? $_SESSION['confirm_password'] : '';

// Clear them after saving
unset($_SESSION['email'], $_SESSION['username'], $_SESSION['password'], $_SESSION['confirm_password']);
?>

<!-- Optional: Bootstrap Alert Styling -->
<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <?php echo htmlspecialchars($errorMessage); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Your Registration Form -->
<form action="/src/Registering/register_action.php" method="POST" class="mt-4">
    <div class="mb-3">
        <label for="email" class="form-label label-dark">Gmail address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="name@gmail.com" value="<?php echo htmlspecialchars($email); ?>" required>
    </div>
    <div class="mb-3">
        <label for="username" class="form-label label-dark">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label label-dark">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Create Password" value="<?php echo htmlspecialchars($password); ?>" required>
    </div>
    <div class="mb-3">
        <label for="confirm-password" class="form-label label-dark">Confirm Your Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter your Password" value="<?php echo htmlspecialchars($confirm_password); ?>" required>
    </div>
    <div class="mb-3">
        <label for="securityQ" class="form-label label-dark">Security Question</label>
        <select name="securityQ" class="form-control" required>
            <option value="">Select a question</option>
            <option value="What is your pet’s name?">What is your pet’s name?</option>
            <option value="What is your mother’s maiden name?">What is your mother’s maiden name?</option>
            <option value="What city were you born in?">What city were you born in?</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="securityA" class="form-label label-dark">Your Answer</label>
        <input type="text" name="securityA" class="form-control" required>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Create New Account</button>
    </div>
</form>
