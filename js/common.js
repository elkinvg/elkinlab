//common.js

//<COOKIES>
var cookie_prefix = "livni_"; //see config.inc.php
//var domain = ".eas.jinr.ru"; //need for common usage with Joomla domain cookie settings
//
//var today = new Date();
//var date_from = new Date(2009, 5 - 1, 7);//the date of data accumulation start (month -> 0..11
//var jobs_from = new Date(2010, 2 - 1, 4);//1st job
//var meteo_from = new Date(2010, 9 - 1, 14);//the date of data accumulation start (month -> 0..11
//var exp_min = new Date(today.getTime() + 1 * 60 * 1000);
var today = new Date();
var exp_day = new Date(today.getTime() + 24 * 60 * 60 * 1000);
//var exp_year = new Date(today.getTime() + 365 * 24 * 60 * 60 * 1000);

var timeago = new Date("2009-01-01".replace(/-/g, "/"));
//var jobs_from = my_getcookie("jobs_from");
//var jobs_to = my_getcookie("jobs_to");
var jobs_from = localStorage.getItem("jobs_from");
var jobs_to = localStorage.getItem("jobs_to");
//if(session_id() == '')	session_start();
//var jobs_from = $
	var tmpstr = timeago.getTime().toString();
	var tmpstr2 = today.getTime().toString();
	
if (jobs_from === null || jobs_from === "NaN")
    //my_setcookie("jobs_from", timeago.getTime().toString(), exp_day, "/");

	localStorage.setItem("jobs_from",timeago.getTime().toString());
if (jobs_to === null || jobs_to === "NaN")
    //my_setcookie("jobs_to", today.getTime().toString(), exp_day, "/");
	
	localStorage.setItem("jobs_to",today.getTime().toString());

var isTranslate = false;

function borderDel()
{
    $(".ppview").css("border-top", "0px");
    $(".ppview").css("border-bottom", " 0px");
    $(".ppcontrol").css("border-top", "0px");
    $(".ppcontrol").css("border-bottom", " 0px");
    $(".pjnew").css("border-top", "0px");
    $(".pjnew").css("border-bottom", " 0px");
}

function heightDiv()
{
//    var hight1 = $(".ppview").height();
////			$(".pppanel").height(hight1);
//    $(".ppcontrol").height(hight1);
//
//    var hight = 0;
//    var hightv = $(".ppview").outerHeight();
//    var hightc = $(".ppcontrol").outerHeight();
//    if (hightc>hightv) {$(".ppview").outerHeight(hightc);}
//    else {$(".ppcontrol").outerHeight(hightv);}
//			$(".pppanel").outerHeight(hightv);
    var panH = $('.pmain').outerHeight() - $(".ppheader").outerHeight() - $(".ppfooter").outerHeight();
    $(".pppanel").outerHeight(panH);
    $(".ppview").outerHeight($(".pppanel").outerHeight());
    $(".ppcontrol").outerHeight($(".pppanel").outerHeight());
}

function heightDivJNew()
{
    var panH = $('.pmain').outerHeight() - $(".ppheader").outerHeight() - $(".ppfooter").outerHeight();
    $(".pppanel").outerHeight(panH);
    $('.pjnew').outerHeight($(".pppanel").outerHeight());
}

function addTd()
{
    var td = "";
    for (var n = 0; n < arguments.length; n++)
	td = td + "<td>" + arguments[n] + "</td>";
    return td;
}

function addDateTimePicker(min_time, max_time) {
    $(".my-datepicker").datetimepicker({
	dateFormat: "yy-mm-dd",
	changeMonth: true,
	changeYear: true,
	minDate: min_time,
	maxDate: max_time,
//                                onSelect: function () {
//                                    $(this).focus();
//                                }, // for fix bug in IE
//                                onClose: function () {
//                                    (this).datepicker("hide");
//                                }   // for fix bug in IE
    }); //fix bug - чередовать окошки ... иначе не закрывается in IE
}

var rexNumber = new RegExp("^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$", "i");

function Translate_par(use_station_fun, pcap_fun, aret_fun, params_fun)
{
    var transl = "";

    if (use_station_fun)
    {
	if (aret_fun.caption.indexOf("Use station") != -1 && params_fun.use_station != params_fun.none)
	    transl = pcap_fun.replace("Use station", params_fun.use_station.toString());
    }
    else
    {
	if (aret_fun.caption.indexOf("Select data from") != -1 && params_fun.start_time != params_fun.none)
	    transl = pcap_fun.replace("Select data from", params_fun.start_time.toString());
	else if (aret_fun.caption.indexOf("Select data until") != -1 && params_fun.end_time != params_fun.none)
	    transl = pcap_fun.replace("Select data until", params_fun.end_time.toString());
	else if (aret_fun.caption.indexOf("Number of bins in the hiistogram") != -1 && params_fun.num_of_bins != params_fun.none)
	    transl = pcap_fun.replace("Number of bins in the hiistogram", params_fun.num_of_bins.toString());
	else if (aret_fun.caption.indexOf("Coincidence rank") != -1 && params_fun.rank != params_fun.none)
	    transl = pcap_fun.replace("Coincidence rank", params_fun.rank.toString());
	else if (aret_fun.caption.indexOf("Comments") != -1 && params_fun.comments != params_fun.none)
	    transl = pcap_fun.replace("Comments", params_fun.comments.toString());
	else if (aret_fun.caption.indexOf("Minimum of the histogram") != -1 && params_fun.min_of_hist != params_fun.none)
	    transl = pcap_fun.replace("Minimum of the histogram", params_fun.min_of_hist.toString());
	else if (aret_fun.caption.indexOf("Maximum of the histogram") != -1 && params_fun.max_of_hist != params_fun.none)
	    transl = pcap_fun.replace("Maximum of the histogram", params_fun.max_of_hist.toString());
	else if (aret_fun.caption.indexOf("Log scale") != -1 && params_fun.log_scale != params_fun.none)
	    transl = pcap_fun.replace("Log scale", params_fun.log_scale.toString());
    }
    //alert(transl);
    //$('#errordiv').append(transl + '<br>');
    return transl;

} // Translate_par()

//function my_cookieson()
//{
//    var cookieEnabled = (navigator.cookieEnabled) ? true : false;
//    if (typeof navigator.cookieEnabled == "undefined" && !cookieEnabled)
//    {
//	document.cookie = "testcookie";
//	cookieEnabled = (document.cookie.indexOf("testcookie") != -1) ? true : false;
//    }
//    return cookieEnabled;
//}
//
function my_setcookie(sName, value, expires, path, domain, secure)
{
    document.cookie = cookie_prefix + sName + "=" + escape(value) +
	    ((expires) ? "; expires=" + expires.toGMTString() : "") +
	    ((path) ? "; path=" + path : "") +
	    ((domain) ? "; domain=" + domain : "") +
	    ((secure) ? "; secure=" + secure : "");
}
//
//function my_delcookie(sName) {
//    document.cookie = cookie_prefix + sName + "=undefined; expires=Fri, 31 Dec 1999 23:59:59 GMT;";
//}
//
function my_getcookie(sName)
{
    var name = cookie_prefix + sName
    var aCookie = document.cookie.split("; ");
    for (var i = 0; i < aCookie.length; i++)
    {
	var aCrumb = aCookie[i].split("=");
	if (name == aCrumb[0])
	    return unescape(aCrumb[1]);
    }
    return null;
}
////context:
var context = new Object();
//context.uuid = my_getcookie("uuid");
//if (!context.uuid)
//    context.uuid = 0;
//context.user = my_getcookie("user");
//if (!context.user)
//    context.user = "anonymous";
//context.utype = my_getcookie("utype");
//if (!context.utype) {
//    context.utype = "visitor";
//    my_setcookie("utype", context.utype, exp_year, "/", domain);
//}
//context.visits = my_getcookie("visits");
//if (!context.visits)
//    context.visits = -1;//undefined
//context.jobs = my_getcookie("jobs");
//if (!context.jobs)
//    context.jobs = 0;//undefined - 20.04.2011 13:38:54
//
context.lang = my_getcookie("lang");
if (!context.lang) context.lang = "en";
//context.langs = new Array("en", "ru", "cz", "bg"); //actually this is the list we support, but not a lang. code (see ISO 639-2 http://www.w3.org/WAI/ER/IG/ert/iso639.htm)
//if (!context.lang) 	//if cookie is not set - try to define a user language
//{
//    var found = false;
//    var userlang = navigator.userLanguage ? navigator.userLanguage : navigator.language;
//    context.lang = "en";
//    for (m = 0; m < context.langs.length; m++) {
//	if (userlang.substr(0, 2) == context.langs[m]) {
//	    context.lang = context.langs[m];
//	    found = true;
//	    break;
//	}
//    }
//    if (!found)
//	alert("Sorry, your native language is not currently supported. Select from the list of available languages or e-mail us for support");
//    my_setcookie("lang", context.lang, exp_year, "/");
//}
////</COOKIES>
//
////<DEBUG>
//context.lang = 'ru';
////</DEBUG>
//
////<MISC>
//function ChangeLang(new_lang) {
//    context.lang = new_lang;
//    my_setcookie("lang", context.lang, exp_year, "/");
//    window.location.reload(true);
//}
//</MISC>

//ELKIN-DEBUG B
//function PopulateParams(allFields)
//{
//    var op = $('#newrec').val();
//    
//    //var sh = (op==0) ? "jobpars.php" : "taskpars.php";
//    var sh = "taskpars.php"; // TMP
//    $.post(sh,allFields,function(data){
//        //aret = eval(data);
//  //alert("Data Loaded: " + aret.lenght);
//  $.html(data);
//});
//}
//ELKIN-DEBUG B
//eof common.js