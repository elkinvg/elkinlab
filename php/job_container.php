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
        <script type='text/javascript'>

//            
	    $(document).ready(function () {

//		$(window).load(function () {
		heightDiv();
//		});


		$(window).resize(function () {
		    heightDiv();
		});

		var job_id = getUrlVars()["job_id"];
		var task_id = getUrlVars()["task_id"];
		var user_id = getUrlVars()["user_id"];
		var utype = getUrlVars()["utype"];
		var job_status = getUrlVars()["job_status"];
		$('#task_id').val(task_id);
//        $('#errordiv').append($(".ppview").height() + " ... " + $(".ppcontrol").height());
		getParams();
//        borderDel();

		$.post("../php/job_comment.php", {uid: user_id, jid: job_id, oper: "read"}, function (data) {
		    var descrs = $("<p>", {html: data}).find("p");
		    descrs.each(function () {
			var id = $(this).attr('pid');
			$('#div_' + id).append($(this));
		    });
		}, "text");




		//class='us_descr'  id='ud$ii'
		$('.desc-add').click(function ()
		{
		    if ($('.p_descr').attr('hidden') !== undefined) {
			$('.p_descr').removeAttr('hidden');
		    }
		    else {
			$('.p_descr').attr('hidden', '');
		    }
		    //if ($('.p_descr').has('[name=hidden]') === undefined) $('.p_descr').set('hidden');
		});

		$('.us_descr').click(function ()
		{
		    $(this).after(form);
		    var aid = $(this).attr('id');
		    var desc_in_p = $('[pid=' + aid + ']');
		    //if (desc_in_p.length>0) var ftext = $('[pid=' + aid + ']')[0].innerText;
		    if (desc_in_p.length > 0)
			var ftext = $('[pid=' + aid + ']').html();
		    if (ftext !== undefined)
			$('#com_text').val(ftext);
		    $('#ok_com').click(function ()
		    {
			var div_id = 'div_' + aid;
			var text = $('#com_text').val();
			$('#com_form').remove();
			var pattern = /\r\n|\r|\n/g;
			text = text.replace(pattern, "<br>");
			var descr_div = '<p pid="' + aid + '">' + text + '</p>';
			//descr_a.after(descr_div);
			$("#" + div_id).html(descr_div);
			$.post("../php/job_comment.php", {uid: user_id, jid: job_id, aid: div_id, text: descr_div, oper: "write"}, function (data) {
			}, "text");
		    });

		    $('#canc_com').click(function ()
		    {
			$('#com_form').remove();
		    });

		});

		function getParams()
		{
		    $.post("./jobpars-li.php", {oper: "list_pars", job_id: job_id}, function (data) {
			var nn = data.pars.length;
			//$('#errordiv').append("size=" + nn.length);
			var tr = "";
			if (!data.errno)
			{

			    for (var i = 0; i < nn; i++)
			    {
				tr += "<tr>";
				tr += "<td>" + data.pars[i]['caption'] + "</td>";
				tr += "<td>" + data.pars[i]['def_val'] + "</td>";
				tr += "</tr>";
			    }
			    addInfo(data);
			    parametersTable(data.pars);

			    var usrjobinfo = data.usrjobinfo;
			    var option = usrjobinfo['option'];
			    var uuid = my_getcookie("uuid");
			    var owner = usrjobinfo['user_id'];
			    if (option === '1' || uuid !== owner)
				$('.desc-add').remove();


			}
			else
			    tr = data.error;
			$('.logo_labs').append(" " + data.task_cap);
			$('#job_table').append(tr);

			function addInfo(inp)
			{
			    var jstatus = "";
			    if (Object.keys(inp.usrjobinfo).length > 1)
			    {
				$('#us').after(inp.usrjobinfo['last_name'] + " " + inp.usrjobinfo['first_name']);
				$('#str').after(inp.usrjobinfo['started']);
				$('#fnsh').after(inp.usrjobinfo['finished']);
				if (inp.usrjobinfo['job_status'] == "0")
				    jstatus = "<span style='color: pink'>" + $('.job_info').attr('dis') + "</span>";
				if (inp.usrjobinfo['job_status'] == "1")
				    jstatus = "<span style='color: blue'>" + $('.job_info').attr('pen') + "</span>";
				if (inp.usrjobinfo['job_status'] == "2")
				    jstatus = "<span style='color: orange'>" + $('.job_info').attr('run') + "</span>";
				if (inp.usrjobinfo['job_status'] == "3")
				    jstatus = "<span style='color: green'>" + $('.job_info').attr('compl') + "</span>";
				if (inp.usrjobinfo['job_status'] == "4")
				    jstatus = "<span style='color: red'>" + $('.job_info').attr('fail') + "</span>";
				$('#sts').after(jstatus);
			    }
			}
			$('.job-add').click(function ()
			{
			    $('#params').dialog("open");
			    $('#params').dialog('option', 'title', data.task_cap);
			});
			$('.hov').hover(function () {
			    $(this).addClass("ui-state-hover");
			}, function () {
			    $(this).removeClass("ui-state-hover");
			}); // job-add.click()
			heightDiv();
		    }, "json"); // post getparams
		}

		dialog();

		function parametersTable(datapars)
		{
		    var tr = "";
		    var name, type, min_val, max_val, inputType, inputValue, add, caption, cssclass, def_val, min_time;
		    min_time = "";
		    var max_time = $.datepicker.formatDate('yy-mm-dd', new Date()) + " 23:59";
		    for (var i = 0; i < datapars.length; i++)
		    {
			inputValue = "";
			inputType = "";
			add = "";
			cssclass = "";

			min_val = datapars[i]['min_val'];
			max_val = datapars[i]['max_val'];
			def_val = datapars[i]['def_val'];
			type = datapars[i]['type'];
			name = datapars[i]['name'];
			caption = datapars[i]['caption'];

			if (type == 2)
			{
			    cssclass = 'ui-widget-content ui-corner-all my-datepicker';
			    add = "readonly";
			    inputType = "text";
			    inputValue = def_val;
			    min_time = min_val;
			}
			else {
			    if (type == 0 && name.indexOf("USE_STATION_") != -1)
			    {
				inputType = "checkbox";
				inputValue = def_val;
				if (def_val == "1")
				    add = "checked";
				//else add="unchecked";
//				else add 
			    }
			    else
			    {
				inputType = "text";
				inputValue = def_val;
				cssclass = 'ui-widget-content ui-corner-all';
			    }
			}

			var vals = " min_val='" + min_val + "' max_val='" + max_val + "' ptype='" + type + "' " + " pname='" + name + "' ";
			tr += "<tr><td><input type=text readonly class='ui-widget-content ui-corner-all' value='"
				+ caption +
				"' maxlength=80 size=84></td><td><input type='" + inputType + "' class='" + cssclass + "' maxlength=32 size=24 value='" + inputValue + "' " + vals + add + " ></td></tr>";
		    }
		    $('#params_form tbody').html(tr);
		    addDateTimePicker(min_time, max_time);
		    checkAll();
		}


		function getUrlVars()
		{
		    var vars = [], hash;
		    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		    for (var i = 0; i < hashes.length; i++)
		    {
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		    }
		    return vars;
		} // getURLvars

		var form = "<form name='com_form' action='' method='post' id='com_form'> \
                <fieldset> \
                    <p>Your Comment / Ваш комментарий </p> \
                    <textarea maxlength='2000' rows='6' cols='51' name='com_text' id='com_text'></textarea> \
                    <p> \
                        <input type='button' name='ok_com' id='ok_com' class='but' value='Ok'> \
                        <input type='button' name='canc_com' id='canc_com' class='but' value='Cancel'> \
                    </p> \
                </fieldset> \
            </form> ";

	    });
        </script>
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
//    echo "<div class='pform ui-dialog ui-corner-all' id='pform'>";
//    echo "<form name='set_form' action='' method='post'>";
//    echo "<fieldset>";
//    echo "<input type='text' id='data_beg' class='my-datepicker' readonly value=''>";
//    echo "<input type='text' id='data_end' class='my-datepicker' readonly value=''>";
//    echo "<input type='button' name='updt_lst' id='updt_lst' class='but' value='Обновить'>";
//    echo "</fieldset>";
//    echo "</form>";
//    echo "</div>";
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


//     $files = glob("*.php");
//    print_r($_SERVER);
//    echo "<br>----------------1----------------------------<br>";
//    print_r($files);
//    echo "<br>";
//    echo "numofpng = ".  count($png_files)."<br>";
//    echo "---------------------2-----------------------<br>";
    //preg_match_all('/(img|src)=("|\')[^"\'>]+/i', $files, $media);
//    $pict = glob($job_path."*png");
//    echo $web_job_path."<br>";
//    echo "---------------------3-----------------------<br>";
    //print_r($media);
    $ii = 0;
    foreach ($png_files as $png_file) {
	//echo "<p class='phid' hidden><a href='#' class='us_descr'  id='ud$ii'>ДОБАВИТЬ ОПИСАНИЕ</a></p>";
	echo "<p class='p_descr' hidden><a href='#' class='us_descr'  id='ud$ii'>$jobs_table[add_descr]</a></p>";
	echo "<div id='div_ud$ii' class='div_descr'></div>";
	$png = "http://" . $web_job_path . $png_file;
//	echo $png;
	echo "<p class='img_hist'><img src='$png' ></p>";
	$ii++;
    }
//    print_r($_REQUEST);


    echo "</div>";
}

function files() {
    
}
?>