<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<?php
	$pp = "..";

	echo "<link href='$pp/css/common.css' rel='stylesheet' type='text/css' />";
	require "$pp/php/config.inc.php";


//lang-dependent:
	require "$pp/lang/$context[lang]/msg.inc.php";
	echo "<script type='text/javascript' src='$pp/js/jquery/jquery-2.1.3.min.js'></script> \n"; // elkin
	echo "<link type='text/css' href='$pp/js/jquery/jquery-ui-1.11.3/themes/sunny/jquery-ui.css' rel='stylesheet' />\n"; // elkin
	echo "<script type='text/javascript' src='$pp/js/jquery/jquery-ui-1.11.3/external/jquery/jquery.js'></script>\n"; // elkin
	echo "<script type='text/javascript' src='$pp/js/jquery/jquery-ui-1.11.3/jquery-ui.js'></script>\n"; // elkin
	echo "<script type='text/javascript' src='$pp/js/jquery/jquery-ui-timepicker-addon.js'></script>\n"; // elkin
	echo "<script type='text/javascript' src='$pp/js/common.js'></script>\n"; // elkin
	?>

        <script type="text/javascript">
<?php
echo "warn_length='$reg_form[warn_length]';";
echo "warn_digits_only='$reg_form[warn_digits_only]';";
echo "warn_symbols = '$reg_form[warn_symbols]';";
echo "warn_no_sel= '$tasks_form[no_sel_warning]';";
echo "warn_number='$reg_form[warn_number]';";
echo "warn_date_fromat='$tasks_form[warn_date_fromat]';";
echo "warn_station='$tasks_form[warn_station]';";
echo "job_enqueued='$tasks_form[job_enqueued]';";
?>
	    var rexNumber = new RegExp("^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$", "i");

	    $(document).ready(function () {
		var caption = $("#caption"),
			par_numb = $("#par_numb"),
			job_id = $("#job_id"),
			task_id = $("#task_id"),
			params_task_id = $("#params_task_id"),
			oper = $("#oper"),
			params_oper = $("#params_oper"),
			uuid = $("#uuid"),
			newrec = $("#newrec"),
			allFields = $([]).add(caption).add(par_numb).add(job_id).add(task_id).add(oper).add(uuid).add(newrec).add(params_task_id).add(params_oper),
			tips = $("#validateTips"),
			tipsparams = $("#validateTipsParams");



		function checkLengthNew(o, n, min, max, otips)
		{
		    if (o.val().length >= min && o.val().length <= max) {
			return true;
		    }
		    o.addClass('ui-state-error');
		    if (min == max)
			t = warn_length + " : " + min;
		    else
			t = warn_length + " : " + min + " - " + max;
		    updateTipsNew(n + " -> " + t, otips);
		    return false;
		}

		function checkRegexpNew(o, regexp, n, t, otips)
		{
		    if (regexp.test(o.val())) {
			return true;
		    }
		    o.addClass('ui-state-error');
		    updateTipsNew(n + " -> " + t, otips);
		    return false;
		}

		function checkNums(odef, omin, omax, otips)
		{
		    var s;
		    s = odef.val();
		    var vdef = parseFloat(s);	//odef.val());	//isNaN(x)
		    s = omin.val();
		    var vmin = parseFloat(s);	//omin.val());
		    s = omax.val();
		    var vmax = parseFloat(s);	//omax.val());       	    
		    if (vmin > vmax) {
			omin.addClass('ui-state-error');
			omax.addClass('ui-state-error');
			updateTipsNew("Min > Max", otips);
			return false;
		    }
		    if ((vdef > vmax) || (vdef < vmin)) {
			odef.addClass('ui-state-error');
			var wartext = "Value vs [" + omin.val() + " - " + omax.val() + " ]";
			updateTipsNew(wartext, otips);
			return false;
		    }
		    return true;
		}

		function updateTipsNew(t, o) {
		    o.text(t).effect("highlight", {}, 1500);
		}
		function trimstring(str) {
		    if (str.trim)
			return str.trim();
		    else
			return str.replace(/(^\s*)|(\s*$)/g, "");
		} //find and remove spaces from left and right hand side of string

		$('.job-add').click(function ()
		{
		    var task_id = $(this).attr("task_id");
		    var task_par_numb = $(this).attr("par_number");
		    var task_caption = $(this).find('a').html();

		    $('#newrec').val(1);	//set brand new job flag
		    $('#task_id').val(task_id);
		    $('#par_numb').val(task_par_numb);
		    params_task_id.val(task_id);
		    caption.val(task_caption);

<?php echo "var langt='{$job_params_form['dtitle_new']}'; "; ?>
		    var t = langt + task_caption + ")";
		    PopulateParams();

		    $('#params').dialog('option', 'title', t);
		    $('#params').dialog("open");
		})
			.hover(function () {
			    $(this).addClass("ui-state-hover");
			}, function () {
			    $(this).removeClass("ui-state-hover");
			})
			.mousedown(function () {
			    $(this).addClass("ui-state-active");
			})
			.mouseup(function () {
			    $(this).removeClass("ui-state-active");
			});


		function PopulateParams()
		{
		    var op = $('#newrec').val();

		    //var sh = (op==0) ? "jobpars.php" : "taskpars.php";
		    var sh = "taskpars-li.php"; // TMP
		    params_oper.val("load");



		    //$('#errordiv').append( + '<br>');




		    $.post(sh, allFields, function (data) {
			try
			{
			    var aret = $.parseJSON(data);
			}
			catch (err)
			{
			    var aret = null;
			}

			if (aret == null) {
			    alert("No JSON DATA ");
			    return;
			}
			var n_taskpars = aret.length;

			par_numb.val(n_taskpars); // XZ
			$("#par_numb").val(n_taskpars); // XZ

			var selTag = $('#params_form tbody');
			selTag.empty();

			for (var i = 0; i < n_taskpars; i++)
			{
			    var pcap = '"' + aret[i].caption + '"'; // caption of parameter
			    var pname = '"' + aret[i].name + '"'; // name of parameter
			    var ptype = '"' + aret[i].type + '"'; // type of parameter
			    var pdef = '"' + aret[i].def_val + '"'; // default value
			    var pmin = '"' + aret[i].min_val + '"'; // min value
			    var pmax = '"' + aret[i].max_val + '"'; // max value

			    if (aret[i].type == 2) // for time 
			    {
				if (aret[i].max_val == 'undefined' || aret[i].max_val == 0)
				{
				    var now = new Date();
				    var now_ms = now.getTime();
				    var tomorrow = new Date(now_ms + 24 * 3600 * 1000);
				    var y = tomorrow.getFullYear();
				    var m = tomorrow.getMonth() + 1;
				    if (m < 10)
					m = "0" + m;
				    var d = tomorrow.getDate();
				    if (d < 10)
					d = "0" + d;
				    pmax = '"' + y + "-" + m + "-" + d + '"';
				}
			    }

			    var use_station = (aret[i].type == 0 && (aret[i].name.indexOf("USE_STATION_") != -1)) ? true : false; //shelkov

			    var transl;
			    var ptemp;
			    var TTT = <?php
if (isset($job_params_form)) {
    echo json_encode($job_params_form);
} else {
    echo "\"none\"";
}
?>;
			    if (TTT.end_time == TTT.none)
				$('#errordiv').append('>' + TTT.end_time + '<' + '<br>');



			    //title=' + ptitle + ' value=' + pcap 



			    if (TTT != "none")
				transl = Translate_par(use_station, pcap, aret[i], TTT);
			    else
				transl = "";

			    if (isTranslate)
			    {
				if (transl.length > 0)
				    ptemp = ' value=' + transl + '';
				else
				    ptemp = ' value=' + pcap;

			    } // translate for parameters                               

			    else
			    {
				if (transl.length > 0)
				    ptemp = 'title = ' + transl + ' value=' + pcap;
				else
				    ptemp = ' value=' + pcap;
			    }

			    var sdef = "";
			    var smin = "readonly";
			    var smax = "readonly";
			    var sshow = "hidden";

			    if (use_station == false)
			    {
				if (aret[i].type == 2)
				{
				    var def_time;
				    var def_data = $.datepicker.formatDate('yy-mm-dd', new Date());

				    if (aret[i].name.indexOf("START_TIME") != -1)
				    {
					def_time = "00:00";
				    }
				    if (aret[i].name.indexOf("END_TIME") != -1)
				    {
					def_time = "23:59";
				    }

				    var def_date_time = def_data.toString() + " " + def_time;

				    var params_def_val = '<td><input type="text" readonly' + sdef + ' name="params_def_' + i + '"       id="params_def_' + i + '" class="ui-widget-content ui-corner-all my-datepicker" maxlength=32 size=24  value="' + def_date_time /*pdef*/ + '"></td>'
					    //+ '<td><input type="text" readonly' + sdef + ' name="time_def_' + i + '"       id="time_def_' + i + '" class="ui-widget-content ui-corner-all my-timepicker" maxlength=32 size=8 value=' + def_time + '></td>';
					    ;
				}
				else
				{
//                                    if (aret[i].name.indexOf("RANK")!=-1)
//                                    {
//                                        params_def_val = '<td><input type="text" ' + sdef + ' name="params_def_' + i + '"       id="params_def_' + i + '" class="ui-widget-content ui-corner-all my-rank" maxlength=32  size=14 value=' + pdef + '></td>';
//                                    }
//                                    else
//                                    {
				    params_def_val = '<td><input type="text" ' + sdef + ' name="params_def_' + i + '"       id="params_def_' + i + '" class="ui-widget-content ui-corner-all" maxlength=32 size=14 value=' + pdef + '></td>';
//                                }
				}
				selTag.append(
					'<tr>' +
					//'<td><input type="text" readonly name="params_caption_' + i + '" id="params_caption_' + i + '" class="ui-widget-content ui-corner-all" maxlength=32 size=64  title=' + ptitle + ' value=' + pcap + '></td>' +
					'<td><input type="text" readonly name="params_caption_' + i + '" id="params_caption_' + i + '" class="ui-widget-content ui-corner-all" maxlength=32 size=64 ' + ptemp + '></td>' +
					params_def_val +
					'<td><input type=' + sshow + ' readonly name="params_name_' + i + '"   id="params_name_' + i + '" class="ui-widget-content ui-corner-all" maxlength=16 size=32 value=' + pname + '></td>' +
					'<td><input type=' + sshow + ' readonly name="params_type_' + i + '"     id="params_type_' + i + '" class="ui-widget-content ui-corner-all" maxlength=3 size=6 value=' + ptype + '></td>' +
					'<td><input type=' + sshow + ' ' + smin + ' name="params_min_' + i + '"      id="params_min_' + i + '" class="ui-widget-content ui-corner-all" maxlength=32 size=24 value=' + pmin + '></td>' +
					'<td><input type=' + sshow + ' ' + smax + ' name="params_max_' + i + '"     id="params_max_' + i + '" class="ui-widget-content ui-corner-all" maxlength=32 size=24 value=' + pmax + '></td>' +
					'</tr>'
					); // append
			    }
			    else
			    {
				pdef = 1;	//server gets this for checked boxes
				scb = (aret[i].def_val == 0) ? " " : " checked";
				selTag.append(
					'<tr>' +
					//'<td><input type="text" readonly name="params_caption_' + i + '" id="params_caption_' + i + '" class="ui-widget-content ui-corner-all" maxlength=32 size=64  title=' + ptitle + ' value=' + pcap + '></td>' +
					'<td><input type="text" readonly name="params_caption_' + i + '" id="params_caption_' + i + '" class="ui-widget-content ui-corner-all" maxlength=32 size=64  ' + ptemp + '></td>' +
					'<td><input type="checkbox" ' + sdef + ' name="params_def_' + i + '"       id="params_def_' + i + '" class="ui-widget-content ui-corner-all" maxlength=32 size=24 value=' + pdef + scb + '></td>' +
					'<td><input type=' + sshow + ' readonly name="params_name_' + i + '"   id="params_name_' + i + '" class="ui-widget-content ui-corner-all" maxlength=16 size=32 value=' + pname + '></td>' +
					'<td><input type=' + sshow + ' readonly name="params_type_' + i + '"     id="params_type_' + i + '" class="ui-widget-content ui-corner-all" maxlength=3 size=6 value=' + ptype + '></td>' +
					'<td><input type=' + sshow + ' ' + smin + ' name="params_min_' + i + '"      id="params_min_' + i + '" class="ui-widget-content ui-corner-all" maxlength=32 size=24 value=' + pmin + '></td>' +
					'<td><input type=' + sshow + ' ' + smax + ' name="params_max_' + i + '"     id="params_max_' + i + '" class="ui-widget-content ui-corner-all" maxlength=32 size=24 value=' + pmax + '></td>' +
					'</tr>'
					);
			    } // if else use station


			    $(".my-datepicker").datetimepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
				minDate: aret[i].min_val,
				maxDate: today,
				onSelect: function () {
				    $(this).focus();
				}, // for fix bug in IE
				onClose: function () {
				    (this).datepicker("hide");
				}   // for fix bug in IE
			    }); //fix bug - чередовать окошки ... иначе не закрывается in IE

			    //$('#errordiv').append("time_sel=" + time_sel.valueOf() + "<br>");

			} // for n_taskpars

		    }, "text"); //post
		} // PopulateParams()

		$("#params").dialog({
		    autoOpen: false,
		    width: 440,
		    //height: 540,
//                    position: "center",
		    position: {my: "center", at: "center", of: $('#jobs_new_sel')},
		    //position: [ { my: "center", at: "center", of: $('#jobs_new_sel') } ],
		    modal: true,
		    buttons: [
			{
			    text: "<?php echo "$tasks_form[button_ok]"; ?>",
			    click: function () {
				var i, ptype, n = par_numb.val();
				var sel_datatime;
				var isSelData, isSelTime;
				var bValid = true;

<?php echo "var sdef='$job_params_form[def_val]';"; ?>
<?php echo "var smin='$job_params_form[min_val]';"; ?>
<?php echo "var smax='$job_params_form[max_val]';"; ?>

				var dsel, sval, sel;
				var selTag = $('#params_form :input');
				selTag.removeClass('ui-state-error');
				var sField;

				var nStations = 0, bStations = false, sStartTime = null, sEndTime = null;

				for (i = 0; i < n; i++)
				{
				    ptype = $("#params_type_" + i).val();
				    sel = sel = $("#params_def_" + i);
				    sField = sdef;

				    if (ptype == 2)
				    {
					var space = "";
					dsel = $("#params_name_" + i);
					sval = dsel.val();

					sel_datatime = $("#params_def_" + i);

					if (sval.indexOf("START_TIME") != -1)
					{
					    sStartTime = sel_datatime;
					}
					else if (sval.indexOf("END_TIME") != -1)
					{
					    sEndTime = sel_datatime;
					}

					if (sStartTime != null && sEndTime != null)
					{
					    //$('#errordiv').append("START_TIME=" + sStartTime.val() + "<br>" + "END_TIME=" + sEndTime.val() + "<br>");
					}

				    } // if ptype == 2
				    else if (ptype == 1)
				    {
					var scom = trimstring(sel.val());	//26.09.2011 20:14:26
					sel.val(scom);
					bValid = bValid && checkLengthNew(sel, sField, 1, 32, tipsparams);
				    } // else if ptype == 1
				    else if (ptype == 0)
				    {
					bValid = bValid && checkLengthNew(sel, sField, 1, 32, tipsparams);
					bValid = bValid && checkRegexpNew(sel, rexNumber, sField, warn_number, tipsparams);
				    }// else if ptype == 0

				    //check user value is within {min,max}------------------------
				    var sel_def = $("#params_def_" + i);
				    var sel_min = $("#params_min_" + i);
				    var sel_max = $("#params_max_" + i);
				    if (ptype == 0)
					bValid = bValid && checkNums(sel_def, sel_min, sel_max, tipsparams);
				    if (!bValid)
					break;
				}


				var bTime = (Date.parse(sEndTime.val()) - Date.parse(sStartTime.val()) > 0) ? true : false;
				if (!bTime) {
				    sEndTime.addClass('ui-state-error');
				    updateTipsNew("END_TIME < START_TIME !!!", tipsparams);
				    bValid = bTime;
				}
				//bValid = !bValid;
				//bValid = false;
				if (bValid)
				{
				    //$('#errordiv').append("fields");
				    var ok = false;
				    params_oper.val("save");
				    //$('#errordiv').append(params_oper.val()+"<br>");
				    var user_id = my_getcookie("uuid");
				    uuid.val(user_id);

				    tid = params_task_id.val();
				    var fields = $("#params :input").serializeArray();
				    
				    

				    //$('#errordiv').append(" data.length: " + fields.length + "; <br>");
				    //$.post("taskpars-li.php", fields, function (data)
				    $.post("jobpars-li.php", fields, function (data)
				    {

					var aret;
					try
					{
					    aret = $.parseJSON(data);
					    //$('#errordiv').append("aret != null <br>");
					}
					catch (err)
					{
					    aret = null;
					    $('#errordiv').append("<br>" + data+ " <br>");
					    $('#errordiv').append("<br> aret == null <br>");
					}
					//$('#errordiv').append(aret[0].par_number + "  END <br>");
//					if (aret[0].par_number > 0)
//					{
//					    window.location = "../index.php";
//					}
				    }, "text");
				    $(this).dialog('close');
				}
				; //if bValid
			    }
			},
			{
			    text: "<?php echo "$tasks_form[button_cancel]"; ?>",
			    click: function () {
				$(this).dialog("close");
			    }
			}
		    ]
		});
	    });

        </script>

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
    <body vlink=black link=black>
        <!--<button id="opener-2">Open Dialog</button>-->


        <div <?php echo " id='params' name='params' title='$job_params_form[title]'"; ?> >
<?php
//echo "<div id='params' name='params' title='$job_params_form[title]'>";
echo "<p id='validateTipsParams'>$job_params_form[note_1]($job_params_form[note_2]" . date('Y-m-d', $date_from) . ")<br>$job_params_form[note_3]$max_bins</p>";
?>

            <form>
                <fieldset>
                    <input type="hidden" name="params_oper" id="params_oper">
                    <input type="hidden" name="uuid" id="uuid">
                    <input type="hidden" name="job_id" id="job_id">	
                    <input type="hidden" name="newrec" id="newrec" value=1>	
                    <input type="hidden" name="params_task_id" id="params_task_id">
                    <input type="hidden" name="par_numb" id="par_numb" value=0>	
                    <table name="params_form" id="params_form">
                        <thead>
                            <tr><td><?php echo "$job_params_form[caption]"; ?></td><td><?php echo "$job_params_form[def_val]"; ?></td><td colspan=4>&nbsp;</td></tr>	
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
	$brief_descr = file_get_contents("$pp/lang/$context[lang]/newjob_brief_descr.html");
	$icon = "<img src='../skin/rating_on.png'>";
	?>
        <table height=100%>

            <TR height=100%><TD class=showcase>

                    <table name='jobs_new_sel' id='jobs_new_sel' cellpadding=2>
                        <div id="errordiv"></div>
<!--//$icon="<img src='../skin/star_gray4_16x16.png'>";-->

                        <thead>
                            <tr><td <?php echo "colspan=$cols"; ?> class=page_title><?php echo "$jobs_new[jobs_new_title]"; ?> </td>
                            <tr><td <?php echo "colspan=$cols"; ?> class=page_note> <?php echo "$brief_descr"; ?> </td>
                            <tr><td <?php echo "colspan=$cols"; ?> ><hr></td></tr>
                            <tr class=page_table_header>
                                <td title= <?php echo "$jobs_new[complexity]"; ?> ><a href='#'><?php echo "$icon"; ?> </a></td>
                                <td><?php echo "$jobs_new[caption]" ?> </td>
                                <td> <?php echo "$jobs_new[description]"; ?> </td>
                                <td><?php echo "$jobs_new[remark]"; ?> </td>
                            </tr>
                            <tr><td colspan=<?php echo "$cols"; ?> ><hr></td></tr>
                        </thead>
                        <tbody>

			    <?php
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

				$descr_link = "" . $proj_home . "php/container.php?url=lang/" . $context['lang'] . "/task_descr/task" . $task_id . ".htm";
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
				    $tr = $fill ? "class=interlace" : "";
				    echo "<tr $tr>";
				    echo "<td class=\"col_complexity\" width=4%><a href='#' title='$complexity_tt'>$icons</a></td>";
				    echo "<td width=10% class='job-add' task_id=$task_id par_number=$pars><a href='#' title='$jobs_new[caption_tt]'>$value[caption]</a></td>";
				    echo "<td width=43% class='job-descr hover_on_white' task_id=$task_id><a href='$descr_link' target=_new title='$jobs_new[description_tt]'>$descr</a></td>";
				    echo "<td width=43%>$rem</td>";
				    echo "</tr>";
				    //ELKIN-B
				}
				//ELKIN-E
			    }
			    ?>
                        </tbody>
                        <tr><td <?php echo "colspan=$cols"; ?> ><hr></td></tr>
                        <tr><td <?php echo "colspan=$cols"; ?> class=hover_on_white><a href='#'> <?php echo "$jobs_new[jobs_new_note]"; ?> </a></td></tr>
                    </table>

                </TD></TR>
        </table>


    </body>
</html>