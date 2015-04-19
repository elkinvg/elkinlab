<?php
global $pp;
include $pp."tmp/debug.inc.php";
require $pp."php/config.inc.php";
echo "<link href='".$pp."css/common.css' rel='stylesheet' type='text/css' />";
require $pp."lang/$context[lang]/msg.inc.php";
require $pp."lang/$context[lang]/dic.inc.php";


//lang-dependent:
//        require "../lang/$context[lang]/msg.inc.php";
//        require "../lang/$context[lang]/dic.inc.php";


echo "<title>$dic[livni_logo] $dic[labs_logo]</title>";

function pHeader($logo) {
    global $proj_home, $sweet_home, $dic,$pp;
    //echo "<tr><td colspan=2 class='ui-widget-header ui-corner-top pheader' align=left>";
    echo "<div class='ui-widget pmain'>";
    echo "<div class='ui-widget-header ui-corner-top ppheader' align=left>";
    echo "<span class=logo><a href='".$pp."/php/debuginfo-page.php' title='$dic[livni_logo_tt]' id='proj_home'>$dic[livni_logo]</a></span>"; //  : $dic[jobs_title]
    echo "<a href=".$pp." title='$dic[labs_logo_tt]' id='labs_home'><span class=logo_labs_main>$dic[labs_logo]</span></a>";
    echo $logo;
    //echo "<span class=logo_labs>: $dic[jobs_list]</span>";
    echo "</div>";

//    echo "<div class='psize'></div>";
    echo "<div class='pppanel'>";
//	echo "<div class='psize'></div>";
    //echo "</td></tr>";
}

function pFooter() {
    global $dic;
    echo "</div >";
//    echo "<tr><td class='ui-widget-content ui-corner-bottom pfooter' colspan=2 align=right><a href='#' class='tt_switch' status=1 title='$dic[help_off_title_tt]'>$dic[help_off_title]</a></td></tr>";
    echo "<div class='ui-widget-header ui-corner-bottom ppfooter' align=right></div>";
    echo "</div>";
}

function StationsStatus($fname, $nStations)
{
  $astatus=array();
  $f=  fopen($fname,"r");
  if ($f)
  {
   while (!feof($f))
   {
     $s = fgets($f, 64);
     list($station_id,$ping_ok,$daq_ok,$data_ok,$age,$ts)=explode(" ",$s,6); //ts =>  timestamp of the last data transmittion !!!!!
     $id = substr($station_id,3,1);

     $ts = mktime(substr($ts,8,2),substr($ts,10,2),0,substr($ts,4,2),substr($ts,6,2),substr($ts,0,4));
     $ts=date("Y-m-d H:i",$ts);

     $astatus[$id] = array("ping" => $ping_ok, "daq" => $daq_ok, "data" =>$data_ok, "age" => $age, "ts" => $ts);
    }
    fclose($f);
	}
  return $astatus;
}