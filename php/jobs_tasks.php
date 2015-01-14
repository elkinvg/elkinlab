<?php
//jobs_tasks.php

function pHeader()
{
  global $proj_home, $sweet_home,$dic;
  echo "<tr><td colspan=2 class='ui-widget-header ui-corner-top pheader' align=left>";
    echo "<span class=logo><a href='$proj_home' title='$dic[livni_logo_tt]' id='proj_home'>$dic[livni_logo]</a></span>"; //  : $dic[jobs_title]
    echo "<a href='$sweet_home' title='$dic[labs_logo_tt]' id='labs_home'><span class=logo_labs>$dic[labs_logo]</span></a>";
    echo "<span class=logo_labs>: $dic[tasks_title]</span>";
  echo  "</td></tr>";
}
function pFooter(){global $dic; echo "<tr><td class='ui-widget-content ui-corner-bottom pfooter' colspan=2 align=right><a href='#' class='tt_switch' status=1 title='$dic[help_off_title_tt]'>$dic[help_off_title]</a></td></tr>";}
function View(){echo "<td class='ui-widget-content pview' align=center valign=top>view tasks list</td>";}

function Control()
{
  global $context;
  $uu=array(56,57,58,61,370);
  $task_creator=in_array($context['uuid'],$uu);

  echo "<td class='ui-widget-content pcontrol' align=center valign=top>";

  echo "<table width=100%>";

  //LIST buttons: delete, refresh
  echo "<tr>";
  if ($task_creator)
    echo "<td align=left><div id='delete' class='btn nobr' title='Delete selected tasks'>Delete</div></td>";
  else  
    echo "<td align=left>'view only' mode</td>";
  echo "<td align=right><div id='refresh' class='btn' title='View tasks list'>Refresh</div></td>";
  echo "</tr>";
		
  //TASK: main description (main task definition)
  echo "<tr class=task_info><td colspan=2>";
	echo "<div class='ui-widget-content ui-corner-all main_descr'></div>";
  echo "</td></tr>";

  //TASK: parameters list (task parameters list)
  echo "<tr class=task_info><td colspan=2>";
	echo "<div class='ui-widget-content ui-corner-all parameters_list'></div>";
  echo "</td></tr>";
  
  //TASK buttons: create new, save
  if ($task_creator)
  {  
    echo "<tr>";
    echo "<td align=right><div id='createnew' task_id=0 class='btn nobr' action='clear' title='Create a new task'>Create new</div></td>";
    echo "<td align=left><div id='save' class='btn nobr' title='Save the task and/or parameters changes'>Save changes</div></td>";
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