<?php 
session_start();
session_destroy();

setcookie('id', '', time() - 3600, "/", "localhost", 1);
setcookie('key', '', time() - 3600, "/", "localhost", 1);

header("Location: login.php");
?>