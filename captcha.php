<?php

//Для каждой новой сессии генерируем новую каптчу
session_start();
//Капча состоит из 4-значного числа
$code=rand(1000,9999);
//Код сохраняется в сессии для следующей проверки при отправке формы
$_SESSION["code"]=$code;
$im = imagecreatetruecolor(50, 24);               //Создаем изображение
$bg = imagecolorallocate($im, 22, 86, 165);       //Цвет фона
$fg = imagecolorallocate($im, 255, 255, 255);     //Цвет шрифта
//Заливаем полученное изображение $im цветом $bg
imagefill($im, 0, 0, $bg);
//Рисуем строку
imagestring($im, 5, 5, 5,  $code, $fg);
//Отключаем кэширование
header("Cache-Control: no-cache, must-revalidate");
//Описание содержащихся данных
header('Content-type: image/png');
//Вывод png изображения
imagepng($im);
//Уничтожить изображение
imagedestroy($im);
?>
