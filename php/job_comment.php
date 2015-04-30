<?php

error_reporting(0);
global $users_path;
if (!empty($_POST['jid'])) {$job_id = $_POST['jid'];}
if (!empty($_POST['uid'])) {$user_id = $_POST['uid'];}
if (!empty($_POST['aid'])) {$a_id = $_POST['aid'];}
if (!empty($_POST['text'])) {$text = $_POST['text'];}
if (!empty($_POST['oper'])) {$oper = $_POST['oper'];}
$postprefix = "#%&";
$dir = $_SERVER['DOCUMENT_ROOT'] . "/users/" . "$user_id/jobs/$job_id";
$filed = $dir . "/descr.txt";
//$job_path = $_SERVER['DOCUMENT_ROOT'] . "/users/" . $user_id . "/jobs/" . $jobnum . "/";
if ($oper == "write") {

    $beg_tag = $postprefix . $a_id . "begin";
    $end_tag = $postprefix . $a_id . "end";
    if (file_exists($filed)) {
	$div_conts = file($filed);
	$ii = 0;
	$ib = 0;
	$ie = 0;
	foreach ($div_conts as $div_cont) {
	    if (substr_count($div_cont, $beg_tag) > 0)
		$ib = $ii;
	    if (substr_count($div_cont, $end_tag) > 0)
		$ie = $ii;
	    $ii++;
	}

	if ($ie > 0) {
	    for ($iter = $ie; $iter >= $ib; $iter--) {
		//unset($div_conts[$ib]);
		//unset($div_conts[$ie]);
		unset($div_conts[$iter]);
	    }
	    $f = fopen($filed, "w");
            if (!$f) {fclose($f);return false;}
	    $write_text = $beg_tag . "\n" . $text . "\n" . $end_tag . "\n";
	    $write_text = $write_text . implode("", $div_conts);
	    fwrite($f, $write_text);
	    fclose($f);
	} else {
	    $f = fopen($filed, "a");
	    if (!$f) {fclose($f);return false;}
	    $write_text = $beg_tag . "\n" . $text . "\n" . $end_tag . "\n";
	    fwrite($f, $write_text);
	    fclose($f);
	}
    }
    else {
	$f = fopen($filed, "w");
	if (!$f) {fclose($f);return false;}
	$write_text = $beg_tag . "\n" . $text . "\n" . $end_tag . "\n";
	fwrite($f, $write_text);
	fclose($f);
    }
    $aaaa = 1;
//        $f = fopen($filed,"a+");  if (!$f) return false;
//	
//	$write_text= $beg_tag . "\n" . $text . "\n" . $end_tag . "\n";
//        fwrite( $f,$write_text);
//        fclose($f);
}
elseif ($oper == "read") {
    if (file_exists($filed))
    {
	$div_conts = file($filed);
	$out_text ="";
	foreach ($div_conts as $div_cont)
	{
	    if (substr_count($div_cont, $postprefix) == 0) $out_text = $out_text.$div_cont;	    
	}
	echo $out_text;
    }
}

//if (!file_exists($filed))
?>

