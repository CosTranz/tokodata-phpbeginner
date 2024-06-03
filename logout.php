<?php
session_start();


session_unset();
session_destroy();

// // Delete the "Remember Me" cookies
// setcookie('user_name', '', time() - 3600, "/");
// setcookie('password', '', time() - 3600, "/");

header("Location: index.php");
exit;
?>
