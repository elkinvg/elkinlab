<?php

//taskpars: handles the 'livni.taskpars' table. Following is the list of functions currently supported:
//oper={load, modify} note: load requires $ret global
if (!isset($params_oper)) {
    $oper = $_POST['params_oper'];
}

$task_id = $_POST['params_task_id'];
//echo "<p>TASK_ID = $task_id</p><br>"; // for debug

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

if ($oper == "modify") {
    
}
else if ($oper == "load") {
    $ret = array();
    $query = "SELECT * FROM taskpars WHERE task_id=$task_id ORDER BY par_id ASC";
    //echo "QUERY:  $query \n       "; //for debug
    $result = mysqli_query($link, $query);
    if (!$result) {
        echo mysqli_errno($link) . ": " . mysqli_error($link);
        return;
    }

    $rows = mysqli_num_rows($result);
    $ret = array();
    if ($rows) {
        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
//       $ret[]=array('caption' => $row['caption'], 'name' => $row['name'],  'type' => $row['type'],  'def_val' => $row['def_val'],  'min_val' => $row['min_val'],  'max_val' => $row['max_val']);
            $ret[] = $row;
        }
    }
}
else if ($oper=="save") 	//begin------------------------------------------------------------------------SAVE
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
        //SaveJob($job_id,$user_id);
    }
    if (!$result) {echo mysqli_errno($link) . ": " . mysqli_error($link);}	
    $ret[] = array('par_number' => $i, 'job_id' => $job_id);
}//end--------------------------------------------------------------------------------------------------- SAVE

echo json_encode($ret);

mysqli_close($link);
?>

