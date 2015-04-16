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

	<script type='text/javascript' src='../js/jobs_new.js'></script>
        <style type="text/css">
            label, input { display:block; }
            select, input {padding: .4em; }
            select, input { width:95%;}
            fieldset { padding:0; border:0; margin-top:15px; }
            h1 { font-size: 1.2em; margin: .6em 0; }
            div#task-select, div#delete, div#params {margin: 15px 0; }
            .ui-button { 
                outline: 0; margin:0; padding: .4em 1em .5em; 
                text-decoration:none; cursor:pointer; position: relative; 
                text-align: center; 
            }
            .ui-dialog .ui-state-highlight, .ui-dialog .ui-state-error { padding: .3em;  }
        </style>
    </head>
    <body>
        <div id="errordiv"></div>
	<div <?php echo " id='params' name='params' title='$job_params_form[title]'"; ?> >
<?php
//echo "<div id='params' name='params' title='$job_params_form[title]'>";
echo "<p id='validateTipsParams'>$job_params_form[note_1]($job_params_form[note_2]" . date('Y-m-d', $date_from) . ")<br>$job_params_form[note_3]$max_bins</p>";
?>

            <form>
                <fieldset>
                    <input type="hidden" name="warn_station" id="warn_station" value="<?php echo $tasks_form['warn_station']; ?>">
		    <input type="hidden" name="warn_number" id="warn_number" value="<?php echo $reg_form['warn_number']; ?>">
		    <input type="hidden" name="def_value" id="def_value" value="<?php echo $job_params_form['def_val']; ?>">
                    <input type="hidden" name="task_id" id="task_id">	
                    <table name="params_form" id="params_form">
                        <thead>
                            <tr><td width="60%"><?php echo "$job_params_form[caption]"; ?></td><td width="40%"><?php echo "$job_params_form[def_val]"; ?></tr>	
                        </thead>
                        <tbody></tbody>
                    </table>
                </fieldset>
            </form>
        </div>
	<?php
	$oper = 'list';
	$ret = array();
	$cols = 4;
	require "./tasks-li.php";

//global $context;
	$brief_descr = file_get_contents("../lang/$context[lang]/newjob_brief_descr.html");
	$icon = "<img src='../skin/rating_on.png'>";

	Rendermain();
	?>
    </body>
</html>

<?php

function Rendermain() {
    global $dic;

    $head_txt = "<span class=logo_labs>: $dic[new_job]</span>";
    pHeader($head_txt);
    echo "<div class='ui-widget-content pjnew showcase' align=center valign=top >";
//        echo "<div class='ui-widget-content ppview' align=center valign=top>";
    View();

    echo "</div>";
    pFooter();
}

function View() {
    global $jobs_new, $icon, $brief_descr, $cols;
    //echo "<div class='ui-widget-content pview showcase' align=center valign=top>\n";
    echo "<table name='jobs_new_sel' id='jobs_new_sel'  cellpadding=2 width=100%>\n";


    echo "<thead>";
    //echo "<tr><td colspan=$cols class=page_title>$jobs_new[jobs_new_title] </td>\n";
    echo "  <tr><td colspan=$cols class=page_note> $brief_descr </td>\n";
    echo "<tr><td colspan=$cols ><hr></td></tr>\n";
    echo "<tr class=page_table_header>\n";
    echo " <td title= $jobs_new[complexity] ><a href='#'>$icon </a></td>\n";
    echo " <td>$jobs_new[caption]</td>\n";
    echo " <td> $jobs_new[description] </td>\n";
    echo " <td>$jobs_new[remark]</td>\n";
    echo " </tr>\n";
    echo " <tr><td colspan=$cols><hr></td></tr>\n";
    echo " </thead>\n";
    echo " <tbody>\n";

    global $ret, $context, $debug, $proj_home;
    $fill = false;
    foreach ($ret as $value) {
	if (!$debug) {
	    $descr = ($context['lang'] == 'ru') ? $value['description_ru'] : $value['description_en'];
	    $rem = ($context['lang'] == 'ru') ? $value['remark_ru'] : $value['remark_en'];
	} else {
	    $descr = $value['description_ru'];
	    $rem = $value['remark_ru'];
	}

	$task_id = $value['task_id'];
	$pars = $value['par_number'];

//	$descr_link = "" . $proj_home . "/php/container.php?url=lang/" . $context['lang'] . "/task_descr/task" . $task_id . ".htm";
	$descr_link = "./container.php?task_id=" . $task_id;
	//$descr_link="http://livni.jinr.ru/php/container.php?url=lang/$context[lang]/task_descr/task$task_id.htm";
	$complexity = $value['complexity'];
	if ($complexity > 2)
	    $complexity = 2; //we have only 3 titles
	$complexity_tt = $jobs_new['complexity_at'][$complexity];
	$icons = "";
	for ($n = 0; $n <= $complexity; $n++) {
	    $icons.=$icon;
	}
	//ELKIN-B
	$task_visibly_for_flag;
	if ($complexity < 2)
	    $task_visibly_for_flag = 1;
	else {
	    if ($complexity == 2 && ($context['utype'] == "admin" || $context['utype'] == "expert"))
		$task_visibly_for_flag = 1;
	    else
		$task_visibly_for_flag = 0;
	}

	if ($task_visibly_for_flag) {
	    //ELKIN-E
	    $fill = !$fill;
	    $tr = $fill ? "class=ui-state-highlight" : "";
	    echo "<tr $tr>";
	    echo "<td class=\"col_complexity\" width=4%><a href='#' title='$complexity_tt'>$icons</a></td>";
	    echo "<td width=10% class='job-add' task_id=$task_id task_name='$value[caption]' par_number=$pars><a href='#' title='$jobs_new[caption_tt]'>$value[caption]</a></td>";
	    echo "<td width=43% class='job-descr hover_on_white' task_id=$task_id><a href='$descr_link' target=_new title='$jobs_new[description_tt]'>$descr</a></td>";
	    echo "<td width=43%>$rem</td>";
	    echo "</tr>";
	    //ELKIN-B
	}
	//ELKIN-E
    }


    echo "</table>\n";
    //echo "</div>\n";
}
