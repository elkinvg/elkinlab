<?php
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
	$nprhead=true;
        require "./common_page.inc.php";
        require "../lang/$context[lang]/tasks_descr.inc.php";
        ?>

        <script type="text/javascript">
            $(function () {
                heightDivJNew();
                $(window).resize(function () {
                    heightDivJNew();
                });
                $("#accordion").accordion({header: "h3", heightStyle: "content", collapsible: true});
            });
        </script>
    </head>
    <body vlink=black link=black>
        <?php
        Rendermain();
        ?>
    </body>
</html>

<?php

function Rendermain() {
    global $dic;
//    echo "<table class='ui-widget main' width=100% height=100% border=0>";
    $head_txt = "<span class=logo_labs>: $dic[task_list]</span>";
    pHeader($head_txt);
    echo "<div class='ui-widget-content pjnew showcase' align=center valign=top >";
    View();
    echo "</div>";
    pFooter();
}

function View() {
    global $tasks_descr, $tasks_descr_txt, $task_id;
    echo "
                    <table width=100% height=100% cellpadding=25px class='page_indent hover_on_white'>
                        <tr><td class=page_note>$tasks_descr_txt[note]</td></tr>
                        <tr height=100%><td height=100%>
                                <div id='accordion'>
                                    <div>";
    foreach ($tasks_descr as $task_id => $value)
        echo "<h3><a href='#'>$value[caption]</a></h3><div>$value[descr]</div>";

    echo "</div>
                                </div>
                            </td></tr>
                    </table>";
}
?>