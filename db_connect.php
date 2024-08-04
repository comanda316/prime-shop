<?php
// Параметры подключения к базе данных
$host = 'localhost'; // или имя хоста вашего сервера
$dbname = 'prime-shop'; // имя вашей базы данных
$user = 'root'; // имя пользователя для подключения
$pass = ''; // пароль, если он установлен

// Подключение к базе данных
$conn = new mysqli($host, $user, $pass, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Установка кодировки для правильной работы с UTF-8
$conn->set_charset("utf8");

?>