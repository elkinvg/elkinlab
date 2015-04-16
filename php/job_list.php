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
	<script type='text/javascript' src='../js/job_list.js'></script>
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

    $head_txt = "<span class=logo_labs>: $dic[jobs_list] </span>";
    pHeader($head_txt);

    Control();
    View();

    pFooter();
}
//<span class='ui-widget-header tr-head'>TEST</span>
function Control() {
    global $jobs_table;
    echo "<div class='ui-widget-content ppcontrol' align=center valign=top>";
    echo "<div class='pform' id='pform'>";
    echo "<form name='set_form' class='set_form' action='' method='post'>";
    echo "<fieldset>";
    echo "<table class='param_table'>";
//    echo "<thead colspan=3 class='ui-widget-header tr-head'><td>TEST</td></thead>";
    echo "<tbody>";
    echo "<tr class='ui-widget-header tr-head'><td colspan=3>TEST</td></tr>";
    echo "<tr>";
    echo "<td><label>$jobs_table[period]</label> </td>";
    echo "<td><input type='text' id='data_beg' class='my-datepicker' readonly value=''></td>";
    echo "<td><input type='text' id='data_end' class='my-datepicker' readonly value=''></td>";
    echo "</tr>";
//    echo "<tr>";
//    echo "<td colspan=1><input type='button' name='cost_b' id='cost_b' class='but' value=$jobs_table[update]></td>";
//    echo "</tr>"; 
    echo "</tbody>";
    echo "</table>";
    echo "<input type='button' name='cost_b' id='cost_b' class='but' value=$jobs_table[update]>";
    echo "</fieldset>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
}

function View() {
    echo "<div class='ui-widget-content ppview' align=center valign=top>";

    echo "view list, ROOT output";

    echo "</div>";
}
?>


