<?php
//main.php

function pHeader()
{
  global $proj_home, $sweet_home,$dic;
  echo "<tr><td colspan=2 class='ui-widget-header ui-corner-top pheader' align=left>";
//    echo "<span class=logo><a href='$proj_home' title='$dic[livni_logo_tt]' id='proj_home'>$dic[livni_logo]</a></span>";
    echo "<span class=logo>$dic[livni_logo]</span>";
    echo "<a href='$sweet_home' title='$dic[labs_logo_tt]' id='labs_home'><span class=logo_labs>$dic[labs_logo]</span></a>";
  echo  "</td></tr>";
}
function pFooter(){global $dic; echo "<tr><td class='ui-widget-content ui-corner-bottom pfooter' colspan=2 align=right><a href='#' class='tt_switch' status=1 title='$dic[help_off_title_tt]'>$dic[help_off_title]</a></td></tr>";}

function View(){}

function Control()
{
  global $context,$dic;
  $allowed=($context['utype']="admin" || $context['utype']="expert");

  //ELKIN-B
  $is_old_version = FALSE;
  $page_height; 
  $num_of_cols;
  
  if ($context['utype']="visitor") $num_of_cols = 5;
  else $num_of_cols = 5;
  $page_height = 100/$num_of_cols;

  
  //task list
  echo "<tr>";
  echo "<td height=$page_height% class='ui-widget-content ui-corner-right jcontrol' align=center><a href='./php/tempdev.php'><span class='logo_labs' title='$dic[task_list_tt]'>$dic[task_list]</span></a></td>";
  echo "<td class='ui-widget-content ui-corner-left jview' id=jobs_brief_descr>$context[lang] brief description</td>";
  //jobs_list
  echo "<tr>";
  echo "<td height=$page_height% class='ui-widget-content ui-corner-right jcontrol' align=center><a href='./php/tempdev.php'><span class='logo_labs' title='$dic[jobs_list_tt]'>$dic[jobs_list]</span></a></td>";
  echo "<td class='ui-widget-content ui-corner-left jview' id=tasks_brief_descr>$context[lang] brief description</td>";
  //new_job
  echo "<tr>";
  echo "<td height=$page_height% class='ui-widget-content ui-corner-right jcontrol' align=center><a href='./php/tempdev.php'><span class='logo_labs' title='$dic[new_job_tt]'>$dic[new_job]</span></a></td>";
  echo "<td class='ui-widget-content ui-corner-left jview' id=newjob_brief_descr>$context[lang] brief description</td>";
  //example_job
  echo "<tr>";
  echo "<td height=$page_height% class='ui-widget-content ui-corner-right jcontrol' align=center><a href='./php/tempdev.php'><span class='logo_labs' title='$dic[example_job_tt]'>$dic[example_job]</span></a></td>";
  echo "<td class='ui-widget-content ui-corner-left jview' id=examplejob_brief_descr>$context[lang] brief description</td>";
  //shared_job
  echo "<tr>";
  echo "<td height=$page_height% class='ui-widget-content ui-corner-right jcontrol' align=center><a href='./php/tempdev.php'><span class='logo_labs' title='$dic[shared_job_tt]'>$dic[shared_job]</span></a></td>";
  echo "<td class='ui-widget-content ui-corner-left jview' id=sharedjob_brief_descr>$context[lang] brief description</td>";
  //ELKIN-E

  if ($context['utype']=="admin") {
      //BASIL
//  //jobs
//  echo "<tr>";
//  echo "<td height=25% class='ui-widget-content ui-corner-right jcontrol' align=center><a href='./jobs_list_v3.php'><span class='logo_labs' title='$dic[jobs_title_tt]'>$dic[jobs_title]</span></a></td>";
//  echo "<td class='ui-widget-content ui-corner-left jview' id=jobs_brief_descr>$context[lang] brief description</td>";
//  echo "</tr>";
 //journal 
  echo "<tr>";
  echo "<td height=25% class='ui-widget-content ui-corner-right jcontrol' align=center><a href='./journal_list_v3.php'><span class='logo_labs' title='$dic[journal_title_tt]'>$dic[journal_title]</span></a></td>";
  echo "<td class='ui-widget-content ui-corner-left jview' id=journal_brief_descr>$context[lang] brief description</td>";
  echo "</tr>";
 //tasks
  echo "<tr>";
  echo "<td height=25% class='ui-widget-content ui-corner-right jcontrol' align=center><a href='./jobs_tasks_v3.php'><span class='logo_labs' title='$dic[tasks_title_tt]'>$dic[tasks_title]</span></a></td>";
  echo "<td class='ui-widget-content ui-corner-left jview'  id=tasks_brief_descr>$context[lang] brief description</td>";
  echo "</tr>";
 //statistics
  echo "<tr>";
  echo "<td height=25% class='ui-widget-content ui-corner-right jcontrol' align=center><a href='./statistics_v3.php'><span class='logo_labs' title='$dic[statistics_title_tt]'>$dic[statistics_title]</span></a></td>";
  echo "<td class='ui-widget-content ui-corner-left jview'  id=statistics_brief_descr>$context[lang] brief description</td>";
  echo "</tr>";
  }  
}

function Rendermain()
{
  echo "<table class='ui-widget' width=100% height=100% border=0>";  
  pHeader();
  Control();
  pFooter();  
  echo "</table>";
}

?>