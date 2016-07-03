<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Создание таблиц</title>
</head>
<body>
    <h3>Создание...</h3>

<?php

require_once 'classes/connection.class.php';

$sql = "CREATE TABLE messages(
        id INT(5) PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(35) NOT NULL default '',
        email VARCHAR(35) NOT NULL default '',
        position VARCHAR(35) default '',
        message TEXT NOT NULL,
        image VARCHAR(50) default '')";

$db = new Connection;
$db->query($sql);
?>


    <br>...готово
</body>
</html>
