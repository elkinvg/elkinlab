//common.js

//<COOKIES>
var cookie_prefix="livni_"; //see config.inc.php
var domain=".eas.jinr.ru"; //need for common usage with Joomla domain cookie settings

var today = new Date();
var date_from = new Date(2009,5-1,7);//the date of data accumulation start (month -> 0..11
var jobs_from = new Date(2010,2-1,4);//1st job
var meteo_from = new Date(2010,9-1,14);//the date of data accumulation start (month -> 0..11
var exp_min = new Date(today.getTime() +1*60*1000);	
var exp_day = new Date(today.getTime() +24*60*60*1000);	
var exp_year = new Date(today.getTime() +365*24*60*60*1000);	

function my_cookieson()
{
  var cookieEnabled=(navigator.cookieEnabled)? true : false;
  if (typeof navigator.cookieEnabled=="undefined" && !cookieEnabled)
  { 
    document.cookie="testcookie";
    cookieEnabled=(document.cookie.indexOf("testcookie")!=-1)? true : false;
  }
  return cookieEnabled;
}

function my_setcookie(sName, value, expires, path, domain, secure)
{
  document.cookie = cookie_prefix + sName + "=" + escape(value) + 
  ((expires) ? "; expires=" + expires.toGMTString() : "") +
  ((path) ? "; path=" + path : "") +
  ((domain) ? "; domain=" + domain : "") +
  ((secure) ? "; secure=" + secure : "");  
}

function my_delcookie(sName) {document.cookie = cookie_prefix + sName + "=undefined; expires=Fri, 31 Dec 1999 23:59:59 GMT;";}

function my_getcookie(sName) 
{  
  var name=cookie_prefix + sName
  var aCookie = document.cookie.split("; ");
  for (var i=0; i < aCookie.length; i++)
  {   
    var aCrumb = aCookie[i].split("=");
    if (name == aCrumb[0]) return unescape(aCrumb[1]);
  }
  return null;
}
//context:
var context = new Object();
context.uuid=my_getcookie("uuid"); if (!context.uuid) context.uuid=0;
context.user=my_getcookie("user"); if (!context.user) context.user="anonymous";
context.utype=my_getcookie("utype"); if (!context.utype) {context.utype="visitor"; my_setcookie("utype",context.utype,exp_year,"/",domain);}
context.visits=my_getcookie("visits"); if (!context.visits) context.visits=-1;//undefined
context.jobs=my_getcookie("jobs"); if (!context.jobs) context.jobs=0;//undefined - 20.04.2011 13:38:54

context.lang=my_getcookie("lang"); 
context.langs=new Array("en", "ru","cz","bg"); //actually this is the list we support, but not a lang. code (see ISO 639-2 http://www.w3.org/WAI/ER/IG/ert/iso639.htm)
if (!context.lang) 	//if cookie is not set - try to define a user language
{   
   var found=false;
   var userlang=navigator.userLanguage?navigator.userLanguage:navigator.language;
	context.lang="en"; 
   for (m=0; m< context.langs.length; m++)   {if (userlang.substr(0,2)==context.langs[m]) {context.lang=context.langs[m];  found=true; break;}}		
   if (!found) alert("Sorry, your native language is not currently supported. Select from the list of available languages or e-mail us for support");
	my_setcookie("lang",context.lang,exp_year,"/");
}
//</COOKIES>

//<DEBUG>
context.lang='ru';
//</DEBUG>

//<MISC>
function ChangeLang(new_lang) {context.lang=new_lang;   my_setcookie("lang",context.lang,exp_year,"/"); window.location.reload(true); }
//</MISC>

//eof common.js