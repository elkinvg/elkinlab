//jobs_list.js

 $(function(){

var astat = new Array("???",'pending','running','completed','failed');

$(".btn").button();
$(".btn").css("font-size","0.7em");

$(".radiosel").buttonset();
 
$("input").css("font-size","0.7em");
$("input").css("text-align","center");
$("select").css("font-size","0.7em");


var today = new Date();
var tfrom = new Date();  tfrom.setTime(today.getTime()-7*24*3600*1000);  //-1W
var tupto = new Date();

$("#filter_from").datepicker({changeMonth: true,changeYear: true, minDate: jobs_from, maxDate: today, defaultDate: tfrom});  
$("#filter_upto").datepicker({changeMonth: true,changeYear: true, minDate: jobs_from, maxDate: today, defaultDate: tupto});  
$("#filter_from").datepicker("setDate",tfrom);
$("#filter_upto").datepicker("setDate",tupto);
$("#filter_from").datepicker("widget").css("font-size","0.7em");
$("#filter_upto").datepicker("widget").css("font-size","0.7em");

$(document).tooltip({track: true});
$(document).tooltip("widget").css("font-size","0.7em");

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

// picture for a tooltip:
/*
 $( document ).tooltip(
 {
   items: "[title]",
   content: function() 
   {
     var element = $(this); 
     if (element.is("[title]")) 
     {
       return "<div>Go to project home<br><img src='http://livni.jinr.ru/skin/shower1.gif'></div>";
     }
   }
 });
*/
function Hide_1()
{
 $(".param_info").hide();
 $(".job_info").hide(); 
 $("#delete").hide();
 $("#createnew").hide();
 $("#start").hide();
}

function PopulateTaskType()
{
	$.post("php/liv3tasks.php", {oper:"list"}, function(data) 
	{
    if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
    else
    { 
	    var html ="<option value=0>Task type filter</option>";
      for(n=0; n < data.val.length; n++)
      {
	       html +="<option class=sel_task value="+data.val[n].task_id+" description_en='"+data.val[n].description_en+"' remark_en='"+data.val[n].remark_en+"'>"+data.val[n].caption+"</option>";
      }
	    $('#tasktype').html(html);
    }
  },"json");
}

$("#createnew").click(function()
{
  var task_id = $(this).attr("task_id");
  paramsTable(task_id);
});

function paramsTable(task_id)
{
    $(".param_info").show();
    $("#createnew").show();  $("#createnew").attr("task_id",task_id);
    $("#start").show();
	  $.post("php/liv3tasks.php", {oper:"params",task_id:task_id}, function(data) 
	  {		
      if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
      else
      { 
        var html="", stypes=new Array("numeric", "string","date time"), ph="???", tt="", def="", ntype;
        html+="<table style='border-collapse: collapse' width=100%>";
        html+="<tr class='ui-widget-header info' width=100%><td>parameter</td><td align=right>your value</td></tr>";
        for(n=0; n < data.val.length; n++)
        {
          ntype=parseInt(data.val[n].type);
          if (ntype==0) //numeric
          {
            ph=stypes[ntype];
            tt="Range: "+data.val[n].min_val+" ... "+data.val[n].max_val;
            def=data.val[n].def_val;
          }
          else if (ntype==1) // string
          {              
            ph=stypes[ntype];
            tt="personal hint, note";
            def="";
          }
          else if (ntype == 2) //data time
          {
            ph="YYYY-MM-DD HH:SS";
            //TO DO: take from common.js later
            //var date_from = new Date(2009,5-1,7);//the date of data accumulation start (month -> 0..11
            tt="Range: 2009-05-07 18:00 ... now, format: YYYY-MM-DD HH:MM";
            def="";
          }
          else //error
          {
            tt="Some error in a task";
            ph ="???";
            def="";
          }
          html+="<tr class='info'>";
          html+="<td width=50%>"+data.val[n].caption+"</td>";
          html+="<td width=50% align=right><input size=30 class=param placeholder='"+ph+"' id='"+data.val[n].name+"' min_val="+data.val[n].min_val+"  max_val="+data.val[n].max_val+" value='"+def+"' ntype="+ntype+" caption='"+data.val[n].caption+"' title='"+tt+"'></td>";
          html+="</tr>";
        }
        html+="</table>";
        $(".parameters").html(html);
      }
    },"json");
}

function paramsInfo(job_id)
{
	$.post("php/liv3jobs.php", {oper:"params",job_id:job_id}, function(data) 
	{		
    if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
    else
    { 
      var par_name, par_val;
      for (n=0; n < data.val.length; n++)
      {
        par_name=data.val[n].name;
        par_val=data.val[n].def_val;
        $("#"+par_name).val(par_val);        
      }
    }
  },"json");
}

$('#tasktype').change(function() 
{

  var task_id =$(this).val();  
  $(".parameters").html("");
  if (task_id >0) paramsTable(task_id);  
  else Hide_1();
});

function PopulateJobInfo(job_id, task_name)
{
	$.post("php/liv3jobs.php", {oper:"job",job_id:job_id}, function(data) 
	{
     if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
     else
     { 	 
       var cuuid=data.val.user_id;
       if (data.val.job_status > 4) data.val.job_status=0;
       var stat = astat[data.val.job_status];
       if (data.val.job_status == 3) stat +=" in "+ data.val.sec +" sec.";
	     //attributes
	     var html= "<div class='info'>Task name: "+task_name+"</div>";
	     html+="<div class='info'>Job ID:"+job_id+"  Comment: "+data.val.def_val+" By: "+data.val.first_name+" "+data.val.last_name+"</div>";
	     html+="<div class='info'>Started: "+data.val.started+" Status: "+stat+"</div>";  
       $('.job_info_attrt').html(html);
       
        //output
        html="";
        //as report = stderr+stdout+figures - no need any more to show it
        //if (job_id > 12614) //error in report_<job_id>.html was fixed by Alex Zhemchugoff
        //    html+="<div id='report' class='btn nobr' title='View the selected job compound report'>Report</div>";
        
        for (n=0; n < data.val.figures.length; n++)
        {
          html+="<div id='fig"+(n+1)+"' pic='"+data.val.figures[n]+"' class='btn nobr' title='View report fig."+(n+1)+"'>"+(n+1)+"</div>";
        }
        html+="<div id='stdout' class='btn nobr' title='View the stdout file'>stdout</div>";
        html+="<div id='stderr' class='btn nobr' title='View the errors log file'>stderr</div>";
        $('.job_info_output').html(html);
        $(".btn").button();
        $(".btn").css("font-size","0.7em");
       
        var job_path="http://livni.jinr.ru/users/"+cuuid+"/jobs/"+job_id;

        $(("div[id^='fig']")).click(function()
        {
          var html="<img src='"+job_path+"/"+$(this).attr('pic')+"'>";
          $('.pview').html(html);
        }); 

        //$("#report").click(function() {$('.pview').html(data.val.report);});
        $("#stdout").click(function() {$('.pview').html(data.val.stdout);});
        $("#stderr").click(function() {$('.pview').html(data.val.stderr);});
     }
  },"json"); //post
}

function getTaskName(task_id)
{  
  var task_name="task type id="+task_id;
  $(".sel_task").each(function( index ) 
  {
    if ($(this).val()==task_id) {task_name = $(this).text(); return false;}
  });
  return task_name;
}

$('#refresh').click(function()
{
  var from = $("#filter_from").datepicker("getDate"); if (from==null) {displayMessage("Error","Date from - not selected"); $("#filter_from").addClass('ui-state-error'); return;} else $("#filter_from").removeClass('ui-state-error');
  var upto = $("#filter_upto").datepicker("getDate"); if (upto==null) {displayMessage("Error","Date upto - not selected"); $("#filter_from").addClass('ui-state-error'); return;} else $("#filter_upto").removeClass('ui-state-error');

  var filter = new Object();
  filter.owner=$("input[id*='fi']:checked").val(); //{all,users,expert,own,illustr,person,jobid}
  filter.task_id = $('#tasktype').val();
  filter.from = from.getTime()/1000;
  filter.upto = upto.getTime()/1000 + 86400 - 1;
  if (filter.from >= filter.upto) {displayMessage("Error","Date from >= date upto"); return;}
  filter.person=$("#person").val();
  filter.jobid=$("#jobid").val();
  if (filter.owner==5) { if (filter.person.length==0) {displayMessage("Error","Person last name should be specified for this filter"); return;}}
  if (filter.owner==6) { if (filter.jobid.length==0) {displayMessage("Error","Job ID should be specified  for this filter"); return;}}  
  
	$.post("php/liv3jobs.php", {oper:"list",filter:filter}, function(data) 
	{
      if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
      else
      { 
        var cb,cbattr, uattr,status_class,task_type;
        var html="<table style='border-collapse: collapse' width=100%>";
        html+="<tr class='ui-widget-header'><td width=4%>ID</td><td width=4%><nobr><input type=checkbox id=cball value=0 title='Mark/unmark all' class=nobr><a href='#' id=invert title='Invert marks'>~</a></nobr></td><td width=30%>Comment</td><td width=40%>[Task Name]</td><td width=2%>[&#9733;]<nobr></td><td width=20%>[User]</td></tr>";
        for (n=0; n < data.val.length-1; n++)
       {
        
         if (data.val[n].job_status > 4) data.val[n].job_status=0;
         status_class=astat[data.val[n].job_status];           
         task_type=getTaskName(data.val[n].task_id);
         cbattr = (context.uuid==data.val[n].uuid || context.utype=="admin") ? "" : " disabled";//if this job owner or admin
         uattr="?";
         if (data.val[n].utype==1) uattr="<span class=newbie>&#9733;</span>"
         else if (data.val[n].utype==2) uattr="<span class=expert>&#9733;&#9733;</span>"
         else if (data.val[n].utype==8) uattr="<span class=admin>&#9733;&#9733;&#9733;</span>"
         html+="<tr class='info list_row' task_id="+data.val[n].task_id+" id="+data.val[n].job_id+" person="+data.val[n].last_name+"><td>"+data.val[n].job_id+"</td><td><input type=checkbox "+cbattr+" class=jobmark job_id="+data.val[n].job_id+"><span class='"+status_class+"'>&#9679;</span></td><td>"+data.val[n].def_val+"</td><td>"+task_type+"</td><td>"+uattr+"</td><td>"+data.val[n].first_name+" "+data.val[n].last_name+"</td></tr>";
       }
       html+="<table>"; 
       $('.pview').html(html);

       $('.pending').css("color","white"); 
       $('.running').css("color","cyan");
       $('.completed').css("color","green");
       $('.failed').css("color","red");

       $('.newbie').css("color","orange"); 
       $('.expert').css("color","brown");
       $('.admin').css("color","red");

       $('.list_row').hover(function()  {$(this).addClass("ui-state-highlight"); $(this).css("cursor","pointer");}, function () {$(this).removeClass("ui-state-highlight"); $(this).css("cursor","arrow");});

       $("#cball").click(function()
       {
         $("#delete").show();
         var state = $(this).is(':checked')==true;
         $(".jobmark").each(function(index) {if ($(this).prop('disabled')==false) $(this).get(0).checked=state;});
       });
       $("#invert").click(function()
       {
         $("#delete").show();
         $(".jobmark").each(function(index) {if ($(this).prop('disabled')==false) $(this).get(0).checked = !($(this).get(0).checked);});
       });
       
       $('.list_row').click(function()  
       {
         var task_id = $(this).attr("task_id");
         var job_id=$(this).attr("id");
         var task_name=getTaskName(task_id);
         $("#person").val($(this).attr("person"));
         $("#jobid").val(job_id);
         $("#delete").show();
         $(".param_info").show();
         $(".job_info").show();
         paramsTable(task_id);
         PopulateJobInfo(job_id,task_name);
         paramsInfo(job_id);
       });

       Hide_1();
      }
  },"json"); //post
}); //click

$("#delete").on("click", function(event)
{
  var adeljobs = new Array();
  $(".jobmark").each(function(index) {if ($(this).get(0).checked==true) adeljobs.push($(this).attr("job_id"));});  
	$.post("php/liv3jobs.php", {oper:"delete",adeljobs:adeljobs}, function(data) 
	{		
    if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
    else {$(".jobmark").each(function(index) {if ($(this).get(0).checked==true) $(this).parent().parent().remove();});}
  },"json");  
});


$("#start").on("click",function(event)
{
  var task_id=$("#createnew").attr("task_id");  
  var aparams = {};
  var ok=true;
  $(".param").each(function( index ) 
  {
    aparams[index]=new Object();
    aparams[index].value=$(this).val();
    aparams[index].min=$(this).attr("min_val");
    aparams[index].max=$(this).attr("max_val");
    aparams[index].name=$(this).attr("id");
    aparams[index].caption=$(this).attr("caption");
    aparams[index].type=$(this).attr("ntype");
    if (aparams[index].type==0) //numeric, boolean
    {
      ok&=checkVal($(this),aparams[index].min,aparams[index].max);
    }
    else if (aparams[index].type==1) //string
    {
      ok&=checkLen($(this),3,32);
    }
    else if (aparams[index].type==2) //date, time
    {
      ok&=checkLen($(this),10,16);
    }    
  });
  if (!ok) {displayMessage("Error","Some of parameters don't fit the requirements"); return;}
  
	$.post("php/liv3jobs.php", {oper:"start",task_id:task_id,aparams:aparams}, function(data) 
	{		
    if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
    else 
    {
      $('#refresh').click();
    }
  },"json");  

});

//init page:
PopulateTaskType();
Hide_1();
$('#refresh').click();

});