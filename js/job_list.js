$(document).ready(function () {
    var tmpDayAgo = 60;


    //timeago.setMilliseconds(today.getMilliseconds() - tmpDayAgo * 24 * 3600 * 1000);
    var begin_height = $(".pppanel").outerHeight();

    borderDel();

    debugInfo();
    updateTable('first');
    $(window).resize(function () {
	//if($(".ppcontrol").height()>$(".ppview").height())$(".ppcontrol").height($(".ppview").height());
	heightDiv();
    });

    $("#cost_b").click(function ()
    {
	updateTable('list');
    });


    function debugInfo()
    {
	//$("#errordiv").append("context lang=" + context.lang + "<br>");
	//$("#errordiv").append("today (sek) = " + Math.round(today.getTime() / 1000) + "<br>");
	//$("#errordiv").append("timeago (sek) = " + Math.round(timeago.getTime() / 1000) + "<br>");
    }

    function onlyHeadTable()
    {
	var tr = "<tr class='ui-widget-header tr-head'>";
	tr += "<td width='4%'>ID</td> <td width='4%'><input type='checkbox'></td><td width='15%'>started||finished</td><td width='25%'>Comment</td>";
	tr += "<td width='35%'>Task Name</td><td width='2%'><nobr>&#9733</nobr></td><td width='15%'>User</td>";
	tr += "<tr>";
	return tr;
    }

    function updateTable(operation)
    {
	var html = "";
	html += "<table id='result_table' class='result_table'>";
	html += "<tbody>";
	html += onlyHeadTable();

	html += "</tbody>";
	html += "</table>";
	$(".ppview").html(html);
	$("#result_table").css("font-size", "0.7em");


	var params = new Object();
	if (operation == 'first')
	{
	    var from,upto;
	    if (jobs_to===undefined && jobs_from===undefined)
	    {
		from = timeago;
		upto = today;
	    }
	    else
	    {
		from = new Date();
		from.setTime(jobs_from);
		upto = new Date();
		upto.setTime(jobs_to);
	    }

	    $(".my-datepicker").datepicker({
		dateFormat: "yy-mm-dd",
		maxDate: upto,
		minDate: from,
		changeMonth: true,
		changeYear: true
	    });
	    params.finishTime = Math.round((upto.getTime() / 1000) + 3600);
	    params.startTime = Math.round(from.getTime() / 1000);

	}
	else if (operation == 'list')
	{
	    var from = new Date($("#data_beg").val());
	    var upto = new Date($("#data_end").val());
	    from.setHours(0, 0);
	    upto.setHours(23, 59);
	    my_setcookie("jobs_from",from.getTime().toString(),exp_day,"/");
	    my_setcookie("jobs_to",upto.getTime().toString(),exp_day,"/");
//                        //$("#errordiv").append("from="+from.getTime()+"<br>");
//                        //$("#errordiv").append("to="+upto.getTime()+"<br>");
	    //.getTime()/1000
	    if (from.getTime() > upto.getTime()) {
		$("#data_end").addClass("ui-state-error");
		return;
	    }
	    else
	    {
		$("#data_end").removeClass("ui-state-error");
		params.startTime = Math.round(from.getTime() / 1000);
		params.finishTime = Math.round(upto.getTime() / 1000);
	    }
	}


	$.post("../php/dbcon4job_list.php", {oper: operation, params: params, cookie_prefix: cookie_prefix},
	function (data) {
	    var tr = "";

	    for (var n = 0; n < data.val.length - 1; n++)
	    {
		var utype = "", job_status = "";
		var job_time = data.val[n].started;
		if (data.val[n].utype == 1)
		    utype = "<nobr><span style='color: green'>&#9733</span></nobr>";
		else if (data.val[n].utype == 2)
		    utype = "<span style='color: orange'><nobr>&#9733&#9733</nobr></span>";
		else if (data.val[n].utype == 8)
		    utype = "<span style='color: red'><nobr>&#9733&#9733&#9733</nobr></span>";

		if (data.val[n].job_status == 0)
		    job_status = '<span style=\'color: pink\'>&#9679</span>';
		if (data.val[n].job_status == 1)
		    job_status = '<span style=\'color: blue\'>&#9679</span>';
		if (data.val[n].job_status == 2)
		    job_status = '<span style=\'color: orange\'>&#9679</span>';
		if (data.val[n].job_status == 3) {
		    job_status = '<span style=\'color: green\'>&#9679</span>';
		    job_time = data.val[n].finished
		}
		if (data.val[n].job_status == 4)
		    job_status = '<span style=\'color: red\'>&#9679</span>';
		if (data.val[n].job_status > 10)
		    job_status = '<span style=\'color: black\'>&#9679</span>';

		var pattrs = "job_id=" + data.val[n].job_id + " ";
		pattrs += "task_id=" + data.val[n].task_id + " ";
		pattrs += "user_id=" + data.val[n].user_id + " ";
		pattrs += "utype=" + data.val[n].utype + " ";
		pattrs += "job_status=" + data.val[n].job_status + " ";
		//pattrs =
		tr += "<tr class='job_choose' style='cursor: pointer'" + pattrs + ">";
		tr += addTd(data.val[n].job_id, job_status, job_time, data.val[n].def_val, data.val[n].caption, utype, data.val[n].first_name + " " + data.val[n].last_name);
		tr += "</tr>";

	    }

	    $("#result_table").append(tr);


	    $(".job_choose").hover(function () {
		$(this).addClass("ui-state-highlight");
	    }, function () {
		$(this).removeClass("ui-state-highlight");
	    });

	    var upto_str = $.datepicker.formatDate('yy-mm-dd', upto);
	    var ago_str = $.datepicker.formatDate('yy-mm-dd', from);
	    heightDiv();

	    $("#data_beg").val(ago_str.toString());
	    $("#data_end").val(upto_str.toString());
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
	    par_get.utype = $(this).attr("utype");
	    par_get.job_status = $(this).attr("job_status");

	    window.location.href = "../php/job_container.php?" + $.param(par_get);
	});
    }

    function addTd()
    {
	var td = "";
	for (var n = 0; n < arguments.length; n++)
	    td = td + "<td>" + arguments[n] + "</td>";
	return td;
    }

});

