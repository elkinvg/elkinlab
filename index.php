<?php
$indexdir = true;
require './php/common_page.inc.php';
?>

<html><head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="keywords" content="free open interactive project for cosmic showers particles detectors detecting labs"/>
<meta name="description" content="This is an open free interactive project for cosmic showers particles detecting and accompanying physics studying"/>
<meta name="robots" content="all"/>
<meta http-equiv="expires" content="0"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="cache-control" content="no-cache"/>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<!--<link href="css/common.css" rel="stylesheet" type="text/css">-->
<!--<script src='js/common.js' type='text/javascript'></script>-->


<!--<script type='text/javascript' src='js/jquery/jquery-2.1.3.min.js'></script>
<link type='text/css' href='js/jquery/jquery-ui-1.11.3/themes/sunny/jquery-ui.css' rel='stylesheet' />
<script type='text/javascript' src='js/jquery/jquery-ui-1.11.3/external/jquery/jquery.js'></script>
<script type='text/javascript' src='js/jquery/jquery-ui-1.11.3/jquery-ui.js'></script>-->
<!--<script type='text/javascript' src='js/main.js'></script>-->
<?php
//require './php/js.inc.php';
$nprhead=true;
require './php/common_page.inc.php';

echo "<script type='text/javascript' src='js/main.js'></script>";
//require "php/config.inc.php";
//require "lang/$context[lang]/dic.inc.php";
//vars2js();
echo "<title>$dic[livni_logo] $dic[labs_logo]</title>";
?>

<!--<style>
    /* common.css */
 a {text-decoration: none; font-weight: bold;} 
 body {margin: 0;}
.nobr {display: inline-block;}
.blind {display: none;}
.pheader{height: 30;}
.pfooter{height: 30;}
.pfooter_on{color: green;}
.pfooter_off{color: red;}
.pcontrol{width: 40%;}
.pview{width: 60%;}
.jcontrol{width: 20%;}
.jview{width: 80%;}
.ui-tooltip {max-width: 300px;}
.logo {font-size: 22px; font-weight: bolder; margin-left: 30px;}
.logo_labs {font-size: 22px; font-weight: bold; font-style: italic; margin-left: 5px;color: #FF0000;}
.radiosel, .info, .parameters {font-size: 0.7em};
.tabrow {white-space: nowrap;}
.st_ok {font-weight: bolder; color: green;}
.st_fail {font-weight: bolder; color: red;}
</style>-->

</head>

<body>
<script language='JavaScript' type='text/javascript'>
//if (context.utype=="visitor") window.location=proj_home;
</script>

<?php
require "php/main.php";
RenderMain();
?>
<div id=dlgm class=blind><p><span class='ui-icon ui-icon-circle-check' style='float:left; margin:0 7px 50px 0;'></span>hell o</p></div>
</body>
</html>