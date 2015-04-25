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
	$nprhead = true;
	require "./common_page.inc.php";
	require "../lang/$context[lang]/sharedjob_descr.inc.php";
	?>
        <script type="text/javascript">
	    $(document).ready(function () {
		heightDivJNew();
		$(window).resize(function () {
		    heightDivJNew();
		});

		$('#jobs_shar tbody').append(onlyHeadTable());
		updateTable();

		function onlyHeadTable()
		{
		    var tr = "<tr class='ui-widget-header tr-head'>";
		    tr += "<td width='15%'>User</td> <td width='40%'>Comment</td><td width='30%'>Task Name</td><td width='15%'>finished</td>";
		    tr += "<tr>";
		    return tr;
		}

		function updateTable()
		{
		    var operation = "shared";
		    var params = "";
		    $.post("../php/dbcon4job_list.php", {oper: operation, params: params, cookie_prefix: cookie_prefix}, function (data) {
			var tmp = data;
			var tmp2 = tmp;
			var tr = null;
			for (var n = 0; n < data.val.length; n++)
			{
			    var pattrs = "job_id=" + data.val[n].job_id + " ";
			    pattrs += "task_id=" + data.val[n].task_id + " ";
			    pattrs += "user_id=" + data.val[n].user_id + " ";
			    //pattrs += "utype=" + data.val[n].utype + " ";
			    pattrs += "job_status=" + data.val[n].job_status + " ";
			    tr = "<tr class='job_choose' style='cursor: pointer' + " + pattrs + ">";
			    //tr+="<td>" + data.val['last_name'] + " " + data.val['first_name'] + "</td>";
			    var uname = data.val[n]['last_name'] + " " + data.val[n]['first_name'];
			    tr += addTd(uname, data.val[n]['def_val'], data.val[n]['caption'], data.val[n]['finished']);
			    tr += '</tr>';

			}
			if (tr != null)
			    $("#jobs_shar").append(tr);

			$(".job_choose").hover(function () {
			    $(this).addClass("ui-state-highlight");
			}, function () {
			    $(this).removeClass("ui-state-highlight");
			});
			heightDiv();
			jobChoose();
		    }, "json"); //post
		}
		
		    function jobChoose()
    {
	$(".job_choose").click(function ()
	{
	    var par_get = new Object();
	    par_get.job_id = $(this).attr("job_id");
	    par_get.task_id = $(this).attr("task_id");
	    par_get.user_id = $(this).attr("user_id");
	    //par_get.utype = $(this).attr("utype");
	    par_get.job_status = $(this).attr("job_status");

	    window.location.href = "../php/job_container.php?" + $.param(par_get);
	});
    }
	    });
        </script>
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

