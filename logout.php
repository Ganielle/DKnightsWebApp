<?php

session_start();
session_unset();
session_destroy();
setcookie('user_id', $_SESSION['user_id'], time() -1);
header("Location: index.php");

?>