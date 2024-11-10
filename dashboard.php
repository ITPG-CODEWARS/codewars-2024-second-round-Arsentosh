<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Ако потребителят не е влязъл, го пренасочваме към страницата за вход
    exit;
}

// echo "Welcome, " . $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <center>
            <div class="welcome-message">
                <?php echo "Welcome, " . htmlspecialchars($_SESSION['username']); ?>
            </div>
            <div class="nav-links">
                <a class="nav-link" href="index.php">Home</a><br>
                <a class="nav-link" href="logout.php">Back</a>
            </div>
        </center>
    </div>
</body>
</html>
