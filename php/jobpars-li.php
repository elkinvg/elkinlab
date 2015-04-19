<?php

//jobpars: handles the 'livni.jobpars' table. Following is the list of functions currently supported:
//oper={save, delete,list, load} note: list requires $ret global
error_reporting(0);
$pp = "..";
$fname = "params.txt";

if (!isset($log_inc))
    require "$pp/php/log.php";

function SaveJob($job_id, $uuid) {
    global $pp, $fname, $users_path;
    $ret = true;
    $dir = "$users_path/$uuid/jobs/$job_id";

    $tz_utc_offset_sec = date("Z"); //UTC timezone offset in seconds (added 16-June-2010)

    if (file_exists($dir) == false) {
        $ret = mkdir($dir, 0777); //check/create  'dir'
        chmod($dir, 0777);
    }
    $start_time = $end_time = time();

    if ($ret) {
        $par_file = "$dir/$fname";
        $f = fopen($par_file, "a+");
        if (!$f)
            return false;
        $ii = 0;
        $params = $_POST['params'];
        $n = count($params);

        for ($i = 0; $i < $n; $i++) {
            $name = $params[$i]['name'];
            $type = $params[$i]['type'];
            $def_val = $params[$i]['def_val'];
            if (!isset($def_val))
                $def_val = 0; //this if is for unset checkboxes (for shelkov)
            elseif ($def_val == 'none')
                $def_val = 0;
            $min_val = $params[$i]['min_val'];
            $max_val = $params[$i]['max_val'];
            if ($type == 2) { //date, time -----------------------------------------
                if (strlen($def_val) > 10) {   //time specified
                    list($d, $t) = explode(" ", $def_val); //date and time
                    list($y, $m, $d) = explode("-", $d);
                    list($hr, $min) = explode(":", $t);
                } else {
                    list($y, $m, $d) = explode("-", $def_val); //as it was
                    if ($name == "START_TIME") {
                        $hr = $min = $sec = 0;
                    } else if ($name == "END_TIME") {
                        $hr = 23;
                        $min = 59;
                        $sec = 59;
                    } //default time (if not specified)
                }

                if ($name == "START_TIME") {  //last 20-Apr-2010 => if from==upto
                    $value = mktime($hr, $min, $sec, $m, $d, $y);
                    $start_time = $value;
                } else if ($name == "END_TIME") {
                    $value = mktime($hr, $min, $sec, $m, $d, $y);
                    $end_time = $value;
                    if ($start_time == $end_time) {
                        if ((time() - $end_time) <= 24 * 3600) //if today
                            $value = time();  //up to this moment
                        else
                            $value = mktime($hr, $min, $sec, $m, $d, $y);
                    }
                }

                //$value -= $tz_utc_offset_sec;  //UTC time shift (added 16-June-2010)
            } //if date, time ---------------------------------------------------------
            else
                $value = $def_val;

            $par = "$name $value\n";
            if (fwrite($f, $par) == FALSE) {
                $ret = false;
                break;
            }
            $ii++;
        }
        fclose($f);
        if ($ret) {
            $msg = "Job ID=$job_id queued";
            $dir = $users_path;
            $ret = LogRecord($dir, "activity.log", $uuid, $msg);
        }
    } //if dir ok
    return $ret;
}

if (!isset($params_oper)) {
    $oper = $_POST['oper'];
    if (!isset($oper))
        $oper = $_GET['oper'];
    if (!isset($oper))
        $oper = $GLOBALS['oper'];
    if (!isset($oper))
        $oper = "goback";
}
else {
    $oper = $params_oper;
}
if ($oper == "goback") {
    echo "<script language='JavaScript' type='text/javascript'>window.location='$sweet_home';</script>";
    return;
}



require "./connect.php";
if (!$link) {
    echo "Could not connect : " . mysqli_error($link);
    return;
}
if (!mysqli_select_db($link, "livni")) {
    echo mysqli_errno($link) . ": " . mysqli_error($link);
    mysqli_close($link);
    return;
}

if ($oper == "save") {  //begin------------------------------------------------------------------------SAVE
    $i = 0;
    $task_id = $_POST['task_id'];
    $user_id = $_POST['user_id'];
    $job_status = 1; //pending
    $query = "INSERT INTO jobs (task_id,user_id,job_status,started) VALUES ($task_id, $user_id,$job_status,NOW())";
    $result = mysqli_query($link, $query);

    if (!$result) {
        echo mysqli_errno($link) . ": " . mysqli_error($link);
    } else {
        $job_id = mysqli_insert_id($link);
        $params = $_POST['params'];
        $n = count($params);
        $ii = 0;
        for ($i = 0; $i < $n; $i++) {
            $caption = $params[$i]['caption'];
            $name = $params[$i]['name'];
            $type = $params[$i]['type'];
            $def_val = $params[$i]['def_val'];
            if (!isset($def_val))
                $def_val = 0; //this if is for unset checkboxes (for shelkov)
            elseif ($def_val == 'none')
                $def_val = 0;
            $min_val = $params[$i]['min_val'];
            $max_val = $params[$i]['max_val'];
            $query = "INSERT INTO jobpars (job_id,task_id,caption,name,type,def_val,min_val,max_val) VALUES ($job_id,$task_id, '$caption','$name',$type,'$def_val','$min_val','$max_val')";
            $result = mysqli_query($link, $query);
            if (!$result)
                break;
            $ii++;
        }
        //increment tasks.popularity
        $query = "UPDATE tasks SET popularity=popularity+1 WHERE task_id=$task_id LIMIT 1";
        $result = mysqli_query($link, $query);
        SaveJob($job_id, $user_id);
    }
    $errno = 0;
    $error = "0";
    if (!$result) {
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
    }
    $ret = array('errno' => $errno, 'error' => $error, 'par_number' => $ii, 'job_id' => $job_id);
}//end--------------------------------------------------------------------------------------------------- SAVE

if ($oper == "list_pars") {
    $job_id = $_POST['job_id'];
    $query = "SELECT * FROM  jobpars WHERE job_id =$job_id";
    $result = mysqli_query($link, $query);
    $errno = 0;
    $error = "0";
    if (!$result) {
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
    }
    $rows = mysqli_num_rows($result);

    if ($rows) {
        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
            $rets[] = $row;
        }
	$task_id=$rets[0]['task_id'];
	mysqli_free_result($result);
	$query="SELECT caption FROM `tasks` WHERE task_id=$task_id";
	$result = mysqli_query($link, $query);	
	$task_capt = mysqli_fetch_array($result, MYSQL_ASSOC);
	mysqli_free_result($result);
	$query="SELECT jobs.*, users.first_name, users.last_name FROM `jobs`, `users` WHERE job_id=$job_id AND jobs.user_id=users.uuid";
	$result = mysqli_query($link, $query);
	$user_job_inf= mysqli_fetch_array($result, MYSQL_ASSOC);
    }
    $ret = array('errno' => $errno, 'error' => $error,'task_cap'=>$task_capt['caption'],'usrjobinfo'=>$user_job_inf, 'pars' => $rets);
}

$encode = json_encode($ret);

echo $encode;

mysqli_close($link);
?>