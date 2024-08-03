<?php
include 'lang.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['dashboard']; ?></title>
</head>

<body>
    <h1><?php echo $lang['dashboard']; ?></h1>
    <nav>
        <a href="logout.php"><?php echo $lang['logout']; ?></a>
        <a href="dashboard.php?lang=ka">ქართული</a>
        <a href="dashboard.php?lang=en">English</a>
        <a href="dashboard.php?lang=ru">Русский</a>
    </nav>

    <?php if ($role == 'admin'): ?>
        <h2>Администраторская панель</h2>
        <!-- Тут идет функционал для админа -->
    <?php elseif ($role == 'support'): ?>
        <h2>Панель поддержки</h2>
        <!-- Тут идет функционал для поддержки -->
    <?php else: ?>
        <h2>Панель пользователя</h2>
        <!-- Тут идет функционал для пользователя -->
    <?php endif; ?>
</body>

</html>