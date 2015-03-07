<?php

require "./connect.php";

if (!$link) {echo "Could not connect: " .mysql_error(); return;}
if (!mysql_select_db("livni", $link)) {echo mysql_errno($link) . ": " . mysql_error($link);mysql_close($link); return;}

if ($debug) {
mysql_query('SET NAMES "utf8"', $link);
mysql_query("set character_set_connection=utf8"); 
mysql_query("set names utf8");
}

if ($oper=="listall")//begin------------------------------------------------------------------------LISTALL
{
  $user_type = my_getcookie("utype");
  if ($user_type=="admin" || $user_type=="expert")
    $query="SELECT * FROM tasks ORDER BY sequence ASC,popularity DESC";
  else  
    $query="SELECT * FROM tasks WHERE status=1 ORDER BY sequence ASC,popularity DESC";
  $result=mysql_query($query, $link);
  if (!$result) {echo mysql_errno($link) . ": " . mysql_error($link); return;}	
  $rows=mysql_num_rows($result);
  while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
  {
     $ret[]=$row;
  }
  mysql_free_result($result);
}//end---------------------------------------------------------------------------------------------------LISTALL

else if ($oper=="list")//begin------------------------------------------------------------------------LIST
{
  $query="SELECT * FROM tasks WHERE status=1 ORDER BY sequence ASC,popularity DESC";
  $result=mysql_query($query, $link);
  if (!$result) {echo mysql_errno($link) . ": " . mysql_error($link); return;}	
  $rows=mysql_num_rows($result);
  while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
  {
     //$ret[]=array('caption' => $row['caption'], 'popularity' => $row['popularity']);
     $ret[]=$row;
  }
  mysql_free_result($result);
}//end---------------------------------------------------------------------------------------------------LIST
?>
