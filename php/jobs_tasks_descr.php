<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <?php
        $pp = "..";
        require "$pp/php/config.inc.php";
        echo "<link href='$pp/css/common.css' rel='stylesheet' type='text/css' />";
        require "$pp/lang/$context[lang]/msg.inc.php";
        require "$pp/lang/$context[lang]/tasks_descr.inc.php";

//jquery:
        echo "<script type='text/javascript' src='$pp/js/jquery/jquery-2.1.3.min.js'></script> \n"; // elkin
        echo "<link type='text/css' href='$pp/js/jquery/jquery-ui-1.11.3/themes/sunny/jquery-ui.css' rel='stylesheet' />\n"; // elkin
        echo "<script type='text/javascript' src='$pp/js/jquery/jquery-ui-1.11.3/external/jquery/jquery.js'></script>\n"; // elkin
        echo "<script type='text/javascript' src='$pp/js/jquery/jquery-ui-1.11.3/jquery-ui.js'></script>\n"; // elkin
        ?>

        <script type="text/javascript">
            $(function () {
                $("#accordion").accordion({header: "h3", heightStyle: "content", collapsible: true})
            });
        </script>
    </head>

    <body vlink=black link=black>
        <table height="100%" >
            <tr><td class=showcase>
                    <table width=100% height=100% cellpadding=25px class='page_indent hover_on_white'>
                        <tr><td class=page_title> <?php echo "{$tasks_descr_txt['page_title']}"; ?> </td></tr>
                        <tr><td class=page_note> <?php echo "$tasks_descr_txt[note]"; ?> </td></tr>
                        <tr height=100%><td height=100%>
                                <div id="accordion">
                                    <div>
                                        <?php
                                        foreach ($tasks_descr as $task_id => $value)
                                            echo "<h3><a href='#'>$value[caption]</a></h3><div>$value[descr]</div>";
                                        ?>
                                    </div>
                                </div>
                            </td></tr>
                    </table>

                </td></tr>
        </table>
    </body>
</html>