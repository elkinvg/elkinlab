<?php

global $pp;


echo "<link href='" . $pp . "css/common.css' rel='stylesheet' type='text/css' />";
require $pp . "lang/$context[lang]/msg.inc.php";
require $pp . "lang/$context[lang]/dic.inc.php";
echo "<link href='" . $pp . "css/jquery.fancybox.css' rel='stylesheet' type='text/css' />";
echo "<script type='text/javascript' src='" . $pp . "js/jquery/jquery.fancybox.pack.js'></script>\n";
?>
<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>       
<?php
//lang-dependent:
//        require "../lang/$context[lang]/msg.inc.php";
//        require "../lang/$context[lang]/dic.inc.php";


echo "<title>$dic[livni_logo] $dic[labs_logo]</title>";

function pHeader($logo) {
    global $proj_home, $sweet_home, $dic, $pp;
    //echo "<tr><td colspan=2 class='ui-widget-header ui-corner-top pheader' align=left>";
    echo "<div class='ui-widget pmain'>";
    echo "<div class='ui-widget-header ui-corner-top ppheader' align=left>";
    echo "<span class=logo><a href='$proj_home' target='_blanc' title='$dic[livni_logo_tt]' id='proj_home'>$dic[livni_logo]</a></span>"; //  : $dic[jobs_title]
    echo "<a href=" . $pp . " title='$dic[labs_logo_tt]' id='labs_home'><span class=logo_labs_main>$dic[labs_logo]</span></a>";
    echo $logo;
    //echo "<span class=logo_labs>: $dic[jobs_list]</span>";
    echo "</div>";

//    echo "<div class='psize'></div>";
    echo "<div class='pppanel'>";
//	echo "<div class='psize'></div>";
    //echo "</td></tr>";
}

function pFooter() {
    global $dic, $stations_status,$pp;
    echo "</div >";
//    echo "<tr><td class='ui-widget-content ui-corner-bottom pfooter' colspan=2 align=right><a href='#' class='tt_switch' status=1 title='$dic[help_off_title_tt]'>$dic[help_off_title]</a></td></tr>";
    $status = StationsStatus($stations_status);
    sort($status);
    echo "<div class='ui-widget-header ui-corner-bottom ppfooter'>";
    echo "<table width='100%'>";
    echo "<tr>";
    foreach ($status as $st) {
	if ($st['ping'] == $st['data'] && $st['ping'] == $st['daq'] && $st['ping'] == 0)
	    echo "<td class='stations' id='Station_$st[id]'><a class='fancybox' href='".$pp."images/stations/Station_$st[id].png'>$st[id] <span style='color: green; font-size:120%'>&#9679</span> </a></td>";
	else
	    echo "<td class='stations' id='Station_$st[id]'><a class='fancybox' href='".$pp."images/stations/Station_$st[id].png'>$st[id] <span class='status_st' style='color: red; font-size:120%'>&#9679</span> </a></td>";
    }
    echo "</tr>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
}

function StationsStatus($fname) {
    $astatus = array();
    $f = fopen($fname, "r");
    if ($f) {
	$station_id = $ping_ok = $daq_ok = $data_ok = $age = $ts = 0;
	while (!feof($f)) {
	    $s = fgets($f, 64);
	    if ($s) {
		list($station_id, $ping_ok, $daq_ok, $data_ok, $age, $ts) = explode(" ", $s); //ts =>  timestamp of the last data transmittion !!!!!
		//$id = substr($station_id,3,1);
		$id = explode("LNP", $station_id);
		$ts = mktime(substr($ts, 8, 2), substr($ts, 10, 2), 0, substr($ts, 4, 2), substr($ts, 6, 2), substr($ts, 0, 4));
		$ts = date("Y-m-d H:i", $ts);

		$astatus[$id[1]] = array("id" => $id[1], "ping" => $ping_ok, "daq" => $daq_ok, "data" => $data_ok, "age" => $age, "ts" => $ts);
	    }
	}
	fclose($f);
    } else
	fclose($f);
    return $astatus;
}
