<?php
session_start();
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'urls';

// Създаване на връзка с базата данни
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $email = $_POST['email'];

    // Хеширане на паролата за сигурно съхранение
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Проверка дали потребителят вече съществува
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "User with this name already exists!";
    } else {
        // Добавяне на нов потребител в базата данни
        $query = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $user, $hashed_password, $email);
        if ($stmt->execute()) {
            echo "Successfully signed up!";
            header('Location: login.php'); // Пренасочване към страницата за вход
        } else {
            echo "There is an error during signing up.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./styles.css" />
    <title>Signing up</title>
</head>
<body>
    <center>
        <h2>Signing up</h2>
        <form method="POST">
            <p>Username: <input type="text" name="username" required></p>
            <p>Password: <input type="password" name="password" required></p>
            <p>Email: <input type="email" name="email"></p>
            <p><input type="submit" value="Signing up"></p>
        </form>
    </center>
</body>
</html>
