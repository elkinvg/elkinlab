<?php
//liv3jobs.php

require "config.inc.php";
require "connect.php";

if ($err_no > 0){$ret = array('err_no' => $err_no, 'result' => $result); echo json_encode($ret); return;}

function SaveUserJob($uuid,$job_id,$aparams)
{
  global $users_path,$fname;

  $dir="$users_path/$uuid/jobs/$job_id";
  
	//check/create 'dir':
  $ok=true;
	if (!file_exists($dir)) {$ret=mkdir($dir,0777); chmod($dir, 0777);}
  if (!$ok) return false;
    
  $start_time=$end_time=time();

  $par_file = "$dir/$fname";
  $f = fopen($par_file,"a+");  if (!$f) return false;
  foreach($aparams as $param)
  {
    $name=$param['name'];
    $type=$param['type'];
    $def_val=$param['value'];
    $min_val=$param['min'];
    $max_val=$param['max'];
    if ($type==2)	//DATE TIME
    {
      if (strlen($def_val) > 10)   //if time specified
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
    } //if date, time
    else $value=$def_val;

    $par="$name $value\n";
    if (fwrite($f,$par)==FALSE) {$ret=false; break;}
  }
  fclose($f);
	return $ok;
}

$val=null;
$ret=array();

$oper=$_POST['oper'];

if ($oper=="list")
{
  $filter=$_POST['filter'];
  //FROM - UPTO
  $where_clause="WHERE jobs.job_status<10 AND UNIX_TIMESTAMP(jobs.started) >= ".$filter['from']." AND UNIX_TIMESTAMP(jobs.started) <= ".$filter['upto'];
 
 //OWNER
 //{all,users,expert,own,illustr,person,jobid}
  if ($filter['owner']==1)       //users
    $where_clause .= " AND users.utype=1";
  else if ($filter['owner']==2)  //expert
    $where_clause .= " AND users.utype > 1";
  else if ($filter['owner']==3)  //my own
   $where_clause .= " AND users.uuid=".$context['uuid'];
  else if ($filter['owner']==4)  //illustr
    $where_clause .= " AND jobs.option=1";
  else if ($filter['owner']==5)  //person
    $where_clause .= " AND users.last_name LIKE '%".$filter['person']."%'";
  else if ($filter['owner']==6)  //jobid
    $where_clause .= " AND jobs.job_id=".$filter['jobid'];
 //else if ($filter['owner']==0) //all

//TASK_ID
  if ($filter['task_id'] > 0)
    $where_clause .= " AND jobs.task_id=".$filter['task_id'];

  $query="SELECT * FROM jobs INNER JOIN (tasks,users) ON (jobs.task_id=tasks.task_id AND jobs.user_id=users.uuid) INNER JOIN jobpars ON (jobs.task_id=jobpars.task_id AND jobs.job_id=jobpars.job_id AND jobpars.name='COMMENT') $where_clause ORDER BY jobs.job_id DESC LIMIT 300";
//  $query="SELECT * FROM jobs INNER JOIN tasks ON jobs.task_id=tasks.task_id INNER JOIN jobpars ON (jobs.task_id=jobpars.task_id AND jobs.job_id=jobpars.job_id AND jobpars.name='COMMENT') $where_clause ORDER BY jobs.job_id DESC LIMIT 300";

  $res=mysql_query($query, $link);
  if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link);}
  else {while($val[] = mysql_fetch_array($res, MYSQL_ASSOC)) {};}
  mysql_free_result($res);  
}

else if ($oper=="job")
{
  $job_id=$_POST['job_id'];
  $query="SELECT * FROM jobs INNER JOIN (tasks,users) ON (jobs.task_id=tasks.task_id AND jobs.user_id=users.uuid) INNER JOIN jobpars ON (jobs.task_id=jobpars.task_id AND jobs.job_id=jobpars.job_id AND jobpars.name='COMMENT') WHERE jobs.job_id=$job_id LIMIT 1";
  $res=mysql_query($query, $link);
  if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link);}
  else 
  {
    $val = mysql_fetch_array($res, MYSQL_ASSOC);
    $val['sec']=strtotime($val['finished']) - strtotime($val['started']);
    if ($val['job_status'] >= 3)  //completed or failed
    {
     //STDOUT, STDERR
      $CRLF=array("\r\n", "\n", "\r");
      $user_id=$val['user_id'];
      $job_path = "$users_home/$user_id/jobs/$job_id";
      $content=file_get_contents ($job_path."/stdout.txt");
      $val['stdout'] = str_replace($CRLF, "<br>", $content);
      $content=file_get_contents ($job_path."/stderr.txt");
      $val['stderr'] = str_replace($CRLF, "<br>", $content);
    }
    if ($val['job_status']==3)  //completed: define number of pictures in root output
    {
      $content=file_get_contents ("$job_path/report_$job_id.html");
      $arr = explode("<p>",$content);
      $pics = preg_grep( "/img src/i", $arr );
      foreach($pics as $pic)
      {
        $pos1=strpos($pic,"img src") + 8;   
        $pos2=strpos($pic,".png");   
        $len=$pos2-$pos1;  
        $im=substr($pic,$pos1,$len);
        $val['figures'][]="$im.png";
      }
    }
    else $val['figures'] = array();
 }
  mysql_free_result($res);  
}

else if ($oper=="params")
{
  $job_id=$_POST['job_id'];
  $query="SELECT * FROM jobpars WHERE job_id=$job_id";
  $res=mysql_query($query, $link);
  if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link);}
  else {while($val[] = mysql_fetch_array($res, MYSQL_ASSOC)) {};}
  mysql_free_result($res);  
}

else if ($oper=="delete")
{
  $adeljobs=$_POST['adeljobs'];
 	foreach($adeljobs as $job_id)
 	{
 	 $query="UPDATE jobs SET job_status=10+job_status WHERE job_id=$job_id LIMIT 1";
   $res=mysql_query($query, $link);
   if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link); break;}
  }
}

else if ($oper=="start")
{
  $err_no=0;
  $aparams=$_POST['aparams'];
  $task_id=$_POST['task_id'];
  $user_id=$context['uuid'];
  $job_status=1; //pending
  $query="INSERT INTO jobs (task_id,user_id,job_status,started) VALUES ($task_id, $user_id,$job_status,NOW())";
  $res=mysql_query($query, $link);
  if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link);}
  if ($err_no==0)
  {
    $job_id=mysql_insert_id($link);
    foreach($aparams as $param)
    {
      $query="INSERT INTO jobpars (job_id,task_id,caption,name,type,def_val,min_val,max_val) VALUES ($job_id,$task_id,'$param[caption]','$param[name]',$param[type],'$param[value]','$param[min]','$param[max]')";
      $res=mysql_query($query, $link);
      if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link); break;}
    }
    if ($err_no==0)    //increment tasks.popularity and save job params
    {
      $query="UPDATE tasks SET popularity=popularity+1 WHERE task_id=$task_id LIMIT 1";
      $res=mysql_query($query, $link);
      SaveUserJob($user_id,$job_id,$aparams);
    }
  }  
}

mysql_close($link);
if (count($ret)==0) $ret = array('err_no' => $err_no, 'result' => $result, 'val' => $val);
echo json_encode($ret);  
?>