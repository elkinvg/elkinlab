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
		
		$('.std-txt').click(function ()
		{
		    if ($('#std_txt').attr('hidden') !== undefined) {
			$('#std_txt').removeAttr('hidden');
		    }
		    else {
			$('#std_txt').attr('hidden', '');
		    }
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
		    $.post("../php/jobpars-li.php", {oper: "list_pars", job_id: job_id}, function (data) {
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
