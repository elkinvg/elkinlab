<!--<link href="../css/common.css" rel="stylesheet" type="text/css" />-->
<html>
    <head>
        <meta http-equiv="content-type" content="text/html"/>
        <meta name="keywords" content="Cosmic, rays, showers, detecting..."/>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="robots" content="all"/>
        <meta http-equiv="expires" content="0"/>
        <meta http-equiv="pragma" content="no-cache"/>
        <meta http-equiv="cache-control" content="no-cache"/>
	<?php
//	require "./oth.inc.php";
	require "./common_page.inc.php";
	$task_id = $_GET['task_id'];
	$url = "../lang/" . $context['lang'] . "/task_descr/task" . $task_id . ".htm";
	$contents = file_get_contents($url);
	?>
    </head>
    <body>
	<?php Rendermain() ?>
    </body>
</html>

<?php
// пока не работают некоторые ссылки
function Rendermain() {
    global $dic, $contents,$task_id;

    $head_txt = "<span class=logo_labs>: task $task_id</span>";
    pHeader($head_txt);
    echo "<div class='ui-widget-content pjnew showcase' valign=top >";
    echo $contents;

    echo "</div>";
    pFooter();
}
?>

