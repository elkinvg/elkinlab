<?php
//journal_list.php

function pHeader()
{
  global $proj_home, $sweet_home, $dic;
  echo "<tr><td colspan=2 class='ui-widget-header ui-corner-top pheader' align=left>";
    echo "<span class=logo><a href='$proj_home' title='$dic[livni_logo_tt]' id='proj_home'>$dic[livni_logo]</a></span>"; //  : $dic[jobs_title]
    echo "<a href='$sweet_home' title='$dic[labs_logo_tt]' id='labs_home'><span class=logo_labs>$dic[labs_logo]</span></a>";
    echo "<span class=logo_labs>: $dic[statistics_title]</span>";
  echo  "</td></tr>";
}
function pFooter(){global $dic; echo "<tr><td class='ui-widget-content ui-corner-bottom pfooter' colspan=2 align=right><a href='#' class='tt_switch' status=1 title='$dic[help_off_title_tt]'>$dic[help_off_title]</a></td></tr>";}

function Control()
{
  echo "<td class='ui-widget-content jcontrol' align=center valign=top>";

  echo "<table width=100%>";  
    echo "<tr><td align=left><div id='refresh' class='btn' title='Refresh the statistics page'>Refresh</div></td></tr>";    //BUTTONS:  refresh
     echo "<tr><td>&nbsp;</td></tr>";
    echo "<tr><td  class='ui-widget-content jview_misc' align=center valign=top></td></tr>";  //STATS:  misc
  echo "</table>";
  
  echo "</td>";
}

function View()
{
  echo "<td class='ui-widget-content jview' align=center valign=top>";

  echo "<table width=100%>";
     echo "<tr><td  class='jview_stations' align=center valign=top></td></tr>";  //STATS: stations
     echo "<tr><td>&nbsp;</td></tr>";  //STATS: stations
     echo "<tr><td  class='jview_status' align=center valign=top></td></tr>";    //STATS: tasks
  echo "</table>";  

  echo "</td>";
}

function Rendermain()
{
  echo "<table class='ui-widget main' width=100% height=100% border=0>";  
  pHeader();

  echo "<tr>";
  Control(); //refresh button and misc
  View();    // stations, tasks
  echo "</tr>";  

  pFooter();  
  echo "</table>";
}

?>