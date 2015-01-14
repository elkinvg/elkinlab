<?php
//liv3journal.php

require "connect.php";
require "config.inc.php";
require "errors.inc.php";

if ($err_no > 0){$ret = array('err_no' => $err_no, 'result' => $result); echo json_encode($ret); return;}

$ret=array();
$val=array();

$oper=$_POST['oper'];


if ($oper=="list")
{
  $from=$_POST['from'];
  $upto=$_POST['upto'];
  $where_clase = "UNIX_TIMESTAMP(timestamp) >= $from AND UNIX_TIMESTAMP(timestamp) <= $upto";
  $query="SELECT * FROM logbook WHERE $where_clase ORDER BY timestamp ASC";
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
  $recid=$_POST['recid'];
  $aparams=$_POST['aparams'];
  $comment=$_POST['comment'];
  
  if ($recid==0) $query="INSERT INTO logbook (lnp1,status1,lnp2,status2,lnp3,status3,lnp4,status4,lnp5,status5,lnp6,status6,lnp7,status7,lnp8,status8,lnp9,status9,comment,timestamp) VALUES ('{$aparams[0][lnp]}',{$aparams[0][status]},'{$aparams[1][lnp]}',{$aparams[1][status]},'{$aparams[2][lnp]}',{$aparams[2][status]},'{$aparams[3][lnp]}',{$aparams[3][status]},'{$aparams[4][lnp]}',{$aparams[4][status]},'{$aparams[5][lnp]}',{$aparams[5][status]},'{$aparams[6][lnp]}',{$aparams[6][status]},'{$aparams[7][lnp]}',{$aparams[7][status]},'{$aparams[8][lnp]}',{$aparams[8][status]},'$comment',NOW())";
  else 
  {
    $q="";
    foreach($aparams as $record)
    {
    	$station=$record["station"];
      $lnp=$record["lnp"];
      $status=$record["status"];
      $q.="lnp$station='$lnp', status$station=$status,";
    }
    $q.="comment='$comment'";
    $query="UPDATE logbook SET $q WHERE recid=$recid LIMIT 1";
  }
  
  $res=mysql_query($query, $link);
  if (!$res) {$err_no=ERR_MYSQL_Q; $result= mysql_errno($link). ": " . mysql_error($link);}
  if ($recid==0)  $new_recid=mysql_insert_id($link);  
}

else if ($oper=="delete")
{
  $adelrecords=$_POST['adelrecords'];
 	foreach($adelrecords as $recid)
 	{
 	 $query="DELETE FROM logbook WHERE recid=$recid";
   $res=mysql_query($query, $link);
   if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link); break;}
  }  
}

else if ($oper=="load")
{
  $recid=$_POST['recid'];
  $params=array();
  if ($recid==0)//
  {
    $val=array("lnp1" => '', "status1" => 3,"lnp2" => '', "status2" => 3,"lnp3" => '', "status3" => 3,"lnp4" => '', "status4" => 3,"lnp5" => '', "status5" => 3,"lnp6" => '', "status6" => 3,"lnp7" => '', "status7" => 3,"lnp8" => '', "status8" => 3,"lnp9" => '', "status9" => 3);
  }
  else
  {
    $query="SELECT * FROM logbook WHERE recid=$recid LIMIT 1";
    $res=mysql_query($query, $link);
    if (!$res) {$err_no=mysql_errno($link); $result=mysql_error($link);}
    else 
    {
      $val = mysql_fetch_array($res, MYSQL_ASSOC);
      mysql_free_result($res);
    }    
  }
}

mysql_close($link);
if (count($ret)==0) $ret = array('err_no' => $err_no, 'result' => $result, 'val' => $val);
echo json_encode($ret);  
?>