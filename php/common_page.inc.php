<?php
if(!isset($indexdir)) {$pp="../"; $pc="./";}
else {$pp="./";$pc="./php/";}
if(!isset($nprhead))
{
    include $pp."tmp/debug.inc.php";
    require $pp."php/config.inc.php";
}
else {
    require $pc."js.inc.php";
    require $pc."oth.inc.php";
}


?>