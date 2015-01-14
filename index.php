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

<link href="css/common.css" rel="stylesheet" type="text/css">
<script src='js/common.js' type='text/javascript'></script>
<script src='js/jquery/jquery.js' type='text/javascript'></script>
<script src='js/jquery/jquery-ui.js' type='text/javascript'></script>
<link href='css/jquery/pepper-grinder/jquery-ui.css' rel='stylesheet' type='text/css'>

<?php
require "php/config.inc.php";
require "lang/$context[lang]/dic.inc.php";
vars2js();
echo "<title>$dic[livni_logo] $dic[labs_logo]</title>";
?>

<script type='text/javascript' src='js/main.js'></script>
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
