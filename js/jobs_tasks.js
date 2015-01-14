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

function PopulateTask(task_id)  //0 - new
{
    $("#createnew").show();  
    $("#createnew").attr("task_id",task_id);
    $("#createnew").attr("action","save");
    if (task_id > 0) 
    {
      $("#createnew").attr("title","Save as a new task");
      $("#save").show();
    }
    else $("#createnew").attr("title","Create a task");
      
	  $.post("php/liv3tasks.php", {oper:"load",task_id:task_id}, function(data) 
	  {		
      if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
      else
      { 
        var v,ph,tt,ro,html="<table style='border-collapse: collapse' width=100%>";
        html+="<tr><td align=center colspan=2 class='ui-widget-header'>Task specification</td></tr>";        
        html+="<tr class='ui-widget-header info' width=100%><td width=30%>parameter</td><td align=right width=70%>your value</td></tr>";
        for(n=0; n < data.val.length; n++)
        {
          ro=(n==0)? "readonly" : "";
          if (n==3) tt="from "+TASK_PARAMS_MIN+" to "+TASK_PARAMS_MAX;
          else if (n==4) tt="0 - task is OFF, 1 - task is ON";
          else if (n==6) tt="0 - newbie, 1 - advanced, 2 - expert";
          else tt="";
          
          if (task_id==0 && (n!=0) && (n!=3)){ph=data.val[n].value; v="";}
          else {v=data.val[n].value; ph="";}
          
          html+="<tr class='info'>";
          html+="<td>"+data.val[n].caption+"</td>";
          html+="<td align=right><input size=70 class=param id='"+data.val[n].name+"' value='"+v+"' "+ro+" title='"+tt+"' placeholder='"+ph+"'></td>";
          html+="</tr>";
        }
        html+="</table>";
        $(".main_descr").html(html);
                
        //parameters table:        
        html="<table style='border-collapse: collapse' width=100%>";
        html+="<tr><td align=center colspan=6 class='ui-widget-header'>Parameters specification and defaults</td></tr>";        
        html+="<tr class='ui-widget-header info' width=100%><td  width=25%>Caption</td><td width=25%>Actual Name</td><td width=5%>Type</td><td>Def.val</td><td>Min.val</td><td>Max.val</td></tr>";

        for(n=0; n < data.params.length; n++)
        {
          html+="<tr class='info taskpar' par_id="+data.params[n].par_id+">";
          html+="<td><input size=20 class=par_caption value='"+data.params[n].caption+"'></td>";
          html+="<td><input size=20 class=par_name    value='"+data.params[n].name+"'></td>";
          html+="<td><input size=5 class=par_type     value="+data.params[n].type+" title='0-numeric(int, float, bool), 1-string, 2-date (YYYY-MM-DD HH:MM)'></td>";
          html+="<td><input size=10 class=par_def_val value='"+data.params[n].def_val+"'></td>";
          html+="<td><input size=10 class=par_min_val value='"+data.params[n].min_val+"'></td>";
          html+="<td><input size=10 class=par_max_val value='"+data.params[n].max_val+"'></td>";
          html+="</tr>";
        }
        html+="</table>";
        $(".parameters_list").html(html);
        
        $("#par_number").change(function() 
        {
          var pn = $(this).val();
          if (pn < TASK_PARAMS_MIN || pn > TASK_PARAMS_MAX) return; //do nothing
          var partab=$(".taskpar");
          var parlen=partab.length;
          if (pn > parlen)
          {
            var par_id=parlen+1;
            for (n=0; n < pn - parlen; n++) 
            {
              html="";
              html+="<tr class='info taskpar' par_id="+par_id+">";
              html+="<td><input size=20 class=par_caption value='caption "+par_id+"'></td>";
              html+="<td><input size=20 class=par_name    value='PARAM_"+par_id+"'></td>";
              html+="<td><input size=5 class=par_type     value=0 title='0-numeric(int, float, bool), 1-string, 2-date (YYYY-MM-DD HH:MM)'></td>";
              html+="<td><input size=10 class=par_def_val value=0></td>";
              html+="<td><input size=10 class=par_min_val value=0></td>";
              html+="<td><input size=10 class=par_max_val value=1></td>";
              html+="</tr>";
              $(".taskpar").last().after(html);
              par_id++;
            }
          }
          else if (pn < parlen)
          {
            for (n=0; n < parlen - pn; n++) $(".taskpar").last().remove();
          }
        });        
        
      }
    },"json");
}

$('#refresh').click(function()
{
  $.post("php/liv3tasks.php", {oper:"listall"}, function(data) 
	{
      if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
      else
      { 
        var cbox;
        var html="<table style='border-collapse: collapse' width=100%>";
        html+="<tr class='ui-widget-header'>";
        html+="<td width=5%>ID</td>";
        html+="<td width=5%><nobr><input type=checkbox id=cball value=0 title='Mark/unmark all' class=nobr><a href='#' id=invert title='Invert marks'>~</a></nobr></td>";
        html+="<td width=40%>Task name</td>";
        html+="<td width=20%>Application</td>";
        html+="<td width=6% align=right>par</td>";
        html+="<td width=6% align=right>stat</td>";
        html+="<td width=6% align=right>pop</td>";
        html+="<td width=6% align=right>lev</td>";
        html+="<td width=6% align=right>seq</td>";
        html+="</tr>";
        for (n=0; n < data.val.length; n++)
       {        
         
         cbox=(data.val[n].popularity==0) ? "<input type=checkbox class=taskmark task_id="+data.val[n].task_id+">" : "";
         html+="<tr class='info list_row' task_id="+data.val[n].task_id+" id="+data.val[n].task_id+">";
         html+="<td>"+data.val[n].task_id+"</td>";
         html+="<td>"+cbox+"</td>";
         html+="<td>"+data.val[n].caption+"</td>";
         html+="<td>"+data.val[n].app_name+"</td>";
         html+="<td align=right>"+data.val[n].par_number+"</td>";
         html+="<td align=right>"+data.val[n].status+"</td>";
         html+="<td align=right>"+data.val[n].popularity+"</td>";
         html+="<td align=right>"+data.val[n].complexity+"</td>";
         html+="<td align=right>"+data.val[n].sequence+"</td>";
         html+="</tr>";
       }
       html+="<table>";        
       $('.pview').html(html);
       $('.main_descr').html("");
       $('.parameters_list').html("");
       $("#createnew").attr("task_id",0);
       $("#createnew").attr("action","clear");
       
        $('.list_row').hover(function()  {$(this).addClass("ui-state-highlight"); $(this).css("cursor","pointer");}, function () {$(this).removeClass("ui-state-highlight"); $(this).css("cursor","arrow");});

       $("#cball").click(function()
       {
         $("#delete").show();
         var state = $(this).is(':checked')==true;
         $(".taskmark").each(function(index) {if ($(this).prop('disabled')==false) $(this).get(0).checked=state;});
       });
       $("#invert").click(function()
       {
         $("#delete").show();
         $(".taskmark").each(function(index) {if ($(this).prop('disabled')==false) $(this).get(0).checked = !($(this).get(0).checked);});
       });
       
       $('.list_row').click(function()  
       {
          var task_id=$(this).attr("task_id");
          PopulateTask(task_id);
          //PopulateTaskParams();
          $("#delete").show();
       });

       Hide_1();
      }
  },"json"); //post
}); //click


$("#delete").on("click", function(event)
{
  var adeltasks = new Array();
  var popularity;
  $(".taskmark").each(function(index) {if ($(this).get(0).checked==true) {adeltasks.push($(this).attr("task_id"));}});  
	$.post("php/liv3tasks.php", {oper:"delete",adeltasks:adeltasks}, function(data) 
	{		
    if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
    else       
    {
      //$(".taskmark").each(function(index) {if ($(this).get(0).checked==true) $(this).parent().parent().remove();});
      $('#refresh').click(); //debugg
    }
  },"json");  
});

$("#createnew").click(function()
{
  var task_id = $(this).attr("task_id");
  var action = $(this).attr("action");
  if (action=="clear")
    PopulateTask(task_id);
  else
  {  
    $("#createnew").attr("task_id",0);
    $("#save").click();
  }
});

$("#save").on("click",function(event)
{
  var task_id=$("#createnew").attr("task_id");  
  var aparams = {};
  var atask = {};
  var ok=true;
  var o;

  //TASK specification
  $(".param").each(function( index ) 
  {
    atask[index]=new Object();
    atask[index].value=$(this).val();
    atask[index].name=$(this).attr("id");

    if (atask[index].name=='par_number') {ok&=checkVal($(this),TASK_PARAMS_MIN,TASK_PARAMS_MAX);}
    else if (atask[index].name=='status'){ok&=checkVal($(this),0,1);}
    else if (atask[index].name=='complexity'){ok&=checkVal($(this),0,2);}

    if (atask[index].name=='description_en') {ok&=checkLen($(this),5,256);}
    else if (atask[index].name=='remark_en') {ok&=checkLen($(this),5,256);}
    else if (atask[index].name=='description_ru') {ok&=checkLen($(this),5,256);}
    else if (atask[index].name=='remark_ru') {ok&=checkLen($(this),5,256);}
      
    else if (atask[index].name=='app_name') {ok&=checkLen($(this),5,64);}
    else if (atask[index].name=='caption') {ok&=checkLen($(this),5,64);}

  });
  $(".taskpar").each(function( index ) 
  {
    aparams[index]=new Object();
    aparams[index].par_id = $(this).attr("par_id");
    
    o = $(this).find(".par_caption"); 
    aparams[index].caption = o.val(); 
    ok&=checkLen(o,5,40);

    o = $(this).find(".par_name");
    aparams[index].name = o.val();
    ok&=checkLen(o,2,16); 
    
    o = $(this).find(".par_type");
    aparams[index].type = o.val();
    ok&=checkVal(o,0,2);
    
    if (aparams[index].type==0) //numeric
    {
      o = $(this).find(".par_def_val");
      aparams[index].def_val = o.val();
      ok&=checkLen(o,1,32);
    
      o = $(this).find(".par_min_val");
      aparams[index].min_val = o.val();
      ok&=checkLen(o,1,32);

      o = $(this).find(".par_max_val");
      aparams[index].max_val = o.val();
      ok&=checkLen(o,1,32);
    }    
  });
  
  if (!ok) {displayMessage("Error","Some of parameters don't fit the requirements"); return;}
  
	$.post("php/liv3tasks.php", {oper:"save",task_id:task_id,aparams:aparams, atask:atask}, function(data) 
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