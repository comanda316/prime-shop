<?php include 'lang.php'; ?>
<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['login']; ?></title>
    <link rel="stylesheet" href="styles.css"> <!-- Подключаем файл стилей -->
    <style type="text/css">
        /* Примерные стили для страницы регистрации, адаптированные под стиль хедера */
        .login-container {
            width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #2c3e50;
            /* Основной цвет границы */
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Тень как у хедера */
            background-color: #ffffff;
            /* Белый фон для контраста */
            text-align: center;
            /* Центрирование содержимого */
        }

        .logo-container {
            margin-bottom: 20px;
            /* Отступ снизу для разделения логотипа и заголовка */
        }

        .logo {
            max-width: 150px;
            /* Устанавливаем максимальную ширину логотипа */
            height: auto;
            /* Автоматическая высота для сохранения пропорций */
        }

        .login-title {
            font-size: 24px;
            color: #2c3e50;
            /* Основной цвет заголовка */
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
            /* Шрифт для заголовка */
        }

        .input-field {
            width: calc(100% - 22px);
            /* Учитываем отступы */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #bdc3c7;
            /* Серый цвет границы для полей ввода */
            border-radius: 3px;
            font-size: 16px;
            /* Размер шрифта */
            color: #2c3e50;
            /* Цвет текста */
        }

        .submit-button {
            width: 100%;
            padding: 10px;
            background-color: #F46C22;
            /* Основной цвет кнопки */
            color: white;
            border: none;
            border-radius: 4px;
            /* Скругленные углы */
            cursor: pointer;
            font-size: 16px;
            /* Размер шрифта */
            transition: background-color 0.3s;
            /* Плавный переход */
        }

        .submit-button:hover {
            background-color: #e67e22;
            /* Цвет кнопки при наведении */
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="images/logo2.png" alt="Логотип" class="logo">
        </div>
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
include 'db_connect.php'; // Подключение к базе данных

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
if ($login_successful) {
    $_SESSION['user_id'] = $user_id; // Сохранение идентификатора пользователя в сессии

    // Загрузка языка из базы данных
    $stmt = $conn->prepare("SELECT language FROM users WHERE id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($language);
    $stmt->fetch();
    $_SESSION['lang'] = $language;
    $stmt->close();

    // Перенаправление на главную страницу или другую после успешного входа
    header('Location: index.php');
    exit();
}
?>