<?php
//настройки для подключения к БД
$dbhost = 'localhost';
$dbname = 'guestbook';
$dbuser = 'root';
$dbpass = 'mars123';

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if($connection->connect_error) die($connection->connect_error);

//соберем все функции для проверки вводимых данных пользователем
function sanitizeString($var) {
    global $connection;
    $var = strip_tags($var);            //Удаляет HTML и PHP-теги из строки
    $var = htmlentities($var);          //Преобразует символы в HTML-сущности
    $var = stripslashes($var);          //Удаляет экранирование символов
    return $connection->real_escape_string($var);     //Экранирует необходимые символы
}
?>
