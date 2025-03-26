<!DOCTYPE html>

<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  <br>
  <style>
    .center {
      margin: auto;
      width: 50%;
      padding: 5px;
    }
    
</style>
</head>
<body style="background-color:gray; color: black;">
  <div class="center">
      <h1 style="color:greenyellow;">Login</h1>
    <form class="form-inline" name="login" action="loginAction.php" method="post">
      <div class="center">
        <label style="color:greenyellow;">Username</label>
        <input type="text" class="form-control" required placeholder="Enter Username" name="user">
      </div>
      <div class="center">
        <label style="color:greenyellow;">Password</label>
        <input type="password" class="form-control" required placeholder="Enter password" name="pwd">
      </div>
      </div>
      <br>
      <div class="center">
        <button type="submit" class="btn w3-yellow">Login</button>
        <input type="reset" value="Reset" />
      </div>
    </form>
  </div>
  <br>
</body>
</html>
