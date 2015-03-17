<?php

//log user activity
$log_inc=true;

if (!isset($users_path)) $users_path= "/projects/livni/users";	//the same must be in common.php
//if (!isset($users_path)) $users_path = "h:/Livni/users";

function LogRecord($dir,$fname,$uuid,$msg)
{
  //user dir:
  $log_file = "$dir/$uuid/$fname";
  $notnew = file_exists($log_file);
  $log = fopen($log_file,"a+");  if (!$log) return false;
  $format = '%d.%m.%Y %H:%M:%S';
  $strf = strftime($format);
  $record = "$strf $msg\n"; 
  fwrite($log,$record);
  fclose($log);
  if ($notnew==false) chmod($log_file, 0666);

  //common dir:
  $dt = time();
  $log_file = "$dir/$fname";
  $notnew = file_exists($log_file);
  $log = fopen($log_file,"a+");  if (!$log) return false;
  $record = "$dt;$uuid;$msg\n"; 
  fwrite($log,$record);
  fclose($log);
  if ($notnew==false) chmod($log_file, 0666);

  return true;
}

?>