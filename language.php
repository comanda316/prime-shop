<?php
session_start();
include 'db_connect.php'; // Подключение к базе данных

// Проверка, выбран ли язык
if (isset($_GET['lang'])) {
    $language = $_GET['lang'];

    // Обновление языка в базе данных для авторизованного пользователя
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("UPDATE users SET language = ? WHERE id = ?");
        $stmt->bind_param('si', $language, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    // Сохранение выбранного языка в сессию
    $_SESSION['lang'] = $language;
} else if (isset($_SESSION['user_id'])) {
    // Если язык не выбран, загружаем его из базы данных для авторизованного пользователя
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT language FROM users WHERE id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($language);
    $stmt->fetch();
    $_SESSION['lang'] = $language;
    $stmt->close();
} else {
    // Язык по умолчанию, если пользователь не авторизован
    $_SESSION['lang'] = 'ka';
}
?>