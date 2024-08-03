<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">

<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['welcome']; ?></title>
    <link rel="icon" type="image/x-icon" href="/images/ico.ico">
    <link rel="stylesheet" href="header.css"> <!-- Подключаем файл стилей -->
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="images/logo2.png" alt="<?php echo $lang['welcome']; ?>">
            </div>
            <nav class="nav-menu">
                <ul>
                    <li><a href="#home"><?php echo $lang['home']; ?></a></li>
                    <li><a href="#about"><?php echo $lang['about']; ?></a></li>
                    <li><a href="#services"><?php echo $lang['services']; ?></a></li>
                    <li><a href="#contact"><?php echo $lang['contact']; ?></a></li>
                    <div class="dropdown">
                        <button class="dropbtn"><?php echo $lang['language']; ?></button>
                        <div class="dropdown-content">
                            <a href="index.php?lang=ka">ქართული</a>
                            <a href="index.php?lang=en">English</a>
                            <a href="index.php?lang=ru">Русский</a>
                        </div>
                    </div>
                </ul>
            </nav>
            <div class="header-buttons">
                <a class="btn btn-register" href="register.php"><?php echo $lang['register']; ?></a>
                <a class="btn btn-login" href="login.php"><?php echo $lang['login']; ?></a>
            </div>
        </div>
    </header>
</body>

</html>