<?php
session_start();

$servername = 'localhost'; // Свързване с базата данни на XAMPP
$username = 'root';        // Потребителско име за MySQL (по дефолт - root)
$password = '';            // Парола за MySQL  
$dbname = 'urls';          // Име на базата данни
$base_url = 'http://localhost/urlShortener/'; // Основен URL 
// Връзка с DB
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Проверка на връзката с DB
if ($mysqli->connect_error) {
    die("Неуспешно свързване: " . $mysqli->connect_error);
}

// Проверка, дали потребителят е логнат
if (!isset($_SESSION['user_id'])) {
    echo "<a href='login.php'>Вход</a> | <a href='register.php'>Регистрация</a>";
    exit;
}

//Проверка за коретно попълнени данни
if (isset($_GET['url']) && $_GET['url'] != "") {
    $url = urldecode($_GET['url']);
    
    // Валидация на URL
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Неуспешно свързване: " . $conn->connect_error);
        }

        $slug = GetShortUrl($url);
        $conn->close();

        // Визиализация на генерирания кратък URL и QR код
        echo "Вашият кратък URL е: <br><a href='" . $base_url . $slug . "?redirect=" . $slug . "'>" . $base_url . $slug . "</a><br>";
         // Генериране на QR код за краткия URL
         generateQRCode($base_url . $slug);
        
    } else {
        die("$url - това не е валиден URL");
    }
} else { ?>
    <center>
    <h1>Въведете вашия URL тук</h1>
    <form method="get" action="">
        <p><input style="width:500px" type="url" name="url" required /></p>
        <p><input type="submit" value="Съкратете URL" /></p>
    </form>
    </center>
<?php }

function GetShortUrl($url) {
    global $conn;
    $query = "SELECT * FROM url_shorten WHERE url = '".$url."'"; 
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        // Ако URL вече съществува в базата данни, връщаме кратък URL
        $row = $result->fetch_assoc();
        return $row['short_code'];
    } else {
        // Ако URL не съществува, генерираме нов 
        $short_code = generateUniqueID();
        $sql = "INSERT INTO url_shorten (url, short_code, hits) VALUES ('".$url."', '".$short_code."', '0')";
        
        if ($conn->query($sql) === TRUE) {
            return $short_code;
        } else { 
            die("Възникна грешка");
        }
    }
}

function generateUniqueID() {
    global $conn; 
    $token = substr(md5(uniqid(rand(), true)), 0, 6); // Генериране на уникален 6-символен код
    $query = "SELECT * FROM url_shorten WHERE short_code = '".$token."' ";
    $result = $conn->query($query); 
    
    if ($result->num_rows > 0) {
        // Ако кодът вече съществува, генерираме нов отново
        return generateUniqueID();
    } else {
        return $token;
    }
}

function generateQRCode($url) {
    //
    $qrCodeFile = 'qrcodes/' . md5($url) . '.png';
    
    // Генериране на QR код и запис във файл
    require_once('phpqrcode/qrlib.php');
    QRcode::png($url, $qrCodeFile, 'L', 4, 4); // 'L' - ниво на корекция на грешки, 4 - размер на QR кода

    // Визуализация на екрана
    echo "Сканирайте QR кода за бърз достъп до URL:<br><img src='".$qrCodeFile."' alt='QR код' />";
}

if (isset($_GET['redirect']) && $_GET['redirect'] != "") {
    $slug = urldecode($_GET['redirect']);
    
    // Пренасочване към оригиналния URL по генерирания 
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Неуспешно свързване: " . $conn->connect_error);
    }

    $url = GetRedirectUrl($slug);
    $conn->close();

    header("Location: " . $url);
    exit;
}

function GetRedirectUrl($slug) {
    global $conn;
    $query = "SELECT * FROM url_shorten WHERE short_code = '" . addslashes($slug) . "'"; 
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hits = $row['hits'] + 1;
        $sql = "UPDATE url_shorten SET hits='" . $hits . "' WHERE id='" . $row['id'] . "'";
        $conn->query($sql);
        return $row['url']; // Връщаме оригиналния URL
    } else { 
        die("Невалиден линк!");
    }
}
?>
