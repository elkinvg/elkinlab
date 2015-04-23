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

function checkAll()
{
    if ($('#params_form tbody tr :checkbox').length > 0)
    {
	var chkAll = "<tr><td> (un)check All </td><td> <input type='checkbox' chkall checked> </td></tr>";
	$('#params_form tbody tr :checkbox:eq(0)').parent().parent().before(chkAll);

	$("#params_form tbody [chkall]").change(function ()
	{
	    $("#params_form tbody [pname]:checkbox").each(function ()
	    {
		$(this).prop("checked", $("#params_form tbody [chkall]").prop("checked"));
	    });
	});
    }

    //prepend("<tr><td> One </td><td> Two </td></tr>");

}

function dialog() {
    $("#params").dialog({
	autoOpen: false,
	width: 400,
	height: 540,
//                    position: "center",
	position: {my: "center", at: "top", of: window},
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
		    $('#params_form tbody [ptype]:checkbox').each(function ()
		    {
			var ch = $(this).prop("checked");
			if (!ch)
			    $(this).val("0");
			if (ch)
			    $(this).val("1");
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
			var paramsTr = $('#params_form tbody :input').not('[chkall]');
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
				var from = timeago;
				var upto = new Date();
				upto.setHours(23, 59);				
				
				my_setcookie("jobs_from", from.getTime().toString(), exp_day, "/");
				my_setcookie("jobs_to", upto.getTime().toString(), exp_day, "/");
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
    });
} // dialog
