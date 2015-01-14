<?php
//journal_list.php

function pHeader()
{
  global $proj_home, $sweet_home, $dic;
  echo "<tr><td colspan=2 class='ui-widget-header ui-corner-top pheader' align=left>";
    echo "<span class=logo><a href='$proj_home' title='$dic[livni_logo_tt]' id='proj_home'>$dic[livni_logo]</a></span>"; //  : $dic[jobs_title]
    echo "<a href='$sweet_home' title='$dic[labs_logo_tt]' id='labs_home'><span class=logo_labs>$dic[labs_logo]</span></a>";
    echo "<span class=logo_labs>: $dic[journal_title]</span>";
  echo  "</td></tr>";
}
function pFooter(){global $dic; echo "<tr><td class='ui-widget-content ui-corner-bottom pfooter' colspan=2 align=right><a href='#' class='tt_switch' status=1 title='$dic[help_off_title_tt]'>$dic[help_off_title]</a></td></tr>";}
function View(){echo "<td class='ui-widget-content jview' align=center valign=top>view journal records</td>";}

function Control()
{
  global $context;
  $allowed=($context['utype']="admin" || $context['utype']="expert");

  echo "<td class='ui-widget-content jcontrol' align=center valign=top>";

  echo "<table width=100%>";

  //BUTTONS: delete, refresh
  echo "<tr>";
  if ($allowed)
    echo "<td align=left><div id='delete' class='btn nobr' title='Delete selected records'>Delete</div></td>";
  else  
    echo "<td align=left>'view only' mode</td>";
  echo "<td align=right><div id='refresh' class='btn' title='View journal records'>Refresh</div></td>";
  echo "</tr>";

  //TIME SPAN
  echo "<tr>";
  echo "<td align=left><input id=filter_from type=text class='ui-widget-content ui-corner-all' title='filter: date from...'></td>";
  echo "<td align=right><input id=filter_upto type=text class='ui-widget-content ui-corner-all' title='filter: date upto...'></td>";
	echo "</tr>";
		
  //JOURNAL record: form table
  echo "<tr class=task_info><td colspan=2>";
	echo "<div class='ui-widget-content ui-corner-all record'></div>";
  echo "</td></tr>";
  
  //BUTTONS: create new, save changes
  if ($allowed)
  {  
    echo "<tr>";
    echo "<td align=right><div id='createnew' recid=0 class='btn nobr' action='clear' title='Create a new record'>Create new</div></td>";
    echo "<td align=left><div id='save' class='btn nobr' title='Save the record changes'>Save changes</div></td>";
    echo "</tr>";
  }

  echo "</table>";
  

  echo "</td>";
}

function Rendermain()
{
  echo "<table class='ui-widget main' width=100% height=100% border=0>";  
  pHeader();
  echo "<tr>";
  Control();
  View();
  echo "</tr>";  
  pFooter();  
  echo "</table>";
}

?>