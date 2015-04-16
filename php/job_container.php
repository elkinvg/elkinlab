<html>
    <head>
        <meta http-equiv="content-type" content="text/html"/>
        <meta name="keywords" content="Cosmic, rays, showers, detecting..."/>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="robots" content="all"/>
        <meta http-equiv="expires" content="0"/>
        <meta http-equiv="pragma" content="no-cache"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <?php
        require "./common_page.inc.php";
        global $dic;
        $jobnum = null;
        $user_id = null;
        if (!empty($_GET['job_id'])) {
            $jobnum = $_GET['job_id'];
            $jobnum_head = $jobnum;
        } else {
            $jobnum_head = $dic['job_container_nf'];
        }
        if (!empty($_GET['user_id'])) $user_id = $_GET['user_id'];
        ?>
<!--        <script type='text/javascript'>
            $(document).ready(function () {
                
        var job_id=getUrlVars()["job_id"];
        var task_id = getUrlVars()["task_id"];
        var user_id = getUrlVars()["user_id"];
        var utype = getUrlVars()["utype"];
        var job_status = getUrlVars()["job_status"];


        
        function getUrlVars()
                {
                    var vars = [], hash;
                    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                    for (var i = 0; i < hashes.length; i++)
                    {
                        hash = hashes[i].split('=');
                        vars.push(hash[0]);
                        vars[hash[0]] = hash[1];
                    }
                    return vars;
                } // getURLvars
                
            });
        </script>-->
    </head>
    <body>
        <div id="errordiv"></div>
        <?php Rendermain(); ?>
    </body>
</html>

<?php

function Rendermain() {
    global $dic, $jobnum_head;

    $head_txt = "<span class=logo_labs>: " . $dic['job_container'] . $jobnum_head . "</span>";
    pHeader($head_txt);
    Control();
    View();

    pFooter();
}

function Control() {
    echo "<div class='ui-widget-content ppcontrol' align=center valign=top>";
//    echo "<div class='pform ui-dialog ui-corner-all' id='pform'>";
//    echo "<form name='set_form' action='' method='post'>";
//    echo "<fieldset>";
//    echo "<input type='text' id='data_beg' class='my-datepicker' readonly value=''>";
//    echo "<input type='text' id='data_end' class='my-datepicker' readonly value=''>";
//    echo "<input type='button' name='cost_b' id='cost_b' class='but' value='Обновить'>";
//    echo "</fieldset>";
//    echo "</form>";
//    echo "</div>";
    echo "</div>";
}

function View() {
    global $jobnum,$user_id,$job_id;
    echo "<div class='ui-widget-content ppview' position=relative valign=top>";

    if (!$jobnum) {echo "<div class='center'> Job not found </div></div>";return;}
    
    $job_path= $_SERVER['DOCUMENT_ROOT']."/users/".$user_id."/jobs/".$jobnum."/";
    $web_job_path = $_SERVER['SERVER_NAME']."/users/".$user_id."/jobs/".$jobnum."/";
    
    $report = $job_path."report_$job_id.html";
 
    if(file_exists($job_path)) $files = scandir($job_path);
    else {echo "<div class='center'> Job not found </div></div>";return;}
//     $files = glob("*.php");
//    print_r($_SERVER);
//    echo "<br>----------------1----------------------------<br>";
//    print_r($files);
    $csv_files = array();
    $png_files = array();
    $txt_files = array();
    
//    if (!count($txt_files)) echo "SIZE=".count($txt_files)."<br>";
    
    foreach ($files as $file)
    {
	if (pathinfo($file, PATHINFO_EXTENSION) == "csv") $csv_files[] = $file;
	if (pathinfo($file, PATHINFO_EXTENSION) == "png") $png_files[] = $file;
	if (pathinfo($file, PATHINFO_EXTENSION) == "txt") $txt_files[] = $file;
    }
//    echo "<br>";
//    echo "numofpng = ".  count($png_files)."<br>";
//    echo "---------------------2-----------------------<br>";
    //preg_match_all('/(img|src)=("|\')[^"\'>]+/i', $files, $media);
//    $pict = glob($job_path."*png");
//    echo $web_job_path."<br>";
//    echo "---------------------3-----------------------<br>";
    //print_r($media);
    foreach ($png_files as $png_file)
    {
	$png = "http://".$web_job_path.$png_file;
//	echo $png;
	echo "<center><p><img src='$png' ></p></center>";
    }
//    print_r($_REQUEST);


    echo "</div>";
}
?>