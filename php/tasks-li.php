<?php

require "./connect.php";

if (!$link) {echo "Could not connect: " .mysql_error(); return;}
//if (!mysql_select_db("livni", $link)) {echo mysql_errno($link) . ": " . mysql_error($link);mysql_close($link); return;}
if (!mysqli_select_db($link,"livni")){echo mysqli_errno($link) . ": " . mysqli_error($link);mysqli_close($link); return;}

if ($debug) {
mysqli_query( $link,'SET NAMES "utf8"');
mysqli_query( $link,"set character_set_connection=utf8"); 
mysqli_query( $link,"set names utf8");
}

if ($oper=="listall")//begin------------------------------------------------------------------------LISTALL
{
  //$user_type = my_getcookie("utype");
  $user_type = $context['utype'];
  if ($user_type=="admin" || $user_type=="expert")
    $query="SELECT * FROM tasks ORDER BY sequence ASC,popularity DESC";
  else  
    $query="SELECT * FROM tasks WHERE status=1 ORDER BY sequence ASC,popularity DESC";
  $result=mysql_query($link, $query);
  if (!$result) {echo mysqli_errno($link) . ": " . mysqli_error($link); return;}	
  $rows=mysqli_num_rows($result);
  while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) 
  {
     $ret[]=$row;
  }
  mysqli_free_result($result);
}//end---------------------------------------------------------------------------------------------------LISTALL

else if ($oper=="list")//begin------------------------------------------------------------------------LIST
{
  $query="SELECT * FROM tasks WHERE status=1 ORDER BY sequence ASC,popularity DESC";
  $result=mysqli_query( $link, $query);
  if (!$result) {echo mysqli_errno($link) . ": " . mysqli_error($link); return;}	
  $rows=mysqli_num_rows($result);
  while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) 
  {
     //$ret[]=array('caption' => $row['caption'], 'popularity' => $row['popularity']);
     $ret[]=$row;
  }
  mysqli_free_result($result);
}//end---------------------------------------------------------------------------------------------------LIST
?>
