<?php

//---------------------
//Скрипт для AJAX-а, что бы листать отзывы на страние без перезагрузки
//В HTML находится в блоке с id="rew"
//---------------------

include 'classes/reviews.class.php';
$rew = new Reviews;
$rew->leafing();
?>
