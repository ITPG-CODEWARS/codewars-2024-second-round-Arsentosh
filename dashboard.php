<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Ако потребителят не е влязъл, го пренасочваме към страницата за вход
    exit;
}

echo "Добре дошли, " . $_SESSION['username'];
?>
<a href="index.php">Влезте на сайта</a>
<a href="logout.php">Изход</a>
