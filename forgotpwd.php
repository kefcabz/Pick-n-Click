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
    <h1>Forgot Password</h1>
    <form class="form-inline" name="forgotpwd" action="forgotpwdAction.php" method="post">
        <div class="center">
        <label style="color:greenyellow;">Email</label>
        <input type="text" class="form-control" required placeholder="Enter Email" name="email">
      </div>
      </div>
      <br>
      <div class="center">
        <button type="submit" class="btn">Submit</button>
      </div>
    </form>
  </div>
    </form>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
