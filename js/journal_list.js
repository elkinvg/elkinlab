//jobs_tasks.js

 $(function(){

$(".btn").button();
$(".btn").css("font-size","0.7em");

$(".radiosel").buttonset();
 
$("input").css("font-size","0.7em");
$("input").css("text-align","center");
$("select").css("font-size","0.7em");

$(document).tooltip({track: true});
$(document).tooltip("widget").css("font-size","0.7em");

var today = new Date();
var tfrom = new Date();  tfrom.setTime(today.getTime()-120*24*3600*1000);  //-4M
var tupto = new Date();

$("#filter_from").datepicker({changeMonth: true,changeYear: true, minDate: jobs_from, maxDate: today, defaultDate: tfrom});  
$("#filter_upto").datepicker({changeMonth: true,changeYear: true, minDate: jobs_from, maxDate: today, defaultDate: tupto});  
$("#filter_from").datepicker("setDate",tfrom);
$("#filter_upto").datepicker("setDate",tupto);
$("#filter_from").datepicker("widget").css("font-size","0.7em");
$("#filter_upto").datepicker("widget").css("font-size","0.7em");

$("#dlgm").dialog({modal: true,autoOpen: false,buttons: {Ok: function() {$(this).dialog('close');}}});
function displayMessage(t,msg){$('#dlgm').dialog({ title: t }); $('#dlgm').text(msg); $('#dlgm').dialog('open');}
function checkLen(o,min,max){if ( o.val().length > max || o.val().length < min ) {o.addClass('ui-state-error'); setTimeout(function() {o.removeClass('ui-state-error', 1500);}, 500);return false;} return true;}
function checkVal(o,min,max){var v=parseInt(o.val()),m=parseInt(min),M=parseInt(max); if (v > M || v < m) {o.addClass('ui-state-error'); setTimeout(function() {o.removeClass('ui-state-error', 1500);}, 500);return false;} return true;}

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

function Hide_1()
{
 $("#delete").hide();
 $("#save").hide();
}

function populateStatus(station,sel)
{
  var s="";
  var html="<select class=status id=status"+station+">";  
  s = (sel==1)?"selected":"";
  html+="<option "+s+" value=1>ok</option>";
  s = (sel==2)?"selected":"";
  html+="<option "+s+" value=2>special</option>";
  s = (sel==3)?"selected":"";
  html+="<option "+s+" value=3>undefined</option>";
  s = (sel==4)?"selected":"";
  html+="<option "+s+" value=4>inactive</option>";
  html+="</select>";
  return html;
}

function PopulateRecord(recid)  //0 - new
{
    $("#createnew").show();  
    $("#createnew").attr("recid",recid);
    $("#createnew").attr("action","save");
    if (recid > 0) 
    {
      $("#createnew").attr("title","Save as a new record");
      $("#save").show();
    }
    else $("#createnew").attr("title","Create a record");
      
	  $.post("php/liv3journal.php", {oper:"load",recid:recid}, function(data) 
	  {		
      if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
      else
      { 
        var status,lnp,html="<table style='border-collapse: collapse' width=100%>";
        html+="<tr><td align=center colspan=3 class='ui-widget-header'>Logbook Record</td></tr>";        
        html+="<tr class='ui-widget-header info' width=100%><td width=5%>LNP</td><td width=50%>description</td><td align=right width=45%>station status</td></tr>";
        
        var sel="";        
        for(station=1; station <= STATIONS_NUMBER; station++)
        {          
          status=data.val["status"+station];
          lnp=data.val["lnp"+station];
          if (status==3) lnp="undefined";
          else if (status==4) lnp="inactive";
          html+="<tr class='info recpar' station="+station+">";
          html+="<td>"+station+"</td>";
          html+="<td><input size 10 class=lnp id=lnp"+station+" value='"+lnp+"'></td>";
          sel = populateStatus(station,status);
          html+="<td>"+sel+"</td>";
          html+="</tr>";
        }
        html+="<tr class='info'><td colspan=3>comment:</td></tr>";
        html+="<tr class='info'><td colspan=3><textarea maxlength=255 cols=45 id=comment>"+data.val["comment"]+"</textarea></td></tr>";
        html+="</table>";
        $(".record").html(html);                                
      }
    },"json");
}

$('#refresh').click(function()
{
  var from = $("#filter_from").datepicker("getDate"); if (from==null) {displayMessage("Error","Date from - not selected"); $("#filter_from").addClass('ui-state-error'); return;} else $("#filter_from").removeClass('ui-state-error');
  var upto = $("#filter_upto").datepicker("getDate"); if (upto==null) {displayMessage("Error","Date upto - not selected"); $("#filter_from").addClass('ui-state-error'); return;} else $("#filter_upto").removeClass('ui-state-error');

  var fr = from.getTime()/1000;
  var to = upto.getTime()/1000 + 86400 - 1;
  if (fr >= to) {displayMessage("Error","Date from >= date upto"); return;}

  $.post("php/liv3journal.php", {oper:"list",from:fr,upto:to}, function(data) 
	{
      if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
      else
      { 
        var html="<table style='border-collapse: collapse' width=100%>";
        var status; var lnp;
        aclr=new Array("black","green","blue","magenta","red");

        //header
        html+="<tr class='ui-widget-header'>";
        html+="<td width=3%><nobr><input type=checkbox id=cball value=0 title='Mark/unmark all' class=nobr><a href='#' id=invert title='Invert marks'>~</a></nobr></td>";
        html+="<td width=7%>Date</td>";
        for (station=1; station <=STATIONS_NUMBER; station++) html+="<td width=8%>LNP"+station+"</td>";
        html+="<td>Comment</td>";
        html+="</tr>";
        //body
        for (n=0; n < data.val.length; n++)
       {                 
         html+="<tr class='info list_row' recid="+data.val[n].recid+" id="+data.val[n].recid+">";
         html+="<td><input type=checkbox class=recordmark recid="+data.val[n].recid+"></td>";
         html+="<td>"+data.val[n].timestamp.substr(0,10)+"</td>";
         for (station=1; station <=STATIONS_NUMBER; station++)
         {
           status=data.val[n]["status"+station];
           lnp=data.val[n]["lnp"+station];
           if (status==3) lnp="undefined";
           else if (status==4) lnp="inactive";
           
           html+="<td><font color="+aclr[status]+">"+lnp+"</td>";
         }
         html+="<td>"+data.val[n].comment+"</td>";
         html+="</tr>";
       }
       html+="<table>";        
       $('.jview').html(html);
       $('.record').html("");
       $("#createnew").attr("recid",0);
       $("#createnew").attr("action","clear");
       
        $('.list_row').hover(function()  {$(this).addClass("ui-state-highlight"); $(this).css("cursor","pointer");}, function () {$(this).removeClass("ui-state-highlight"); $(this).css("cursor","arrow");});

       $("#cball").click(function()
       {
         $("#delete").show();
         var state = $(this).is(':checked')==true;
         $(".recordmark").each(function(index) {if ($(this).prop('disabled')==false) $(this).get(0).checked=state;});
       });
       $("#invert").click(function()
       {
         $("#delete").show();
         $(".recordmark").each(function(index) {if ($(this).prop('disabled')==false) $(this).get(0).checked = !($(this).get(0).checked);});
       });
       
       $('.list_row').click(function()  
       {
          var recid=$(this).attr("recid");
          $("#delete").show();
          PopulateRecord(recid);
       });

       Hide_1();
      }
  },"json"); //post
  
}); //click


$("#delete").on("click", function(event)
{
  var adelrecords = new Array();
  $(".recordmark").each(function(index) {if ($(this).get(0).checked==true) {adelrecords.push($(this).attr("recid"));}});  
	$.post("php/liv3journal.php", {oper:"delete",adelrecords:adelrecords}, function(data) 
	{		
    if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
    else $('#refresh').click();
  },"json");  
});

$("#createnew").click(function()
{
  var recid = $(this).attr("recid");
  var action = $(this).attr("action");
  if (action=="clear")
  {
    PopulateRecord(recid);
  }
  else
  {  
    $("#createnew").attr("recid",0);
    $("#save").click();
  }
});

$("#save").on("click",function(event)
{
  var recid=$("#createnew").attr("recid");  
  var aparams = {};
  var ok=true;
  var o;
  $(".recpar").each(function(index) 
  {
    aparams[index]=new Object();
    aparams[index].station = $(this).attr("station");    
    o = $(this).find(".lnp");    aparams[index].lnp = o.val();     ok&=checkLen(o,5,40);
    o = $(this).find(".status"); aparams[index].status = o.val();  
  });
 // o=$("#comment"); ok&=checkLen(o,5,255);
  var comment=$("#comment").val();
  if (!ok) {displayMessage("Error","Some of parameters don't fit the requirements"); return;}
  
	$.post("php/liv3journal.php", {oper:"save",recid:recid,aparams:aparams,comment:comment}, function(data) 
	{		
    if (data.err_no)
    {
      tit = "Error ("+data.err_no+")"; 
      displayMessage(tit,data.result);
      $('#refresh').click(); //debugg
    }
    else 
    {
      $('#refresh').click();
    }
  },"json");  

});

//init page:
Hide_1();
$('#refresh').click();

});