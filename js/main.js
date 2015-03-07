//main.js

 $(function(){

$(document).tooltip({track: true});
$(document).tooltip("widget").css("font-size","0.7em");

$("#dlgm").dialog({modal: true,autoOpen: false,buttons: {Ok: function() {$(this).dialog('close');}}});
function displayMessage(t,msg){$('#dlgm').dialog({ title: t }); $('#dlgm').text(msg); $('#dlgm').dialog('open');}

$(".tt_switch").click(function(){
 var help_status = $(this).attr("status");
 var new_t, new_tt;
 if (help_status==1) 
 {
   new_t ="help on";
   new_tt="Switch help on";
   $(document).tooltip({disabled:true});
   help_status=0; 
 }
 else 
 {
  new_t = "help off";
  new_tt= "Switch help off";
  $(document).tooltip("enable");
  help_status=1;   
 }
 $(this).attr("status",help_status);
 $(this).attr("title",new_tt);
 $(this).html(new_t); 
});

// ELKIN-DEBUG B
$(".tt_switch_debug").click(function(){
 var debug_status = $(this).attr("status");
 var new_t, new_tt;
 if (debug_status>0) 
 {
   new_t ="debug on";
   new_tt="Switch debug on";
   my_setcookie("debug",0,exp_day,"/");
//   $(document).tooltip({disabled:true});
   debug_status=0; 
 }
 else 
 {
  new_t = "debug off";
  new_tt= "Switch debug off";
//  $(document).tooltip("enable");
  my_setcookie("debug",1,exp_day,"/");
  debug_status=1;   
 }
 $(this).attr("status",debug_status);
 $(this).attr("title",new_tt);
 $(this).html(new_t); 
});
// ELKIN-DEBUG E

function LoadBriefDescr()
{
   $("#jobs_brief_descr").load("lang/"+context.lang+"/jobs_brief_descr.html",function(){$(this).css({"font-size": "16px","padding":"30px"});});
   //$("#journal_brief_descr").load("lang/"+context.lang+"/journal_brief_descr.html",function(){$(this).css({"font-size": "16px","padding":"30px"});});
   $("#tasks_brief_descr").load("lang/"+context.lang+"/tasks_brief_descr.html",function(){$(this).css({"font-size": "16px","padding":"30px"});});
   //$("#statistics_brief_descr").load("lang/"+context.lang+"/statistics_brief_descr.html",function(){$(this).css({"font-size": "16px","padding":"30px"});});
   $("#newjob_brief_descr").load("lang/"+context.lang+"/newjob_brief_descr.html",function(){$(this).css({"font-size": "16px","padding":"30px"});});
   $("#examplejob_brief_descr").load("lang/"+context.lang+"/examlejob_brief_descr.html",function(){$(this).css({"font-size": "16px","padding":"30px"});});
   $("#sharedjob_brief_descr").load("lang/"+context.lang+"/sharedjob_brief_descr.html",function(){$(this).css({"font-size": "16px","padding":"30px"});});
}


//init page:

LoadBriefDescr();

});