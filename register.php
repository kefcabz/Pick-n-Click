<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4 text-center">Create New Account</h2>
            <form action="register_action.php" method="POST">
                <div class="mb-3">
                    <label for="gmail" class="form-label">Gmail address</label>
                    <input type="email" class="form-control" id="gmail" name="gmail" placeholder="name@gmail.com" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Create Password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Create new account</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>