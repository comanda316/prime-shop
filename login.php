<?php include 'lang.php'; ?>
<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['login']; ?></title>
    <link rel="stylesheet" href="styles.css"> <!-- Подключаем файл стилей -->
    <style type="text/css">
        /* Примерные стили для страницы логина */
        .login-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .submit-button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .submit-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1 class="login-title"><?php echo $lang['login']; ?></h1>
        <form action="login.php" method="post" class="login-form">
            <label for="username"><?php echo $lang['username']; ?>:</label>
            <input type="text" id="username" name="username" required class="input-field"><br>

            <label for="password"><?php echo $lang['password']; ?>:</label>
            <input type="password" id="password" name="password" required class="input-field"><br>

            <input type="submit" value="<?php echo $lang['login']; ?>" class="submit-button">
        </form>
    </div>
</body>

</html>
<?php
include 'lang.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'prime-shop');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, password, role FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['login_time'] = time();

            // Логи авторизации
            $login_ip = $_SERVER['REMOTE_ADDR'];
            $device_info = json_encode(
                array(
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                    'remote_port' => $_SERVER['REMOTE_PORT']
                )
            );

            $sql_log = "INSERT INTO login_logs (user_id, login_ip, device_info) VALUES (" . $row['id'] . ", '$login_ip', '$device_info')";
            $conn->query($sql_log);

            // Создание сессии на 30 минут
            $session_id = session_id();
            $expiration_date = date('Y-m-d H:i:s', time() + 1800);
            $sql_session = "INSERT INTO sessions (session_id, user_id, expiration_date) VALUES ('$session_id', " . $row['id'] . ", '$expiration_date')";
            $conn->query($sql_session);

            header("Location: dashboard.php");
        } else {
            echo "Неверный пароль!";
        }
    } else {
        echo "Пользователь не найден!";
    }

    $conn->close();
}
?>