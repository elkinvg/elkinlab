$(document).ready(function () {
    borderDel();
    heightDivJNew();
    $(window).resize(function () {
        heightDivJNew();
    });
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

    dialog();

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
                var def_val = data.val[n].def_val;
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
                    min_time = min_val;                    
                    max_val = def_data.toString() + " 23:59";
                    max_time = max_val;
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
                        "' maxlength=80 size=84></td><td><input type='" + inputType + "' class='" + cssclass + "' maxlength=32 size=24 value='" + inputValue + "' " + vals + add + " ></td></tr>";
            }
            $('#params_form tbody').html(tr);
            addDateTimePicker(min_time, max_time);
            checkAll();

        }
        , "json"); // post
    } //parametersTable


//    function updateTipsNew(t, o) {
//	o.text(t).effect("highlight", {}, 1500);
//    }
//
//    function trimstring(str) {
//	if (str.trim)
//	    return str.trim();
//	else
//	    return str.replace(/(^\s*)|(\s*$)/g, "");
//    } //find and remove spaces from left and right hand side of string
//
//    function checkNums(oinput, otips)
//    {
//	//$(this).val(), $(this).attr('min_val'),  $(this).attr('max_val')
//	var odef = oinput.val();
//	var omin = oinput.attr('min_val');
//	var omax = oinput.attr('max_val');
//
//	var vdef = parseFloat(odef);	//odef.val());	//isNaN(x)
//	var vmin = parseFloat(omin);	//omin.val());
//	var vmax = parseFloat(omax);	//omax.val());
//	if ((vdef > vmax) || (vdef < vmin)) {
//	    oinput.addClass('ui-state-error');
//	    var wartext = "Value vs [" + omin + " - " + omax + " ]";
//	    updateTipsNew(wartext, otips);
//	    return false;
//	}
//	return true;
//    }
//
//    function checkRegexpNew(o, regexp, n, t, otips)
//    {
//	if (regexp.test(o.val())) {
//	    return true;
//	}
//	o.addClass('ui-state-error');
//	updateTipsNew(n + " -> " + t, otips);
//	return false;
//    }

});


