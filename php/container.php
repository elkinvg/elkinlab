<?php
require './common_page.inc.php';
?>
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
	$nprhead=true;
	require "./common_page.inc.php";
	
	
	if (isset($_GET['task_id']) && !empty($_GET['task_id'])) {
	    $task_id = $_GET['task_id'];
	    $url = "../lang/" . $context['lang'] . "/task_descr/task" . $task_id . ".htm";
	}
	if (isset($_GET['task_name']) && !empty($_GET['task_name'])) {
	    $task_name = $_GET['task_name'];
	    //$url = "../lang/" . $context['lang'] . "/task_descr/task" . $task_id . ".htm";
	}
	if (isset($_GET['file']) && !empty($_GET['file']) ) {
	    $file_desc = $_GET['file'];
	    $url = "../lang/" . $context['lang'] . "/" . $file_desc;
	}
	$contents = file_get_contents($url);
	?>
	<script type="text/javascript">
	    $(function () {
		heightDivJNew();
		$(window).resize(function () {
		    heightDivJNew();
		});
	    });
	</script>
    </head>
    <body>
	<?php Rendermain() ?>
    </body>
</html>

<?php

// пока не работают некоторые ссылки
function Rendermain() {
    global $dic, $contents, $task_id,$task_name;
    if (isset($task_name)) $ht = "<span class=logo_labs>: $task_name </span>";
    elseif (isset($task_id))  $ht = "<span class=logo_labs>: task $task_id</span>";
    else $ht = "<span class=logo_labs>: unknown task</span>";

    $head_txt = $ht;
    pHeader($head_txt);
    echo "<div class='ui-widget-content pjnew showcase' valign=top >";
    echo $contents;

    echo "</div>";
    pFooter();
}
?>

