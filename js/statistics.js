//jobs_tasks.js

//TO DO: would be better to
//a)load dic here for common use OR
//b)prepare html on the server side

 $(function(){

$(".btn").button();
$(".btn").css("font-size","0.7em");

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

$('#refresh').click(function(){location.reload(true);});


function PopulateStations()
{  
	$.post("php/liv3stats.php", {oper:"stations"}, function(data) 
	{
    if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
    else
    { 
      var html="<table class='ui-widget-content' width=90%>";
     
     //title:
       html+="<tr class='ui-widget-content'><td colspan=4>"+data.val.dic.stations_title+" "+date_from.toUTCString().substr(4,12)+"</td></tr>";
       html+="<tr class='ui-widget-content'><td colspan=4>&nbsp;</td></tr>";
    
     //header:
      html+="<tr class='ui-widget-header  ui-corner-top'>";
        html+="<td width=10% title='"+data.val.dic.station_col_title_tt+"'>"+data.val.dic.station_col_title+"</td>";
        html+="<td  align=right title='"+data.val.dic.events_col_title_tt+"'>"+data.val.dic.events_col_title+"</td>";
        html+="<td align=right title='"+data.val.dic.time_col_title_tt+"'>"+data.val.dic.time_col_title+"</td>";
        html+="<td align=right title='"+data.val.dic.freq_col_title_tt+"'>"+data.val.dic.freq_col_title+"</td>";
        html+="<td align=right title='"+data.val.dic.files_col_title_tt+"'>"+data.val.dic.files_col_title+"</td>";
      html+="</tr>";
    //data: //   $val[0] = array('nevents' =>0, 'nfiles' => 0, 'timesec' => 0);
      for(station=1; station <= STATIONS_NUMBER; station++)
      {
        html+="<tr class='ui-widget-content'>";
          html+="<td>LNP"+station+"</td>";
          html+="<td align=right>"+data.val[station].nevents+"</td>";
          html+="<td align=right>"+data.val[station].timesec+"</td>";
          html+="<td align=right>"+(data.val[station].nevents/data.val[station].timesec).toFixed(3)+"</td>";
          html+="<td align=right>"+data.val[station].nfiles+"</td>";
        html+="</tr>";
      }
     //totals:
     station=0;
      html+="<tr class='ui-widget-header ui-corner-bot'>";
        html+="<td title='"+data.val.dic.total_col_title_tt+"'>"+data.val.dic.total_col_title+"</td>";
        html+="<td align=right>"+data.val[station].nevents+"</td>";
        html+="<td align=right>"+data.val[station].timesec+"</td>";
        html+="<td align=right>"+(data.val[station].nevents/data.val[station].timesec).toFixed(3)+"</td>";
        html+="<td align=right>"+data.val[station].nfiles+"</td>";
      html+="</tr>";
      
      html+="</table>";
      $(".jview_stations").html(html);    
   	}
  },"json");
}

//
//
//TO DO: for last 6 hours data - see 'mon_stat_graph.php'!!!
//
//

function PopulateStatus()
{
	$.post("php/liv3stats.php", {oper:"status"}, function(data) 
	{
    if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
    else
    {
      var alive,cl,s_status=""; 
      var html="<table class='ui-widget-content' width=90%>";
     
     //title:
       html+="<tr class='ui-widget-content'><td colspan=6>"+data.val.dic.stations_status_title+"</td></tr>";
       html+="<tr class='ui-widget-content'><td colspan=6>&nbsp;</td></tr>";
    
     //header:
      html+="<tr class='ui-widget-header  ui-corner-top'>";
        html+="<td title='"+data.val.dic.station_col_title_tt+"'>"+data.val.dic.station_col_title+"</td>";
        html+="<td align=center title='"+data.val.dic.status_title_tt+"'>"+data.val.dic.status_title+"</td>";
        html+="<td align=center title='"+data.val.dic.data_age_title_tt+"'>"+data.val.dic.data_age_title+"</td>";
        html+="<td align=center title='"+data.val.dic.latitude_title_tt+"'>"+data.val.dic.latitude_title+"</td>";
        html+="<td align=center title='"+data.val.dic.longitude_title_tt+"'>"+data.val.dic.longitude_title+"</td>";
        html+="<td align=center title='"+data.val.dic.altitude_title_tt+"'>"+data.val.dic.altitude_title+"</td>";
      html+="</tr>";
    //data:
      for(station=1; station <= STATIONS_NUMBER; station++)
      {
        alive=(data.val.status[station].ping+data.val.status[station].data)==0;
        cl = (alive) ? "st_ok" : "st_fail";
        s_status="";
        s_status +=(data.val.status[station].ping > 0)? "ping " : "";
        s_status +=(data.val.status[station].daq > 0)? "daq " : "";
        s_status +=(data.val.status[station].data > 0)? "data " : "";
        if (s_status.length==0) s_status="ok";
        html+="<tr class='ui-widget-content'>";
          html+="<td><span class='"+cl+"'>LNP"+station+"</span></td>";
          html+="<td align=center class='"+cl+"'>"+s_status+"</td>";
          html+="<td align=center>"+data.val.status[station].age+"</td>";
          html+="<td align=center>"+data.val.locations[station].lat+"</td>";
          html+="<td align=center>"+data.val.locations[station].lon+"</td>";
          html+="<td align=center>"+data.val.locations[station].alt+"</td>";
        html+="</tr>";
      }      
      html+="</table>";
     $(".jview_status").html(html);
   	}
  },"json");
}

function PopulateMisc()
{
	$.post("php/liv3stats.php", {oper:"misc"}, function(data) 
	{
    if (data.err_no){tit = "Error ("+data.err_no+")"; displayMessage(tit,data.result);}
    else
    { 
      var html="<table class='ui-widget-content' width=100%>";
      html+="<tr class='ui-widget-header'><td colspan=2 title='"+data.val.misc_title_tt+"'>"+data.val.misc_title+"</td></tr>";
         
      html+="<tr class='ui-widget-content'><td colspan=2>&nbsp;</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.reports_title_tt+"'>"+data.val.reports_title+"</td><td>"+data.val.reports+"</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.experts_tasks_title_tt+"'>"+data.val.experts_tasks_title+"</td><td>"+data.val.tasks+"</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.participants_title_tt+"'>"+data.val.participants_title+"</td><td>"+(parseInt(data.val.users)+parseInt(data.val.experts))+"</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.users_title_tt+"'>"+data.val.users_title+"</td><td>"+data.val.users+"</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.experts_title_tt+"'>"+data.val.experts_title+"</td><td>"+data.val.experts+"</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.active_title_tt+"'>"+data.val.active_title+"</td><td>"+data.val.active+"</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.daily_visits_title_tt+"'>"+data.val.daily_visits_title+"</td><td>"+data.val.visits+"</td></tr>";

      html+="<tr class='ui-widget-content'><td colspan=2>&nbsp;</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.jobs_tot_title_tt+"'>"+data.val.jobs_tot_title+"</td><td>"+(parseInt(data.val.jobs_users)+parseInt(data.val.jobs_experts))+"</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.jobs_users_title_tt+"'>"+data.val.jobs_users_title+"</td><td>"+data.val.jobs_users+"</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.jobs_experts_title_tt+"'>"+data.val.jobs_experts_title+"</td><td>"+data.val.jobs_experts+"</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.cpu_tot_title_tt+"'>"+data.val.cpu_tot_title+"</td><td>"+data.val.cpu_all+"</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.cpu_users_title_tt+"'>"+data.val.cpu_users_title+"</td><td>"+data.val.cpu_users+"</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.cpu_experts_title_tt+"'>"+data.val.cpu_experts_title+"</td><td>"+data.val.cpu_experts+"</td></tr>";

      html+="<tr class='ui-widget-content'><td colspan=2>&nbsp;</td></tr>";
      html+="<tr class='ui-widget-content'><td class='tabrow' title='"+data.val.meteo_since_title_tt+"'>"+data.val.meteo_since_title+"</td><td>"+meteo_from.toUTCString().substr(4,12)+"</td></tr>";
   
      html+="</table>";
      $(".jview_misc").html(html);  
   	}
  },"json");
}

//init page:

PopulateStations();
PopulateStatus();
PopulateMisc();

});