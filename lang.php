<?php
// Дефолтный язык - грузинский
$lang_code = isset($_GET['lang']) ? $_GET['lang'] : 'ka';

if ($lang_code == 'en') {
    // Английский язык
    include 'lang/en.php';
} elseif ($lang_code == 'ru') {
    // Русский язык
    include 'lang/ru.php';
} else {
    // Грузинский язык
    include 'lang/ka.php';
}
?>