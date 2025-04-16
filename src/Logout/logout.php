<?php
session_start();
session_unset();
session_destroy();
$msg = urlencode("You have been logged out successfully.");
header("Location: ../../main.php?msg=$msg");
exit();
?>