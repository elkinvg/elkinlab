<?php
//jobs_list.php

function pHeader()
{
  global $proj_home, $sweet_home,$dic;
  echo "<tr><td colspan=2 class='ui-widget-header ui-corner-top pheader' align=left>";
    echo "<span class=logo><a href='$proj_home' title='$dic[livni_logo_tt]' id='proj_home'>$dic[livni_logo]</a></span>"; //  : $dic[jobs_title]
    echo "<a href='$sweet_home' title='$dic[labs_logo_tt]' id='labs_home'><span class=logo_labs>$dic[labs_logo]</span></a>";
    echo "<span class=logo_labs>: $dic[jobs_title]</span>";
  echo  "</td></tr>";
}
function pFooter(){global $dic; echo "<tr><td class='ui-widget-content ui-corner-bottom pfooter' colspan=2 align=right><a href='#' class='tt_switch' status=1 title='$dic[help_off_title_tt]'>$dic[help_off_title]</a></td></tr>";}

function Control()
{
  echo "<td class='ui-widget-content pcontrol' align=center valign=top>";

  echo "<table>";

  //REFRESH button
  echo "<tr>";
  echo "<td align=left><div id='delete' class='btn nobr' title='Delete selected jobs'>Delete</div></td>";
  echo "<td align=right><div id='refresh' class='btn' title='View the filtered jobs list'>Refresh</div></td>";
  echo "</tr>";

  //TIME SPAN
  echo "<tr>";
  echo "<td align=left><input id=filter_from type=text class='ui-widget-content ui-corner-all' title='filter: date from...'><span class=info>&nbsp;-&nbsp;date from</span></td>";
  echo "<td align=right><span class=info>date upto&nbsp;-&nbsp;</span><input id=filter_upto type=text class='ui-widget-content ui-corner-all' title='filter: date upto...'></td>";
	echo "</tr>";

  echo "<tr><td colspan=2 align=center>"; //filter, info  
  //Filter:
  // -  jobs owner:
  echo "<div id='filter_owner' class='radiosel'><nobr>";
  echo "<input type='radio' id='fi1' name='radio' checked='checked' value=0><label for='fi1' title='No owner filter'><span>all</span></label>";
  echo "<input type='radio' id='fi2' name='radio' value=1 /><label for='fi2' title='filter: users'><span>users</span></label>";
  echo "<input type='radio' id='fi3' name='radio' value=2 /><label for='fi3' title='filter: experts'><span >experts</span></label>";
  echo "<input type='radio' id='fi4' name='radio' value=3 /><label for='fi4' title='filter: my own'><span >my own</span></label>";
  echo "<input type='radio' id='fi5' name='radio' value=4 /><label for='fi5' title='filter: illustrations'><span >illustr.</span></label>";
  echo "<input type='radio' id='fi6' name='radio' value=5 /><label for='fi6' title='filter: specific person'><span >person</span></label>";
  echo "<input type='radio' id='fi7' name='radio' value=6 /><label for='fi7' title='filter: specific job ID'><span >job ID</span></label>";
  echo "</nobr></div>";
	echo "</td></tr>";
  
  //LOOK FOR - PERSON, JOB ID
  echo "<tr>";
  echo "<td align=left><div id='filter_person' class='ui-corner-all nobr'><input type=text id=person title='filter: person' size=15 placeholder='last name' class='ui-corner-all'><span class=info>&nbsp;-&nbsp;person</span></div></td>";
  echo "<td align=right><span class=info>job ID&nbsp;-&nbsp;</span><div id='filter_id' class='ui-corner-all nobr'><input type=text id=jobid title='find: specific job' size=15 placeholder='job ID' class='ui-corner-all'></div></td>";
	echo "</tr>";

  echo "<tr><td colspan=2>&nbsp;</td></tr>";

  //TASK TYPE
  echo "<tr><td align=center colspan=2>";
	echo "<form id='form_tasktype'><select id='tasktype' class='ui-corner-all'></select></form>";
	echo "</td></tr>";
	
  echo "<tr><td colspan=2><hr></td></tr>";
	
  //JOB INFO : attributes
  echo "<tr class=job_info><td colspan=2>";
  echo "<div class=job_info_attrt></div>";
  echo "</td></tr>";
  //JOB INFO : output
  echo "<tr class=job_info><td colspan=2>";
  echo "<div class=job_info_output></div>";
  echo "</td></tr>";
  
  //PARAMETERS
  echo "<tr class=param_info><td colspan=2>";
	echo "<div class='ui-widget-content ui-corner-all parameters'>parameters</div>";
  echo "</td></tr>";

  // - Job buttons: delete, create, start
  echo "<tr>";
  echo "<td align=right><div id='createnew' task_id=0 class='btn nobr' title='Create new job'>Create new</div></td>";
  echo "<td align=left><div id='start' class='btn nobr' title='Launch the job (new or modified)'>Start</div></td>";
  echo "</tr>";

  echo "</table>";
  

  echo "</td>";
}

function View()
{
  echo "<td class='ui-widget-content pview' align=center valign=top>";

  echo "view list, ROOT output";

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