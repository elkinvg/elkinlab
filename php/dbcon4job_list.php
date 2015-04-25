<?php

error_reporting(0);

require './connect.php';

$result = "ok";
$err_no = 0;

if (!$link) {
    $result = mysqli_error($link);
    $err_no = mysqli_errno($link);
}
if (!mysqli_select_db($link, "livni")) {
    $err_no = mysqli_errno($link);
    $result = mysql_error($link);
    mysqli_close($link);
}

if ($err_no > 0) {
    $ret = array('err_no' => $err_no, 'result' => $result);
    echo json_encode($ret);
    return;
}

//if (isset($context['uuid'])) 
//    $ouuid = $context['uuid'];
//else  $ouuid=0;
$oper = $_POST['oper'];
if (empty($oper))
    return;
$cookie_prefix = $_POST['cookie_prefix'];

$ret = array();
$out = null;
$ouuid = $_COOKIE[$cookie_prefix . 'uuid'];
$utype = $_COOKIE[$cookie_prefix . 'utype'];



if ($oper == "first") {
    if (empty($ouuid) || empty($utype)) {
	$out = array('err_no' => '-1', 'result' => 'No cookies for uuid or utype');
	$jsen = json_encode($out);
	echo $jsen;
	return;
    }
    $params = $_POST['params'];

    $select = "SELECT jobs.*, tasks.caption, jobpars.def_val, users.utype, users.first_name, users.last_name FROM jobs, jobpars, tasks, users  ";
    $join = " jobs.job_id=jobpars.job_id AND jobpars.name='COMMENT' AND jobs.task_id=jobpars.task_id AND jobs.task_id=tasks.task_id AND users.uuid=jobs.user_id";
    $where = "WHERE " . $join . " AND jobs.job_status<10 AND UNIX_TIMESTAMP(jobs.started) >=" . $params['startTime'] . " AND UNIX_TIMESTAMP(jobs.started) <= " . $params['finishTime'];
    $order = " ORDER BY jobs.job_id DESC LIMIT 300";

    if ($utype != "expert" && $utype != "admin")
	$if = " AND jobs.user_id = $ouuid ";
    $query = $select . $where . $if . $order;

    if (isset($params['uiid']) && !empty($params['uiid'])) {
	$query = $query . " WHERE jobs.user_id=" . $params['uiid'];
    }
    $res = mysqli_query($link, $query);
    //$out = array();
    if (!$res) {
	$err_no = mysqli_errno($link);
	$result = mysqli_error($link);
	$out = array('err_no' => $err_no, 'result' => $result);
    }
    //if (count($res)==0) $out = array('err_no' => $err_no, 'result' => $result);
    else {
	while ($ret = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	    $out[] = $ret;
	};
    }

    mysqli_free_result($res);
    mysqli_close($link);
    $ret = array('err_no' => $err_no, 'result' => $result, 'val' => $out);
    $jsen = json_encode($ret);
    echo $jsen;
} 
elseif ($oper == "list") {
    if (empty($ouuid) || empty($utype)) {
	$out = array('err_no' => '-1', 'result' => 'No cookies for uuid or utype');
	$jsen = json_encode($out);
	echo $jsen;
	return;
    }
    $params = $_POST['params'];

    $select = "SELECT jobs.*, tasks.caption, jobpars.def_val, users.utype, users.first_name, users.last_name FROM jobs, jobpars, tasks, users  ";
    $join = " jobs.job_id=jobpars.job_id AND jobpars.name='COMMENT' AND jobs.task_id=jobpars.task_id AND jobs.task_id=tasks.task_id AND users.uuid=jobs.user_id";
    $where = "WHERE " . $join . " AND jobs.job_status<10 AND UNIX_TIMESTAMP(jobs.started) >=" . $params['startTime'] . " AND UNIX_TIMESTAMP(jobs.started) <= " . $params['finishTime'];
    $order = " ORDER BY jobs.job_id DESC LIMIT 300";

    $query = $select . $where . $order;
    if (isset($params['uiid']) && !empty($params['uiid'])) {
	$query = $query . " WHERE jobs.user_id=" . $params['uiid'];
    }
    $res = mysqli_query($link, $query);
    //$out = array();
    if (!$res) {
	$err_no = mysqli_errno($link);
	$result = mysqli_error($link);
	$out = array('err_no' => $err_no, 'result' => $result);
    }
    //if (count($res)==0) $out = array('err_no' => $err_no, 'result' => $result);
    else {
	while ($ret = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	    $out[] = $ret;
	};
    }

    mysqli_free_result($res);
    mysqli_close($link);
    $ret = array('err_no' => $err_no, 'result' => $result, 'val' => $out);
    $jsen = json_encode($ret);
    echo $jsen;
} 
elseif ($oper == "example") {
    $cookie = $_POST['cookie'];
    if (empty($cookie)) {
	$out = array('err_no' => '-1', 'result' => 'No cookies for uuid or utype');
	return;
    }
    $query = "SELECT * FROM  `jobs` WHERE  `option` =1 AND  `job_status` <10";
    $res = mysqli_query($link, $query);
    if (!$res) {
	$err_no = mysqli_errno($link);
	$result = mysqli_error($link);
	$out = array('err_no' => $err_no, 'result' => $result);
    } else {
	while ($ret = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	    $out[] = $ret;
	};
    }

    mysqli_free_result($res);
    mysqli_close($link);
    $ret = array('err_no' => $err_no, 'result' => $result, 'val' => $out);
    $jsen = json_encode($ret);
    echo $jsen;
//    echo 10;
}
elseif ($oper == "shared") {
    $query = "SELECT jobs.*, users.first_name, users.last_name, tasks.caption, jobpars.def_val FROM jobs, users, tasks, jobpars WHERE `option` =2 AND `job_status` <10 AND jobs.job_id=jobpars.job_id AND jobpars.name='COMMENT' AND jobs.task_id=jobpars.task_id AND jobs.task_id=tasks.task_id AND users.uuid=jobs.user_id";
    $res = mysqli_query($link, $query);
    //$out = array();
    if (!$res) {
	$err_no = mysqli_errno($link);
	$result = mysqli_error($link);
	$out = array('err_no' => $err_no, 'result' => $result);
    }
    else {
	while ($ret = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	    $out[] = $ret;
	};
    }
    mysqli_free_result($res);
    mysqli_close($link);
    $ret = array('err_no' => $err_no, 'result' => $result, 'val' => $out);
    $jsen = json_encode($ret);
    echo $jsen;
}

