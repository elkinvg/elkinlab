<?php
//jobpars: handles the 'livni.jobpars' table. Following is the list of functions currently supported:
//oper={save, delete,list, load} note: list requires $ret global

$pp="..";
$fname="params.txt";

if (!isset($log_inc))  require "$pp/php/log.php";

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

require "./connect.php";
if (!$link) {
    echo "Could not connect : " . mysqli_error($link);
    return;
}
if (!mysqli_select_db($link,"livni")) {
    echo mysqli_errno($link) . ": " . mysqli_error($link);
    mysqli_close($link);
    return;
}

if ($oper=="save") 	//begin------------------------------------------------------------------------SAVE
{	
    $i=0;
    $task_id=$_POST['params_task_id'];
    $user_id=$_POST['uuid'];
    $job_status=1; //pending
    $query="INSERT INTO jobs (task_id,user_id,job_status,started) VALUES ($task_id, $user_id,$job_status,NOW())";
    $result=mysqli_query($link,$query);

    if (!$result) {echo mysqli_errno($link) . ": " . mysqli_error($link);}	
    else 
    {
       $job_id=mysqli_insert_id($link);
       while(isset($_POST['params_caption_'.$i]))
       {
          $caption=$_POST['params_caption_'.$i];
          $name=$_POST['params_name_'.$i];
          $type=$_POST['params_type_'.$i];
          $def_val=$_POST['params_def_'.$i];    if (!isset($def_val)) $def_val=0;	//this if is for unset checkboxes (for shelkov)
          $min_val=$_POST['params_min_'.$i];
          $max_val=$_POST['params_max_'.$i];
          $query="INSERT INTO jobpars (job_id,task_id,caption,name,type,def_val,min_val,max_val) VALUES ($job_id,$task_id, '$caption','$name',$type,'$def_val','$min_val','$max_val')";
          $result=mysqli_query($link, $query);
           if (!$result) break;
           $i++;
        }
        //increment tasks.popularity
        $query="UPDATE tasks SET popularity=popularity+1 WHERE task_id=$task_id LIMIT 1";
        $result=mysqli_query($link, $query);
        SaveJob($job_id,$user_id);
    }
    if (!$result) {echo mysqli_errno($link) . ": " . mysqli_error($link);}	
    $ret[] = array('par_number' => $i, 'job_id' => $job_id);
}//end--------------------------------------------------------------------------------------------------- SAVE

echo json_encode($ret);

mysql_close($link);


?>