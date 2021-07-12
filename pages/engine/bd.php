<?php
if (!isset($sys)) exit;
    $host = 'localhost';  // Хост, у нас все локально
    $user = 'u1352224_default';    // Имя созданного вами пользователя
    $pass = '4OZf9a!z'; // Установленный вами пароль пользователю
    $db_name = 'u1352224_default';   // Имя базы данных
    $link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой
    mysqli_set_charset($link, "utf8");
?>