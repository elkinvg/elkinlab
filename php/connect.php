<?php

//connect.php - connect to db

//$link = mysql_connect("localhost","root");
//$link = mysql_connect("localhost","livni","ea5pa8");
$link = mysqli_connect("localhost","livni","ea5pa8");
mysqli_set_charset($link, 'utf8');

?>