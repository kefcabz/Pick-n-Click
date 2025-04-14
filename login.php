<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php include 'header.php'; ?>
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

        .btn-admin {
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-admin:hover {
            background-color: #0b7dda;
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
</head>
<body>

<div class="center">
    <h1>Login</h1>
    <form class="form-inline" name="login" action="loginAction.php" method="post">
        <div class="center">
            <label style="color:greenyellow;">Username</label>
            <input type="text" class="form-control" required placeholder="Enter Username" name="user">
        </div>
        <div class="center">
            <label style="color:greenyellow;">Password</label>
            <input type="password" class="form-control" required placeholder="Enter Password" name="pwd">
        </div>
        <br>
        <div class="center">
            <button type="submit" class="btn">Login</button>
            <input type="reset" value="Reset" />
        </div>
    </form>

    <div class="center" style="margin-top: 20px;">
        <form action="admin_login.php" method="get">
            <button type="submit" class="btn-admin">Admin Privileges</button>
        </form>
    </div>
</div>

<?php
if (isset($_GET['msg'])) {
    echo "
    <script type='text/javascript'>
        alert('Account created successfully!');
    </script>
    ";
}
?>
<?php include 'footer.php'; ?>

</body>
</html>
