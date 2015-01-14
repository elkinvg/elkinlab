<?php
//liv3journal.php

require "connect.php";
require "config.inc.php";
require "errors.inc.php";
require "../lang/$context[lang]/dic.inc.php";

if ($err_no > 0){$ret = array('err_no' => $err_no, 'result' => $result); echo json_encode($ret); return;}

$ret=array();
$val=array();

$oper=$_POST['oper'];

function HMS($s)
{
  $hr=(int)round(floor($s/3600));
  $min=(int)round(floor(($s-3600*$hr)/60));
  $sec=$s-3600*$hr - 60*$min;
  $hrs=sprintf("%d:%02d:%02d",$hr,$min,$sec);
  return $hrs;
}

function StationsStatus($fname, $nStations)
{
  $astatus=array();
  $f=  fopen($fname,"r");
  if ($f)
  {
   while (!feof($f))
   {
     $s = fgets($f, 64);
     list($station_id,$ping_ok,$daq_ok,$data_ok,$age,$ts)=explode(" ",$s,6); //ts =>  timestamp of the last data transmittion !!!!!
     $id = substr($station_id,3,1);

     $ts = mktime(substr($ts,8,2),substr($ts,10,2),0,substr($ts,4,2),substr($ts,6,2),substr($ts,0,4));
     $ts=date("Y-m-d H:i",$ts);

     $astatus[$id] = array("ping" => $ping_ok, "daq" => $daq_ok, "data" =>$data_ok, "age" => $age, "ts" => $ts);
    }
    fclose($f);
	}
  return $astatus;
}
 
if ($oper=="misc")
{
  //REPPORTS
  $query="SELECT COUNT(*) AS total FROM reports JOIN users ON reports.user_id=users.uuid WHERE users.utype=1";
  $result=mysql_query($query, $link); if (!$result) {echo mysql_errno($link) . ": " . mysql_error($link); mysql_close($link); return;}	
  $row = mysql_fetch_array($result);
  $reports=$row['total'];
  
  //JOBS
  $query="SELECT COUNT(*) AS total FROM jobs JOIN users ON jobs.user_id=users.uuid WHERE ((job_status=3) OR (job_status=13)) AND (users.utype=1)";
  $result=mysql_query($query, $link);
  $row = mysql_fetch_array($result);
  $jobs_users=$row['total']; 

  $query="SELECT COUNT(*) AS total FROM jobs JOIN users ON jobs.user_id=users.uuid WHERE ((job_status=3) OR (job_status=13)) AND (users.utype=2 OR users.utype=8)";
  $result=mysql_query($query, $link);
  $row = mysql_fetch_array($result);
  $jobs_experts=$row['total']; 
  
  //TASKS
  $query="SELECT COUNT(*) AS total FROM tasks WHERE status=1";
  $result=mysql_query($query, $link); if (!$result) {echo mysql_errno($link) . ": " . mysql_error($link); mysql_close($link); return;}	
  $row = mysql_fetch_array($result);
  $tasks=$row['total'];

  //USERS : newbie
  $query="SELECT COUNT(*) AS total FROM users WHERE status=2 AND utype=1";
  $result=mysql_query($query, $link); if (!$result) {echo mysql_errno($link) . ": " . mysql_error($link); mysql_close($link); return;}	
  $row = mysql_fetch_array($result);
  $users=$row['total'];

  //USERS : experts and admin
  $query="SELECT COUNT(*) AS total FROM users WHERE status=2 AND (utype=2 OR utype=8)";
  $result=mysql_query($query, $link); if (!$result) {echo mysql_errno($link) . ": " . mysql_error($link); mysql_close($link); return;}	
  $row = mysql_fetch_array($result);
  $experts=$row['total'];

  //ACTIVE
  $query="SELECT user_id, COUNT(user_id) AS total FROM jobs WHERE job_status<10 GROUP BY user_id";
  $result=mysql_query($query, $link); if (!$result) {echo mysql_errno($link) . ": " . mysql_error($link); mysql_close($link); return;}	
  $active = mysql_num_rows($result);

  //VISITS
  $query="SELECT SUM(visits_numb) AS total FROM users WHERE status=2";
  $result=mysql_query($query, $link); if (!$result) {echo mysql_errno($link) . ": " . mysql_error($link); mysql_close($link); return;}	
  $row = mysql_fetch_array($result);
  $visits = $row['total'];
  
  //CPU
   $tot_user= $tot_expert=0;

  $query="SELECT * FROM jobs JOIN users ON jobs.user_id=users.uuid WHERE ((job_status=3) OR (job_status=13)) AND (users.utype=1)";
  $result=mysql_query($query, $link);
  if (!$result) $cpu_user="?";
  else
  {
    $rows=mysql_num_rows($result);
    $total_sec=0;
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 	//TO DO as in ustats.php
    {
      if (!isset($row['finished']) || ($row['finished'] < $row['started'])) continue;
      $stime=strtotime($row['started']); 
      $run_time=strtotime($row['finished']) - $stime; 
      if ($run_time > 0 ) $total_sec+=$run_time; else $total_sec+=0.5;
    }
    $tot_user=$total_sec;    
    $cpu_users=HMS($total_sec);
 }
  mysql_free_result($result);
  
  $query="SELECT * FROM jobs JOIN users ON jobs.user_id=users.uuid WHERE ((job_status=3) OR (job_status=13)) AND (users.utype=2 OR users.utype=8)";
  $result=mysql_query($query, $link);
  if (!$result) $cpu_expert="?";
  else
  {
    $rows=mysql_num_rows($result);
    $total_sec=0;
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 	//TO DO as in ustats.php
    {
      if (!isset($row['finished']) || ($row['finished'] < $row['started'])) continue;
      $stime=strtotime($row['started']); 
      $run_time=strtotime($row['finished']) - $stime; 
      if ($run_time > 0 ) $total_sec+=$run_time; else $total_sec+=0.5;
    }
    $tot_expert=$total_sec;    
    $cpu_experts=HMS($total_sec);
  } 
  $tot = $tot_user+$tot_expert; 
  if ($tot > 0)$cpu_all=HMS($total_sec);    
  else  $cpu_all="?";
  mysql_free_result($result);
      
  $val=array(
  "misc_title" => $dic['misc_title'], "misc_title_tt" => $dic['misc_title_tt'],
  "meteo_since_title" => $dic['meteo_since_title'], "meteo_since_title_tt" => $dic['meteo_since_title_tt'],
  "reports" => $reports, "reports_title" => $dic['reports_title'], "reports_title_tt" => $dic['reports_title_tt'],  
  "tasks" => $tasks, "experts_tasks_title" => $dic[experts_tasks_title], "experts_tasks_title_tt" => $dic['experts_tasks_title_tt'],
     "participants_title" => $dic['participants_title'], "participants_title_tt" => $dic['participants_title_tt'],
  "users" => $users, "users_title" => $dic['users_title'], "users_title_tt" => $dic['users_title_tt'],
  "experts" => $experts, "experts_title" => $dic['experts_title'], "experts_title_tt" => $dic['experts_title_tt'],
  "active" => $active, "active_title" => $dic['active_title'], "active_title_tt" => $dic['active_title_tt'],
  "visits" => $visits, "daily_visits_title" => $dic['daily_visits_title'], "daily_visits_title_tt" => $dic['daily_visits_title_tt'],
     "jobs_tot_title" => $dic['jobs_tot_title'], "jobs_tot_title_tt" =>  $dic['jobs_tot_title_tt'],
  "jobs_users" => $jobs_users, "jobs_users_title" => $dic['jobs_users_title'], "jobs_users_title_tt" => $dic['jobs_users_title_tt'],
  "jobs_experts" => $jobs_experts, "jobs_experts_title" => $dic['jobs_experts_title'], "jobs_experts_title_tt" => $dic['jobs_experts_title_tt'],      
  "cpu_all" => $cpu_all, "cpu_tot_title" => $dic['cpu_tot_title'], "cpu_tot_title_tt" => $dic['cpu_tot_title_tt'],  
  "cpu_users" => $cpu_users, "cpu_users_title" => $dic['cpu_users_title'], "cpu_users_title_tt" => $dic['cpu_users_title_tt'],
  "cpu_experts" => $cpu_experts, "cpu_experts_title" => $dic['cpu_experts_title'], "cpu_experts_title_tt" => $dic['cpu_experts_title_tt']
  );
}

else if ($oper=="stations")
{
   $query="SELECT station_id, SUM(nevents) AS total, COUNT(nevents) AS files, SUM(TIME_TO_SEC(CONVERT_TZ(FROM_UNIXTIME(TIMESTAMPDIFF(SECOND,start_time,end_time)),'Europe/Moscow','GMT'))) as timesec  FROM dfc GROUP BY station_id";
   $result=mysql_query($query, $link);
   $val[0] = array('nevents' =>0, 'nfiles' => 0, 'timesec' => 0);
   while($row = mysql_fetch_array($result))
   {
     $st=$row['station_id'];
	 $val[$st]=array('nevents' =>$row['total'], 'nfiles' => $row['files'], 'timesec' => $row['timesec']);
	 $val[0]['nevents'] +=$row['total'];
	 $val[0]['nfiles'] +=$row['files'];
	 $val[0]['timesec'] +=$row['timesec'];
   }   
   mysql_free_result($result);  
   $val['dic'] = $dic; //attach the dictionary   
}

else if ($oper=="status")
{
    for ($ind=0; $ind < STATIONS_NUMBER; $ind++)
    {
      $st=$locations[$ind]['station_id'];
      $lat=$locations[$ind]['latitude'];
      $lon=$locations[$ind]['longitude'];
      $alt=$locations[$ind]['altitude'];
      $val['locations'][$st] = array('lat' => $lat, 'lon' => $lon, 'alt' => $alt);
    }
 
  //get stations satus
  $nStations = count($locations);
  $val['status'] = StationsStatus($stations_status, $nStations);	//get status
  //$aaa=StationsStatus($stations_status, $nStations);
  //$err_no=ERR_DEBUG; $result="len = ".count($aaa).", nStations=".$nStations.", ping(1) => ".$aaa[1]['ping'].", file=".$stations_status;
   $val['dic'] = $dic; //attach the dictionary  
}

mysql_close($link);
if (count($ret)==0) $ret = array('err_no' => $err_no, 'result' => $result, 'val' => $val);
echo json_encode($ret);  
?>