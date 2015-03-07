<!--<link href="../css/common.css" rel="stylesheet" type="text/css" />-->
<?php

$context['level']=1; $pp="..";
//$rel=$_GET['rel']; if (!isset($rel)) $rel=0; else $rel=1;
//if ($rel==0)  $url="$pp/{$_GET['url']}";
//else  $url=$_GET['url'];
$url="$pp/{$_GET['url']}";
$contents = file_get_contents($url);
echo '<html>';
echo '<head>';
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
echo '</head>';
echo $contents;
echo '</html>';
?>