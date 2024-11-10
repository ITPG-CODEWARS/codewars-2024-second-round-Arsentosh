<?php
session_start();
session_unset();
session_destroy();
header('Location: login.php'); // пренасоване на логин страница
exit;
?>
