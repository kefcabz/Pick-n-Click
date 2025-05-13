<!DOCTYPE html>

<html>
<head>
    <?php include'../Components/header.php'; ?>
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
    <h1>Login</h1>
    <form class="form-inline" name="login" action="./loginAction.php" method="post">
        <div class="center">
            <label style="color:greenyellow;">Username</label>
            <input type="text" class="form-control" required placeholder="Enter Username" name="username">
        </div>
        <div class="center">
            <label style="color:greenyellow;">Password</label>
            <input type="password" class="form-control" required placeholder="Enter Password" name="pwd">
        </div>
        <br>
        <div class="center">
            <button type="submit" class="btn">Login</button>
            <input type="reset" value="Reset" />
            <a href="forgotpwd.php" class="btn">Forgot Password?</a>
        </div>
        <div class="center mt-3">
            <a href="../Admin/admin_login.php" class="btn btn-warning" style="margin-right: 10px;">Admin Privileges</a>
            <button class="btn btn-secondary" id="backToExplore">← Back</button>
        </div>
    </form>
</div>
    <?php include'../Components/footer.php'; ?>
    <script>
// Reusable function/component for showing toasts
document.getElementById('backToExplore').addEventListener('click', function () {
    startOverlayEffect();

    setTimeout(() => {
        window.location.href = "../../main.php";
    }, 700);
});

function startOverlayEffect() {
    const overlay = document.createElement("div");
    overlay.style.position = "fixed";
    overlay.style.top = 0;
    overlay.style.left = 0;
    overlay.style.width = "100%";
    overlay.style.height = "100%";
    overlay.style.background = "rgba(255,255,255,0.8)";
    overlay.style.display = "flex";
    overlay.style.alignItems = "center";
    overlay.style.justifyContent = "center";
    overlay.style.zIndex = 9999;
    overlay.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status"></div>
            <div class="mt-2">Processing...</div>
        </div>
    `;
    document.body.appendChild(overlay);

    setTimeout(() => {
        overlay.remove();
    }, 3000);  // Removes the overlay after 3 seconds
}
</script>
</body>
</html>
