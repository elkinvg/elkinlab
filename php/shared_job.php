<?php
$shar=true;
require './common_page.inc.php';
?>
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
	$nprhead = true;
	require "./common_page.inc.php";
	require "../lang/$context[lang]/sharedjob_descr.inc.php";
	?>
        <script type="text/javascript" src="../js/shared_job.js"></script>
    </head>
    <body>
        <div id="errordiv"></div>
	<?php Rendermain(); ?>
    </body>
</html>
<?php

function Rendermain() {
    global $dic;

    $head_txt = "<span class=logo_labs>: $dic[shared_job] </span>";
    pHeader($head_txt);
    echo "<div class='ui-widget-content pjnew showcase' align=center valign=top >";
    View();
    echo "</div>";

    pFooter();
}

function View() {
    global $tasks_descr_txt;
    $cols = 4;
    echo "<table name='jobs_shar' id='jobs_shar'  cellpadding=2 width=100%>\n";
    echo "<thead>";
    echo "<tr><td colspan=$cols class=page_note><h4 align='center'>$tasks_descr_txt[page_title]</h4></td>\n";
    echo "<tr><td colspan=$cols class=page_note>$tasks_descr_txt[note]</td>\n";
    echo "<tr><td colspan=$cols><hr></td></tr>";
    echo " </thead>\n";
    echo " <tbody>\n";
    echo " </tbody>\n";
    echo "</table>\n";
}
?>

