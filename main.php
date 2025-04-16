<?php
session_start();
?>
<style>
    .label-dark {
    color: #333;
}
</style> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="mystyles.css">
    <link rel="icon" type="image/x-icon" href="https://i.imgur.com/L1o4bPB.png">
    <style>
        .loginmargin {
            margin-left: 700px;
        }
    </style>
</head>
<body>
<div class="w3-container">
<div class="w3-bar w3-blue w3-padding">
    <a href="#" class="w3-bar-item w3-button w3-mobile w3-white">
        Pick N Click <span style="font-size: 12px; color: white;"></span>
    </a>
    <a href="mens.php" class="w3-bar-item w3-button w3-mobile">A - Z</a>
    <a href="womens.php" class="w3-bar-item w3-button w3-mobile">Categories</a>
    <div class="w3-dropdown-hover w3-mobile">
        <button class="w3-button">All <i class="fa fa-caret-down"></i></button>
        <div class="w3-dropdown-content w3-bar-block w3-grey">
            <a href="trending.php" class="w3-bar-item w3-button w3-mobile">Trending</a>
            <a href="clearance.php" class="w3-bar-item w3-button w3-mobile">Clearance</a>
            <a href="about.php" class="w3-bar-item w3-button w3-mobile">About Us</a>
        </div>
    </div>
    <input type="text" class="w3-bar-item w3-input" placeholder="Search..">
    <a href="" class="w3-bar-item w3-button w3-green">Go</a>
<div class="w3-right">
    <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
        <a href="./src/Login/login.php" class="w3-bar-item w3-button">
            <i class="fa fa-sign-in"></i> Login
        </a>
<button onclick="openSignupModal()" class="w3-bar-item w3-button w3-yellow">
    <i class="fa fa-user-plus"></i> Sign Up
</button>


    <?php else: ?>
        <a href="./src/logout.php" class="w3-bar-item w3-button">
            <i class="fa fa-sign-out"></i> Logout
        </a>
    <?php endif; ?>
</div>
    <a href="#" class="w3-bar-item w3-button w3-right">
        <i class="fa fa-wechat"></i>
    </a>
        <a href="#" class="w3-bar-item w3-button w3-right">
            <i class="fa fa-search-plus"></i>
        </a>
<div id="signupModal" class="w3-modal">
  <div class="w3-modal-content w3-card-4" style="max-width: 600px;">
    <header class="w3-container w3-blue">
      <span onclick="document.getElementById('signupModal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
      <h3>Sign Up</h3>
    </header>
    <div id="signupContent" class="w3-container w3-padding">
      Loading form...
    </div>
  </div>
</div>
<?php if (isset($_GET['msg']) && !empty($_GET['msg'])): ?>
  <!-- Bootstrap Modal -->
  <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center">
        <div class="modal-header">
          <h5 class="modal-title w-100 label-dark" id="feedbackModalLabel">Notification</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body label-dark">
          <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Put this AFTER Bootstrap JS is loaded -->
  <script>
    window.onload = function () {
      const feedbackModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
      feedbackModal.show();
    };
  </script>
<?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
function openSignupModal() {
    document.getElementById('signupModal').style.display = 'block';
    fetch('./src/Registering/register.php')
        .then(response => response.text())
        .then(html => {
            document.getElementById('signupContent').innerHTML = html;
        });
}

// this is to close modal when clicking outside of it
window.onclick = function(event) {
  var modal = document.getElementById('signupModal');
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</html>
