<?php
require './common_page.inc.php';
global $dic;
$jobnum = null;
$user_id = null;
if (!empty($_GET['job_id'])) {
    $jobnum = $_GET['job_id'];
    $jobnum_head = $jobnum;
} else {
    $jobnum_head = $dic['job_container_nf'];
}
if (!empty($_GET['user_id']))
    $user_id = $_GET['user_id'];

$job_path = $_SERVER['DOCUMENT_ROOT'] . "/users/" . $user_id . "/jobs/" . $jobnum . "/";
$web_job_path = $_SERVER['SERVER_NAME'] . "/users/" . $user_id . "/jobs/" . $jobnum . "/";

$csv_files = array();
$png_files = array();
$txt_files = array();

//    if (!count($txt_files)) echo "SIZE=".count($txt_files)."<br>";

if (file_exists($job_path)) {
    $files = scandir($job_path);
    foreach ($files as $file) {
	if (pathinfo($file, PATHINFO_EXTENSION) == "csv")
	    $csv_files[] = $file;
	if (pathinfo($file, PATHINFO_EXTENSION) == "png")
	    $png_files[] = $file;
	if (pathinfo($file, PATHINFO_EXTENSION) == "txt")
	    $txt_files[] = $file;
    }
} else
    $files = null;
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
	?>
        <style type="text/css">
            /*            label, input { display:block; }*/
            select, input {padding: .4em; }
            select, input { width:95%;}
            fieldset { padding:0; border:0; margin-top:15px; }
            /*            h1 { font-size: 1.2em; margin: .6em 0; }
                        div#task-select, div#delete, div#params {margin: 15px 0; }
                        .ui-button { 
                            outline: 0; margin:0; padding: .4em 1em .5em; 
                            text-decoration:none; cursor:pointer; position: relative; 
                            text-align: center; 
                        }
                        .ui-dialog .ui-state-highlight, .ui-dialog .ui-state-error { padding: .3em;  }*/
        </style>
        <script type='text/javascript' src='../js/job-add.js'></script>
        <script type='text/javascript' src="../js/job_container.js"></script>
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
<?php Rendermain(); ?>
    </body>
</html>

<?php

function Rendermain() {
    global $dic, $jobnum_head;

    $head_txt = "<span class=logo_labs>: <a style='color: orange' href='./job_list.php'> список </a> :" . $dic['job_container'] . $jobnum_head . "</span>";
    pHeader($head_txt);
    Control();
    View();

    pFooter();
}

function Control() {
    global $jobs_table, $csv_files, $web_job_path;
    echo "<div class='ui-widget-content ppcontrol' align=center valign=top>";
    echo "<hr>";
    echo "<h4> $jobs_table[note] </h4>";
    echo "<p class='notel'>$jobs_table[note_l]</p>";
    echo "<hr>";
    echo "<h4>$jobs_table[job_info]</h4>";
    echo "<div class='job_info' dis='$jobs_table[disabled]' pen='$jobs_table[pending]' "
    . "run='$jobs_table[running]' compl='$jobs_table[completed]' fail='$jobs_table[failed]'> ";
    echo "<b id='us'>" . $jobs_table['user'] . '</b><br>';
    echo "<b id='str'>" . $jobs_table['started'] . '</b><br>';
    echo "<b id='fnsh'>" . $jobs_table['finished'] . '</b><br>';
    echo "<b id='sts'>" . $jobs_table['status'] . '</b><br>';
    echo "</div>";
    echo "<hr>";
    echo "<h4>$jobs_table[pars_jobs]</h4>";
    echo "<table class='job_table' id='job_table'>";
    echo "<tbody>";
    echo "<tr class='ui-widget-header tr-head'><td>$jobs_table[parameter]</td>"
    . "<td>$jobs_table[value]</td> </tr>";
    echo "</tbody>";
    echo "</table>";
    echo "<hr>";
    echo "<h4>$jobs_table[links]</h4>";
    if (!count($csv_files))
	echo $jobs_table['no_data'];
    else {
	foreach ($csv_files as $csv_file) {
	    $csv = "http://" . $web_job_path . $csv_file;
	    echo "<p class='file_link'><a style='color:#619226' href='$csv' download>$jobs_table[csv_link_pre]$csv_file$jobs_table[csv_link_post]</a></p>";
	}
    }
    echo "<hr>";
    echo "<h4>$jobs_table[actions]</h4>";
    echo "<table class='actions_jc' id='actions_jc'>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td class='job-add hov'><a href='#'>$jobs_table[new_job]</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='hov'><a href='./job_list.php'>$jobs_table[back]</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='desc-add hov'><a href='#'>$jobs_table[add_descr]</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='std-txt hov'><a href='#'>$jobs_table[stdouttxt]</a></td>";
    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
}

function View() {
    global $jobnum, $user_id, $job_id, $png_files, $files, $txt_files;
    global $web_job_path, $job_path, $jobs_table;
    echo "<div class='ui-widget-content ppview' position=relative valign=top>";

    if (!$jobnum) {
	echo "<div class='center'> Job not found </div></div>";
	return;
    }
    if (count($txt_files) && !count($png_files)) {
	$fgc = file_get_contents($job_path . "stderr.txt");
	echo "<p class='err_link'>$fgc</p>";
    }
    if (count($txt_files)) {
//	$fgo = file_get_contents($job_path . "stdout.txt");
	$f=  fopen($job_path . "stdout.txt"."","r");
	if ($f)
	{
	    $fgo = "";
	    while (!feof($f)) {
		$s = fgets($f, 128);
		$fgo .= $s. "<br>";
	    }
	    fclose($f);
	}   else
	fclose($f);	
    }




    $report = $job_path . "report_$job_id.html";
    $addtext = $job_path . "addtext.htm";
    if (file_exists($addtext)) {
	$fgc = file_get_contents($addtext);
	if ($fgc)
	    echo "<div align='center'>$fgc</div>";
    }

    if (!$files) {
	echo "<div class='center'> Job not found </div></div>";
	return;
    }


    $ii = 0;
    foreach ($png_files as $png_file) {
	echo "<p class='p_descr' hidden><a href='#' class='us_descr'  id='ud$ii'>$jobs_table[add_descr]</a></p>";
	echo "<div id='div_ud$ii' class='div_descr'></div>";
	$png = "http://" . $web_job_path . $png_file;
	echo "<p class='img_hist'><img src='$png' ></p>";
	$ii++;
    }
    echo "<div id='std_txt' align=center hidden>$fgo</div>";
    echo "</div>";
}
?>