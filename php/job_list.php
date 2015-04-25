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
        ?>
	<script type='text/javascript' src='../js/job_list.js'></script>
	        <style type="text/css"> 
		    input { width:100%;}
/*		    input, button { font-size:30px;}*/
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
    echo "<hr>";
    echo "<h4> $jobs_table[note] </h4>";
    echo "<p class='notel'>$jobs_table[note_l]</p>";
    echo "<hr>";
    echo "<h4> $jobs_table[user_filters] </h4>";
    echo "<form name='set_form' class='set_form' action='' method='post'>";
    echo "<fieldset>";
    echo "<table class='param_table'>";
//    echo "<thead colspan=3 class='ui-widget-header tr-head'><td>TEST</td></thead>";
    echo "<tbody>";
    echo "<tr class='ui-widget-header tr-head'><td colspan=3>$jobs_table[time_filter]</td></tr>";
    echo "<tr>";
    echo "<td><label>$jobs_table[period]</label> </td>";
    echo "<td><input type='text' id='data_beg' class='my-datepicker' readonly value=''></td>";
    echo "<td><input type='text' id='data_end' class='my-datepicker' readonly value=''></td>";
    echo "</tr>";
//    echo "<tr>";
//    echo "<td colspan=1><input type='button' name='updt_lst' id='updt_lst' class='but' value=$jobs_table[update]></td>";
//    echo "</tr>"; 
    echo "</tbody>";
    echo "</table>";
    echo "<input type='button' name='updt_lst' id='updt_lst' class='but' value=$jobs_table[update] style='font-size:10px'>";
    echo "<input type='button' name='updt_lst2' id='updt_lst2' class='but' value=$jobs_table[default] style='font-size:10px'>";
    echo "</fieldset>";
    echo "</form>";
    echo "<hr>";
    echo "<h4>$jobs_table[actions]</h4>";
    echo "<table class='actions_jc' id='actions_jc'>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td class='hov'><a href='../index.php' target='_blanc'>$jobs_table[back_main]</a></td>";
    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
}

function View() {
    echo "<div class='ui-widget-content ppview' align=center valign=top>";

    echo "view list, ROOT output";

    echo "</div>";
}
?>


