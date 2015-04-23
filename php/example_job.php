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
	require "./common_page.inc.php";
	?>
<!--	<script type='text/javascript' src='../js/job_list.js'></script>-->
        <script type="text/javascript">
	    $(document).ready(function () {
		heightDivJNew();
		$(window).resize(function () {
		    heightDivJNew();
		});
		$(window).load(function ()
		{
		    $("#accordion").accordion({header: "h3", heightStyle: "content", collapsible: true});
		});
//                $.post("../php/dbcon4job_list.php", {oper: 'example'},
//                function (data) {
//
//                }, "json");
	    });
        </script>
        <style type="text/css"> input { width:100%;}
        </style>
    </head>
    <body>
        <div id="errordiv"></div>
	<?php Rendermain(); ?>
    </body>
</html>
<?php

function Rendermain() {
    global $dic;

    $head_txt = "<span class=logo_labs>: $dic[example_job] </span>";
    pHeader($head_txt);
    echo "<div class='ui-widget-content pjnew showcase' align=center valign=top >";
    postJob();
    echo "</div>";

    pFooter();
}

function postJob() {
    global $dic,$jobs_table;
    $script = str_replace("example_job.php", "dbcon4job_list.php", $_SERVER['PHP_SELF']);
    $url = "http://" . $_SERVER['HTTP_HOST'] . $script;
    $params = array(
	'oper' => 'example'
    );

    $result = file_get_contents($url, false, stream_context_create(array(
	'http' => array(
	    'method' => 'POST',
	    'header' => 'Content-type: application/x-www-form-urlencoded',
	    'content' => http_build_query($params)
	)
    )));

    $res = json_decode($result, true);
    $errno = $res['err_no'];
    if (!$errno) {
	//echo "$errno <br>fsdkfsdf<br>$res[result]";
	echo "<div id='accordion'>";
	foreach ($res['val'] as $job) {
	    $user_id = $job['user_id'];
	    $task_id = $job['task_id'];
	    $job_id = $job['job_id'];
	    $job_path = $_SERVER['DOCUMENT_ROOT'] . "/users/" . $user_id . "/jobs/" . $job_id . "/";
	    $web_job_path = "http://" . $_SERVER['SERVER_NAME'] . "/users/" . $user_id . "/jobs/" . $job_id . "/";
	    $png = getPngFromDir($job_path);

	    $h3 = "<h3><a href='#'>" . $dic['job_container'] . $job_id . "</a></h3>";
	    $fgc = file_get_contents($job_path . "addtext.htm");
	    echo "<p class='err_link'>$h3 <div> $fgc";
	    foreach ($png as $png_file) {
		echo "<p class='img_hist'><img src='$web_job_path$png_file' ></p>";
                echo "<p><a href='../php/job_container.php?job_id=$job_id&user_id=$user_id' target'_blank'> <span style='color: rgb(204, 0, 0);'>$jobs_table[gotojob] </span><a></p>";
//	echo $png;
	    }
	    echo "</div></p>";
	}
	echo "</div>";
    }
}

function getPngFromDir($job_path) {
    $png_files = array();
    if (file_exists($job_path)) {
	$files = scandir($job_path);
	foreach ($files as $file) {
	    if (pathinfo($file, PATHINFO_EXTENSION) == "png")
		$png_files[] = $file;
	}
    }
    return $png_files;
}
?>

