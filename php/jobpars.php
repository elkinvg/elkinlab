<?php

//jobpars: handles the 'livni.jobpars' table. Following is the list of functions currently supported:
//oper={save, delete,list, load} note: list requires $ret global

$pp="..";
$fname="params.txt";

if (!isset($log_inc))
  require "$pp/php/log.php";


function SaveJob($job_id,$uuid)
{
	global $pp, $fname, $users_path;
  $ret=true;
  $dir="$users_path/$uuid/jobs/$job_id";
  
  $tz_utc_offset_sec=date("Z"); //UTC timezone offset in seconds (added 16-June-2010)
	
	if (file_exists($dir)==false)  
	{
		 $ret=mkdir($dir,0777);	//check/create  'dir'
          chmod($dir, 0777);
	}
  $start_time=$end_time=time();

	if ($ret)
	{
       $par_file = "$dir/$fname";
       $f = fopen($par_file,"a+");  if (!$f) return false;
       $i=0;
       while(isset($_POST['params_caption_'.$i]))
       {
          $name=$_POST['params_name_'.$i];
          $type=$_POST['params_type_'.$i];
          $def_val=$_POST['params_def_'.$i];     if (!isset($def_val)) $def_val=0;	//this if is for unset checkboxes (for shelkov)
          $min_val=$_POST['params_min_'.$i];
          $max_val=$_POST['params_max_'.$i];
          if ($type==2)	//date, time -----------------------------------------
          {
             if (strlen($def_val) > 10)   //time specified
             {
          	   list($d,$t)=explode(" ",$def_val); //date and time
          	   list($y,$m,$d)=explode("-",$d);
          	   list($hr,$min)=explode(":",$t);
             }
             else
             {
          	  list($y,$m,$d)=explode("-",$def_val); //as it was
          	  if ($name=="START_TIME") {$hr=$min=$sec=0;} else if ($name=="END_TIME")  {$hr=23; $min=59; $sec=59;} //default time (if not specified)
             }
                       	
          	if ($name=="START_TIME")  //last 20-Apr-2010 => if from==upto
          	{
          	  $value=mktime($hr,$min,$sec,$m,$d,$y);
          	  $start_time=$value;
          	}
          	else if ($name=="END_TIME")  
          	{
          	   $value=mktime($hr,$min,$sec,$m,$d,$y);
          	  $end_time=$value;
          	  if ($start_time==$end_time)
          	  {
          	    if ((time() - $end_time) <= 24*3600) //if today
          	      $value=time();  //up to this moment
          	    else
          	      $value=mktime($hr,$min,$sec,$m,$d,$y);
          	  }
          	}
          	
          	//$value -= $tz_utc_offset_sec;  //UTC time shift (added 16-June-2010)
          	
          } //if date, time ---------------------------------------------------------
          else $value=$def_val;

          $par="$name $value\n";
          if (fwrite($f,$par)==FALSE) {$ret=false; break;}
          $i++;
        }
        fclose($f);
        if ($ret)
        {
          $msg="Job ID=$job_id queued";
          $dir = $users_path;
          $ret = LogRecord($dir,"activity.log",$uuid,$msg);
        }
      } //if dir ok
	return $ret;
}

function unlinkRecursive($dir, $deleteRootToo)
{
    if(!$dh = @opendir($dir)) return;
    while (false !== ($obj = readdir($dh)))
    {
        if($obj == '.' || $obj == '..') continue;
        if (!@unlink($dir . '/' . $obj)) unlinkRecursive($dir.'/'.$obj, true);
    }
    closedir($dh);
    if ($deleteRootToo) @rmdir($dir);
} 

function DeleteJob($job_id,$uuid)
{
   global $pp, $users_path;
    $dir="$users_path/$uuid/jobs/";

  $del_dir=$dir.$job_id;
  if (file_exists($del_dir)==false) return true;//nothing to do: the dir doesn't exist

  $save = getcwd();
  chdir($dir);
  unlinkRecursive($job_id,true);
  chdir($save);

  $msg="Job ID=$job_id deleted";
  $dir = $users_path;
   LogRecord($dir,"activity.log",$uuid,$msg);
}

//------------------------------------------------------------ global

if (!isset($params_oper)) 
{
  $oper=$_POST['params_oper']; 
  if (!isset($oper)) $oper=$_GET['params_oper']; 
  if (!isset($oper)) $oper=$GLOBALS['params_oper'];
  if (!isset($oper))$oper="goback";
}
else {$oper=$params_oper;}
if ($oper=="goback")
{
    echo "<script language='JavaScript' type='text/javascript'>window.location='$sweet_home';</script>";	
	return;
}

$job_id=$_POST['job_id'];

require "connect.php";
if (!$link){echo "Could not connect : " .mysql_error(); return;}
if (!mysql_select_db("livni", $link)){echo mysql_errno($link) . ": " . mysql_error($link); mysql_close($link);  return;}

if ($oper=="save") 	//begin------------------------------------------------------------------------SAVE
{	
    $i=0;
    $task_id=$_POST['params_task_id'];
    $user_id=$_POST['uuid'];
    $job_status=1; //pending
    $query="INSERT INTO jobs (task_id,user_id,job_status,started) VALUES ($task_id, $user_id,$job_status,NOW())";
    $result=mysql_query($query, $link);

    if (!$result) {echo mysql_errno($link) . ": " . mysql_error($link);}	
    else 
    {
       $job_id=mysql_insert_id($link);
       while(isset($_POST['params_caption_'.$i]))
       {
          $caption=$_POST['params_caption_'.$i];
          $name=$_POST['params_name_'.$i];
          $type=$_POST['params_type_'.$i];
          $def_val=$_POST['params_def_'.$i];    if (!isset($def_val)) $def_val=0;	//this if is for unset checkboxes (for shelkov)
          $min_val=$_POST['params_min_'.$i];
          $max_val=$_POST['params_max_'.$i];
          $query="INSERT INTO jobpars (job_id,task_id,caption,name,type,def_val,min_val,max_val) VALUES ($job_id,$task_id, '$caption','$name',$type,'$def_val','$min_val','$max_val')";
          $result=mysql_query($query, $link);
           if (!$result) break;
           $i++;
        }
        //increment tasks.popularity
        $query="UPDATE tasks SET popularity=popularity+1 WHERE task_id=$task_id LIMIT 1";
        $result=mysql_query($query, $link);
        SaveJob($job_id,$user_id);
    }
    if (!$result) {echo mysql_errno($link) . ": " . mysql_error($link);}	
    $ret[] = array('par_number' => $i, 'job_id' => $job_id);
}//end--------------------------------------------------------------------------------------------------- SAVE

else if ($oper=="delete")//begin-------------------------------------------------------------------DELETE
{
  /* initial version for physically records deleting
  $user_id=$_POST['uuid'];
  $task_id=$_POST['params_task_id'];
  $query="DELETE FROM jobs WHERE job_id=$job_id AND user_id=$user_id LIMIT 1";
  $result=mysql_query($query, $link);
  if ($result==0) echo "0"; 
  else 
  {
    $query="DELETE FROM jobpars WHERE job_id=$job_id";
    $result=mysql_query($query, $link);
    if ($result==0) echo "0"; 
    else
    {
      //decrement tasks.popularity
      $query="UPDATE tasks SET popularity=popularity-1 WHERE task_id=$task_id LIMIT 1";
      $result=mysql_query($query, $link);
      DeleteJob($job_id,$user_id);
  	  echo $job_id;
    }
  }
  mysql_close($link);
  return;
  */

  $user_id=$_POST['uuid'];
  $task_id=$_POST['params_task_id'];
 	$query="UPDATE jobs SET job_status=10+job_status WHERE job_id=$job_id AND user_id=$user_id LIMIT 1";
  $result=mysql_query($query, $link);
  if ($result==0) echo "0"; 
  else 
  {
    LogRecord($users_path,"activity.log",$user_id,"Job ID=$job_id deleted");    
  	echo $job_id;
  }
  mysql_close($link);
  return;

}//end--------------------------------------------------------------------------------------------- DELETE

else if ($oper=="delete_cb")//begin-------------------------------------------------------------------DELETE MARKED (CHECKBOX version)
{
  $user_id=$_POST['uuid'];
  $cbdel=$_POST['cbdel'];    //$delnumb=count($cbdel);
  $cnt=0;
//  print_r($cbdel);

 	foreach($cbdel as $job_id)
 	{
 	 $query="UPDATE jobs SET job_status=10+job_status WHERE job_id=$job_id AND user_id=$user_id LIMIT 1";
   $result=mysql_query($query, $link);
   if ($result==0) break;
   $cnt++;
  }
  if ($cnt > 0)
  {
    LogRecord($users_path,"activity.log",$user_id,"Jobs deleted: $cnt");    
  }
  echo $cnt;
  mysql_close($link);
  return;
}


else if ($oper=="list")//begin----------------------------------------------------------------------LIST
{
  $user_id = my_getcookie("uuid");
  $user_type = my_getcookie("utype");
  $user_lname = my_getcookie("lname");
  $jobs_numb = my_getcookie("jobs");
  if (isset($user_lname) && (strlen($user_lname) > 0)) $user_lname=urldecode($user_lname);
  if (!isset($user_id) || !isset($user_type)) {echo  "<script language='JavaScript' type='text/javascript'>window.location='$sweet_home';</script>";}

  if ($user_type=="admin" || $user_type=="expert")
  {
    if (isset($tfrom) && isset($tupto) && isset($ftype))
    {
      if ($ftype=="user")
          $fuser = " AND users.utype = 1";
      else if ($ftype=="expert")                      
          $fuser = " AND users.utype > 1";
      else if ($ftype=="person")                      
          $fuser = " AND users.last_name LIKE '%$user_lname%'";
      else // ($ftype=="all")
          $fuser="";                
      $filter=" AND UNIX_TIMESTAMP(started) >= ".$tfrom." AND UNIX_TIMESTAMP(started) <= ".$tupto.$fuser;
    }
    else $filter="";  
    $query="SELECT * FROM jobs INNER JOIN (tasks,users) ON (jobs.task_id=tasks.task_id AND jobs.user_id=users.uuid) WHERE (job_status<10) $filter ORDER BY job_id DESC";
  }
  else    //for mortals ))
  {      
      if (($jobs_numb > 50) && (isset($tfrom) && isset($tupto)))
        $filter=" AND UNIX_TIMESTAMP(started) >= ".$tfrom." AND UNIX_TIMESTAMP(started) <= ".$tupto;
      else 
        $filter="";
      $query="SELECT * FROM jobs INNER JOIN tasks ON jobs.task_id=tasks.task_id WHERE (jobs.user_id=$user_id OR jobs.option=1) AND (job_status<10) $filter ORDER BY job_id DESC";
  }
  $result=mysql_query($query, $link);
  if (!$result) {echo mysql_errno($link) . ": " . mysql_error($link); return;}	
  $rows=mysql_num_rows($result);
  while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 	//TO DO as in ustats.php
  {
     $ret[]=array('caption' => $row['caption'], 
                   'job_id' => $row['job_id'], 
                   'job_status' => $row['job_status'],
                   'started' => $row['started'],
                   'finished' => $row['finished'],
                   'user_id' => $row['user_id'],
                   'first_name' => $row['first_name'],
                   'last_name' => $row['last_name'],
                   'option' => $row['option']
                   );
  }
  mysql_free_result($result);
  
  //08-Apr-2010:for Shelkov: add a COMMENT for each job (now find a 'comment' for each 'job_id' in 'jobpars' table)
  foreach($ret as $ind => $job)
  {
    $job_id=$job['job_id'];
    $query="SELECT * FROM jobpars WHERE job_id=$job_id AND name='COMMENT' LIMIT 1";
    $result=mysql_query($query, $link);
    $rows=mysql_num_rows($result);
    if ($rows)
    {
      $row = mysql_fetch_array($result, MYSQL_ASSOC);
      $ret[$ind]['comment']=$row['def_val'];
    }
    else $job['comment']="";
    mysql_free_result($result);
  }
  //for Shelkov
  
  mysql_close($link);
  return;
}//end-----------------------------------------------------------------------------------------------LIST

else if ($oper=="load")//begin------------------------------------------------------------------------LOAD
{
  $query="SELECT * FROM taskpars  LEFT JOIN jobpars ON jobpars.name=taskpars.name AND jobpars.task_id=taskpars.task_id WHERE job_id=$job_id ORDER BY par_id";
  $result=mysql_query($query, $link);
  if (!$result) {echo mysql_errno($link) . ": " . mysql_error($link); return;}	
  $rows=mysql_num_rows($result);
  $ret=array();
  if ($rows)
  {
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
    {
       $ret[]=array('caption' => $row['caption'], 'name' => $row['name'],  'type' => $row['type'],  'def_val' => $row['def_val'],  'min_val' => $row['min_val'],  'max_val' => $row['max_val'], 'task_id' => $row['task_id']);
    }
  }
  else
  {
       $ret[]=array('caption' => 'New Parameter', 'name' => 'NEW_PAR',  'type' => 0,  'def_val' => '0',  'min_val' => '0',  'max_val' => '100');
  }
  mysql_free_result($result);
}//end---------------------------------------------------------------------------------------------------LOAD

echo json_encode($ret);

mysql_close($link);

?>
