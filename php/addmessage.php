<?php
session_start();

include 'classes/reviews.class.php';

$review = new Reviews;
$review->adding();

?>
