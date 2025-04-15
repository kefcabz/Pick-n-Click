<?php
include 'header.php';
if (isset($_GET['msg']))
  echo "<h2 class='w3-center'>" . $_GET['msg'] . "</h2>";

require 'DBConnect.php';
?>
<title>Pick n Click</title> 
    <p class="game-name" style="color: black">Temporary</p>
  <?php include 'footer.php' ?>


</body>
</html>