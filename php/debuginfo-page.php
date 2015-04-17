<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require "./common_page.inc.php";
        //global $context;
        echo "<p>";
        echo '$debug = '.$debug.'<br>';
	echo '$debug_status = '.$debug_status.'<br>';
        echo '$users_home = '.$proj_home.'<br>';
        echo '$users_path = '.$users_path.'<br>';
        echo '$context[\'uuid\'] = '.$context['uuid'].'<br>';
        echo '$context[\'user\'] = '.$context['user'].'<br>';
        echo '$context[\'utype\'] = '.$context['utype'].'<br>';
        echo '$context[\'visits\'] = '.$context['visits'].'<br>';
	echo '$context[\'jobs\'] = '.$context['jobs'].'<br>';
        echo '$context[\'lang\'] = '.$context['lang'].'<br>';
        echo '$cookie_prefix='.$cookie_prefix.'<br>';
        echo "</p>";
        ?>
    </body>
</html>
