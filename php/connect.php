<?php
$result="ok"; $err_no=0;
$link = mysql_connect("localhost","basilg","L1vN1");
if (!$link){$result= mysql_error(); $err_no=666;}
if (!mysql_select_db("livni", $link)){$err_no=mysql_errno($link); $result=mysql_error($link); mysql_close($link);}
?>