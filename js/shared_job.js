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

