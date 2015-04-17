$(document).ready(function () {
    borderDel();
    var validateTipsParams = $("#validateTipsParams").html();

    $(".job-add").click(function ()
    {
	$("#validateTipsParams").html(validateTipsParams);
	var sh = "../php/taskpars-li.php";
	var task_id = $(this).attr("task_id");
	//var task_par_numb = $(this).attr("par_number");
	var params = new Object();
	params.task_id = task_id;
	$('#task_id').val(task_id);
	$('#params').dialog("open");
	$('#params').dialog('option', 'title', $(this).attr("task_name"));
	parametersTable(sh, "load", params);
    }).hover(function () {
	$(this).addClass("ui-state-hover");
    }, function () {
	$(this).removeClass("ui-state-hover");
    }); // job-add.click()

    function err()
    {
	$("#errordiv").append("pmain = " + $(".pmain").height() + "<br>");
	$("#errordiv").append("pppanel = " + $(".pppanel").height() + "<br>");
	$("#errordiv").append(" pjnew = " + $(".pjnew").outerHeight() + "<br>");
	$("#errordiv").append("table = " + $("#result_table").outerHeight() + "<br>");
    }

    $("#params").dialog({
	autoOpen: false,
	width: 400,
	height: 540,
//                    position: "center",
	position: {my: "center", at: "top", of: $('#jobs_new_sel')},
	//position: [ { my: "center", at: "center", of: $('#jobs_new_sel') } ],
	modal: true,
	buttons: [
	    {
		text: "Ok",
		click: function ()
		{
		    var tipsparams = $("#validateTipsParams");
//				$('#errordiv').append("--->" + validateTipsParams + "<---");
		    var bValid = true;
		    var sStartTime = null;
		    var sEndTime = null;
		    var sel = $('#params_form tbody [min_val]');
		    sel.removeClass('ui-state-error');
		    sStartTime = $('[pname="START_TIME"]');
		    sEndTime = $('[pname="END_TIME"]');

		    $('[ptype="1"]').each(function ()
		    {
			$(this).val(trimstring($(this).val()));
			if ($(this).val().length < 1)
			{
			    $(this).addClass('ui-state-error');
			    updateTipsNew("COMMENT!", tipsparams);
			    bValid = false;
			}
		    });
                    $('#params_form tbody :checkbox').each(function ()
                    {
                        var ch = $(this).prop("checked");
                        if (!ch) $(this).val("0");
                    });
                    //				

		    if ($('#params_form tbody :checkbox').length > 0 && $('#params_form tbody :checkbox:checked').length < 1)
		    {
			var warn_station = $("#warn_station").val();
			updateTipsNew(warn_station, tipsparams);
			bValid = false;
		    } //[type=text] input[type=text] [pname]  [ptype="0"]

		    $('#params_form tbody [ptype="0"][type=text]').each(function ()
		    {
			$(this).val(trimstring($(this).val()));
			var warn_number = $("#warn_number");
			var sField = $("#def_value");
			bValid = bValid && checkRegexpNew($(this), rexNumber, sField.val(), warn_number.val(), tipsparams);
			if (!bValid)
			    return bValid;
			bValid = bValid && checkNums($(this), tipsparams);
			if (!bValid)
			    return bValid;
		    });//attr('pname')


		    var bTime = (Date.parse(sEndTime.val().replace(/-/g, '/')) - Date.parse(sStartTime.val().replace(/-/g, '/')) > 0) ? true : false; // replace for fixing IE bug
		    if (!bTime) {
			sEndTime.addClass('ui-state-error');
			updateTipsNew("END_TIME < START_TIME !!!", tipsparams);
			bValid = bTime;
		    }

		    if (bValid)
		    {
			var params = new Array();
			var paramsTr = $('#params_form tbody :input');
			var n = 0;
			var tmpAr = new Object();
			paramsTr.each(function ()
			{

			    if (n % 2 == 0)
			    {
				tmpAr = {};
				tmpAr.caption = $(this).val();
			    }
			    else
			    {
				tmpAr.def_val = $(this).val();
				tmpAr.min_val = $(this).attr("min_val");
				tmpAr.max_val = $(this).attr("max_val");
				tmpAr.type = $(this).attr("ptype");
				tmpAr.name = $(this).attr("pname");
				params.push(tmpAr);
			    }

			    n++;
			});

			var user_id = my_getcookie("uuid");
			var task_id = $('#task_id').val();
			$.post("../php/jobpars-li.php", {task_id: task_id, user_id: user_id, oper: 'save', params: params}, function (data) {
			    var errno = data.errno;
			    var error = data.error;
			    if (!errno)
			    {
				window.location = "../php/job_list.php";
			    }
			}, "json");
		    }
		}


	    },
	    {
		text: "Cancel",
		click: function () {
		    $(this).dialog("close");
		}
	    }
	]
    }); // dialog

    function parametersTable(sh, oper, params)
    {
	$.post(sh, {oper: oper, params: params}, function (data) {
	    var tr = "";
	    var min_time = "";
	    var max_time = "";
	    for (var n = 0; n < data.val.length; n++)
	    {
		var type = data.val[n].type;
		var name = data.val[n].name;
		var def_val = data.val[n].min_val;
		var min_val = data.val[n].min_val;
		var max_val = data.val[n].max_val;
		var caption = data.val[n].caption;
		var task_id = data.val[n].task_id;
		var par_id = data.val[n].par_id;
		var inputValue = "";
		var inputType = "";
		var add = "";
		var cssclass = "";

		if (type == 2)
		{
		    var def_data = $.datepicker.formatDate('yy-mm-dd', new Date());
		    var def_time;
		    if (name == "START_TIME")
			def_time = "00:00";
		    if (name == "END_TIME")
			def_time = "23:59";
		    //min_time = min_val;
		    max_val = def_data.toString();
		    inputValue = def_data.toString() + " " + def_time;
		    inputType = "text";
		    cssclass = 'ui-widget-content ui-corner-all my-datepicker';
		    add = "readonly";
		}
		else
		{
		    if (type == 0 && name.indexOf("USE_STATION_") != -1)
		    {
			inputType = "checkbox";
			inputValue = 1;
			add = "checked";
		    }
		    else
		    {
			inputType = "text";
			inputValue = def_val;
			cssclass = 'ui-widget-content ui-corner-all';
		    }

		}
//			    if (max_val=="") max_val="none";
//			    if (min_val=="") min_val="none";
		var vals = " min_val='" + min_val + "' max_val='" + max_val + "' ptype='" + type + "' " + " pname='" + name + "' ";
		tr += "<tr><td><input type=text readonly class='ui-widget-content ui-corner-all' value='"
			+ caption +
			"' maxlength=80 size=84></td><td><input type='" + inputType + "' class='" + cssclass + "' maxlength=80 size=24 value='" + inputValue + "' " + vals + add + " ></td></tr>";
	    }
	    $('#params_form tbody').html(tr);

	    $(".my-datepicker").datetimepicker({
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		minDate: min_time,
		maxDate: new Date(),
//                                onSelect: function () {
//                                    $(this).focus();
//                                }, // for fix bug in IE
//                                onClose: function () {
//                                    (this).datepicker("hide");
//                                }   // for fix bug in IE
	    }); //fix bug - чередовать окошки ... иначе не закрывается in IE
	}
	, "json"); // post
    } //parametersTable

    function updateTipsNew(t, o) {
	o.text(t).effect("highlight", {}, 1500);
    }

    function trimstring(str) {
	if (str.trim)
	    return str.trim();
	else
	    return str.replace(/(^\s*)|(\s*$)/g, "");
    } //find and remove spaces from left and right hand side of string

    function checkNums(oinput, otips)
    {
	//$(this).val(), $(this).attr('min_val'),  $(this).attr('max_val')
	var odef = oinput.val();
	var omin = oinput.attr('min_val');
	var omax = oinput.attr('max_val');

	var vdef = parseFloat(odef);	//odef.val());	//isNaN(x)
	var vmin = parseFloat(omin);	//omin.val());
	var vmax = parseFloat(omax);	//omax.val());
	if ((vdef > vmax) || (vdef < vmin)) {
	    oinput.addClass('ui-state-error');
	    var wartext = "Value vs [" + omin + " - " + omax + " ]";
	    updateTipsNew(wartext, otips);
	    return false;
	}
	return true;
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

});


