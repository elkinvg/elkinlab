<?php
//liv3tasks.php

require "connect.php";
require "config.inc.php";
require "errors.inc.php";

if ($err_no > 0){$ret = array('err_no' => $err_no, 'result' => $result); echo json_encode($ret); return;}

$ret=array();
$val=array();

$oper=$_POST['oper'];


if ($oper=="list")
{
  $query="SELECT * FROM tasks WHERE status=1 ORDER BY sequence ASC,popularity DESC";
  $res=mysql_query($query, $link);
  if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link);}
  else 
  {
    $rows=mysql_num_rows($res);
    if (!$rows) {$err_no=ERR_MYSQL_R; $result="wrong query or server error.";}
    else while($row = mysql_fetch_array($res, MYSQL_ASSOC)) {$val[]=$row;}
  }
  mysql_free_result($res);
}

else if ($oper=="params")
{
  $task_id=$_POST['task_id'];
  $query="SELECT * FROM taskpars WHERE task_id=$task_id ORDER BY par_id ASC";
  $res=mysql_query($query, $link);
  if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link);}
  else 
  {
    $rows=mysql_num_rows($res);
    if (!$rows) {$err_no=ERR_MYSQL_R; $result="wrong query or server error.";}
    else while($row = mysql_fetch_array($res, MYSQL_ASSOC)) {$val[]=$row;}
  }
  mysql_free_result($res);
}

else if ($oper=="listall")
{
  $query="SELECT * FROM tasks ORDER BY sequence ASC, popularity DESC";
  $res=mysql_query($query, $link);
  if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link);}
  else
  {
    $rows=mysql_num_rows($res);
    if (!$rows) {$err_no=ERR_MYSQL_R; $result="wrong query or server error.";}
    else while($row = mysql_fetch_array($res, MYSQL_ASSOC)) {$val[]=$row;}
  }
  mysql_free_result($res);
}

else if ($oper=="save")
{
  $task_id=$_POST['task_id'];
  $aparams=$_POST['aparams'];
  $atask=$_POST['atask'];
  
  foreach($atask as $task)  $$task['name'] = $task['value'];

  if ($task_id==0)$query="INSERT INTO tasks (app_name,par_number,caption,popularity,status,description_en,remark_en,description_ru,remark_ru,complexity,sequence) VALUES ('$app_name',$par_number,'$caption',$popularity,$status,'$description_en','$remark_en','$description_ru','$remark_ru',$complexity,$sequence)";
  else $query="UPDATE tasks SET app_name='$app_name', par_number=$par_number, caption='$caption', status=$status, popularity=$popularity, description_en='$description_en', remark_en='$remark_en',description_ru='$description_ru',remark_ru='$remark_ru',complexity=$complexity,sequence=$sequence WHERE task_id=$task_id LIMIT 1";

  $res=mysql_query($query, $link);
  if (!$res) {$err_no=ERR_MYSQL_Q; $result= mysql_errno($link). ": " . mysql_error($link);}

  if ($task_id==0)  $new_task_id=mysql_insert_id($link);
  
  if ($err_no==ERR_NONE)
  {
   $ok=true;
   if ($task_id > 0) //tidy up:
   {
     $query="DELETE FROM taskpars WHERE task_id=$task_id";	 //first delete all:
     $res=mysql_query($query, $link);
     if (!$res) $ok=false;
   }
   else $task_id=$new_task_id;
   
   if ($ok==true)	  //now add:
   {
     foreach ($aparams as $param)
     {
       $caption=$param['caption'];
       $name=$param['name'];
       $type=$param['type'];
       $def_val=$param['def_val'];
       $min_val=$param['min_val'];
       $max_val=$param['max_val'];
       $par_id=$param['par_id'];
       $query="INSERT INTO taskpars (par_id,task_id,caption,name,type,def_val,min_val,max_val) VALUES ($par_id,$task_id,'$caption','$name',$type,'$def_val','$min_val','$max_val')";
       $res=mysql_query($query, $link);
       if (!$res) break;
      }
    }
    if (!$res) {$err_no=ERR_MYSQL_Q; $result= mysql_errno($link). ": " . mysql_error($link);}
  }
}

else if ($oper=="delete")
{
  $adeltasks=$_POST['adeltasks'];
 	foreach($adeltasks as $task_id)
 	{
 	 $query="DELETE FROM tasks,taskpars USING tasks,taskpars WHERE tasks.task_id=$task_id AND taskpars.task_id=$task_id";
   $res=mysql_query($query, $link);
   if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link); break;}
  }
}

else if ($oper=="load")
{
  $task_id=$_POST['task_id'];
  $params=array();
  if ($task_id==0)//
  {
    $v=array(0,'User friendly task name','application (executable name)',TASK_PARAMS_MIN,0,0,0,1000,'some description in English','some remark in English','описание на русском','ремарка на русском');
    $params[]=array('caption' => 'Comments', 'name' => 'COMMENT', 'type' => 1, 'def_val' =>'', 'min_val'=>'', 'max_val'=>'', 'par_id' => 1, 'task_id' => 0);
    $params[]=array('caption' => 'Select from', 'name' => 'START_TIME', 'type' => 2, 'def_val' =>'', 'min_val'=>'2009-05-07', 'max_val'=>'', 'par_id' => 1, 'task_id' => 0);
    $params[]=array('caption' => 'Select till', 'name' => 'END_TIME', 'type' => 2, 'def_val' =>'', 'min_val'=>'', 'max_val'=>'', 'par_id' => 1, 'task_id' => 0);
  }
  else
  {
    $query="SELECT * FROM tasks WHERE task_id=$task_id LIMIT 1";
    $res=mysql_query($query, $link);
    if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link);}
    else 
    {
      $row = mysql_fetch_array($res, MYSQL_ASSOC);
      $v=array($task_id,$row['caption'],$row['app_name'],$row['par_number'],$row['status'],$row['popularity'],$row['complexity'],$row['sequence'],$row['description_en'],$row['remark_en'],$row['description_ru'],$row['remark_ru']);
      mysql_free_result($res);
    }    
    if ($err_no==ERR_NONE) //load parameters
    {
      $query="SELECT * FROM taskpars WHERE task_id=$task_id ORDER BY par_id ASC";
      $res=mysql_query($query, $link);
      if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link);}
      else 
      {
        $rows=mysql_num_rows($res);
        if (!$rows) {$err_no=ERR_MYSQL_R; $result="wrong query or server error.";}
        else while($row = mysql_fetch_array($res, MYSQL_ASSOC)) {$params[]=$row;}
        mysql_free_result($res);
      }    
    }
  }
  $n=0;
  $val[]=array('caption' => 'Task ID', 'name' => 'task_id', 'value' => $v[$n++]);
  $val[]=array('caption' => 'Task name', 'name' => 'caption', 'value' => $v[$n++]);
  $val[]=array('caption' => 'Application name', 'name' => 'app_name', 'value' => $v[$n++]);
  $val[]=array('caption' => 'Param. number', 'name' => 'par_number', 'value' => $v[$n++]);
  $val[]=array('caption' => 'Task status', 'name' => 'status', 'value' => $v[$n++]);
  $val[]=array('caption' => 'Popularity', 'name' => 'popularity', 'value' => $v[$n++]);
  $val[]=array('caption' => 'Complexity', 'name' => 'complexity', 'value' => $v[$n++]);
  $val[]=array('caption' => 'Sequence', 'name' => 'sequence', 'value' => $v[$n++]);
  $val[]=array('caption' => 'Description (en)', 'name' => 'description_en', 'value' => $v[$n++]);
  $val[]=array('caption' => 'Remark (en)', 'name' => 'remark_en', 'value' => $v[$n++]);
  $val[]=array('caption' => 'Description (ru)', 'name' => 'description_ru', 'value' => $v[$n++]);
  $val[]=array('caption' => 'Remark (ru)', 'name' => 'remark_ru', 'value' => $v[$n++]);  
  $ret = array('err_no' => $err_no, 'result' => $result, 'val' => $val, 'params' => $params);
}

mysql_close($link);
if (count($ret)==0) $ret = array('err_no' => $err_no, 'result' => $result, 'val' => $val);
echo json_encode($ret);  
?>