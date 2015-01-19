<?php
//v3 started: 10-January-2013
//v3 last changes: 21-October-2014
$debug=false;

if ($debug==true)
{
	$proj_home="http://livni.labs";
  $sweet_home=$proj_home;
}
else 
{
	$proj_home="http://eas.jinr.ru";
  $sweet_home=$proj_home."/labs";
}

$stations_status="/projects/livni/software/eas.cron.d/status.dat";

$users_home= $proj_home."/users";
$users_path= "/projects/livni/users";
$fname="params.txt";

//project
define("PROJ", "livni");
define("PROJ_V", 3.0);
define("PROJ_NAME", "Livni");

//stations:
define("STATIONS_NUMBER", 9);

//layout
define("JOBS_LIST_MAX", 300);
define("TASK_PARAMS_MIN", 3);
define("TASK_PARAMS_MAX", 20);

$locations = array(
array('station_id' => 1,  'latitude' => "56:44.53475", 'longitude' => "37:11.32134", 'altitude' =>125),
array('station_id' => 2,  'latitude' => "56.739051",   'longitude' => "37.190603", 'altitude' =>147),
array('station_id' => 3,  'latitude' => "56.741110", 'longitude' => "37.191407", 'altitude' =>132),
array('station_id' => 4,  'latitude' => "56:44.53931", 'longitude' => "37:11.39153", 'altitude' =>137),
array('station_id' => 5,  'latitude' => "56.739941",   'longitude' => "37.189848", 'altitude' =>145), 
array('station_id' => 6,  'latitude' => "56:44.52598", 'longitude' => "37:11.57898", 'altitude' =>140),
array('station_id' => 7,  'latitude' => "56:44.51821", 'longitude' => "37:11.45461", 'altitude' =>127),
array('station_id' => 8,  'latitude' => "??", 'longitude' => "??", 'altitude' =>"??"),
array('station_id' => 9,  'latitude' => "56.741422", 'longitude' => "37.190201", 'altitude' =>131)
);

//<COOKIES>
$cookie_prefix=PROJ."_";	//see common.js
$now=time();
$exp_day = $now+86400;
$exp_year = $now+31536000;
function my_setcookie($name, $value, $expires){return setcookie($GLOBALS['cookie_prefix'].$name,$value,$expires,"/");}
function my_delcookie($name){return setcookie ($GLOBALS['cookie_prefix'].$name, "undefined", $now - 3600,"/");}
function my_getcookie($name){return $_COOKIE[$GLOBALS['cookie_prefix'].$name];} 
//context:
$context['uuid']=my_getcookie("uuid"); if (!isset($context['uuid'])) $context['uuid']=0;
$context['user']=my_getcookie("user"); if (!isset($context['user'])) $context['user']="anonymous";
$context['utype']=my_getcookie("utype"); if (!isset($context['utype'])) $context['utype']="visitor";
$context['visits']=my_getcookie("visits"); if (!isset($context['visits'])) $context['visits']=-1;
$context['jobs']=my_getcookie("jobs"); if (!isset($context['jobs'])) $context['jobs']=0;
$context['lang']=my_getcookie("lang"); if (!isset($context['lang'])) $context['lang']="en";
//</COOKIES>

<DEBUG>
$context['lang']='ru';
</DEBUG>

function vars2js()
{
global $sweet_home, $proj_home;
echo "<script language='JavaScript' type='text/javascript'>";
echo "var proj_home='".$proj_home."';";
echo "var sweet_home='".$sweet_home."';";
echo "var PROJ='".PROJ."';";
echo "var PROJ_V=".PROJ_V.";";
echo "var PROJ_NAME='".PROJ_NAME."';";
echo "var JOBS_LIST_MAX=".JOBS_LIST_MAX.";";
echo "var TASK_PARAMS_MIN=".TASK_PARAMS_MIN.";";
echo "var TASK_PARAMS_MAX=".TASK_PARAMS_MAX.";";
echo "var STATIONS_NUMBER=".STATIONS_NUMBER.";";
echo "</script>";
}

?>