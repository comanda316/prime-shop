<?php include 'lang.php'; ?>
<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['register']; ?></title>
    <link rel="stylesheet" href="styles.css"> <!-- Подключаем файл стилей -->
    <style type="text/css">
        /* Примерные стили для страницы регистрации, адаптированные под стиль хедера */
        .register-container {
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

        .register-title {
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
    <div class="register-container">
        <div class="logo-container">
            <img src="images/logo2.png" alt="Логотип" class="logo">
        </div>
        <h1 class="register-title"><?php echo $lang['register']; ?></h1>
        <form action="register.php" method="post" class="register-form">
            <label for="first_name"><?php echo $lang['first_name']; ?>:</label>
            <input type="text" id="first_name" name="first_name" required class="input-field"><br>

            <label for="last_name"><?php echo $lang['last_name']; ?>:</label>
            <input type="text" id="last_name" name="last_name" required class="input-field"><br>

            <label for="phone"><?php echo $lang['phone']; ?>:</label>
            <input type="text" id="phone" name="phone" required class="input-field"><br>

            <label for="address"><?php echo $lang['address']; ?>:</label>
            <input type="text" id="address" name="address" required class="input-field"><br>

            <label for="personal_id"><?php echo $lang['personal_id']; ?>:</label>
            <input type="text" id="personal_id" name="personal_id" required class="input-field"><br>

            <label for="username"><?php echo $lang['username']; ?>:</label>
            <input type="text" id="username" name="username" required class="input-field"><br>

            <label for="password"><?php echo $lang['password']; ?>:</label>
            <input type="password" id="password" name="password" required class="input-field"><br>

            <input type="submit" value="<?php echo $lang['submit']; ?>" class="submit-button">
        </form>
    </div>
</body>

</html>
<?php
include 'lang.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $personal_id = $_POST['personal_id'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $registration_ip = $_SERVER['REMOTE_ADDR'];

    // Собираем информацию об устройстве
    $device_info = json_encode(
        array(
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'remote_port' => $_SERVER['REMOTE_PORT']
        )
    );

    $conn = new mysqli('localhost', 'root', '', 'prime-shop');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (first_name, last_name, phone, address, personal_id, username, password, role, registration_ip) 
            VALUES ('$first_name', '$last_name', '$phone', '$address', '$personal_id', '$username', '$password', 'user', '$registration_ip')";

    if ($conn->query($sql) === TRUE) {
        echo "Регистрация прошла успешно!";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>