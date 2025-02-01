<?php
session_start();
session_unset();
session_destroy();

// Delete cookies
setcookie("user_id", "", time() - 3600, "/");
setcookie("username", "", time() - 3600, "/");

// Redirect to home.html in the Home folder
header("Location: Home/home.html");
exit;
?>
